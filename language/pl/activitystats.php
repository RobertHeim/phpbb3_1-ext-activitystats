<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @translation (c) 2015 HPK
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
	'ACTIVITY_STATS'					=> 'Statystyki aktywności',
	'ACTIVITY_STATS_LATEST1'			=> 'ostatnio o',
	'ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'ACTIVITY_STATS_NEW_TOPICS'			=> 'Nowych tematów: <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_POSTS'			=> 'Nowych postów: <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_USERS'			=> 'Nowych użytkowników: <strong>%d</strong>',

	'ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'W sumie było <strong>0</strong> użytkowników online :: ',
		1		=> 'W sumie był <strong>%d</strong> użytkownik online :: ',
		2		=> 'W sumie było <strong>%d</strong> użytkowników online :: ',
	),
	'ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 zarejestrowanych',
		1		=> '%d zarejestrowany',
		2		=> '%d zarejestrowanych',
	),
	'ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 ukrytych',
		1		=> '%d ukryty',
		2		=> '%d ukrytych',
	),
	'ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 botów',
		1		=> '%d bot',
		2		=> '%d boty',
	),
	'ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 gości',
		1		=> '%d gość',
		2		=> '%d gości',
	),

	'ACTIVITY_STATS_WORD'				=> ' i',
	'ACTIVITY_STATS_EXP'				=> 'Poniższe dane są oparte na użytkownikach aktywnych dzisiaj',
	'ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'Poniższe dane pokazują użytkowników aktywnych teraz', // h=m=s=0 
		1		=> 'Poniższe dane pokazują użytkowników aktywnych w ciągu ostatniej ', // first non zero value is 1
		2		=> 'Poniższe dane pokazują użytkowników aktywnych w ciągu ostatnich ', // first non zero value is >1
	),
	'ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s godziny',
		2		=> '%%s %1$s godzin',
	),
	'ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minuty',
		2		=> '%%s %1$s minut',
	),
	'ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s sekundy',
		2		=> '%%s %1$s sekund',
	),
	'ACTIVITY_STATS_RECORD_DAY'			=> 'Najwięcej użytkowników (<strong>%1$s</strong>) było online dnia %2$s',
	'ACTIVITY_STATS_RECORD_PERIOD'		=> 'Najwięcej użytkowników (<strong>%1$s</strong>) było online między %2$s a %3$s',
));