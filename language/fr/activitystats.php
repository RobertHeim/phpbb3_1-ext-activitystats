<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
* French translation by ForumsFaciles (http://www.forumsfaciles.fr) & Galixte (http://www.galixte.com)
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
	'ACTIVITY_STATS'					=> 'Statistiques d’activité',
	'ACTIVITY_STATS_LATEST1'			=> 'dernière connexion le',
	'ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'ACTIVITY_STATS_NEW_TOPICS'			=> 'Nouveau(x) sujet(s) : <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_POSTS'			=> 'Nouveau(x) message(s) : <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_USERS'			=> 'Nouveau(x) membre(s) : <strong>%d</strong>',

	'ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'Il n’y avait <strong>aucun</strong> utilisateur en ligne : ',
		1		=> 'Il y avait <strong>%d</strong> utilisateur en ligne : ',
		2		=> 'Il y avait <strong>%d</strong> utilisateurs en ligne : ',
	),
	'ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> 'aucun membre',
		1		=> '%d membre',
		2		=> '%d membres',
	),
	'ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> 'aucun masqué',
		1		=> '%d masqué',
		2		=> '%d masqués',
	),
	'ACTIVITY_STATS_BOTS'				=> array(
		0		=> 'aucun robot',
		1		=> '%d robot',
		2		=> '%d robots',
	),
	'ACTIVITY_STATS_GUESTS'				=> array(
		0		=> 'aucun invité',
		1		=> '%d invité',
		2		=> '%d invités',
	),

	'ACTIVITY_STATS_WORD'				=> ' et',
	'ACTIVITY_STATS_EXP'				=> 'Les données suivantes sont basées sur les utilisateurs actifs d’aujourd’hui',
	'ACTIVITY_STATS_EXP_TIME'			=> array(
		0		=> 'Les données suivantes sont basées sur les utilisateurs actifs à l’instant', // d=h=m=s=0
		1		=> 'Les données suivantes sont basées sur les utilisateurs actifs durant la dernière ', // first non zero value is 1
		2		=> 'Les données suivantes sont basées sur les utilisateurs actifs durant les dernières ', // first non zero value is >1
	),
	'ACTIVITY_STATS_DAYS'				=> array(
		0		=> '',
		1		=> '%%s %1$s jour',
		2		=> '%%s %1$s jours',
	),
	'ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s heure',
		2		=> '%%s %1$s heures',
	),
	'ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minute',
		2		=> '%%s %1$s minutes',
	),
	'ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s seconde',
		2		=> '%%s %1$s secondes',
	),
	'ACTIVITY_STATS_RECORD_DAY'			=> 'Le nombre maximum d’utilisateurs en ligne était de <strong>%1$s</strong> le %2$s',
	'ACTIVITY_STATS_RECORD_PERIOD'		=> 'Le nombre maximum d’utilisateurs en ligne était de <strong>%1$s</strong> entre le %2$s et le %3$s',
));
