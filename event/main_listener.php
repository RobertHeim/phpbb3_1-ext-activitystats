<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace robertheim\activitystats\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use robertheim\activitystats\MODES;
use robertheim\activitystats\PERMISSIONS;
use robertheim\activitystats\PREFIXES;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{

	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'	=> 'main',
		);
	}

	const SORT_ASC = 0;

	const SORT_USERNAME_ASC = 0;
	const SORT_USERNAME_DESC = 1;
	const SORT_LASTPAGE_ASC = 2;
	const SORT_LASTPAGE_DESC = 3;
	const SORT_USERID_ASC = 4;
	const SORT_USERID_DESC = 5;

	/**
	* Would be too nice, if we could use a constant.
	*/
	static public function table($table_name = 'rh_activitystats')
	{
		global $table_prefix;
		return $table_prefix . $table_name;
	}

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\cache\service */
	protected $cache;

	/* @var \phpbb\user */
	protected $user;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param \phpbb\template						$template	Template object
	 * @param \phpbb\cache\service					$cache		Cache object
	 * @param \phpbb\user							$user		User object
	 * @param \phpbb\db\driver\driver_interface		$db			Database connection object
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\cache\service $cache, \phpbb\user $user, \phpbb\db\driver\driver_interface $db)
	{
		$this->template = $template;
		$this->cache = $cache;
		$this->user = $user;
		$this->db = $db;
	}

	public function main($event)
	{
		global $config, $auth;
		if (!$config[PREFIXES::CONFIG.'_check_permissions'] || $auth->acl_get(PERMISSIONS::SEE_STATS)) {
			$this->user->add_lang_ext('robertheim/activitystats', 'activitystats');

			// find timeperiod: today (mode=1) or other configured time period (mode=2)
			$timestamp = time();
			if (MODES::TODAY == $config['robertheim_activitystats_mode'])
			{
				// today
				$help_timestamp = gmmktime(0, 0, 0, gmdate('m', $timestamp), gmdate('d', $timestamp), gmdate('Y', $timestamp));
				$help_timestamp -= ($config['board_timezone'] * 3600);
				$help_timestamp -= ($config['board_dst'] * 3600);
				$timestamp = ($help_timestamp < $timestamp - 86400) ? $help_timestamp + 86400 : (($help_timestamp > $timestamp) ? $help_timestamp - 86400 : $help_timestamp);
			}
			else
			{
				// timeperiod
				$timestamp -= (3600 * $config['robertheim_activitystats_del_time_h']);
				$timestamp -= (  60 * $config['robertheim_activitystats_del_time_m']);
				$timestamp -=         $config['robertheim_activitystats_del_time_s'];
			}
			$this->update_session();
			$this->prune($timestamp);
	
			// don't re-calculate the data within that time, but use the cached data from the last calculation.
			$cachetime = $config['robertheim_activitystats_cache_time'];
	
			// calculate the data to display or read it from the cache
			$activity = $this->obtain_data($timestamp, $cachetime);
			$this->display($activity);
		}
	}

	/**
	 * calculates the data which shall be displayed or reads it from the cache if within $cachetime.
	 *
	 * @param $timestamp the interval for which data should be displayed
	 * @param $cachetime timespan indicating how long the calculated data should be cached, before calculating it again
	 * @return array the activity data based on the boards configuration
	 */
	private function obtain_data($timestamp, $cachetime)
	{
		global $config, $user, $db;

		if (0 == $cachetime || ($activity = $this->cache->get('_robertheim_activitystats')) === false)
		{
			$activity = array();
	
			if ($config['robertheim_activitystats_disp_new_topics'])
			{
				// total new topics
				$sql = 'SELECT COUNT(topic_id) AS new_topics
						FROM ' . TOPICS_TABLE . '
						WHERE topic_time > ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_topics'] = $this->db->sql_fetchfield('new_topics');
				$this->db->sql_freeresult($result);
			}

			if ($config['robertheim_activitystats_disp_new_posts'])
			{
				// total new posts
				$sql = 'SELECT COUNT(post_id) AS new_posts
						FROM ' . POSTS_TABLE . '
						WHERE post_time > ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_posts'] = $this->db->sql_fetchfield('new_posts');
				$this->db->sql_freeresult($result);
			}

			if ($config['robertheim_activitystats_disp_new_users'])
			{
				// total new users (counts inactive users as well)
				$sql = 'SELECT COUNT(user_id) AS new_users
						FROM ' . USERS_TABLE . '
						WHERE user_regdate > ' . $timestamp;
				$result = $this->db->sql_query($sql);
				$activity['new_users'] = $this->db->sql_fetchfield('new_users');
				$this->db->sql_freeresult($result);
			}

			switch ($config['robertheim_activitystats_sort_by'])
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
			$sql_ordering = (($config['robertheim_activitystats_sort_by'] % 2) == self::SORT_ASC) ? 'ASC' : 'DESC';

			$count_total = $count_reg = $count_hidden = $count_bot = $count_guests = 0;

			// holds all users-data
			$users_list = array();

			// this array  is used to prevent counting users (or bots etc) twice (while ANONYMOUS is counted several times)
			$ids_user = array();

			$sql = 'SELECT user_id, username, username_clean, user_colour, user_type, viewonline, lastpage, user_ip
				FROM  ' . self::table() . "
				ORDER BY $sql_order_by $sql_ordering";
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				if (!in_array($row['user_id'], $ids_user))
				{
					// don't count / display any user twice - except ANONYMOUS
					if ($row['user_id'] != ANONYMOUS) {
						$ids_user[] = $row['user_id'];
					}

					// we only count the ones who will be displayed (as defined in the configuration)
					$will_be_displayed = true;

					if ($row['user_id'] == ANONYMOUS && ($will_be_displayed = $config['robertheim_activitystats_disp_guests']))
					{
						$count_guests++;
					}
					else if ($row['user_type'] == USER_IGNORE && ($will_be_displayed = $config['robertheim_activitystats_disp_bots']))
					{
						$count_bot++;
					}
					else if ($row['viewonline'] == 1)
					{
						$count_reg++;
					}
					else if ($will_be_displayed = $config['robertheim_activitystats_disp_hidden'])
					{
						$count_hidden++;
					}

					if ($will_be_displayed) {
						// replace username with the printable username
						$row['username'] = get_username_string((($row['user_type'] == USER_IGNORE) ? 'no_profile' : 'full'), $row['user_id'], $row['username'], $row['user_colour']);
						$users_list[]=$row;
						$count_total++;
					}
				}
			}

			// set calculated counts to activity
			$activity['count_total'] = $count_total;
			$activity['count_reg'] = $count_reg;
			$activity['count_hidden'] = $count_hidden;
			$activity['count_bot'] = $count_bot;
			$activity['count_guests'] = $count_guests;

			$activity['users_list'] = $users_list;

			// Need to update the record?
			if ($config['robertheim_activitystats_record_ips'] < $count_total)
			{
				$config->set('robertheim_activitystats_record_ips', $count_total, true);
				$config->set('robertheim_activitystats_record_time', time(), true);
			}

			if ($cachetime > 0)
			{
				$this->cache->put('_robertheim_activitystats', $activity, $cachetime);
			}
		}
	
		return $activity;
	}

	/**
	* Update the users session in the table.
	*/
	private function update_session()
	{
		global $db, $user;

		if ($user->data['user_id'] != ANONYMOUS)
		{
			$data = array(
				'user_id'			=> $user->data['user_id'],
				'user_ip'			=> $user->ip,
				'username'			=> $user->data['username'],
				'username_clean'	=> $user->data['username_clean'],
				'user_colour'		=> $user->data['user_colour'],
				'user_type'			=> $user->data['user_type'],
				'viewonline'		=> $user->data['session_viewonline'],
				'lastpage'			=> time(),
			);

			$db->sql_return_on_error(true);
			$sql = 'UPDATE ' . self::table() . ' 
				SET ' . $db->sql_build_array('UPDATE', $data) . '
				WHERE user_id = ' . (int) $user->data['user_id'] . "
					OR (user_ip = '" . $db->sql_escape($user->ip) . "'
						AND user_id = " . ANONYMOUS . ')';
			$result = $db->sql_query($sql);
			$db->sql_return_on_error(false);

			if ((bool) $result === false)
			{
				// database does not exist yet...
				return;
			}

			$sql_affectedrows = (int) $db->sql_affectedrows();
			if ($sql_affectedrows != 1)
			{
				if ($sql_affectedrows > 1)
				{
					// Found multiple matches, so we delete them and just add one
					$sql = 'DELETE FROM ' . self::table() . '
						WHERE user_id = ' . (int) $user->data['user_id'] . "
							OR (user_ip = '" . $db->sql_escape($user->ip) . "'
								AND user_id = " . ANONYMOUS . ')';
					$db->sql_query($sql);
					$db->sql_query('INSERT INTO ' . self::table() . ' ' . $db->sql_build_array('INSERT', $data));
				}

				if ($sql_affectedrows == 0)
				{
					// No entry updated. Either the user is not listed yet, or has opened two links in the same time
					$sql = 'SELECT 1 as found
						FROM ' . self::table() . '
						WHERE user_id = ' . (int) $user->data['user_id'] . "
							OR (user_ip = '" . $db->sql_escape($user->ip) . "'
								AND user_id = " . ANONYMOUS . ')';
					$result = $db->sql_query($sql);
					$found = (int) $db->sql_fetchfield('found');
					$db->sql_freeresult($result);
					if (!$found)
					{
						// He wasn't listed.
						$db->sql_query('INSERT INTO ' . self::table() . ' ' . $db->sql_build_array('INSERT', $data));
					}
				}
			}
		}
		else
		{
			$db->sql_return_on_error(true);
			$sql = 'SELECT user_id
				FROM ' . self::table() . "
				WHERE user_ip = '" . $db->sql_escape($user->ip) . "'";
			$result = $db->sql_query_limit($sql, 1);
			$db->sql_return_on_error(false);

			if ((bool) $result === false)
			{
				// database does not exist yet...
				return;
			}

			$user_logged = (int) $db->sql_fetchfield('user_id');
			$db->sql_freeresult($result);

			if (!$user_logged)
			{
				$data = array(
					'user_id'			=> $user->data['user_id'],
					'user_ip'			=> $user->ip,
					'username'			=> $user->data['username'],
					'username_clean'	=> $user->data['username_clean'],
					'user_colour'		=> $user->data['user_colour'],
					'user_type'			=> $user->data['user_type'],
					'viewonline'		=> 1,
					'lastpage'		=> time(),
				);
				$db->sql_query('INSERT INTO ' . self::table() . ' ' . $db->sql_build_array('INSERT', $data));
			}
		}
		$db->sql_return_on_error(false);
	}

	/**
	* Fetching the user-list and putting the stuff into the template.
	*/
	private function display($activity)
	{
		global $config, $auth, $user;

		if ($config['robertheim_activitystats_disp_new_topics'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_TOPICS'			=> $this->user->lang('ACTIVITY_STATS_NEW_TOPICS', $activity['new_topics']),
			));
		}

		if ($config['robertheim_activitystats_disp_new_posts'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_POSTS'			=> $this->user->lang('ACTIVITY_STATS_NEW_POSTS', $activity['new_posts']),
			));
		}

		if ($config['robertheim_activitystats_disp_new_users'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_USERS'			=> $this->user->lang('ACTIVITY_STATS_NEW_USERS', $activity['new_users']),
			));
		}

		$users_list='';
		foreach ($activity['users_list'] as $key => $row) {
			$hover_time = (($config['robertheim_activitystats_disp_time'] == '2') ? $user->lang['ACTIVITY_STATS_LATEST1'] . '&nbsp;' . $user->format_date($row['lastpage'], $config['robertheim_activitystats_disp_time_format']) . $user->lang['ACTIVITY_STATS_LATEST2'] : '' );
			$hover_ip = ($auth->acl_get('a_') && $config['robertheim_activitystats_disp_ip']) ? $user->lang['IP'] . ':&nbsp;' . $row['user_ip'] : '';
			$hover_info = (($hover_time || $hover_ip) ? ' title="' . $hover_time . (($hover_time && $hover_ip) ? ' | ' : '') . $hover_ip . '"' : '');
			$disp_time = (($config['robertheim_activitystats_disp_time'] == '1') ? '&nbsp;(' . $user->lang['ACTIVITY_STATS_LATEST1'] . '&nbsp;' . $user->format_date($row['lastpage'], $config['robertheim_activitystats_disp_time_format']) . $user->lang['ACTIVITY_STATS_LATEST2'] . (($hover_ip) ? ' | ' . $hover_ip : '' ) . ')' : '' );

			// if not hidden user
			if ($row['viewonline'] || ($row['user_type'] == USER_IGNORE))
			{
				if (($row['user_id'] != ANONYMOUS) && ($config['robertheim_activitystats_disp_bots'] || ($row['user_type'] != USER_IGNORE)))
				{
					$users_list .= $user->lang['COMMA_SEPARATOR'] . '<span' . $hover_info . '>' . $row['username'] . '</span>' . $disp_time;
					$ids_user[] = $row['user_id'];
				}
			}
			else if (($config['robertheim_activitystats_disp_hidden']) && ($auth->acl_get('u_viewonline')))
			{
				$users_list .= $user->lang['COMMA_SEPARATOR'] . '<em' . $hover_info . '>' .$row['username'] . '</em>' . $disp_time;
				$ids_user[] = $row['user_id'];
			}
		}

		$users_list = utf8_substr($users_list, utf8_strlen($user->lang['COMMA_SEPARATOR']));
		if ($users_list == '')
		{
			// User list is empty.
			$users_list = $user->lang['NO_ONLINE_USERS'];
		}

		$this->template->assign_vars(array(
			'ACTIVITY_STATS_TOTAL_NEWS' => $this->get_total_news_string($activity),
			'ACTIVITY_STATS_LIST'		=> $user->lang['REGISTERED_USERS'] . ' ' . $users_list,
			'ACTIVITY_STATS_TOTAL'		=> $this->get_total_users_string($activity),
			'ACTIVITY_STATS_EXP'		=> $this->get_explanation_string($config['robertheim_activitystats_mode']),
			'ACTIVITY_STATS_RECORD'		=> $this->get_record_string($config['robertheim_activitystats_record'], $config['robertheim_activitystats_mode']),
		));
	}

	/**
	 * Deletes the users from the list, whose visit is to old.
	 * @param $timestamp everything before timestamp will be deleted
	 */
	static public function prune($timestamp)
	{
		global $config;

		if ($config['robertheim_activitystats_last_clean'] != $timestamp)
		{
			global $db;

			$db->sql_return_on_error(true);
			$sql = 'DELETE FROM ' . self::table() . '
				WHERE lastpage <= ' . $timestamp;
			$result = $db->sql_query($sql);
			$db->sql_return_on_error(false);

			$config->set('robertheim_activitystats_last_clean', $timestamp);
		}

		// Purging was not needed or done succesfully...
		return true;
	}

	/**
	* Returns the Explanation string for the online list:
	* Demo:	based on users active today
	*		based on users active over the past 30 minutes
	*/
	static public function get_explanation_string($mode)
	{
		global $config, $user;

		if ($mode)
		{
			return $user->lang['ACTIVITY_STATS_EXP'];
		}
		else
		{
			$explanation = $user->lang['ACTIVITY_STATS_EXP_TIME'];
			$explanation .= $user->lang('ACTIVITY_STATS_HOURS', (int) $config['robertheim_activitystats_del_time_h']);
			$explanation .= $user->lang('ACTIVITY_STATS_MINUTES', (int) $config['robertheim_activitystats_del_time_m']);
			$explanation .= $user->lang('ACTIVITY_STATS_SECONDS', (int) $config['robertheim_activitystats_del_time_s']);

			switch (substr_count($explanation, '%s'))
			{
				case 3:
					return sprintf($explanation, '', $user->lang['COMMA_SEPARATOR'], $user->lang['ACTIVITY_STATS_WORD']);
				case 2:
					return sprintf($explanation, '', $user->lang['ACTIVITY_STATS_WORD']);
				default:
					return sprintf($explanation, '');
			}
		}
	}

	/**
	* Returns the Record string for the online list:
	* Demo:	Most users ever online was 1 on Mon 7. Sep 2009
	*		Most users ever online was 1 between Mon 7. Sep 2009 and Tue 8. Sep 2009
	*/
	private function get_record_string($active, $mode)
	{
		global $config, $user;

		if (!$active)
		{
			return '';
		}
		if ($mode)
		{
			return sprintf($user->lang['ACTIVITY_STATS_RECORD'],
				$config['robertheim_activitystats_record_ips'],
				$user->format_date($config['robertheim_activitystats_record_time'], $config['robertheim_activitystats_record_timestamp'])) . '<br />';
		}
		else
		{
			$config['robertheim_activitystats_record_time2'] = $config['robertheim_activitystats_record_time'];
			$config['robertheim_activitystats_record_time2'] -= (3600 * $config['robertheim_activitystats_del_time_h']);
 			$config['robertheim_activitystats_record_time2'] -= (  60 * $config['robertheim_activitystats_del_time_m']);
			$config['robertheim_activitystats_record_time2'] -=         $config['robertheim_activitystats_del_time_s'];
			return sprintf($user->lang['ACTIVITY_STATS_RECORD_TIME'],
				$config['robertheim_activitystats_record_ips'],
				$user->format_date($config['robertheim_activitystats_record_time2'], $config['robertheim_activitystats_record_timestamp']),
				$user->format_date($config['robertheim_activitystats_record_time'], $config['robertheim_activitystats_record_timestamp'])) . '<br />';
		}
	}

	/**
	* Returns the Total string for the "new x" list:
	* Demo:	New topics 1, New posts 2, New users 1
	*/
	static public function get_total_news_string($activity)
	{
		global $config, $user;

		$total_new_string = array();
		if ($config['robertheim_activitystats_disp_new_topics'])
		{
			$total_news_string[] = $user->lang('ACTIVITY_STATS_NEW_TOPICS', $activity['new_topics']);
		}
		if ($config['robertheim_activitystats_disp_new_posts'])
		{
			$total_news_string[] = $user->lang('ACTIVITY_STATS_NEW_POSTS', $activity['new_posts']);
		}
		if ($config['robertheim_activitystats_disp_new_users'])
		{
			$total_news_string[] = $user->lang('ACTIVITY_STATS_NEW_USERS', $activity['new_users']);
		}
		return join(" &bull; ", $total_news_string);
	}

	/**
	* Returns the Total string for the online list:
	* Demo:	In total there was 1 user online :: 1 registered, 0 hidden, 0 bots and 0 guests
	*/
	static public function get_total_users_string($activity)
	{
		global $config, $user;

		$total_users_string = $user->lang('ACTIVITY_STATS_TOTAL', $activity['count_total']);
		$total_users_string .= $user->lang('ACTIVITY_STATS_REG_USERS', $activity['count_reg']);
		if ($config['robertheim_activitystats_disp_hidden'])
		{
			$total_users_string .= '%s ' . $user->lang('ACTIVITY_STATS_HIDDEN', $activity['count_hidden']);
		}
		if ($config['robertheim_activitystats_disp_bots'])
		{
			$total_users_string .= '%s ' . $user->lang('ACTIVITY_STATS_BOTS', $activity['count_bot']);
		}
		if ($config['robertheim_activitystats_disp_guests'])
		{
			$total_users_string .= '%s ' . $user->lang('ACTIVITY_STATS_GUESTS', $activity['count_guests']);
		}

		switch (substr_count($total_users_string, '%s'))
		{
			case 3:
				return sprintf($total_users_string, $user->lang['COMMA_SEPARATOR'], $user->lang['COMMA_SEPARATOR'], $user->lang['ACTIVITY_STATS_WORD']);
			case 2:
				return sprintf($total_users_string, $user->lang['COMMA_SEPARATOR'], $user->lang['ACTIVITY_STATS_WORD']);
			case 1:
				return sprintf($total_users_string, $user->lang['ACTIVITY_STATS_WORD']);
			default:
				return $total_users_string;
		}
	}
}
