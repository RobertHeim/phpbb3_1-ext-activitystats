<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
* Dutch translation by Rembert Oldenboom (http://www.floating-point.nl/ - v.1.0.0 - 2015-06-14
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
	'ACTIVITY_STATS_INSTALLED'				=> 'Geïnstalleerde versie: v%s',

	'ACTIVITY_STATS_TITLE'					=> 'Activiteitsstatistieken',
	'ACTIVITY_STATS_DISP_SET'				=> 'Weergave settings',
	'ACTIVITY_STATS_OTHER'					=> 'Overige settings',

	// acp form
	'ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Toon nieuwe onderwerpen',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Toont het aantal nieuw aangemaakte onderwerpen',
	'ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Toont nieuwe bijdragen',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Toont het aantal nieuwe bijdragen',
	'ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Toon nieuwe gebruikers',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Toont het aantal nieuwe gebruikers',

	'ACTIVITY_STATS_DISP_BOTS'				=> 'Toon bots',
	'ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Sommige gebruikers vragen zich mogelijk af wat bots zijn en maken zich daar zorgen over',
	'ACTIVITY_STATS_DISP_GUESTS'			=> 'Toon gasten',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Moeten gasten in de teller worden getoond?',
	'ACTIVITY_STATS_DISP_HIDDEN'			=> 'Toon verborgen gebruikers',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Moeten verborgen gebruikers worden getoond in de lijst? (toestemming noodzakelijk)',
	'ACTIVITY_STATS_DISP_TIME'				=> 'Toon tijd',
	'ACTIVITY_STATS_DISP_TIME_EXP'			=> 'Alle gebruikers zien het, of niemand. Geen speciale admin functie.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Tijdformaat',
	'ACTIVITY_STATS_DISP_HOVER'				=> 'Toon bij hover',
	'ACTIVITY_STATS_DISP_IP'				=> 'Toon user-ip',
	'ACTIVITY_STATS_DISP_IP_EXP'			=> 'Alleen voor gebruikers met admin rechten, zoals bv. viewonline.php',

	'ACTIVITY_STATS_RECORD'					=> 'Statistieken opslaan',
	'ACTIVITY_STATS_RECORD_EXP'				=> 'Tonen en opslaan bezoeker statistieken.',
	'ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Datumformaat voor opgeslagen statistieken',
	'ACTIVITY_STATS_RESET'					=> 'Reset statistieken',
	'ACTIVITY_STATS_RESET_EXP'				=> 'Reset de tijd en teller van de statistieken.',
	'ACTIVITY_STATS_RESET_TRUE'				=> 'Met dit commando worden de bezoekerstatistieken op nul teruggezet.',


	'ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Configuratie succesvol aangepast.',
	'ACTIVITY_STATS_SORT_BY'				=> 'Gebruikers sorteren op',
	'ACTIVITY_STATS_SORT_BY_EXP'			=> 'In welke volgorde moeten gebruikers worden getoond?',
	'ACTIVITY_STATS_SORT_BY_0'				=> 'Gebruikersnaam A -> Z',
	'ACTIVITY_STATS_SORT_BY_1'				=> 'Gebruikersnaam Z -> A',
	'ACTIVITY_STATS_SORT_BY_2'				=> 'Tijdstip bezoek, oplopend',
	'ACTIVITY_STATS_SORT_BY_3'				=> 'Tijdstip bezoek, aflopend',
	'ACTIVITY_STATS_SORT_BY_4'				=> 'User-ID oplopend',
	'ACTIVITY_STATS_SORT_BY_5'				=> 'User-ID aflopend',

	'ACTIVITY_STATS_CACHE_TIME'				=> 'Cache periode (seconden)',
	'ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Periode waarin de data niet opnieuw herberekend wordt (verbetert prestatie)',

	'ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Permissies checken',
	'ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'Ja=iedereen mag de aciviteitenstatistieken zien (negeert permissie-settings); Ja=gebruik geconfigureerde permissies (bv. om alleen toe te staan voor geregistreerde gebruikers:  ACP->permissies->globale permissies -> groep permissies -> registered users -> uitgebeide permissies -> diverse -> "Kan activiteitenstatistieken zien")',

	'ACTIVITY_STATS_MODE'					=> 'Toon gebruikers van ...',
	'ACTIVITY_STATS_MODE_EXP'				=> 'Toon de gebruikers van vandaag (vanaf 00:00 forum-tijdzone), of de hieronder opgegeven periode.',
	'ACTIVITY_STATS_MODE_TODAY'				=> 'Vandaag',
	'ACTIVITY_STATS_MODE_PERIOD'			=> 'Periode',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'geef 0 om de gebruikers van de laatste 24 uur weer te geven',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'uitgeschakeld wanneer je "vandaag" hebt gekozen',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'seconden',

));
