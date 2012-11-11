<?php

// name of the language file that needs to be included
$language_file = array ('admin');

// resetting the course id
$cidReset = true;

$help_content = 'platformadministrationsessionadd';

require_once dirname(__FILE__) . '/../inc/global.inc.php';
require_once api_get_path(SYS_PATH) . 'main/core/model/ecommerce/EcommerceCatalog.php';
require_once api_get_path(SYS_PATH) . 'main/core/model/ecommerce/EcommerceCatalogModules.php';
// including additional libraries
require_once api_get_path(LIBRARY_PATH).'sessionmanager.lib.php';
require_once api_get_path(SYS_PATH) . 'main/inc/lib/xajax/xajax.inc.php';
require_once api_get_path(LIBRARY_PATH) . 'formvalidator/FormValidator.class.php';

// setting the section (for the tabs)
$this_section = SECTION_PLATFORM_ADMIN;

// Access restrictions
api_protect_admin_script(true);
// obtaining catalog object
$objCatalog = new EcommerceCatalogModules();
$objCatalog->getCatalogSettings();

if ( $objCatalog->currentValue->selected_value != CATALOG_TYPE_MODULES)
{
    header("location: " . api_get_path(WEB_PATH));
}



$interbreadcrumb[]=array('url' => 'index.php',"name" => get_lang('PlatformAdmin'));
Display::display_header($nameTools);

// for deleting module pack
if( isset($_GET['action']) && $_GET['idEcommerceItem'] )
{
    if( $_GET['action'] == 'delete')
    {
        $objCatalog->deleteEcommerceItem( $_GET['idEcommerceItem'] );
    }
}

if(isset($_GET['status'])){
   $status = intval($_GET['status'], 0);
   $objCatalog->setEcommerceVisibility($_GET['idEcommerceItem'], $status);
   
}

// Create a sortable table with the course data
$get_course_data = array($objCatalog , 'getEcommerceItemData');
$get_total_number_course_data = array($objCatalog , 'getTotalNumberCourseEcommerce');


$get_course_action_buttons = array($objCatalog , 'getItemCatalogButtonList');
$get_course_visibility = array($objCatalog , 'getItemCatalogVisibility');


$table = new SortableTable('courses_ecommerce', $get_total_number_course_data, $get_course_data, 2);
$parameters=array();

$table->set_additional_parameters($parameters);
$table->set_header(0, '', false,'width="10px"');
$table->set_header(1, get_lang('Id'), false, 'width="15px"');
$table->set_header(2, get_lang('Title'), true);
$table->set_header(3, get_lang('Visibility'), true,'width="20px"');
$table->set_header(4, get_lang('Price'),true,'width="50px"');
$table->set_header(5, get_lang('DateStart'),false,'width="65px"');
$table->set_header(6, get_lang('ExpirationDate'),false,'width="50px"');
$table->set_header(7, get_lang('Actions'), false,'width="170px"');
$table->set_column_filter(7,$get_course_action_buttons);
$table->set_column_filter(3,$get_course_visibility);
$table->set_form_actions(array ('delete_courses' => get_lang('DeleteCourse')),'course');

?>
<div class="actions">
    <!--<a href="<?php echo api_get_path(WEB_CODE_PATH); ?>admin/catalogue_management.php">
        <?php echo Display::return_icon('pixel.gif',get_lang('Catalogue'), array('class' => 'toolactionplaceholdericon toolactioncataloguecircle')) . get_lang('Catalogue') ;?>
    </a>-->
    <a href="<?php echo api_get_path(WEB_CODE_PATH); ?>admin/ecommerce_module_packs.php">
        <?php echo Display :: return_icon('pixel.gif', get_lang('ModulePacks'),array('class' => 'toolactionplaceholdericon toolactionassignment')) . get_lang('ModulePacks'); ?>
     </a>
     <a href="<?php echo api_get_path(WEB_CODE_PATH); ?>admin/ecommerce_module_packs_add.php">
        <?php echo Display :: return_icon('pixel.gif', get_lang('CreateModulePacks'),array('class' => 'toolactionplaceholdericon toolactionnewassignment')) . get_lang('CreateModulePacks'); ?>
     </a>
</div>
<div id="content">

<?php $table->display(); ?>
</div>

<?php Display::display_footer();