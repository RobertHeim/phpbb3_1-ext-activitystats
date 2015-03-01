<?php
/**
 *
 * @package phpBB Extension - Activity Stats
 * @copyright (c) 2014 Robet Heim
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
namespace robertheim\activitystats\tests\service;

use robertheim\activitystats\prefixes;
use robertheim\activitystats\tables;
use robertheim\activitystats\service\sessions_manager;
use robertheim\activitystats\tests\mock\cache_mock;
use robertheim\activitystats\tests\mock\user_mock;

class sessions_manager_test extends \phpbb_database_test_case
{
	/**
	 *
	 * @var \robertheim\activitystats\service\sessions_manager
	 */
	protected $sessions_manager;

	protected $table_prefix;

	protected $db;

	protected $cache;

	protected $template;

	protected $user;

	protected function setUp()
	{
		parent::setUp();
		global $table_prefix, $phpbb_root_path, $php_ext;
		$this->table_prefix = $table_prefix;
		$this->db = $this->new_dbal();
		$config = new \phpbb\config\config(
			array(
				prefixes::CONFIG . '_last_clean' => 0,
				prefixes::CONFIG . '_disp_new_topics' => 1,
				prefixes::CONFIG . '_disp_new_posts' => 1,
				prefixes::CONFIG . '_disp_new_users' => 1,
				prefixes::CONFIG . '_disp_new_users' => 1,
				prefixes::CONFIG . '_disp_bots' => 1,
				prefixes::CONFIG . '_disp_hidden' => 1,
				prefixes::CONFIG . '_record_count' => 0,
				prefixes::CONFIG . '_record_time' => 0,
				prefixes::CONFIG . '_sort_by' => sessions_manager::SORT_USERNAME_ASC,
			));
		$this->template = $this->getMock('\phpbb\template\template');
		$this->user = new user_mock();
		$cache_driver = new cache_mock();
		$this->cache = new \phpbb\cache\service($cache_driver, $config, $this->db, $phpbb_root_path, $php_ext);
		$this->sessions_manager = new sessions_manager($this->db, $this->user, $config, $this->cache, $this->table_prefix);

	}

	public function getDataSet()
	{
		return $this->createXMLDataSet(dirname(__FILE__) . '/sessions.xml');
	}

	protected static function setup_extensions()
	{
		return array(
			'robertheim/activitystats'
		);
	}

	public function test_update_sessions()
	{
		$user_id = ANONYMOUS;
		$this->user->data = array(
			'user_id'				=> $user_id,
			'username'				=> 'user2',
			'username_clean'		=> 'user2',
			'user_colour'			=> 'red',
			'user_type'				=> USER_NORMAL,
			'session_viewonline'	=> 1
		);
		$this->user->ip = '1.2.3.4';

		$session = $this->get_user_session($user_id);
		$this->assertFalse($session);

		$timestamp = 1000;
		$this->sessions_manager->update_session($timestamp);
		$session = $this->get_anon_session($this->user->ip);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals(ANONYMOUS, $session['user_id']);
		$this->assertEquals($this->user->ip, $session['user_ip']);
		$this->assertEquals($timestamp, $session['lastpage']);

		$timestamp = 2000;
		$this->sessions_manager->update_session($timestamp);
		$session = $this->get_anon_session($this->user->ip);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals(ANONYMOUS, $session['user_id']);
		$this->assertEquals($this->user->ip, $session['user_ip']);
		$this->assertEquals($timestamp, $session['lastpage']);

		// now we set the user_id, but keep the ip, which means, that the user
		// has logged in; the anonymous session is expected to be removed.
		$old_session = $this->get_anon_session($this->user->ip);
		$this->assertTrue(isset($old_session['user_ip']));
		$user_id = 2;
		$this->user->data['user_id'] = $user_id;
		$timestamp = 3000;
		$this->sessions_manager->update_session($timestamp);
		$session = $this->get_user_session($user_id);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals($user_id, $session['user_id']);
		$this->assertEquals($timestamp, $session['lastpage']);
		$old_user_session = $session;
		$session = $this->get_anon_session($this->user->ip);
		$this->assertFalse($session, 'anonymous session must have been deleted');
		$session = $this->get_session($old_session['id']);
		$this->assertFalse($session, 'anonymous session must have been deleted');

		// update the same session again
		$timestamp = 4000;
		$this->sessions_manager->update_session($timestamp);
		$session = $this->get_user_session($user_id);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals($user_id, $session['user_id']);
		$this->assertEquals($old_user_session['user_id'], $session['user_id']);
		$this->assertEquals($timestamp, $session['lastpage']);
		$old_user_session = $session;
		$session = $this->get_anon_session($this->user->ip);
		$this->assertFalse($session, 'anonymous session must have been deleted');
		$session = $this->get_session($old_session['id']);
		$this->assertFalse($session, 'anonymous session must have been deleted');

		// if the user now is seen as anonymous, both sessions must exist
		// he either logged out (we keep the session for WHO WAS HERE!)
		// or browses the forum from somewhere else, but the same ip (e.g. incognito tab,
		// other browser or other device)
		$user_id = ANONYMOUS;
		$this->user->data['user_id'] = $user_id;
		$timestamp = 5000;
		$this->sessions_manager->update_session($timestamp);
		$session = $this->get_session($old_user_session['id']);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals($old_user_session['user_id'], $session['user_id']);
		$this->assertEquals($old_user_session['lastpage'], $session['lastpage'], 'the logged in user session must not be updated');
		$session = $this->get_anon_session($this->user->ip);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals(ANONYMOUS, $session['user_id']);
		$this->assertEquals($timestamp, $session['lastpage']);

		// update the user session must not affect the anon session
		$user_id = 2;
		$this->user->data['user_id'] = $user_id;
		$timestamp = 6000;
		$this->sessions_manager->update_session($timestamp);
		$session = $this->get_session($old_user_session['id']);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals($old_user_session['user_id'], $session['user_id']);
		$this->assertEquals($timestamp, $session['lastpage']);
		$old_user_session = $session;
		$session = $this->get_anon_session($this->user->ip);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals(ANONYMOUS, $session['user_id']);
		$this->assertNotEquals($timestamp, $session['lastpage']);

		// update the anonymous session again, it must not affect the logged in session
		$user_id = ANONYMOUS;
		$this->user->data['user_id'] = $user_id;
		$timestamp = 7000;
		$this->sessions_manager->update_session($timestamp);
		$session = $this->get_anon_session($this->user->ip);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals(ANONYMOUS, $session['user_id']);
		$this->assertEquals($timestamp, $session['lastpage']);
		$session = $this->get_session($old_user_session['id']);
		$this->assertTrue(isset($session['user_id']));
		$this->assertEquals($old_user_session['user_id'], $session['user_id']);
		$this->assertEquals($old_user_session['lastpage'], $session['lastpage']);
		$this->assertNotEquals($timestamp, $session['lastpage']);
	}

	public function test_prune()
	{
		// create some sessions
		$user_id = 2;
		$this->user->data = array(
			'user_id'				=> $user_id,
			'username'				=> 'user2',
			'username_clean'		=> 'user2',
			'user_colour'			=> 'red',
			'user_type'				=> USER_NORMAL,
			'session_viewonline'	=> 1
		);
		$this->user->ip = '1.2.3.4';

		$timestamp = 1000;
		$this->sessions_manager->update_session($timestamp);
		$user_id = 3;
		$this->user->ip = '1.2.3.5';
		$this->user->data['user_id'] = $user_id;
		$this->sessions_manager->update_session($timestamp);
		$user_id = ANONYMOUS;
		$this->user->ip = '1.2.3.6';
		$this->user->data['user_id'] = $user_id;
		$this->sessions_manager->update_session($timestamp);

		$this->assert_session_count(3);
		$this->sessions_manager->prune(-1);
		$this->assert_session_count(3);
		$this->sessions_manager->prune(0);
		$this->assert_session_count(3);
		$this->sessions_manager->prune($timestamp);
		$this->assert_session_count(3);
		$this->sessions_manager->prune($timestamp+1);
		$this->assert_session_count(0);
	}

	private function assert_session_count($session_count_expected)
	{
		$sql = 'SELECT COUNT(*) as count
				FROM ' . $this->table_prefix . tables::SESSIONS;
		$result = $this->db->sql_query($sql);
		$count = (int) $this->db->sql_fetchfield('count');
		$this->db->sql_freeresult($result);
		$this->assertEquals($session_count_expected, $count);
	}

	private function get_user_session($user_id)
	{
		$sql = 'SELECT *
				FROM ' . $this->table_prefix . tables::SESSIONS . '
				WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $row;
	}

	private function get_anon_session($user_ip)
	{
		$sql = 'SELECT *
				FROM ' . $this->table_prefix . tables::SESSIONS . '
				WHERE user_id = ' . ANONYMOUS . ' AND user_ip= \'' . $this->db->sql_escape($user_ip) . "'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $row;
	}

	private function get_session($id)
	{
		$sql = 'SELECT *
				FROM ' . $this->table_prefix . tables::SESSIONS . '
				WHERE id  = ' . (int) $id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $row;
	}
}
