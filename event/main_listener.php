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

	protected $template;
	protected $user;
	protected $db;
	protected $sessions_manager;
	protected $table_prefix;

	public function __construct(\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\robertheim\activitystats\service\sessions_manager $sessions_manager,
		$table_prefix)
	{
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
		$this->sessions_manager = $sessions_manager;
		$this->table_prefix	= $table_prefix;
	}

	public function main($event)
	{
		global $config, $auth;
		$this->sessions_manager->update_session();
		if (!$config[PREFIXES::CONFIG.'_check_permissions'] || $auth->acl_get(PERMISSIONS::SEE_STATS))
		{
			$this->user->add_lang_ext('robertheim/activitystats', 'activitystats');

			// find timeperiod: today (mode=1) or other configured time period (mode=2)
			$timestamp = 0;
			if (MODES::TODAY == $config[PREFIXES::CONFIG . '_mode'])
			{
				// today
				// we calculate timestamp of midnight in the users timezone

				$timezone_name = empty($this->user->data['user_timezone']) ? $config['board_timezone'] : $this->user->data['user_timezone'];
				$timezone = new \DateTimeZone($timezone_name);
				$now = new \DateTime("now", $timezone);
				$midnight = clone $now;
				$midnight->setTime(0,0,0);
				$timestamp = $midnight->getTimestamp();
				// we prune when the last timezone on earth hits the new day.
				// that means all where last visit was before UTC-10
				$this->sessions_manager->prune(time() - 36000); // -10*3600
			}
			else
			{
				// use UTC for period
				$timestamp = time();
				$timestamp -= (86400 * $config[PREFIXES::CONFIG . '_del_time_d']);
				$timestamp -= ( 3600 * $config[PREFIXES::CONFIG . '_del_time_h']);
				$timestamp -= (   60 * $config[PREFIXES::CONFIG . '_del_time_m']);
				$timestamp -=          $config[PREFIXES::CONFIG . '_del_time_s'];
				// prune everything before the period
				$this->sessions_manager->prune($timestamp);
			}

			// after updating and pruning the sessions table check if a new record is reached
			$this->sessions_manager->check_record();

			// don't re-calculate the data within that time, but use the cached data from the last calculation.
			$cachetime = $config[PREFIXES::CONFIG . '_cache_time'];

			// calculate the data to display or read it from the cache
			$activity = $this->sessions_manager->obtain_data($timestamp, $cachetime);
			$this->display($activity);
		}
	}

	/**
	* Fetching the user-list and putting the stuff into the template.
	*/
	private function display($activity)
	{
		global $config, $auth, $user;

		if ($config[PREFIXES::CONFIG . '_disp_new_topics'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_TOPICS'			=> $this->user->lang('ACTIVITY_STATS_NEW_TOPICS', $activity['new_topics']),
			));
		}

		if ($config[PREFIXES::CONFIG . '_disp_new_posts'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_POSTS'			=> $this->user->lang('ACTIVITY_STATS_NEW_POSTS', $activity['new_posts']),
			));
		}

		if ($config[PREFIXES::CONFIG . '_disp_new_users'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_USERS'			=> $this->user->lang('ACTIVITY_STATS_NEW_USERS', $activity['new_users']),
			));
		}

		$users_list = '';
		foreach ($activity['users_list'] as $key => $row)
		{
			$hover_time = (($config[PREFIXES::CONFIG . '_disp_time'] == '2') ? $user->lang['ACTIVITY_STATS_LATEST1'] . '&nbsp;' . $user->format_date($row['lastpage'], $config[PREFIXES::CONFIG . '_disp_time_format']) . $user->lang['ACTIVITY_STATS_LATEST2'] : '' );
			$hover_ip = ($auth->acl_get('a_') && $config[PREFIXES::CONFIG . '_disp_ip']) ? $user->lang['IP'] . ':&nbsp;' . $row['user_ip'] : '';
			$hover_info = (($hover_time || $hover_ip) ? ' title="' . $hover_time . (($hover_time && $hover_ip) ? ' | ' : '') . $hover_ip . '"' : '');
			$disp_time = (($config[PREFIXES::CONFIG . '_disp_time'] == '1') ? '&nbsp;(' . $user->lang['ACTIVITY_STATS_LATEST1'] . '&nbsp;' . $user->format_date($row['lastpage'], $config[PREFIXES::CONFIG . '_disp_time_format']) . $user->lang['ACTIVITY_STATS_LATEST2'] . (($hover_ip) ? ' | ' . $hover_ip : '' ) . ')' : '' );

			// if not hidden user
			if ($row['viewonline'] || ($row['user_type'] == USER_IGNORE))
			{
				if (($row['user_id'] != ANONYMOUS) && ($config[PREFIXES::CONFIG . '_disp_bots'] || ($row['user_type'] != USER_IGNORE)))
				{
					$users_list .= $user->lang['COMMA_SEPARATOR'] . '<span' . $hover_info . '>' . $row['username'] . '</span>' . $disp_time;
					$ids_user[] = $row['user_id'];
				}
			}
			else if (($config[PREFIXES::CONFIG . '_disp_hidden']) && ($auth->acl_get('u_viewonline')))
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

		$record_string = '';
		if ($config[PREFIXES::CONFIG . '_record'])
		{
			$record_string = $this->get_record_string();
		}

		$this->template->assign_vars(array(
			'ACTIVITY_STATS_TOTAL_NEWS' => $this->get_total_news_string($activity),
			'ACTIVITY_STATS_LIST'		=> $user->lang['REGISTERED_USERS'] . ' ' . $users_list,
			'ACTIVITY_STATS_TOTAL'		=> $this->get_total_users_string($activity),
			'ACTIVITY_STATS_EXP'		=> $this->get_explanation_string($config[PREFIXES::CONFIG . '_mode']),
			'ACTIVITY_STATS_RECORD'		=> $record_string,
		));
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
			$d = (int) $config[PREFIXES::CONFIG . '_del_time_d'];
			$h = (int) $config[PREFIXES::CONFIG . '_del_time_h'];
			$m = (int) $config[PREFIXES::CONFIG . '_del_time_m'];
			$s = (int) $config[PREFIXES::CONFIG . '_del_time_s'];

			$plural = $h;
			if (0==$h)
			{
				$plural = $m;
				if (0==$m)
				{
					$plural = $s;
				}
			}
			$explanation = $user->lang('ACTIVITY_STATS_EXP_TIME', $plural);
			$explanation .= $user->lang('ACTIVITY_STATS_DAYS', $d);
			$explanation .= $user->lang('ACTIVITY_STATS_HOURS', $h);
			$explanation .= $user->lang('ACTIVITY_STATS_MINUTES', $m);
			$explanation .= $user->lang('ACTIVITY_STATS_SECONDS', $s);

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
	private function get_record_string()
	{
		global $config, $user;

		$format = $config[PREFIXES::CONFIG . '_record_timeformat'];

		if (MODES::TODAY == $config[PREFIXES::CONFIG . '_mode'])
		{
			return sprintf($user->lang['ACTIVITY_STATS_RECORD_DAY'],
				$config[PREFIXES::CONFIG . '_record_count'],
				$user->format_date($config[PREFIXES::CONFIG . '_record_time'], $format)) . '<br />';
		}
		else
		{
			$period_start = $config[PREFIXES::CONFIG . '_record_time'];
			$period_start -= (3600 * $config[PREFIXES::CONFIG . '_del_time_h']);
 			$period_start -= (  60 * $config[PREFIXES::CONFIG . '_del_time_m']);
			$period_start -=         $config[PREFIXES::CONFIG . '_del_time_s'];
			return sprintf($user->lang['ACTIVITY_STATS_RECORD_PERIOD'],
				$config[PREFIXES::CONFIG . '_record_count'],
				$user->format_date($period_start, $format),
				$user->format_date($config[PREFIXES::CONFIG . '_record_time'], $format)) . '<br />';
		}
	}

	/**
	* Returns the Total string for the "new x" list:
	* Demo:	New topics 1, New posts 2, New users 1
	*/
	static public function get_total_news_string($activity)
	{
		global $config, $user;

		$total_news_string = array();
		if ($config[PREFIXES::CONFIG . '_disp_new_topics'])
		{
			$total_news_string[] = $user->lang('ACTIVITY_STATS_NEW_TOPICS', $activity['new_topics']);
		}
		if ($config[PREFIXES::CONFIG . '_disp_new_posts'])
		{
			$total_news_string[] = $user->lang('ACTIVITY_STATS_NEW_POSTS', $activity['new_posts']);
		}
		if ($config[PREFIXES::CONFIG . '_disp_new_users'])
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
		if ($config[PREFIXES::CONFIG . '_disp_hidden'])
		{
			$total_users_string .= '%s ' . $user->lang('ACTIVITY_STATS_HIDDEN', $activity['count_hidden']);
		}
		if ($config[PREFIXES::CONFIG . '_disp_bots'])
		{
			$total_users_string .= '%s ' . $user->lang('ACTIVITY_STATS_BOTS', $activity['count_bot']);
		}
		if ($config[PREFIXES::CONFIG . '_disp_guests'])
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
