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
use robertheim\activitystats\modes;
use robertheim\activitystats\permissions;
use robertheim\activitystats\prefixes;

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

	protected $config;
	protected $auth;
	protected $template;
	protected $user;
	protected $db;
	protected $sessions_manager;
	protected $table_prefix;

	public function __construct(\phpbb\config\config $config,
		\phpbb\auth\auth $auth,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\robertheim\activitystats\service\sessions_manager $sessions_manager,
		$table_prefix)
	{
		$this->config = $config;
		$this->auth = $auth;
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
		$this->sessions_manager = $sessions_manager;
		$this->table_prefix	= $table_prefix;
	}

	public function main($event)
	{
		$this->sessions_manager->update_session(time());
		if (!$this->config[prefixes::CONFIG.'_check_permissions'] || $this->auth->acl_get(permissions::SEE_STATS))
		{
			$this->user->add_lang_ext('robertheim/activitystats', 'activitystats');

			// find timeperiod: today (mode=1) or other configured time period (mode=2)
			$timestamp = 0;
			if (modes::TODAY == $this->config[prefixes::CONFIG . '_mode'])
			{
				// today
				// we calculate timestamp of midnight in the users timezone

				$timezone_name = empty($this->user->data['user_timezone']) ? $this->config['board_timezone'] : $this->user->data['user_timezone'];
				$timezone = new \DateTimeZone($timezone_name);
				$now = new \DateTime("now", $timezone);
				$midnight = clone $now;
				$midnight->setTime(0,0,0);
				$timestamp = $midnight->getTimestamp();
				// we prune when the last timezone on earth hits the new day.
				// that means all where last visit was before UTC-12 -24hours
				$this->sessions_manager->prune(time() - 129600); // -60*60*12-24*60*60
			}
			else
			{
				// use UTC for period
				$timestamp = time();
				$timestamp -= (86400 * $this->config[prefixes::CONFIG . '_del_time_d']);
				$timestamp -= ( 3600 * $this->config[prefixes::CONFIG . '_del_time_h']);
				$timestamp -= (   60 * $this->config[prefixes::CONFIG . '_del_time_m']);
				$timestamp -=          $this->config[prefixes::CONFIG . '_del_time_s'];
				// prune everything before the period
				$this->sessions_manager->prune($timestamp);
			}

			// after updating and pruning the sessions table check if a new record is reached
			$this->sessions_manager->check_record();

			// don't re-calculate the data within that time, but use the cached data from the last calculation.
			$cachetime = $this->config[prefixes::CONFIG . '_cache_time'];

			// calculate the data to display or read it from the cache
			$activity = $this->sessions_manager->obtain_data($timestamp, $cachetime);
			$this->display($activity);
		}
	}

	/**
	* Fetches the user-list and putting the stuff into the template.
	*
	* @param array $activity activity data based on the boards configuration
	*/
	private function display(array $activity)
	{
		if ($this->config[prefixes::CONFIG . '_disp_new_topics'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_TOPICS'	=> $this->user->lang('ACTIVITY_STATS_NEW_TOPICS', $activity['new_topics']),
			));
		}

		if ($this->config[prefixes::CONFIG . '_disp_new_posts'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_POSTS'	=> $this->user->lang('ACTIVITY_STATS_NEW_POSTS', $activity['new_posts']),
			));
		}

		if ($this->config[prefixes::CONFIG . '_disp_new_users'])
		{
			$this->template->assign_vars(array(
				'ACTIVITY_STATS_NEW_USERS'	=> $this->user->lang('ACTIVITY_STATS_NEW_USERS', $activity['new_users']),
			));
		}

		$users_list = $this->calc_users_to_display($activity);

		$users_str = '';
		if (sizeof($users_list) > 0)
		{
			$users_str = join($this->user->lang['COMMA_SEPARATOR'], $users_list);
		}
		else
		{
			$users_str = $this->user->lang['NO_ONLINE_USERS'];
		}

		$record_string = '';
		if ($this->config[prefixes::CONFIG . '_record'])
		{
			$record_string = $this->get_record_string();
		}

		$this->template->assign_vars(array(
			'ACTIVITY_STATS_TOTAL_NEWS' => $this->get_total_news_string($activity),
			'ACTIVITY_STATS_LIST'		=> $this->user->lang['REGISTERED_USERS'] . ' ' . $users_str,
			'ACTIVITY_STATS_TOTAL'		=> $this->get_total_users_string($activity),
			'ACTIVITY_STATS_EXP'		=> $this->get_explanation_string(),
			'ACTIVITY_STATS_RECORD'		=> $record_string,
		));
	}

	/**
	 * Calculates the list of users to display.
	 *
	 * @param array $activity activity data based on the boards configuration
	 * @return array an array containing the user representations as string
	 */
	private function calc_users_to_display(array $activity)
	{
		$users_list = array();
		foreach ($activity['users_list'] as $key => $row)
		{
			$hover_time = (($this->config[prefixes::CONFIG . '_disp_time'] == '2') ? $this->user->lang['ACTIVITY_STATS_LATEST1'] . '&nbsp;' . $this->user->format_date($row['lastpage'], $this->config[prefixes::CONFIG . '_disp_time_format']) . $this->user->lang['ACTIVITY_STATS_LATEST2'] : '' );
			$hover_ip = ($this->auth->acl_get('a_') && $this->config[prefixes::CONFIG . '_disp_ip']) ? $this->user->lang['IP'] . ':&nbsp;' . $row['user_ip'] : '';
			$hover_info = (($hover_time || $hover_ip) ? ' title="' . $hover_time . (($hover_time && $hover_ip) ? ' | ' : '') . $hover_ip . '"' : '');
			$disp_time = (($this->config[prefixes::CONFIG . '_disp_time'] == '1') ? '&nbsp;(' . $this->user->lang['ACTIVITY_STATS_LATEST1'] . '&nbsp;' . $this->user->format_date($row['lastpage'], $this->config[prefixes::CONFIG . '_disp_time_format']) . $this->user->lang['ACTIVITY_STATS_LATEST2'] . (($hover_ip) ? ' | ' . $hover_ip : '' ) . ')' : '' );

			// if not hidden user
			if ($row['viewonline'] || ($row['user_type'] == USER_IGNORE))
			{
				if (($row['user_id'] != ANONYMOUS) && ($this->config[prefixes::CONFIG . '_disp_bots'] || ($row['user_type'] != USER_IGNORE)))
				{
					$users_list[] = '<span' . $hover_info . '>' . $row['username'] . '</span>' . $disp_time;
				}
			}
			else if (($this->config[prefixes::CONFIG . '_disp_hidden']) && ($this->auth->acl_get('u_viewonline')))
			{
				$users_list[] = '<em' . $hover_info . '>' .$row['username'] . '</em>' . $disp_time;
			}
		}
		return $users_list;
	}

	/**
	* Returns the Explanation string for the online list:
	* Demo:	based on users active today
	*		based on users active over the past 30 minutes
	*/
	private function get_explanation_string()
	{
		$mode = $this->config[prefixes::CONFIG . '_mode'];
		if ($mode)
		{
			return $this->user->lang['ACTIVITY_STATS_EXP'];
		}
		else
		{
			$d = (int) $this->config[prefixes::CONFIG . '_del_time_d'];
			$h = (int) $this->config[prefixes::CONFIG . '_del_time_h'];
			$m = (int) $this->config[prefixes::CONFIG . '_del_time_m'];
			$s = (int) $this->config[prefixes::CONFIG . '_del_time_s'];

			$plural = $d;
			if (0==$d)
			{
				$plural = $h;
				if (0==$h)
				{
					$plural = $m;
					if (0==$m)
					{
						$plural = $s;
					}
				}
			}
			$explanation = $this->user->lang('ACTIVITY_STATS_EXP_TIME', $plural);
			$explanation .= $this->user->lang('ACTIVITY_STATS_DAYS', $d);
			$explanation .= $this->user->lang('ACTIVITY_STATS_HOURS', $h);
			$explanation .= $this->user->lang('ACTIVITY_STATS_MINUTES', $m);
			$explanation .= $this->user->lang('ACTIVITY_STATS_SECONDS', $s);

			switch (substr_count($explanation, '%s'))
			{
				case 3:
					return sprintf($explanation, '', $this->user->lang['COMMA_SEPARATOR'], $this->user->lang['ACTIVITY_STATS_WORD']);
				case 2:
					return sprintf($explanation, '', $this->user->lang['ACTIVITY_STATS_WORD']);
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
		$format = $this->config[prefixes::CONFIG . '_record_timeformat'];

		if (modes::TODAY == $this->config[prefixes::CONFIG . '_mode'])
		{
			// the record is calculated based on the boards timezone, because this
			// is a global value to the board itself and not to a specific user
			// its stored as UTC timestamp
			// and we display it in the boards timezone (and give a zimezone hint in the shown string)
			// it is not displayed in the users timezone, because it does not make any
			// sense to calculate it in another timezone than it is displayed.

			$utc_timezone = $this->sessions_manager->get_utc_timezone();
			$board_timezone = $this->sessions_manager->get_board_timezone();

			$record_time_utc = $this->config[prefixes::CONFIG . '_record_time'];
			$datetime = new \phpbb\datetime($this->user, "@$record_time_utc", $utc_timezone);
			$datetime->setTimezone($board_timezone);

			return sprintf($this->user->lang['ACTIVITY_STATS_RECORD_DAY'],
				$this->config[prefixes::CONFIG . '_record_count'],
				$datetime->format($format)) . ' (' . $board_timezone->getName() . ')' . '<br />';
		}
		else
		{
			$period_start = $this->config[prefixes::CONFIG . '_record_time'];
			$period_start -= (86400 * $this->config[prefixes::CONFIG . '_del_time_d']);
			$period_start -= ( 3600 * $this->config[prefixes::CONFIG . '_del_time_h']);
			$period_start -= (   60 * $this->config[prefixes::CONFIG . '_del_time_m']);
			$period_start -=          $this->config[prefixes::CONFIG . '_del_time_s'];
			return sprintf($this->user->lang['ACTIVITY_STATS_RECORD_PERIOD'],
				$this->config[prefixes::CONFIG . '_record_count'],
				$this->user->format_date($period_start, $format),
				$this->user->format_date($this->config[prefixes::CONFIG . '_record_time'], $format)) . '<br />';
		}
	}

	/**
	* Returns the Total string for the "new x" list:
	* Demo:	New topics 1, New posts 2, New users 1
	*/
	private function get_total_news_string($activity)
	{
		$total_news_string = array();
		if ($this->config[prefixes::CONFIG . '_disp_new_topics'])
		{
			$total_news_string[] = $this->user->lang('ACTIVITY_STATS_NEW_TOPICS', $activity['new_topics']);
		}
		if ($this->config[prefixes::CONFIG . '_disp_new_posts'])
		{
			$total_news_string[] = $this->user->lang('ACTIVITY_STATS_NEW_POSTS', $activity['new_posts']);
		}
		if ($this->config[prefixes::CONFIG . '_disp_new_users'])
		{
			$total_news_string[] = $this->user->lang('ACTIVITY_STATS_NEW_USERS', $activity['new_users']);
		}
		return join(" &bull; ", $total_news_string);
	}

	/**
	* Returns the Total string for the online list:
	* Demo:	In total there was 1 user online :: 1 registered, 0 hidden, 0 bots and 0 guests
	*/
	private function get_total_users_string($activity)
	{
		$total_users_string = $this->user->lang('ACTIVITY_STATS_TOTAL', $activity['count_total']);
		$total_users_string .= $this->user->lang('ACTIVITY_STATS_REG_USERS', $activity['count_reg']);
		if ($this->config[prefixes::CONFIG . '_disp_hidden'])
		{
			$total_users_string .= '%s ' . $this->user->lang('ACTIVITY_STATS_HIDDEN', $activity['count_hidden']);
		}
		if ($this->config[prefixes::CONFIG . '_disp_bots'])
		{
			$total_users_string .= '%s ' . $this->user->lang('ACTIVITY_STATS_BOTS', $activity['count_bot']);
		}
		if ($this->config[prefixes::CONFIG . '_disp_guests'])
		{
			$total_users_string .= '%s ' . $this->user->lang('ACTIVITY_STATS_GUESTS', $activity['count_guests']);
		}

		switch (substr_count($total_users_string, '%s'))
		{
			case 3:
				return sprintf($total_users_string, $this->user->lang['COMMA_SEPARATOR'], $this->user->lang['COMMA_SEPARATOR'], $this->user->lang['ACTIVITY_STATS_WORD']);
			case 2:
				return sprintf($total_users_string, $this->user->lang['COMMA_SEPARATOR'], $this->user->lang['ACTIVITY_STATS_WORD']);
			case 1:
				return sprintf($total_users_string, $this->user->lang['ACTIVITY_STATS_WORD']);
			default:
				return $total_users_string;
		}
	}
}
