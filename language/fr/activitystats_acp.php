<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
* French translation by ForumsFaciles (http://www.forumsfaciles.fr) - v.1.0.0 - 2015-02-04 --- 1:43am
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
	'ACTIVITY_STATS_INSTALLED'				=> 'Version installée: v%s',

	'ACTIVITY_STATS_TITLE'					=> 'Statistiques d’activité',
	'ACTIVITY_STATS_DISP_SET'				=> 'Paramètres d’affichage',
	'ACTIVITY_STATS_OTHER'					=> 'Autres paramètres',

	// acp form
	'ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'Afficher les nouveaux sujets',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'Affiche le nombre de nouveaux sujets',
	'ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'Afficher les nouveaux messages',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'Affiche les nouveaux messages',
	'ACTIVITY_STATS_DISP_NEW_USERS'			=> 'Afficher les nouveaux membres',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'Affiche le nombre de nouveaux membres',

	'ACTIVITY_STATS_DISP_BOTS'				=> 'Afficher les robots',
	'ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'Certains utilisateurs pourraient s’interroger sur ce que sont les robots et en avoir peur.',
	'ACTIVITY_STATS_DISP_GUESTS'			=> 'Afficher les visiteurs',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'Afficher les visiteurs dans le compteur ?',
	'ACTIVITY_STATS_DISP_HIDDEN'			=> 'Afficher les membres masqués',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'Les membres masqués doivent-ils être affichés dans la liste ? (permissions nécessaires)',
	'ACTIVITY_STATS_DISP_TIME'				=> 'Afficher l’heure',
	'ACTIVITY_STATS_DISP_TIME_EXP'			=> 'Visible par tous les utilisateurs ou par personne. Pas de fonction spéciale pour les administrateurs.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'Format de la date',
	'ACTIVITY_STATS_DISP_HOVER'				=> 'Afficher au survol de la souris',
	'ACTIVITY_STATS_DISP_IP'				=> 'Afficher l’IP de l’utilisateur',
	'ACTIVITY_STATS_DISP_IP_EXP'			=> 'Uniquement pour les membres avec des permissions d’administration, tout comme sur la page viewonline.php',

	'ACTIVITY_STATS_RECORD'					=> 'Record',
	'ACTIVITY_STATS_RECORD_EXP'				=> 'Afficher et enregistrer le record',
	'ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'Format de la date pour le record',
	'ACTIVITY_STATS_RESET'					=> 'Réinitialiser le record',
	'ACTIVITY_STATS_RESET_EXP'				=> 'Réinitialise l’heure et le compteur du record des statistiques d’activité.',
	'ACTIVITY_STATS_RESET_TRUE'				=> 'Si vous validez ce formulaire, le record sera réinitialisé.',


	'ACTIVITY_STATS_SETTINGS_SAVED'			=> 'Configuration mise à jour correctement.',
	'ACTIVITY_STATS_SORT_BY'				=> 'Trier les utilisateurs selon leur  :',
	'ACTIVITY_STATS_SORT_BY_EXP'			=> 'Dans quel ordre les utilisateurs doivent-ils être affichés ?',
	'ACTIVITY_STATS_SORT_BY_0'				=> 'Pseudo A -> Z',
	'ACTIVITY_STATS_SORT_BY_1'				=> 'Pseudo Z -> A',
	'ACTIVITY_STATS_SORT_BY_2'				=> 'Heure de visite croissante',
	'ACTIVITY_STATS_SORT_BY_3'				=> 'Heure de visite décroissante',
	'ACTIVITY_STATS_SORT_BY_4'				=> 'ID d’utilisateur croissante',
	'ACTIVITY_STATS_SORT_BY_5'				=> 'ID d’utilisateur décroissante',

	'ACTIVITY_STATS_CACHE_TIME'				=> 'Durée du cache (secondes)',
	'ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'Durée pendant laquelle les données ne sont pas recalculées (améliore les performances)',

	'ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'Vérifier les permissions',
	'ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'non= tout le monde peut consulter les statistiques d’activité (ne tient pas compte des permissions) ; oui = utilisation des permissions (ex. : autoriser aux utilisateurs enregistrés seulement : PCA -> permissions -> permissions globales -> permissions des groupes -> utilisateurs enregistrés -> permissions avancées -> divers -> « peut consulter les statistiques d’activité »)',

	'ACTIVITY_STATS_MODE'					=> 'Affichage des utilisteurs...',
	'ACTIVITY_STATS_MODE_EXP'				=> 'Afficher les utilisateurs du jour (depuis minuit, selon le fuseau horaire du forum), ou selon la période de temps définie dans l’option suivante.',
	'ACTIVITY_STATS_MODE_TODAY'				=> 'Aujourd’hui',
	'ACTIVITY_STATS_MODE_PERIOD'			=> 'Période de temps',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'mettez 0, si vous souhaitez afficher les utilisateurs des dernières 24 heures',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'désactivé, si vous avez choisi « aujourd’hui »',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'secondes',

));
