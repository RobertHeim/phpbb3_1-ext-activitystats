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
	'TWENTYFOURHOUR_STATS'	=> 'Aktivit&auml;t der letzten 24 Stunden',
	'TWENTYFOURHOUR_TOPICS'	=> 'Neue Themen: <strong>%d</strong>',
	'TWENTYFOURHOUR_POSTS'	=> 'Neue Beitr&auml;ge: <strong>%d</strong>',
	'TWENTYFOURHOUR_USERS'	=> 'Neue Benutzer: <strong>%d</strong>',
	'USERS_24HOUR_TOTAL'	=> '%d Benutzer waren in den letzten 24 Stunden aktiv',
));
?>

