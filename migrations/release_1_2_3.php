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

class release_1_2_3 extends \phpbb\db\migration\migration
{
	protected $version = "1.2.3-DEV";

	public function effectively_installed()
	{
		return version_compare($this->config[prefixes::CONFIG.'_version'], $this->version, '>=');
	}

	static public function depends_on()
	{
		return array(
			'\robertheim\activitystats\migrations\release_1_2_2',
		);
	}

	public function update_data()
	{
		global $config;
		// rename "record_timestamp" to "record_timeformat"
		$format = $config[prefixes::CONFIG.'_record_timestamp'];
		// rename "record_ips" to "record_count"
		$record_count = $config[prefixes::CONFIG.'_record_ips'];
		return array(
			array('config.remove', array(prefixes::CONFIG.'_record_timestamp')),
			array('config.remove', array(prefixes::CONFIG.'_record_ips')),
			array('config.add', array(prefixes::CONFIG.'_record_timeformat', $format)),
			array('config.add', array(prefixes::CONFIG.'_record_count', $record_count, true)),
			// update version
			array('config.update', array(prefixes::CONFIG.'_version', $this->version)),
		);
	}
}
