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
use robertheim\activitystats\PERMISSIONS;
use robertheim\activitystats\PREFIXES;

class release_1_2_0 extends \phpbb\db\migration\migration
{
	protected $version = "1.2.0-DEV";

	public function effectively_installed()
	{
		return version_compare($this->config[PREFIXES::CONFIG.'_version'], $this->version, '>=');
	}

	static public function depends_on()
	{
		return array(
			'\robertheim\activitystats\migrations\release_1_1_2',
		);
	}

	public function update_data()
	{
		// shortcut
		$p = PERMISSIONS::SEE_STATS;
		return array(
			// add permissions
			array('permission.add', array($p)),

			// Set permissions for the board roles
			array('permission.permission_set', array('ROLE_ADMIN_FULL', $p)),
			array('permission.permission_set', array('ROLE_USER_FULL', $p)),
			array('permission.permission_set', array('ROLE_USER_STANDARD', $p)),

			// switch indicating if permissions should be checked
			array('config.add', array(PREFIXES::CONFIG.'_check_permissions', 0)),

			// update version
			array('config.update', array(PREFIXES::CONFIG.'_version', $this->version)),
		);
	}
}
