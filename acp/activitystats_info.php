<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace robertheim\activitystats\acp;

class activitystats_info
{
	function module()
	{
		return array(
			'filename'	=> '\robertheim\activitystats\acp\activitystats_module',
			'title'		=> 'ACP_ACTIVITY_STATS_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_ACTIVITY_STATS_SETTINGS',
					'auth' => 'ext_robertheim/activitystats && acl_a_board',
					'cat' => array('ACP_ACTIVITY_STATS_TITLE')
				),
			),
		);
	}
}
