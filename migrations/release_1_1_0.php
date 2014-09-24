<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace robertheim\activitystats\migrations;

/**
* @ignore
*/
use robertheim\activitystats\PREFIXES;

class release_1_1_0 extends \phpbb\db\migration\migration
{
	protected $version = "1.1.0-DEV";

    public function effectively_installed() {
		$installed_version = $this->config[PREFIXES::CONFIG.'_version'];
		return isset($installed_version) && version_compare($installed_version, $this->version, '>=');
    }

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema() {
		return array(
			'add_tables' => array(
				$this->table_prefix . PREFIXES::TABLE . '_activitystats'	=> array(
					'COLUMNS'		=> array(
						'id'				=> array('UINT', NULL, 'auto_increment'),
						'user_id'			=> array('UINT', 0),
						'username'			=> array('VCHAR', ''),
						'username_clean'	=> array('VCHAR', ''),
						'user_colour'		=> array('VCHAR:6', ''),
						'user_ip'			=> array('VCHAR:40', '127.0.0.1'),
						'user_type'			=> array('UINT:2', 1),
						'viewonline'		=> array('UINT:1', 1),
						'lastpage'			=> array('TIMESTAMP', 0),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'			=> array(
						'u_id_ip'	=> array('INDEX', array('user_id', 'user_ip')),
		               ),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'    => array(
	            $this->table_prefix . PREFIXES::TABLE . '_activitystats',
        	),
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array(PREFIXES::CONFIG.'_version', $this->version)),
			array('config.add', array(PREFIXES::CONFIG.'_cache_time', 600)),
			array('config.add', array(PREFIXES::CONFIG.'_record_ips', 1, true)),
			array('config.add', array(PREFIXES::CONFIG.'_record_time', time(), true)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_new_topics', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_new_posts', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_new_users', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_bots', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_guests', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_hidden', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_time', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_ip', 0)),
			array('config.add', array(PREFIXES::CONFIG.'_del_time_h', 24)),
			array('config.add', array(PREFIXES::CONFIG.'_del_time_m', 0)),
			array('config.add', array(PREFIXES::CONFIG.'_del_time_s', 0)),
			array('config.add', array(PREFIXES::CONFIG.'_sort_by', 3)),
			array('config.add', array(PREFIXES::CONFIG.'_record', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_record_timestamp', 'D j. M Y')),
			array('config.add', array(PREFIXES::CONFIG.'_reset_time', 1)),
			array('config.add', array(PREFIXES::CONFIG.'_last_clean', 0)),
			array('config.add', array(PREFIXES::CONFIG.'_disp_time_format', 'H:i')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_ACTIVITY_STATS_TITLE'
			)),

			array('module.add', array(
				'acp', 'ACP_ACTIVITY_STATS_TITLE', array(
					'module_basename'	=> '\robertheim\activitystats\acp\activitystats_module',
					'auth'		=> 'ext_robertheim/activitystats && acl_a_board',
					'modes'		=> array('settings'),
				),
			)),
		);
	}

}
