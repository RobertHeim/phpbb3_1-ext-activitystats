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
	'ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Visualizza i nuovi argomenti',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Visualizza il numero di nuovi argomenti',
	'ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Visualizza i nuovi messaggi',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Visualizza il numero di nuovi messaggi',
	'ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Visualizza i nuovi utenti',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Visualizza il numero di nuovi utenti',

	'ACTIVITY_STATS_DISP_BOTS'				=> 'Visualizza bots',
	'ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Some user might wonder what bots are and fear them.',
	'ACTIVITY_STATS_DISP_GUESTS'			=> 'Visualizza gli ospiti',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Visualizza gli ospitini nel contatore ?',
	'ACTIVITY_STATS_DISP_HIDDEN'			=> 'Visualizza gli utente nascosti',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Should hidden users be displayed in the list? (permission necessary)',
	'ACTIVITY_STATS_DISP_TIME'				=> 'Show time',
	'ACTIVITY_STATS_DISP_TIME_EXP'			=> 'All user see it or none. No special function for Admins.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Timeformat',
	'ACTIVITY_STATS_DISP_HOVER'				=> 'Display on hover',
	'ACTIVITY_STATS_DISP_IP'				=> 'Visualizza l\'indirizzo ip degli utenti',
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

	'ACTIVITY_STATS_MODE'					=> 'Visualizza gli utenti di ...',
	'ACTIVITY_STATS_MODE_EXP'				=> 'Visualizza gli utenti di oggi (dalle 00:00 dell\'orario del server), o del periodo impostato nella successivo parametro.',
	'ACTIVITY_STATS_MODE_TODAY'				=> 'Oggi',
	'ACTIVITY_STATS_MODE_PERIOD'			=> 'Periodo di tempo',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'type 0, se vuoi visualizzare gli utenti delle ultime 24 ore',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'disattivato, se si &egrave; scelto "oggi"',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'secondi',

));
