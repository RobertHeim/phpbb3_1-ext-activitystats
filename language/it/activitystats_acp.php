<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/


/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'ACTIVITY_STATS_INSTALLED'				=> 'Versione Installata: v%s',

	'ACTIVITY_STATS_TITLE'					=> 'Activity Stats',
	'ACTIVITY_STATS_DISP_SET'				=> 'Impostazioni Visualizzazione',
	'ACTIVITY_STATS_OTHER'					=> 'Altre Impostazioni',

	// acp form
	'ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Show new topics',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Display the count of new topics',
	'ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Show new posts',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Display the count of new posts',
	'ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Show new users',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Display the count of new users',

	'ACTIVITY_STATS_DISP_BOTS'				=> 'Show bots',
	'ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Some user might wonder what bots are and fear them.',
	'ACTIVITY_STATS_DISP_GUESTS'			=> 'Show guests',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Display guests on the counter?',
	'ACTIVITY_STATS_DISP_HIDDEN'			=> 'Show hidden users',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Should hidden users be displayed in the list? (permission necessary)',
	'ACTIVITY_STATS_DISP_TIME'				=> 'Show time',
	'ACTIVITY_STATS_DISP_TIME_EXP'			=> 'All user see it or none. No special function for Admins.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Timeformat',
	'ACTIVITY_STATS_DISP_HOVER'				=> 'Display on hover',
	'ACTIVITY_STATS_DISP_IP'				=> 'Show user-ip',
	'ACTIVITY_STATS_DISP_IP_EXP'			=> 'Just for the users with administrative permissions, like on the viewonline.php',

	'ACTIVITY_STATS_RECORD'					=> 'Record',
	'ACTIVITY_STATS_RECORD_EXP'				=> 'Display and save record',
	'ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Dateformat for the record',
	'ACTIVITY_STATS_RESET'					=> 'Reset record',
	'ACTIVITY_STATS_RESET_EXP'				=> 'Resets the time and counter of the Activity Stats record.',
	'ACTIVITY_STATS_RESET_TRUE'				=> 'If you submit this form,\nthe record will be reseted.',


	'ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Configuration updated successfully.',
	'ACTIVITY_STATS_SORT_BY'				=> 'Sort users by',
	'ACTIVITY_STATS_SORT_BY_EXP'			=> 'In which order shall the user be displayed?',
	'ACTIVITY_STATS_SORT_BY_0'				=> 'Username A -> Z',
	'ACTIVITY_STATS_SORT_BY_1'				=> 'Username Z -> A',
	'ACTIVITY_STATS_SORT_BY_2'				=> 'Time of visit ascending',
	'ACTIVITY_STATS_SORT_BY_3'				=> 'Time of visit descending',
	'ACTIVITY_STATS_SORT_BY_4'				=> 'User-ID ascending',
	'ACTIVITY_STATS_SORT_BY_5'				=> 'User-ID descending',

	'ACTIVITY_STATS_CACHE_TIME'				=> 'Cache time (seconds)',
	'ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Duration in which the data is not re-calculated (improves performance)',

	'ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Check permissions',
	'ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'no=everybody should see the activity stats (ignore permission-settings); yes=use configured permissions (e.g. allow it for registered users only: ACP->permissions->global permissions -> group permissions -> registered users -> Advanced permissions -> Misc -> "Can see activity stats")',

	'ACTIVITY_STATS_MODE'					=> 'Displaying users of ...',
	'ACTIVITY_STATS_MODE_EXP'				=> 'Displaying users of today (since 00:00 board-timezone), or of the period set in the next option.',
	'ACTIVITY_STATS_MODE_TODAY'				=> 'Today',
	'ACTIVITY_STATS_MODE_PERIOD'			=> 'Period of time',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'type 0, if you want to display the users of the last 24h',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'disabled, if you have choosen "today"',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'seconds',

));
