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
use robertheim\activitystats\MODES;

class release_1_1_3 extends \phpbb\db\migration\migration
{
	protected $version = "1.1.3-DEV";

	protected $config_prefix = "robertheim_activitystats";

	public function effectively_installed()
	{
		return version_compare($this->config[$this->config_prefix.'_version'], $this->version, '>=');
	}

	static public function depends_on()
	{
		return array(
			'\robertheim\activitystats\migrations\release_1_1_2',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array($this->config_prefix.'_version', $this->version)),
		);
	}
}
