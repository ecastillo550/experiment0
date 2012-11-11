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

$htmlHeadXtra[] = '<script src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/vertical-tabs/js/jquery-jvert-tabs-1.1.4.js" type="text/javascript"></script>';
$htmlHeadXtra[] = '<link rel="stylesheet" type="text/css" href="'.api_get_path(WEB_LIBRARY_PATH).'javascript/vertical-tabs/css/jquery-jvert-tabs-1.1.4.css"/>';
$htmlHeadXtra[] = ' <script src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/mselect/jquery.multiselect.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="'.api_get_path(WEB_LIBRARY_PATH).'javascript/mselect/jquery.multiselect.css"/>
<script src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/mselect/jquery.multiselect.filter.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="'.api_get_path(WEB_LIBRARY_PATH).'javascript/mselect/jquery.multiselect.filter.css"/>';

$form = new FormValidator( 'frmEcommerceModulePack', 'post');

if ( $form->validate() )
{
    $submitted = $form->getSubmitValues();

    if ( is_array( $submitted['date_start'] ) && (isset( $submitted['date_start']['d'] ) && isset( $submitted['date_start']['M'] ) && isset( $submitted['date_start']['Y'] )) )
    {
        $submitted['date_start'] = $submitted['date_start']['Y'] . '-' . $submitted['date_start']['M'] . '-' . $submitted['date_start']['d'];
    }
    if ( is_array( $submitted['date_end'] ) && (isset( $submitted['date_end']['d'] ) && isset( $submitted['date_end']['M'] ) && isset( $submitted['date_end']['Y'] )) )
    {
        $submitted['date_end'] = $submitted['date_end']['Y'] . '-' . $submitted['date_end']['M'] . '-' . $submitted['date_end']['d'];
    }

    CatalogueModuleModel::create()->saveItemEcommerce( $submitted );
    header("location: " . api_get_path(WEB_PATH) . '/main/admin/ecommerce_module_packs.php');    
}

Display::display_header($nameTools);

?>

<script type="text/javascript">
$(document).ready(function(){
    var tabsDiv = $('div#courseTabs');
	 $('form#frmEcommerceModulePack div.row:last').after(tabsDiv);

		 $("#courseTabs").jVertTabs({
		select: function(index){
			$('div#courseTabs.vtabs div.vtabs-content-column div.vtabs-content-panel *').remove();			
		}
	});

});
</script>

 
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
<?php  

$form = $objCatalog->getFormForModulePack($form);
if ( ! is_null( $form ))
{
    $form->display();
}


?>

<?php
        $courseLi = '';
        $courseTab = '';
        foreach( $objCatalog->getCoursesList() as $course ){
         $courseLi .= '<li><a href="'. api_get_path(WEB_PATH).'main/core/controller/ecommerce/EcommerceController.php?action=getCourseModulesList&course=' . $course->code . '">'.$course->title .'</a></li> ';
         $courseTab .= '<div id="#vtabs-content-' . $course->code . '"></div>';
        } ?>
        
<div id="courseTabs" style="width: 70%">
    <div>
        <ul>        
        <?php echo $courseLi;?>
        </ul>        
    </div>
    <div>
        <?php echo $courseTab;?>
	</div>
</div>


</div>

<?php //Display::display_footer();