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
	'ACTIVITY_STATS_INSTALLED'				=> 'Installierte Version: v%s',

	'ACTIVITY_STATS_TITLE'					=> 'Aktivitäts Statistiken',
	'ACTIVITY_STATS_DISP_SET'				=> 'Anzeige Einstellungen',
	'ACTIVITY_STATS_OTHER'					=> 'Andere Einstellungen',

	// acp form
	'ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Anzeige neuer Themen',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Zeigt die Anzahl neuer Themen an',
	'ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Anzeige neuer Beiträge',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Zeigt die Anzahl neuere Beiträge an',
	'ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Anzeige neuer Benutzer',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Zeigt die Anzahl neuer Benutzer an',

	'ACTIVITY_STATS_DISP_BOTS'				=> 'Anzeige von Bots',
	'ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Manche Benutze wissen nicht was Bots sind und wundern sich ggf.',
	'ACTIVITY_STATS_DISP_GUESTS'			=> 'Anzeige von Gästen',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Sollen Gäste im Zähler angezeigt werden?',
	'ACTIVITY_STATS_DISP_HIDDEN'			=> 'Anzeige von unsichtbaren Benutzern',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Sollen unsichtbare Benutzer in der Liste angezeigt werden? (Benötigt separate Berechtigung)',
	'ACTIVITY_STATS_DISP_TIME'				=> 'Anzeige Uhrzeit',
	'ACTIVITY_STATS_DISP_TIME_EXP'			=> 'Alle Benutze sehen es oder keiner. Keine Spezielle Funktion für Administratoren.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Zeitformat',
	'ACTIVITY_STATS_DISP_HOVER'				=> 'Anzeige beim hovern',
	'ACTIVITY_STATS_DISP_IP'				=> 'Anzeige der Benutzer IP Adresse',
	'ACTIVITY_STATS_DISP_IP_EXP'			=> 'Nur für Benutzer mit Administratoren Rechten, wie z.B. für wer-ist-online',

	'ACTIVITY_STATS_RECORD'					=> 'Rekorde',
	'ACTIVITY_STATS_RECORD_EXP'				=> 'Anzeige und Speicherung von Besucher Rekorden',
	'ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Datumsformat für den Besucher Rekord',
	'ACTIVITY_STATS_RESET'					=> 'Besucher Rekord zurücksetzen',
	'ACTIVITY_STATS_RESET_EXP'				=> 'Setzt die Zeit und den Zähler der Aktivitäts Statistiken zurück.',
	'ACTIVITY_STATS_RESET_TRUE'				=> 'Wenn Du diesen Befehl sendest,\nwird der Besucher Rekord zurückgesetzt.',


	'ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Konfiguration wurde erfolgreich aktualisiert.',
	'ACTIVITY_STATS_SORT_BY'				=> 'Sortiere Benutzer nach',
	'ACTIVITY_STATS_SORT_BY_EXP'			=> 'In welcher Reihenfolge sollen die Besucher sortiert werden?',
	'ACTIVITY_STATS_SORT_BY_0'				=> 'Benutzername A -> Z',
	'ACTIVITY_STATS_SORT_BY_1'				=> 'Benutzername Z -> A',
	'ACTIVITY_STATS_SORT_BY_2'				=> 'Zeit des Besuchs aufsteigend',
	'ACTIVITY_STATS_SORT_BY_3'				=> 'Zeit des Besuchs absteigend',
	'ACTIVITY_STATS_SORT_BY_4'				=> 'Benutzer-ID aufsteigend',
	'ACTIVITY_STATS_SORT_BY_5'				=> 'Benutzer-ID absteigend',

	'ACTIVITY_STATS_CACHE_TIME'				=> 'Cache Zeit (Sekunden)',
	'ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Zeitraum in welcher die Daten nicht neu berechnet werden (verbessert die Leistung)',

	'ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Berechtigunen prüfen',
	'ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'Nein = jeder sieht die Aktivitäts Statiktiken. (Ignoriere die Berechtigungseinstellungen); Ja = Verwende die vergebenen Berechtigungen z.B. Erlaube es nur für registierte Benutzer: ACP -> Berechtigungen -> Allgemeine Berechtigungen -> Gruppenrechte -> Registrierte Benutzer -> Erweiterte Berechtigungen -> Diverses -> "Kann Activity Statistiken sehen")',

	'ACTIVITY_STATS_MODE'					=> 'Anzeige Benutzer von ...',
	'ACTIVITY_STATS_MODE_EXP'				=> 'Anzeige Benutzer von heute (seit 00:00 Board Zeitzone), oder von einem Zeitraum definiert in folgender Einstellung:',
	'ACTIVITY_STATS_MODE_TODAY'				=> 'Heute',
	'ACTIVITY_STATS_MODE_PERIOD'			=> 'Zeitraume',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'Gib 0 ein, wenn Du die letzten 24 Stunden angezeigt bekommen möchtest',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'Deaktiviert, wenn Du die Einstellung "Heute" verwendest.',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'Sekunden',

));
