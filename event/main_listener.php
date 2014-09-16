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

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'	=> 'load_activity_stats',
		);
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

	public function load_activity_stats($event)
	{
		// if the user is a bot, we won’t even process this function...
		if ($this->user->data['is_bot'])
		{
			return false;
		}

		$this->user->add_lang_ext('robertheim/activitystats', 'activitystats');

		// obtain user activity data
		$active_users = $this->obtain_active_user_data();
		
		// obtain posts/topics/new users activity
		$activity = $this->obtain_activity_data();
	
		// 24 hour users online list, assign to the template block: lastvisit
		foreach ($active_users as $row)
		{
				$this->template->assign_block_vars('lastvisit', array(
					'USERNAME_FULL'	=> get_username_string((($row['user_type'] == USER_IGNORE) ? 'no_profile' : 'full'), $row['user_id'], $row['username'], $row['user_colour']),
				));
		}
	
		// assign the stats to the template.
		$this->template->assign_vars(array(
			'USERS_24HOUR_TOTAL'			=> $this->user->lang('USERS_24HOUR_TOTAL', sizeof($active_users), $activity['guests']),
			'TWENTYFOURHOUR_TOPICS'			=> $this->user->lang('TWENTYFOURHOUR_TOPICS', $activity['topics']),
			'TWENTYFOURHOUR_POSTS'			=> $this->user->lang('TWENTYFOURHOUR_POSTS', $activity['posts']),
			'TWENTYFOURHOUR_USERS'			=> $this->user->lang('TWENTYFOURHOUR_USERS', $activity['users']),
		));
	}



	/**
	 * Obtain an array of active users over the last 24 hours.
	 *
	 * @return array
	 */
	private function obtain_active_user_data()
	{
		if (($active_users = $this->cache->get('_active_users')) === false)
		{
			$active_users = array();
	
			// grab a list of users who are currently online
			// and users who have visited in the last 24 hours
				$sql_ary = array(
			'SELECT'	=> 'u.user_id, u.user_colour, u.username, u.user_type',
				'FROM'		=> array(USERS_TABLE => 'u'),
				'LEFT_JOIN'	=> array(
					array(
						'FROM'	=> array(SESSIONS_TABLE => 's'),
						'ON'	=> 's.session_user_id = u.user_id',
					),
				),
				'WHERE'		=> 'u.user_lastvisit > ' . (time() - 86400) . ' OR s.session_user_id <> ' . ANONYMOUS,
				'GROUP_BY'	=> 'u.user_id',
				'ORDER_BY'	=> 'u.username',
				);

			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
	
			while ($row = $this->db->sql_fetchrow($result))
			{
	         $active_users[$row['user_id']] = $row;
			}
			$this->db->sql_freeresult($result);
	
			// cache this data for 1 hour, this improves performance
			$this->cache->put('_active_users', $active_users, 3600);
		}
	
		return $active_users;
	}

	/**
	 * obtained cached 24 hour activity data
	 *
	 * @return array
	 */
	private function obtain_activity_data()
	{
		if (($activity = $this->cache->get('_activity_mod')) === false)
		{
			// set interval to 24 hours ago
			$interval = time() - 86400;
	
			$activity = array();
	
			// total new posts in the last 24 hours
			$sql = 'SELECT COUNT(post_id) AS new_posts
					FROM ' . POSTS_TABLE . '
					WHERE post_time > ' . $interval;
			$result = $this->db->sql_query($sql);
			$activity['posts'] = $this->db->sql_fetchfield('new_posts');
			$this->db->sql_freeresult($result);
	
			// total new topics in the last 24 hours
			$sql = 'SELECT COUNT(topic_id) AS new_topics
					FROM ' . TOPICS_TABLE . '
					WHERE topic_time > ' . $interval;
			$result = $this->db->sql_query($sql);
			$activity['topics'] = $this->db->sql_fetchfield('new_topics');
			$this->db->sql_freeresult($result);
	
			// total new users in the last 24 hours, counts inactive users as well
			$sql = 'SELECT COUNT(user_id) AS new_users
					FROM ' . USERS_TABLE . '
					WHERE user_regdate > ' . $interval;
			$result = $this->db->sql_query($sql);
			$activity['users'] = $this->db->sql_fetchfield('new_users');
			$this->db->sql_freeresult($result);
			
			// total guests in the last 24 hours
			$sql = 'SELECT COUNT(DISTINCT session_ip) AS num_guests
				FROM ' . SESSIONS_TABLE . '
				WHERE session_user_id = ' . ANONYMOUS . '
				AND session_time >= ' . $interval;                
			$result = $this->db->sql_query($sql);
			$activity['guests'] = $this->db->sql_fetchfield('num_guests');
			$this->db->sql_freeresult($result); 

			// cache this data for 1 hour, this improves performance
			$this->cache->put('_activity_mod', $activity, 3600);
		}
	
		return $activity;
	}
}
