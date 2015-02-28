<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @translation (c) 2015 HPK
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
	'ACTIVITY_STATS_INSTALLED'				=> 'Zainstalowana wersja: v%s',

	'ACTIVITY_STATS_TITLE'					=> 'Statystyki Aktywności',
	'ACTIVITY_STATS_DISP_SET'				=> 'Opcje',
	'ACTIVITY_STATS_OTHER'					=> 'Inne opcje',

	// acp form
	'ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Pokaż nowe tematy',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Wyświetla liczbę nowych tematów.',
	'ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Pokaż nowe posty',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Wyświetla liczbę nowych postów.',
	'ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Pokaż nowych użytkowników',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Wyświetla liczbę nowych użytkowinków.',

	'ACTIVITY_STATS_DISP_BOTS'				=> 'Pokaż boty',
	'ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Wyświetla liczbę botów jakie odwiedziły forum.',
	'ACTIVITY_STATS_DISP_GUESTS'			=> 'Pokaż gości',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Wyświetla liczbę gości odwiedzających forum.',
	'ACTIVITY_STATS_DISP_HIDDEN'			=> 'Pokaż ukrytych użytkowników',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Wyświetla ukrytych użytkowników na liście? (konieczne uprawnienia).',
	'ACTIVITY_STATS_DISP_TIME'				=> 'Pokaż czas',
	'ACTIVITY_STATS_DISP_TIME_EXP'			=> 'Wyświetla czas, kiedy użytkownik był ostatni raz aktywny.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Format daty',
	'ACTIVITY_STATS_DISP_HOVER'				=> 'Wyświetlaj po najechaniu myszką.',
	'ACTIVITY_STATS_DISP_IP'				=> 'Pokaż IP użytkowników',
	'ACTIVITY_STATS_DISP_IP_EXP'			=> 'Tylko dla użytkowników z uprawnieniami administracyjnymi.',

	'ACTIVITY_STATS_RECORD'					=> 'Pokaż rekord',
	'ACTIVITY_STATS_RECORD_EXP'				=> 'Wyświetla i zapamiętuje rekord.',
	'ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Format daty dla rekordu',
	'ACTIVITY_STATS_RESET'					=> 'Resetuj rekord',
	'ACTIVITY_STATS_RESET_EXP'				=> '',
	'ACTIVITY_STATS_RESET_TRUE'				=> 'Jeżeli zatwierdzisz zmiany,\nrekord zostanie zresetowany.',


	'ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Konfiguracja została zmieniona.',
	'ACTIVITY_STATS_SORT_BY'				=> 'Sortuj użytkowników',
	'ACTIVITY_STATS_SORT_BY_EXP'			=> 'W jakiej kolejności będą wyświetlani użytkownicy?',
	'ACTIVITY_STATS_SORT_BY_0'				=> 'Nazwa użytkownika A -> Z',
	'ACTIVITY_STATS_SORT_BY_1'				=> 'Nazwa użytkownika Z -> A',
	'ACTIVITY_STATS_SORT_BY_2'				=> 'Czas wizyty - rosnąco',
	'ACTIVITY_STATS_SORT_BY_3'				=> 'Czas wizyty - malejąco',
	'ACTIVITY_STATS_SORT_BY_4'				=> 'ID użytkownika - rosnąco',
	'ACTIVITY_STATS_SORT_BY_5'				=> 'ID użytkownika - malejjąco',

	'ACTIVITY_STATS_CACHE_TIME'				=> 'Cache (sekundy)',
	'ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Okres, co ile statystyki są przeliczane (poprawia wydajność).',

	'ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Sprawdź uprawnienia',
	'ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'Jeżeli wybierzesz "<strong>Nie</strong>" - każdy powinien zobaczyć statystyki aktywności (ustawienia uprawnień są ignorowane). Jeżeli wybierzesz "<strong>Tak</strong>" - wykorzystane zostaną ustawienia uprawnień dla poszczególnych grup.',

	'ACTIVITY_STATS_MODE'					=> 'Wyświetl użytkowników  z ...',
	'ACTIVITY_STATS_MODE_EXP'				=> 'Wyświetlanie użytkowników z dzisiaj lub z okresu czasu (konfiguracja poniżej).',
	'ACTIVITY_STATS_MODE_TODAY'				=> 'Dzisiaj',
	'ACTIVITY_STATS_MODE_PERIOD'			=> 'Okres czasu',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'Wpisz 0, jeżeli chcesz wyświetlić użytkowników z ostatnich 24 godzin.',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'wyłączone, jeżeli wybrałeś opcję "dzisiaj"',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'sekund',

));