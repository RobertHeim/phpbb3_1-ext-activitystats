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
	'ACTIVITY_STATS'					=> 'Statistiche Attive',
	'ACTIVITY_STATS_LATEST1'			=> 'alle',
	'ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'ACTIVITY_STATS_NEW_TOPICS'			=> 'Nuovi argomenti <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_POSTS'			=> 'Nuovi messaggi <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_USERS'			=> 'Nuovi utenti <strong>%d</strong>',

	'ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'In totale ci sono stati <strong>0</strong> utenti in line : ',
		1		=> 'In totale c\'&egrave; stato <strong>%d</strong> utente in linea : ',
		2		=> 'In totale ci sono stati <strong>%d</strong> utenti in linea : ',
	),
	'ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 registrati',
		1		=> '%d registrato',
		2		=> '%d registrati',
	),
	'ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 nascosti',
		1		=> '%d nascosto',
		2		=> '%d nascosti',
	),
	'ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 bots',
		1		=> '%d bot',
		2		=> '%d bots',
	),
	'ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 ospiti',
		1		=> '%d ospite',
		2		=> '%d ospiti',
	),

	'ACTIVITY_STATS_WORD'				=> ' and',
	'ACTIVITY_STATS_EXP'				=> 'I seguenti dati si basano sugli utenti attivi oggi',
	'ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'I seguenti dati si basano sugli utenti in linea in questo momento', // h=m=s=0
		1		=> 'I seguenti dati si basano sugli utenti attivi negli ultimi ', // first non zero value is 1
		2		=> 'I seguenti dati si basano sugli utenti attivi negli ultimi ', // first non zero value is >1
	),
	'ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s ora',
		2		=> '%%s %1$s ore',
	),
	'ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minuto',
		2		=> '%%s %1$s minuti',
	),
	'ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s secondo',
		2		=> '%%s %1$s secondi',
	),
	'ACTIVITY_STATS_RECORD_DAY'			=> 'Record di utenti connessi giornalmente &egrave; stato di <strong>%1$s</strong> il %2$s',
	'ACTIVITY_STATS_RECORD_PERIOD'		=> 'Record di utenti connessi &egrave; stato di <strong>%1$s</strong> tra il %2$s ed il %3$s',
));
