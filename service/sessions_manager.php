<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace robertheim\activitystats\service;

/**
 * @ignore
 */
use robertheim\activitystats\prefixes;
use robertheim\activitystats\tables;
use robertheim\activitystats\modes;

/**
* Handles all functionallity regarding the session table of activity stats.
*/
class sessions_manager
{
	protected $db;
	protected $user;
	protected $config;
	protected $cache;

	const SORT_ASC = 0;
	const SORT_USERNAME_ASC = 0;
	const SORT_USERNAME_DESC = 1;
	const SORT_LASTPAGE_ASC = 2;
	const SORT_LASTPAGE_DESC = 3;
	const SORT_USERID_ASC = 4;
	const SORT_USERID_DESC = 5;

	public function __construct(
					\phpbb\db\driver\driver_interface $db,
					\phpbb\user $user,
					\phpbb\config\config $config,
					\phpbb\cache\service $cache,
					$table_prefix)
	{
		$this->db			= $db;
		$this->user			= $user;
		$this->config		= $config;
		$this->cache		= $cache;
		$this->table_prefix	= $table_prefix;
	}

	/**
	* Update the users session in the table.
	* @param int $timestamp the timestamp on that the update happens.
	*/
	public function update_session($timestamp)
	{
		$data = array(
			'user_id'			=> $this->user->data['user_id'],
			'user_ip'			=> $this->user->ip,
			'username'			=> $this->user->data['username'],
			'username_clean'	=> $this->user->data['username_clean'],
			'user_colour'		=> $this->user->data['user_colour'],
			'user_type'			=> $this->user->data['user_type'],
			'viewonline'		=> 1,
			'lastpage'			=> $timestamp,
		);
		if ($data['user_id'] != ANONYMOUS)
		{
			// current user is logged in
			$data['viewonline'] = $this->user->data['session_viewonline'];

			$sql = 'SELECT id
					FROM ' . $this->table_prefix . tables::SESSIONS . '
					WHERE user_id = ' . (int) $this->user->data['user_id'];
			$result = $this->db->sql_query($sql);
			$session_id = (int) $this->db->sql_fetchfield('id');
			$this->db->sql_freeresult($result);
			if ($session_id > 0)
			{
				// update session
				$sql = 'UPDATE ' . $this->table_prefix . tables::SESSIONS  . '
					SET ' . $this->db->sql_build_array('UPDATE', $data) . '
					WHERE id  = ' . $session_id;
				$this->db->sql_query($sql);
			}
			else
			{
				// user is not yet registered as logged in user
				// check if he has a session as anonymous
				$sql = 'SELECT id
						FROM ' . $this->table_prefix . tables::SESSIONS . '
						WHERE (user_ip = \'' . $this->db->sql_escape($this->user->ip) . '\'
								AND user_id = ' . ANONYMOUS . ')';
				$result = $this->db->sql_query($sql);
				$session_id = (int) $this->db->sql_fetchfield('id');
				$this->db->sql_freeresult($result);
				if ($session_id > 0)
				{
					// delete it
					$sql = 'DELETE FROM ' . $this->table_prefix . tables::SESSIONS . '
						WHERE id = ' . $session_id;
					$this->db->sql_query($sql);
				}

				// create new user session
				$this->db->sql_query('INSERT INTO ' . $this->table_prefix . tables::SESSIONS . ' ' . $this->db->sql_build_array('INSERT', $data));
			}
		}
		else
		{
			// current user is anonymous
			$sql = 'SELECT id
				FROM ' . $this->table_prefix . tables::SESSIONS . "
				WHERE (user_ip = '" . $this->db->sql_escape($this->user->ip) . "'
						AND user_id = " . ANONYMOUS . ')';
			$result = $this->db->sql_query_limit($sql, 1);

			$session_id = (int) $this->db->sql_fetchfield('id');
			$this->db->sql_freeresult($result);
			if ($session_id > 0)
			{
				// update session
				$sql = 'UPDATE ' . $this->table_prefix . tables::SESSIONS  . '
					SET ' . $this->db->sql_build_array('UPDATE', $data) . '
					WHERE id  = ' . $session_id;
				$this->db->sql_query($sql);
			}
			else
			{
				$this->db->sql_query('INSERT INTO ' . $this->table_prefix . tables::SESSIONS . ' ' . $this->db->sql_build_array('INSERT', $data));
			}
		}
	}

	/**
	 * Deletes the users from the list, whose last visit is too old.
	 *
	 * @param $timestamp everything before timestamp will be deleted
	 */
	public function prune($timestamp)
	{
		if ($this->config[prefixes::CONFIG . '_last_clean'] != $timestamp)
		{
			$sql = 'DELETE FROM ' . $this->table_prefix . tables::SESSIONS . '
				WHERE lastpage < ' . $timestamp;
			$this->db->sql_query($sql);

			$this->config->set(prefixes::CONFIG . '_last_clean', $timestamp);
		}
		// Purging was not needed or done succesfully...
		return true;
	}

	/**
	 * calculates the data which shall be displayed or reads it from the cache if within $cachetime.
	 *
	 * @param $timestamp the earliest timestamp for which data should be displayed
	 * @param $cachetime timespan indicating how long the calculated data should be cached, before calculating it again
	 * @return array the activity data based on the boards configuration
	 */
	public function obtain_data($timestamp, $cachetime)
	{
		if (0 == $cachetime || ($activity = $this->cache->get('_robertheim_activitystats')) === false)
		{
			$activity = array();

			if ($this->config[prefixes::CONFIG . '_disp_new_topics'])
			{
				// total new topics
				$sql = 'SELECT COUNT(topic_id) AS new_topics
						FROM ' . TOPICS_TABLE . '
						WHERE topic_time >= ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_topics'] = $this->db->sql_fetchfield('new_topics');
				$this->db->sql_freeresult($result);
			}

			if ($this->config[prefixes::CONFIG . '_disp_new_posts'])
			{
				// total new posts
				$sql = 'SELECT COUNT(post_id) AS new_posts
						FROM ' . POSTS_TABLE . '
						WHERE post_time >= ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_posts'] = $this->db->sql_fetchfield('new_posts');
				$this->db->sql_freeresult($result);
			}

			if ($this->config[prefixes::CONFIG . '_disp_new_users'])
			{
				// total new users (counts inactive users as well)
				$sql = 'SELECT COUNT(user_id) AS new_users
						FROM ' . USERS_TABLE . '
						WHERE user_regdate >= ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_users'] = $this->db->sql_fetchfield('new_users');
				$this->db->sql_freeresult($result);
			}

			switch ($this->config[prefixes::CONFIG . '_sort_by'])
			{
				case self::SORT_USERNAME_ASC:
				case self::SORT_USERNAME_DESC:
					$sql_order_by = 'username_clean';
				break;
				case self::SORT_USERID_ASC:
				case self::SORT_USERID_DESC:
					$sql_order_by = 'user_id';
				break;
				case self::SORT_LASTPAGE_ASC:
				case self::SORT_LASTPAGE_DESC:
				default:
					$sql_order_by = 'lastpage';
				break;
			}
			$sql_ordering = (($this->config[prefixes::CONFIG . '_sort_by'] % 2) == self::SORT_ASC) ? 'ASC' : 'DESC';

			// count of total_users (eventually including ANONYMOUS several times)
			$count_total = 0;
			// count of different user types
			$count_reg = $count_hidden = $count_bot = $count_guests = 0;

			// holds all users-data without ANONYMOUS
			$users_list = array();

			// this array is used to prevent counting users (or bots etc) twice (while ANONYMOUS is counted several times)
			$ids_user = array();

			$sql = 'SELECT user_id, username, username_clean, user_colour, user_type, viewonline, lastpage, user_ip
				FROM  ' . $this->table_prefix . tables::SESSIONS . "
				WHERE lastpage >= " . ((int) $timestamp) . "
				ORDER BY $sql_order_by $sql_ordering";
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!in_array($row['user_id'], $ids_user))
				{
					// dont put ANONYMOUS in ids_user, so we count all guests while users are only counted once
					if ($row['user_id'] != ANONYMOUS)
					{
						$ids_user[] = $row['user_id'];
					}

					// check if we will display the username
					$display_username = true;

					if ($row['user_id'] == ANONYMOUS)
					{
						// guest
						$display_username = false;
						$count_guests++;
						$count_total++;
					}
					else if ($row['user_type'] == USER_IGNORE)
					{
						// bot
						$display_username = $this->config[prefixes::CONFIG . '_disp_bots'];
						if ($display_username)
						{
							$count_bot++;
							$count_total++;
						}
					}
					else if ($row['viewonline'] == 1)
					{
						// registered user that does not hide his online status
						$count_reg++;
						$count_total++;
					}
					else
					{
						// hidden users
						$display_username = $this->config[prefixes::CONFIG . '_disp_hidden'];
						if ($display_username)
						{
							$count_hidden++;
							$count_total++;
						}
					}

					if ($display_username)
					{
						// replace username with the printable username
						$row['username'] = get_username_string((($row['user_type'] == USER_IGNORE) ? 'no_profile' : 'full'), $row['user_id'], $row['username'], $row['user_colour']);
						$users_list[] = $row;
					}
				}
			}
			$this->db->sql_freeresult($result);

			// set calculated counts to activity
			$activity['count_total']	= $count_total;
			$activity['count_reg']		= $count_reg;
			$activity['count_hidden']	= $count_hidden;
			$activity['count_bot']		= $count_bot;
			$activity['count_guests']	= $count_guests;
			$activity['users_list']		= $users_list;

			if ($cachetime > 0)
			{
				$this->cache->put('_robertheim_activitystats', $activity, $cachetime);
			}
		}

		return $activity;
	}

	public function get_board_timezone()
	{
		// local static variables work like static variables of
		// the class, but with differnt scope
		static $board_timezone;
		if (!isset($board_timezone))
		{
			$board_timezone = new \DateTimeZone($this->config['board_timezone']);
		}
		return $board_timezone;
	}

	public function get_utc_timezone()
	{
		// local static variables work like static variables of
		// the class, but with differnt scope
		static $utc;
		if (!isset($utc))
		{
			$utc = new \DateTimeZone('UTC');
		}
		return $utc;
	}

	/**
	* Checks if a new record is reached and if so stores the new record.
	*/
	public function check_record()
	{
		$where = '';
		if (modes::TODAY == $this->config[prefixes::CONFIG . '_mode'])
		{
			// the record is calculated based on the boards timezone, because this
			// is a global value to the board itself and not to a specific user
			// its stored as UTC timestamp
			// and we display it in the boards timezone
			// it is not displayed in the users timezone, because it does not make any
			// sense to calculate it in another timezone than it is displayed.

			// fetch count of users that have been online today (board timezone)
			// where lastpage >= midnight;
			$now = new \phpbb\datetime($this->user, 'now', $this->get_board_timezone());
			$midnight = clone $now;
			$midnight->setTime(0,0,0);
			$where = ' WHERE lastpage >= ' . $midnight->getTimestamp();
		}
		$sql = 'SELECT DISTINCT COUNT(user_id) AS count_total
			FROM  ' . $this->table_prefix . tables::SESSIONS
			. $where;
		$result = $this->db->sql_query($sql);
		$count_total = (int) $this->db->sql_fetchfield('count_total');
		$this->db->sql_freeresult($result);
		// Need to update the record?
		if ($this->config[prefixes::CONFIG . '_record_count'] < $count_total)
		{
			$this->config->set(prefixes::CONFIG . '_record_count', $count_total, true);
			$this->config->set(prefixes::CONFIG . '_record_time', time(), true);
		}
	}
}
