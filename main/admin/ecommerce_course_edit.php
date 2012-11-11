<?php
// Language files that should be included
$language_file = array('admin','courses');

// resetting the course id
$cidReset = true;

// setting the help
$help_content = 'platformadministrationcourselist';

// including the global Dokeos file
require  dirname(__FILE__) . DIRECTORY_SEPARATOR .'../inc/global.inc.php';
// including additional libraries
require_once (api_get_path(LIBRARY_PATH).'course.lib.php');
require_once (api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php');
require_once api_get_path(SYS_PATH) .'main/core/model/ecommerce/EcommerceCatalog.php';

$courseCode = (isset($_REQUEST['course_code']) && trim($_REQUEST['course_code']) != '' ) ? trim($_GET['course_code']) : NULL;

if( is_null( $courseCode ) )
{
    header('location: ecommerce_courses.php');
}

// section for the tabs
$this_section=SECTION_PLATFORM_ADMIN;

// user permissions
api_protect_admin_script();

// Setting the breadcrumbs
$interbreadcrumb[] = array ("url" => 'index.php', "name" => get_lang('PlatformAdmin'));

$objCatalog = new EcommerceCatalog();

$tool_name = get_lang('Edit') . ' ' . get_lang('Course') ;

// Display the header
Display :: display_header($tool_name);


//Actions
echo '<div class="actions">';
//echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/catalogue_management.php">' . Display::return_icon('pixel.gif',get_lang('Catalogue'), array('class' => 'toolactionplaceholdericon toolactioncataloguecircle')) . get_lang('Catalogue') . '</a>';
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/ecommerce_courses.php">' . Display :: return_icon('pixel.gif', get_lang('Courses'),array('class' => 'toolactionplaceholdericon toolactionadmincourse')) . get_lang('Courses') . '</a>';
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/course_export.php">'.Display::return_icon('pixel.gif',get_lang('Export'),array('class' => 'toolactionplaceholdericon toolactionexportcourse')).get_lang('Export').'</a>';
echo '<a href="javascript:void(0)" id="btn-search">'.Display::return_icon('pixel.gif',get_lang('Search'), array('class' => 'toolactionplaceholdericon toolactionsearch')).get_lang('Search').'</a>';
echo '</div>';

// start the content div
echo '<div id="content">';
$form = $objCatalog->getFormForCourseEcommerceByCode($courseCode);
if ( ! is_null( $form ))
{  if($form->validate()){
      echo '<script>window.location = "ecommerce_courses.php";</script>';
      exit;
   }
    $form->display();
}

echo '</div>';
echo '<div class="actions">';
echo '&nbsp;';
echo '</div>';

// display the footer
Display :: display_footer();
 

//creating form



