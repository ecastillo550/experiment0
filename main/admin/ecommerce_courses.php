<?php
/* For licensing terms, see /dokeos_license.txt */

/**
 * Display a list of courses and search for courses
* @package dokeos.admin
*/


// Language files that should be included
$language_file = array('admin','courses');

// resetting the course id
$cidReset = true;

// setting the help
$help_content = 'platformadministrationcourselist';

// including the global Dokeos file
require dirname(__FILE__) .('/../inc/global.inc.php');
// including additional libraries
require_once (api_get_path(LIBRARY_PATH).'course.lib.php');
require_once (api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php');
require_once (api_get_path(LIBRARY_PATH).'sortabletable.class.php');
require_once '../gradebook/lib/be/gradebookitem.class.php';
require_once '../gradebook/lib/be/category.class.php';
require_once api_get_path(SYS_PATH) .'main/core/model/ecommerce/EcommerceCatalog.php';


$objCatalog = new EcommerceCatalog();

// section for the tabs
$this_section=SECTION_PLATFORM_ADMIN;

// user permissions
api_protect_admin_script();


// Setting the breadcrumbs
$interbreadcrumb[] = array ("url" => 'index.php', "name" => get_lang('PlatformAdmin'));


$tool_name = get_lang('CourseList');

// Display the header
Display :: display_header($tool_name);


//Actions
echo '<div class="actions">';
//echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/catalogue_management.php">' . Display::return_icon('pixel.gif',get_lang('Catalogue'), array('class' => 'toolactionplaceholdericon toolactioncataloguecircle')) . get_lang('Catalogue') . '</a>';
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/ecommerce_courses.php">' . Display :: return_icon('pixel.gif', get_lang('Courses'),array('class' => 'toolactionplaceholdericon toolactionadmincourse')) . get_lang('Courses') . '</a>';
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/course_export.php">'.Display::return_icon('pixel.gif',get_lang('Export'),array('class' => 'toolactionplaceholdericon toolactionexportcourse')).get_lang('Export').'</a>';
echo '<a href="javascript:void(0)" id="btn-search">'.Display::return_icon('pixel.gif',get_lang('Search'), array('class' => 'toolactionplaceholdericon toolactionsearch')).get_lang('Search').'</a>';
echo '</div>';


// Create a sortable table with the course data
$get_course_data = array($objCatalog , 'getCourseEcommerceData');
$get_total_number_course_data = array($objCatalog , 'getTotalNumberCourseEcommerce');

$get_course_action_buttons = array($objCatalog , 'getCourseCatalogButtonList');


$table = new SortableTable('courses_ecommerce', $get_total_number_course_data, $get_course_data, 2);
$parameters=array();

$table->set_additional_parameters($parameters);
$table->set_header(0, '', false,'width="10px"');
$table->set_header(1, get_lang('Code'), false, 'width="20px"');
$table->set_header(2, get_lang('Title'), true);
$table->set_header(3, get_lang('Visibility'), true,'width="20px"');
$table->set_header(4, get_lang('Price'),true,'width="50px"');
$table->set_header(5, get_lang('DateStart'),false,'width="65px"');
$table->set_header(6, get_lang('ExpirationDate'),false,'width="50px"');
$table->set_header(7, get_lang('Status'),false,'width="50px"');
$table->set_header(8, get_lang('Actions'), false,'width="170px"');
$table->set_column_filter(8,$get_course_action_buttons);
$table->set_form_actions(array ('delete_courses' => get_lang('DeleteCourse')),'course');



// start the content div
echo '<div id="content">';
$table->display();
echo '</div>';


echo '<div class="actions">';
echo '&nbsp;';
echo '</div>';

// display the footer
Display :: display_footer();