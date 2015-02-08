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
	'ACTIVITY_STATS_INSTALLED'				=> 'Installed Version: v%s',

	'ACTIVITY_STATS_TITLE'					=> 'Estadísticas de actividad',
	'ACTIVITY_STATS_DISP_SET'				=> 'Ajustes de pantalla',
	'ACTIVITY_STATS_OTHER'					=> 'Otros ajustes',

	// acp form
	'ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Mostrar nuevos temas',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Muestra la cantidad de nuevos temas',
	'ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Mostrar nuevos mensajes',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Muestra la cantidad de nuevos mensajes',
	'ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Mostrar nuevos usuarios',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Muestra la cantidad de nuevos usuarios',

	'ACTIVITY_STATS_DISP_BOTS'				=> 'Mostrar robots',
	'ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Algunos usuarios podrían preguntarse qué son los robots y les temen.',
	'ACTIVITY_STATS_DISP_GUESTS'			=> 'Mostrar invitados',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'		=> '¿Mostrar invitados en el contador?',
	'ACTIVITY_STATS_DISP_HIDDEN'			=> 'Mostrar usuarios ocultos',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> '¿Si el usuario esta oculto, será mostrado en la lista? (permisos necesarios)',
	'ACTIVITY_STATS_DISP_TIME'				=> 'Mostrar hora',
	'ACTIVITY_STATS_DISP_TIME_EXP'			=> 'Ver todos los usuarios o ninguno. Sin función especial para Administradores.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Formato de hora',
	'ACTIVITY_STATS_DISP_HOVER'				=> 'Mostrar en hover (suspendido)',
	'ACTIVITY_STATS_DISP_IP'				=> 'Mostrar IP de usuario',
	'ACTIVITY_STATS_DISP_IP_EXP'			=> 'Sólo para los usuarios con permisos administrativos, como en el viewonline.php',

	'ACTIVITY_STATS_RECORD'					=> 'Registro',
	'ACTIVITY_STATS_RECORD_EXP'				=> 'Mostrar y guardar el registro',
	'ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Formato de fecha del registro',
	'ACTIVITY_STATS_RESET'					=> 'Resetear registro',
	'ACTIVITY_STATS_RESET_EXP'				=> 'Restablece el contador de tiempo y del registro de actividades estadísticas.',
	'ACTIVITY_STATS_RESET_TRUE'				=> 'Si envia este formulario, el registro será reseteado.',


	'ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Configuración actualizada correctamente.',
	'ACTIVITY_STATS_SORT_BY'				=> 'Ordenar los usuarios por',
	'ACTIVITY_STATS_SORT_BY_EXP'			=> '¿En qué orden se mostrará al usuario?',
	'ACTIVITY_STATS_SORT_BY_0'				=> 'Nombre de usuario A -> Z',
	'ACTIVITY_STATS_SORT_BY_1'				=> 'Nombre de usuario Z -> A',
	'ACTIVITY_STATS_SORT_BY_2'				=> 'Tiempo de visita ascendente',
	'ACTIVITY_STATS_SORT_BY_3'				=> 'Tiempo de visita descendente',
	'ACTIVITY_STATS_SORT_BY_4'				=> 'Usuario-ID ascendente',
	'ACTIVITY_STATS_SORT_BY_5'				=> 'Usuario-ID descendiente',

	'ACTIVITY_STATS_CACHE_TIME'				=> 'Tiempo de cache (segundos)',
	'ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Período en el que no se volverá a calcular los datos (mejora el rendimiento)',

	'ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Comprobar permisos',
	'ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'No=Todos verán las estadísticas de actividad (ignorar los ajustes de permisos); Si=Usar permisos configurados (por ejemplo, permitir sólo para usuarios registrados: ACP -> Permisos -> Permisos Globales -> Permisos de grupos -> Usuarios registrados -> Permisos avanzados -> Varios -> "Puede ver las estadísticas de actividad")',

	'ACTIVITY_STATS_MODE'					=> 'Viendo usuarios de ...',
	'ACTIVITY_STATS_MODE_EXP'				=> 'Viendo usuarios de hoy, o el plazo fijado en la siguiente opción.',
	'ACTIVITY_STATS_MODE_TODAY'				=> 'Hoy',
	'ACTIVITY_STATS_MODE_PERIOD'			=> 'Período de tiempo',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'tipo 0, si desea mostrar a los usuarios de las últimas 24h',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'deshabilitado, si ha elegido "Hoy"',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'segundos',

));
