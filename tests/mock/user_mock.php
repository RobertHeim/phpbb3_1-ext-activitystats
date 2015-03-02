<?php
/**
 *
 * @package phpBB Extension - Activity Stats
 * @copyright (c) 2014 Robet Heim
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
namespace robertheim\activitystats\tests\mock;

class user_mock extends \phpbb\user
{
	public $data = array();

	public function __construct()
	{
	}
}
