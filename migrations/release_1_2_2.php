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
use robertheim\activitystats\prefixes;

class release_1_2_2 extends \phpbb\db\migration\migration
{
	protected $version = "1.2.2-DEV";

	public function effectively_installed()
	{
		return version_compare($this->config[prefixes::CONFIG.'_version'], $this->version, '>=');
	}

	static public function depends_on()
	{
		return array(
			'\robertheim\activitystats\migrations\release_1_2_0',
		);
	}

	public function update_data()
	{
		return array(
			// update version
			array('config.update', array(prefixes::CONFIG.'_version', $this->version)),
		);
	}
}
