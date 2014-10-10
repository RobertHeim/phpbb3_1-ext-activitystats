<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
    exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
// for the normal sites
	'ACTIVITY_STATS'					=> 'Activity Statistics',
	'ACTIVITY_STATS_LATEST1'			=> 'last at',
	'ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'ACTIVITY_STATS_NEW_TOPICS'			=> 'New topics <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_POSTS'			=> 'New posts <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_USERS'			=> 'New users <strong>%d</strong>',

	'ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'In total there were <strong>0</strong> users online :: ',
		1		=> 'In total there was <strong>%d</strong> user online :: ',
		2		=> 'In total there were <strong>%d</strong> users online :: ',
	),
	'ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 registered',
		1		=> '%d registered',
		2		=> '%d registered',
	),
	'ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 hidden',
		1		=> '%d hidden',
		2		=> '%d hidden',
	),
	'ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 bots',
		1		=> '%d bot',
		2		=> '%d bots',
	),
	'ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 guests',
		1		=> '%d guest',
		2		=> '%d guests',
	),

	'ACTIVITY_STATS_WORD'				=> ' and',
	'ACTIVITY_STATS_EXP'				=> 'The following data is based on users active today',
	'ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'The following data is based on users active right now', // h=m=s=0 
		1		=> 'The following data is based on users active over the past ', // first non zero value is 1
		2		=> 'The following data is based on users active over the past ', // first non zero value is >1
	),
	'ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s hour',
		2		=> '%%s %1$s hours',
	),
	'ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minute',
		2		=> '%%s %1$s minutes',
	),
	'ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s second',
		2		=> '%%s %1$s seconds',
	),
	'ACTIVITY_STATS_RECORD_DAY'			=> 'Most users ever online was <strong>%1$s</strong> on %2$s',
	'ACTIVITY_STATS_RECORD_PERIOD'		=> 'Most users ever online was <strong>%1$s</strong> between %2$s and %3$s',
));

