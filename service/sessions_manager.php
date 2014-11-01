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
use robertheim\activitystats\PREFIXES;
use robertheim\activitystats\TABLES;

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
	*/
	public function update_session()
	{
		if ($this->user->data['user_id'] != ANONYMOUS)
		{
			// current user is logged in - however he might have opened another session as anonymous from the same ip.
			// so we need to check user_id and (anonymous AND ip=user->ip)
			$data = array(
				'user_id'			=> $this->user->data['user_id'],
				'user_ip'			=> $this->user->ip,
				'username'			=> $this->user->data['username'],
				'username_clean'	=> $this->user->data['username_clean'],
				'user_colour'		=> $this->user->data['user_colour'],
				'user_type'			=> $this->user->data['user_type'],
				'viewonline'		=> $this->user->data['session_viewonline'],
				'lastpage'			=> time(),
			);

			$this->db->sql_return_on_error(true);
			$sql = 'UPDATE ' . $this->table_prefix . TABLES::SESSIONS  . ' 
				SET ' . $this->db->sql_build_array('UPDATE', $data) . '
				WHERE user_id = ' . (int) $this->user->data['user_id'] . "
					OR (user_ip = '" . $this->db->sql_escape($this->user->ip) . "'
						AND user_id = " . ANONYMOUS . ')';
			$result = $this->db->sql_query($sql);
			$this->db->sql_return_on_error(false);

			if ((bool) $result === false)
			{
				// database does not exist yet...
				return;
			}
			$sql_affectedrows = (int) $this->db->sql_affectedrows();
			if ($sql_affectedrows != 1)
			{
				if ($sql_affectedrows > 1)
				{
					// Found multiple matches, so we delete them and just add one
					$sql = 'DELETE FROM ' . $this->table_prefix . TABLES::SESSIONS . '
						WHERE user_id = ' . (int) $this->user->data['user_id'] . "
							OR (user_ip = '" . $this->db->sql_escape($this->user->ip) . "'
								AND user_id = " . ANONYMOUS . ')';
					$this->db->sql_query($sql);
					$this->db->sql_query('INSERT INTO ' . $this->table_prefix . TABLES::SESSIONS . ' ' . $this->db->sql_build_array('INSERT', $data));
				}

				if ($sql_affectedrows == 0)
				{
					// No entry updated. Either the user is not listed yet, or has opened two links in the same time
					$sql = 'SELECT 1 as found
						FROM ' . $this->table_prefix . TABLES::SESSIONS . '
						WHERE user_id = ' . (int) $this->user->data['user_id'] . "
							OR (user_ip = '" . $this->db->sql_escape($this->user->ip) . "'
								AND user_id = " . ANONYMOUS . ')';
					$result = $this->db->sql_query($sql);
					$found = (int) $this->db->sql_fetchfield('found');
					$this->db->sql_freeresult($result);
					if (!$found)
					{
						// He wasn't listed.
						$this->db->sql_query('INSERT INTO ' . $this->table_prefix . TABLES::SESSIONS . ' ' . $this->db->sql_build_array('INSERT', $data));
					}
				}
			}
		}
		else
		{
			// current user is anonymous - however he might have opened another session as a user from the same ip.
			// so we not only need to check (ip=user->ip) but (anonymous AND ip=user->ip)
			$this->db->sql_return_on_error(true);
			$sql = 'SELECT user_id
				FROM ' . $this->table_prefix . TABLES::SESSIONS . "
				WHERE (user_ip = '" . $this->db->sql_escape($this->user->ip) . "'
						AND user_id = " . ANONYMOUS . ')';
			$result = $this->db->sql_query_limit($sql, 1);
			$this->db->sql_return_on_error(false);

			if ((bool) $result === false)
			{
				// database does not exist yet...
				return;
			}

			$this->user_logged = (int) $this->db->sql_fetchfield('user_id');
			$this->db->sql_freeresult($result);

			if (!$this->user_logged)
			{
				$data = array(
					'user_id'			=> $this->user->data['user_id'],
					'user_ip'			=> $this->user->ip,
					'username'			=> $this->user->data['username'],
					'username_clean'	=> $this->user->data['username_clean'],
					'user_colour'		=> $this->user->data['user_colour'],
					'user_type'			=> $this->user->data['user_type'],
					'viewonline'		=> 1,
					'lastpage'			=> time(),
				);
				$this->db->sql_query('INSERT INTO ' . $this->table_prefix . TABLES::SESSIONS . ' ' . $this->db->sql_build_array('INSERT', $data));
			}
		}
		$this->db->sql_return_on_error(false);
	}

	/**
	 * Deletes the users from the list, whose last visit is too old.
	 *
	 * @param $timestamp everything before timestamp will be deleted
	 */
	public function prune($timestamp)
	{
		if ($this->config[PREFIXES::CONFIG . '_last_clean'] != $timestamp)
		{
			$sql = 'DELETE FROM ' . $this->table_prefix . TABLES::SESSIONS . '
				WHERE lastpage < ' . $timestamp;
			$this->db->sql_query($sql);

			$this->config->set(PREFIXES::CONFIG . '_last_clean', $timestamp);
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
	
			if ($this->config[PREFIXES::CONFIG . '_disp_new_topics'])
			{
				// total new topics
				$sql = 'SELECT COUNT(topic_id) AS new_topics
						FROM ' . TOPICS_TABLE . '
						WHERE topic_time >= ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_topics'] = $this->db->sql_fetchfield('new_topics');
				$this->db->sql_freeresult($result);
			}

			if ($this->config[PREFIXES::CONFIG . '_disp_new_posts'])
			{
				// total new posts
				$sql = 'SELECT COUNT(post_id) AS new_posts
						FROM ' . POSTS_TABLE . '
						WHERE post_time >= ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_posts'] = $this->db->sql_fetchfield('new_posts');
				$this->db->sql_freeresult($result);
			}

			if ($this->config[PREFIXES::CONFIG . '_disp_new_users'])
			{
				// total new users (counts inactive users as well)
				$sql = 'SELECT COUNT(user_id) AS new_users
						FROM ' . USERS_TABLE . '
						WHERE user_regdate >= ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_users'] = $this->db->sql_fetchfield('new_users');
				$this->db->sql_freeresult($result);
			}

			switch ($this->config[PREFIXES::CONFIG . '_sort_by'])
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
			$sql_ordering = (($this->config[PREFIXES::CONFIG . '_sort_by'] % 2) == self::SORT_ASC) ? 'ASC' : 'DESC';

			// count of total_users (eventually including ANONYMOUS several times)
			$count_total = 0;
			// count of different user types
			$count_reg = $count_hidden = $count_bot = $count_guests = 0;

			// holds all users-data without ANONYMOUS
			$this->users_list = array();

			// this array is used to prevent counting users (or bots etc) twice (while ANONYMOUS is counted several times)
			$ids_user = array();

			$sql = 'SELECT user_id, username, username_clean, user_colour, user_type, viewonline, lastpage, user_ip
				FROM  ' . $this->table_prefix . TABLES::SESSIONS . "
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
						$display_username = $this->config[PREFIXES::CONFIG . '_disp_bots'];
						if ($display_username)
						{
							$count_bot++;
							$count_total++;
						}
					}
					else if ($row['viewonline'] == 1)
					{
						// registered users that not hides his online status
						$count_reg++;
						$count_total++;
					}
					else
					{
						// hidden users
						$display_username = $this->config[PREFIXES::CONFIG . '_disp_hidden'];
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
						$this->users_list[] = $row;
					}
				}
			}

			// set calculated counts to activity
			$activity['count_total']	= $count_total;
			$activity['count_reg']		= $count_reg;
			$activity['count_hidden']	= $count_hidden;
			$activity['count_bot']		= $count_bot;
			$activity['count_guests']	= $count_guests;

			$activity['users_list']		= $this->users_list;

			if ($cachetime > 0)
			{
				$this->cache->put('_robertheim_activitystats', $activity, $cachetime);
			}
		}
	
		return $activity;
	}

	/**
	* Checks if a new record is reached and if so stores the new record.
	*/
	public function check_record()
	{
		// fetch count of users that have been online
		$sql = 'SELECT DISTINCT COUNT(user_id) AS count_total
			FROM  ' . $this->table_prefix . TABLES::SESSIONS;
		$result = $this->db->sql_query($sql);
		$count_total = (int) $this->db->sql_fetchfield('count_total');
		$this->db->sql_freeresult($result);
		// Need to update the record?
		if ($this->config[PREFIXES::CONFIG . '_record_count'] < $count_total)
		{
			$this->config->set(PREFIXES::CONFIG . '_record_count', $count_total, true);
			$this->config->set(PREFIXES::CONFIG . '_record_time', time(), true);
		}
	}
}
