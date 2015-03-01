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
	'ACTIVITY_STATS'					=> 'Aktivität Statistiken',
	'ACTIVITY_STATS_LATEST1'			=> 'zuletzt um',
	'ACTIVITY_STATS_LATEST2'			=> ' Uhr',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'ACTIVITY_STATS_NEW_TOPICS'			=> 'Neue Themen <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_POSTS'			=> 'Neue Beiträge <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_USERS'			=> 'Neue Benutzer <strong>%d</strong>',

	'ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'Insgesamt waren <strong>0</strong> Benutzer online :: ',
		1		=> 'Insgesamt war <strong>%d</strong> Benutzer online :: ',
		2		=> 'Insgesamt waren <strong>%d</strong> Benutzer online :: ',
	),
	'ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 Registrierte',
		1		=> '%d Registrierter',
		2		=> '%d Registrierte',
	),
	'ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 Unsichtbare',
		1		=> '%d Unsichtbarer',
		2		=> '%d Unsichtbare',
	),
	'ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 Bots',
		1		=> '%d Bot',
		2		=> '%d Bots',
	),
	'ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 Gäste',
		1		=> '%d Gast',
		2		=> '%d Gäste',
	),

	'ACTIVITY_STATS_WORD'				=> ' und',
	'ACTIVITY_STATS_EXP'				=> 'Die folgenden Daten basieren auf den heutigen Aktivitäten',
	'ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'Die folgenden Daten basieren auf den Benutzer Aktivitäten gerade jetzt', // h=m=s=0
		1		=> 'Die folgenden Daten basieren auf den Benutzer Aktivitäten seit ', // first non zero value is 1
		2		=> 'Die folgenden Daten basieren auf den Benutzer Aktivitäten seit ', // first non zero value is >1
	),
	'ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s Stunde',
		2		=> '%%s %1$s Stunden',
	),
	'ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s Minute',
		2		=> '%%s %1$s Minuten',
	),
	'ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s Sekunde',
		2		=> '%%s %1$s Sekunden',
	),
	'ACTIVITY_STATS_RECORD_DAY'			=> 'Der bisherige Rekord von <strong>%1$s</strong> Besuchern lag am %2$s',
	'ACTIVITY_STATS_RECORD_PERIOD'		=> 'Der absolute Besucher Rekord liegt bei <strong>%1$s</strong> zwischen %2$s und %3$s',
));