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
	'TWENTYFOURHOUR_STATS'	=> 'Activity over the last 24 hours',
	'TWENTYFOURHOUR_TOPICS'	=> 'New Topics <strong>%d</strong>',
	'TWENTYFOURHOUR_POSTS'	=> 'New Posts <strong>%d</strong>',
	'TWENTYFOURHOUR_USERS'	=> 'New users <strong>%d</strong>',
	'USERS_24HOUR_TOTAL'	=> '%d Users and %d guests were active over the last 24 hours',
));
?>

