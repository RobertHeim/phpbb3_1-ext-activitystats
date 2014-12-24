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
		// result/return value
		$re = array();
		
		// shortcut
		$p = PERMISSIONS::SEE_STATS;

		// add permissions
		$re[] = array('permission.add', array($p));
		
		// Set permissions for the board roles
		if ($this->role_exists('ROLE_ADMIN_FULL')) {
			$re[] = array('permission.permission_set', array('ROLE_ADMIN_FULL', $p));
		}
		if ($this->role_exists('ROLE_USER_FULL')) {
			$re[] = array('permission.permission_set', array('ROLE_USER_FULL', $p));
		}
		if ($this->role_exists('ROLE_USER_STANDARD')) {
			$re[] = array('permission.permission_set', array('ROLE_USER_STANDARD', $p));
		}
		
		// switch indicating if permissions should be checked
		$re[] = array('config.add', array(PREFIXES::CONFIG.'_check_permissions', 0));
		
		// update version
		$re[] = array('config.update', array(PREFIXES::CONFIG.'_version', $this->version));
		
		return $re;
	}
	
	/**
	 * Checks whether the given role does exist or not.
	 *
	 * @param String $role the name of the role
	 * @return true if the role exists, false otherwise.
	 */
	private function role_exists($role) {
		$sql_array = array(
			'SELECT'	=> '1 AS found',
			'FROM'		=> array(ACL_ROLES_TABLE => 'r'),
			'WHERE'		=> $this->db->sql_in_set('r.role_name', array($role)),
		);
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$found = (int) $this->db->sql_fetchfield('found');
		return ($found > 0);
	}
	
}
