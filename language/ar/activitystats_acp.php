<?php
/**
*
* @package phpBB Extension - Activity Stats
* @copyright (c) 2014 Robet Heim
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
* Translated by Basil Taha Alhitary - www.alhitary.net
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
	'ACTIVITY_STATS_INSTALLED'				=> 'إصدار النسخة : v%s',

	'ACTIVITY_STATS_TITLE'					=> 'إحصائيات اليوم',
	'ACTIVITY_STATS_DISP_SET'				=> 'إظهار الإعدادات',
	'ACTIVITY_STATS_OTHER'					=> 'إعدادات أخرى',

	// acp form
	'ACTIVITY_STATS_DISP_NEW_TOPICS'		=> 'عرض المواضيع الجديدة ',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'	=> 'إظهار عدد المواضيع الجديدة',
	'ACTIVITY_STATS_DISP_NEW_POSTS'			=> 'عرض المشاركات الجديدة ',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'		=> 'إظهار عدد المشاركات الجديدة',
	'ACTIVITY_STATS_DISP_NEW_USERS'			=> 'عرض الأعضاء الجُدد ',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'		=> 'إظهار عدد الأعضاء الجُدد',

	'ACTIVITY_STATS_DISP_BOTS'				=> 'عرض محركات البحث ',
	'ACTIVITY_STATS_DISP_BOTS_EXP'			=> 'ربما يسأل بعض الأعضاء عن محركات البحث ويقلق منها.',
	'ACTIVITY_STATS_DISP_GUESTS'			=> 'عرض الزائرين ',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'		=> 'إظهار عدد الزائرين في الإحصائيات ؟',
	'ACTIVITY_STATS_DISP_HIDDEN'			=> 'عرض الأعضاء المخفيين ',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'		=> 'هل تريد إظهار الأعضاء المخفيين في الإحصائيات ؟ ( الصلاحية مطلوبة )',
	'ACTIVITY_STATS_DISP_TIME'				=> 'عرض الوقت ',
	'ACTIVITY_STATS_DISP_TIME_EXP'			=> 'سيتم إظهار الوقت لجميع الأعضاء. لا يوجد تخصيص للمدراء فقط.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT'		=> 'تنسيق الوقت ',
	'ACTIVITY_STATS_DISP_HOVER'				=> 'عند الإشارة بالماوس',
	'ACTIVITY_STATS_DISP_IP'				=> 'عرض رقم الـ IP',
	'ACTIVITY_STATS_DISP_IP_EXP'			=> 'متاح فقط للأعضاء الذين لديهم الصلاحيات الإدارية , مثل صفحة "الموجودون الآن / viewonline.php" ',

	'ACTIVITY_STATS_RECORD'					=> 'السجل ',
	'ACTIVITY_STATS_RECORD_EXP'				=> 'إظهار وحفظ السجل',
	'ACTIVITY_STATS_RECORD_TIMEFORMAT'		=> 'تنسيق التاريخ لقائمة السجل ',
	'ACTIVITY_STATS_RESET'					=> 'إعادة ضبط السجل ',
	'ACTIVITY_STATS_RESET_EXP'				=> 'إعادة ضبط الوقت والعدد لسجل إحصائيات اليوم.',
	'ACTIVITY_STATS_RESET_TRUE'				=> 'هل أنت متأكد من إعادة ضبط السجل ؟',


	'ACTIVITY_STATS_SETTINGS_SAVED'			=> 'تم التحديث بنجاح.',
	'ACTIVITY_STATS_SORT_BY'				=> 'ترتيب الأعضاء حسب ',
	'ACTIVITY_STATS_SORT_BY_EXP'			=> 'اختار الترتيب الذي تريده لإظهار الأعضاء.',
	'ACTIVITY_STATS_SORT_BY_0'				=> 'إسم المستخدم A -> Z',
	'ACTIVITY_STATS_SORT_BY_1'				=> 'إسم المستخدم Z -> A',
	'ACTIVITY_STATS_SORT_BY_2'				=> 'وقت الزيارة تصاعدياً',
	'ACTIVITY_STATS_SORT_BY_3'				=> 'وقت الزيارة تنازلياً',
	'ACTIVITY_STATS_SORT_BY_4'				=> 'رقم العضو تصاعدياً',
	'ACTIVITY_STATS_SORT_BY_5'				=> 'رقم العضو تنازلياً',

	'ACTIVITY_STATS_CACHE_TIME'				=> 'الملفات المؤقتة (ثواني)',
	'ACTIVITY_STATS_CACHE_TIME_EXP'			=> 'الفترة التي لا يتم إعادة قراءة البيانات من جديد (لتحسين الأداء)',

	'ACTIVITY_STATS_CHECK_PERMISSIONS'		=> 'فحص الصلاحيات ',
	'ACTIVITY_STATS_CHECK_PERMISSIONS_EXP'	=> 'اختيارك "لا" يعني أن جميع الأعضاء يستطيعون مُشاهدة إحصائيات اليوم ( تجاهل إعدادات الصلاحية ); اختيارك "نعم" يعني استخدام صلاحية مُحددة ( مثال : السماح للأعضاء الجُدد فقط : لوحة التحكم الرئيسية ->الصلاحيات->صلاحيات عامة -> صلاحيات المجموعات -> آخر الأعضاء المسجلين -> صلاحيات متقدمة -> عام -> "يستطيع مُشاهدة إحصائيات اليوم")',

	'ACTIVITY_STATS_MODE'					=> 'عرض الأعضاء خلال ',
	'ACTIVITY_STATS_MODE_EXP'				=> 'إظهار الأعضاء خلال اليوم ( 24 ساعة ) , أو خلال فترة مُحددة يمكنك تحديدها من الخيار التالي.',
	'ACTIVITY_STATS_MODE_TODAY'				=> 'اليوم',
	'ACTIVITY_STATS_MODE_PERIOD'			=> 'فترة مُحددة',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'		=> 'أجعلها "صفر" في حالة أنك تريد إظهار الأعضاء خلال الـ24 ساعة',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2'		=> 'هذا الخيار غير فعال في حالة تحديد "اليوم" في الخيار أعلاه',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3'		=> 'ثواني',

));
