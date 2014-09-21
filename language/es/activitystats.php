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
	'ACTIVITY_STATS'					=> 'Estadísticas de actividad',
	'ACTIVITY_STATS_LATEST1'			=> 'Última a las',
	'ACTIVITY_STATS_LATEST2'			=> '',//used for parts like o'clock in the timedisplay (last at vw:xy "o'clock")

	'ACTIVITY_STATS_NEW_TOPICS'			=> 'Nuevos temas <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_POSTS'			=> 'Nuevos mensajes <strong>%d</strong>',
	'ACTIVITY_STATS_NEW_USERS'			=> 'Nuevos usuarios <strong>%d</strong>',

	'ACTIVITY_STATS_TOTAL'				=> array(
		0		=> 'En total hay <strong>0</strong> usuarios conectados :: ',
		1		=> 'En total hay <strong>%d</strong> usuario conectado :: ',
		2		=> 'En total hay <strong>%d</strong> usuarios conectados :: ',
	),
	'ACTIVITY_STATS_REG_USERS'			=> array(
		0		=> '0 registrados',
		1		=> '%d registrado',
		2		=> '%d registrados',
	),
	'ACTIVITY_STATS_HIDDEN'				=> array(
		0		=> '0 ocultos',
		1		=> '%d oculto',
		2		=> '%d ocultos',
	),
	'ACTIVITY_STATS_BOTS'				=> array(
		0		=> '0 robots',
		1		=> '%d robot',
		2		=> '%d robots',
	),
	'ACTIVITY_STATS_GUESTS'				=> array(
		0		=> '0 invitados',
		1		=> '%d invitado',
		2		=> '%d invitados',
	),

	'ACTIVITY_STATS_WORD'				=> ' y',
	'ACTIVITY_STATS_EXP'				=> 'Los siguientes datos estan basados ​​en usuarios activos hoy',
	'ACTIVITY_STATS_EXP_TIME'			=> 'Los siguientes datos están basados ​​en usuarios activos durante la(s) última(s) ',
	'ACTIVITY_STATS_HOURS'				=> array(
		0		=> '',
		1		=> '%%s %1$s hora',
		2		=> '%%s %1$s horas',
	),
	'ACTIVITY_STATS_MINUTES'			=> array(
		0		=> '',
		1		=> '%%s %1$s minuto',
		2		=> '%%s %1$s minutos',
	),
	'ACTIVITY_STATS_SECONDS'			=> array(
		0		=> '',
		1		=> '%%s %1$s segundo',
		2		=> '%%s %1$s segundos',
	),
	'ACTIVITY_STATS_RECORD'				=> 'La mayoría de usuarios conectados a la vez fue <strong>%1$s</strong> el %2$s',
	'ACTIVITY_STATS_RECORD_TIME'		=> 'La mayoría de usuarios conectados a la vez fue <strong>%1$s</strong> entre %2$s y %3$s',
));
