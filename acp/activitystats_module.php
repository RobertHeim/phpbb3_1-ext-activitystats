<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace robertheim\activitystats\acp;

class activitystats_module
{
	private $conf_prefix = 'robertheim_activitystats';

	/** @var string */
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user, $cache;

		// shortcut
		$conf_prefix = $this->conf_prefix;

		// common language file for DATEFORMAT_EXPLANATION
		$user->add_lang('acp/board');

		// Add the activitystats ACP lang file
		$user->add_lang_ext('robertheim/activitystats', 'activitystats_acp');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'activitystats';

		// Set the page title for our ACP page
		$this->page_title = 'ACP_ACTIVITY_STATS_SETTINGS';

		// Define the name of the form for use as a form key
		$form_name = 'activity/stats';
		add_form_key($form_name);

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key($form_name))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set($conf_prefix.'_disp_new_topics', $request->variable($conf_prefix.'_disp_new_topics', 0));
			$config->set($conf_prefix.'_disp_new_posts', $request->variable($conf_prefix.'_disp_new_posts', 0));
			$config->set($conf_prefix.'_disp_new_users', $request->variable($conf_prefix.'_disp_new_users', 0));
			$config->set($conf_prefix.'_disp_bots', $request->variable($conf_prefix.'_disp_bots', 0));
			$config->set($conf_prefix.'_disp_guests', $request->variable($conf_prefix.'_disp_guests', 0));
			$config->set($conf_prefix.'_disp_hidden', $request->variable($conf_prefix.'_disp_hidden', 0));
			$config->set($conf_prefix.'_disp_time', $request->variable($conf_prefix.'_disp_time', 0));
			$config->set($conf_prefix.'_disp_time_format', $request->variable($conf_prefix.'_disp_time_format', 'H:i'));
			$config->set($conf_prefix.'_disp_ip', $request->variable($conf_prefix.'_disp_ip', 0));
			$config->set($conf_prefix.'_version', $request->variable($conf_prefix.'_version', 0));
			$config->set($conf_prefix.'_del_time_h', $request->variable($conf_prefix.'_del_time_h', 0));
			$config->set($conf_prefix.'_del_time_m', $request->variable($conf_prefix.'_del_time_m', 0));
			$config->set($conf_prefix.'_del_time_s', $request->variable($conf_prefix.'_del_time_s', 0));
			$config->set($conf_prefix.'_sort_by', $request->variable($conf_prefix.'_sort_by', 0));
			$config->set($conf_prefix.'_cache_time', $request->variable($conf_prefix.'_cache_time', 600));
			$config->set($conf_prefix.'_record', $request->variable($conf_prefix.'_record', 0));
			$config->set($conf_prefix.'_record_timestamp', $request->variable($conf_prefix.'_record_timestamp', 'D j. M Y'));
			if ($request->variable($conf_prefix.'_reset', 0) > 0)
			{
				$config->set($conf_prefix.'_record_ips', 1);
				$config->set($conf_prefix.'_record_time', time());
				$config->set($conf_prefix.'_reset_time', time());
			}
			// clear cache
			$cache->destroy('_robertheim_activitystats');

			trigger_error($user->lang('ACTIVITY_STATS_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'ACTIVITY_STATS_MOD_VERSION'		=> $user->lang('ACTIVITY_STATS_INSTALLED', $config[$conf_prefix.'_version']),
			'ACTIVITY_STATS_DISP_NEW_TOPICS'	=> $config[$conf_prefix.'_disp_new_topics'],
			'ACTIVITY_STATS_DISP_NEW_POSTS'		=> $config[$conf_prefix.'_disp_new_posts'],
			'ACTIVITY_STATS_DISP_NEW_USERS'		=> $config[$conf_prefix.'_disp_new_users'],
			'ACTIVITY_STATS_DISP_BOTS'			=> $config[$conf_prefix.'_disp_bots'],
			'ACTIVITY_STATS_DISP_GUESTS'		=> $config[$conf_prefix.'_disp_guests'],
			'ACTIVITY_STATS_DISP_HIDDEN'		=> $config[$conf_prefix.'_disp_hidden'],
			'ACTIVITY_STATS_DISP_TIME'			=> $config[$conf_prefix.'_disp_time'],
			'ACTIVITY_STATS_DISP_TIME_FORMAT'	=> $config[$conf_prefix.'_disp_time_format'],
			'ACTIVITY_STATS_DISP_IP'			=> $config[$conf_prefix.'_disp_ip'],
			'ACTIVITY_STATS_VERSION'			=> $config[$conf_prefix.'_version'],
			'ACTIVITY_STATS_DEL_TIME_H'			=> $config[$conf_prefix.'_del_time_h'],
			'ACTIVITY_STATS_DEL_TIME_M'			=> $config[$conf_prefix.'_del_time_m'],
			'ACTIVITY_STATS_DEL_TIME_S'			=> $config[$conf_prefix.'_del_time_s'],
			'ACTIVITY_STATS_SORT_BY'			=> $config[$conf_prefix.'_sort_by'],
			'ACTIVITY_STATS_CACHE_TIME'			=> $config[$conf_prefix.'_cache_time'],
			'ACTIVITY_STATS_RECORD'				=> $config[$conf_prefix.'_record'],
			'ACTIVITY_STATS_RECORD_TIMESTAMP'	=> $config[$conf_prefix.'_record_timestamp'],
			'U_ACTION'							=> $this->u_action,
		));

	}
}
