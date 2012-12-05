<?php
/* For licensing terms, see /dokeos_license.txt */

// name of the language file that needs to be included
$language_file = array('exercice', 'create_course', 'course_info', 'coursebackup', 'admin');

// setting the help
$help_content = 'copycourse';

// setting the global file that gets the general configuration, the databases, the languages, ...
require_once '../inc/global.inc.php';

// including additional libraries
include_once api_get_path(LIBRARY_PATH) . 'fileManage.lib.php';
require_once 'classes/CourseBuilder.class.php';
require_once 'classes/CourseRestorer.class.php';
require_once 'classes/CourseSelectForm.class.php';

// notice for unauthorized people.
if (!api_is_allowed_to_edit())
{
	api_not_allowed(true);
}

//remove memory and time limits as much as possible as this might be a long process...
if(function_exists('ini_set'))
{
	ini_set('memory_limit','256M');
	ini_set('max_execution_time',1800);
}

// breadcrumbs
$interbreadcrumb[] = array ("url" => "../course_info/maintenance.php", "name" => get_lang('Maintenance'));

// the section (for the tabs)
$this_section=SECTION_COURSES;

// Display the header
Display::display_tool_header(get_lang('CopyCourse'));

// Display the tool title
//api_display_tool_title($nameTools);

// start the content div
echo '<div id="content">';
?>
<div class="section_white">
	<div class="sectiontitle"><?php Display::display_icon('pixel.gif', get_lang("CopyCourse"),array('class'=>'toolactionplaceholdericon toolactioncopy')); ?>&nbsp;&nbsp;<a href="../coursecopy/copy_course.php?<?php echo api_get_cidreq();?>"><?php echo get_lang("CopyCourse");?></a></div>
	<div class="sectioncontent">
       <table width="100%" cellspacing="2" cellpadding="10" border="0" align="center">
           <tbody>
               <tr>
                <td valign="top">
                     <?php echo '&nbsp;'.get_lang("DescriptionCopyCourse"); ?>
                   </td>
                   <td width="180px" valign="top"><?php echo Display::return_icon('instructor-books-small.jpg', get_lang("CopyCourse"), array('align' => 'middle')); ?></td>
               </tr>
           </tbody>
       </table>
     </div>
</div>
<?php
// If a CourseSelectForm is posted or we should copy all resources, then copy them
if ((isset ($_POST['action']) && $_POST['action'] == 'course_select_form') || (isset ($_POST['copy_option']) && $_POST['copy_option'] == 'full_copy')) {
	if (isset ($_POST['action']) && $_POST['action'] == 'course_select_form') {
		$course = CourseSelectForm :: get_posted_course('copy_course');
	} else {
		$cb = new CourseBuilder();
		$course = $cb->build();
	}
	$cr = new CourseRestorer($course);
	$cr->set_file_option($_POST['same_file_name_option']);
	$cr->restore($_POST['destination_course']);
	//Display::display_normal_message(get_lang('CopyFinished'));
	echo get_lang('CopyFinished');
} elseif (isset ($_POST['copy_option']) && $_POST['copy_option'] == 'select_items') {
	// Else, if a CourseSelectForm is requested, show it
	Display::display_normal_message(get_lang('ToExportLearnpathWithQuizYouHaveToSelectQuiz'));
	if (api_get_setting('show_glossary_in_documents') != 'none') {
		Display::display_normal_message(get_lang('ToExportDocumentsWithGlossaryYouHaveToSelectGlossary'));
	}
	$cb = new CourseBuilder();
	$course = $cb->build();
	//echo get_lang('SelectItemsToCopy');
	//echo '<br/><br/>';
	$hidden_fields['same_file_name_option'] = $_POST['same_file_name_option'];
	$hidden_fields['destination_course'] = $_POST['destination_course'];
	CourseSelectForm :: display_form($course, $hidden_fields, true);
} else {
	$table_c = Database :: get_main_table(TABLE_MAIN_COURSE);
	$table_cu = Database :: get_main_table(TABLE_MAIN_COURSE_USER);
	$user_info = api_get_user_info();
	$course_info = api_get_course_info();
	$sql = 'SELECT * FROM '.$table_c.' c, '.$table_cu.' cu WHERE cu.course_code = c.code';
	if (!api_is_platform_admin()) {
		$sql .= ' AND cu.status=1 ';
	}
	$sql .= ' AND target_course_code IS NULL AND cu.user_id = '.$user_info['user_id'].' AND c.code != '."'".$course_info['sysCode']."'".' ORDER BY title ASC';
	$res = Database::query($sql,__FILE__,__LINE__);
	if( Database::num_rows($res) == 0) {
		Display::display_normal_message(get_lang('NoDestinationCoursesAvailable'));
	} else {

//--------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------

// name of the language file that needs to be included
$language_file = "create_course";

//delete the globals["_cid"] we don't need it here
$cidReset = true; // Flag forcing the 'current course' reset

require_once api_get_path(SYS_PATH) .  'main/core/model/ecommerce/EcommerceCatalog.php';


// help
$help_content = get_help('createcourse');

// section for the tabs
$this_section=SECTION_COURSES;

// include configuration file
include (api_get_path(CONFIGURATION_PATH).'add_course.conf.php');

// include additional libraries
include_once (api_get_path(LIBRARY_PATH).'add_course.lib.inc.php');
include_once (api_get_path(LIBRARY_PATH).'course.lib.php');
include_once (api_get_path(LIBRARY_PATH).'debug.lib.inc.php');
include_once (api_get_path(LIBRARY_PATH).'fileManage.lib.php');
include_once (api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php');
include_once (api_get_path(CONFIGURATION_PATH).'course_info.conf.php');

$interbreadcrumb[] = array('url'=>api_get_path(WEB_PATH).'user_portal.php', 'name'=> get_lang('MyCourses'));
// Displaying the header
$tool_name = get_lang('CreateSite');

if (api_get_setting('allow_users_to_create_courses')=='false' && !api_is_platform_admin()) {
	api_not_allowed(true);
}
$htmlHeadXtra[] = '<script>
$(document).ready(function (){
  $("#add_training_id").click(function() {
  var get_title = $("#training_title_id").val();
  get_title = $.trim(get_title);
  var title_length = get_title.length;
    if (title_length > 0) {
      return true;
    } else {
      $("#training_title_id").attr("value", "");
      $("#training_title_id").focus();
      return false;
    }
  });
});
</script>';

$htmlHeadXtra[]='<script>
 function reloadpage() {
      location.reload()
  }
</script>';
//href="'.api_get_path(WEB_PATH).'user_portal.php"


// start the content div
echo '<div id="" class="" style="height: 350px;">';

// Check access rights
if(!api_is_session_admin()){
	if (!api_is_allowed_to_create_course()) {
		Display :: display_error_message(get_lang("NotAllowed"));
		Display::display_footer();
		exit;
	}
}
// Get all course categories
$table_course_category = Database :: get_main_table(TABLE_MAIN_CATEGORY);
$table_course = Database :: get_main_table(TABLE_MAIN_COURSE);

$dbnamelength = strlen($_configuration['db_prefix']);
//Ensure the database prefix + database name do not get over 40 characters
$maxlength = 40 - $dbnamelength;

// Build the form
$categories = array();
$form = new FormValidator('add_course');
// form title
$form->addElement('header', '', $tool_name);
//title
$form->add_textfield('title',get_lang('CourseName'),false,array('size'=>'60','class'=>'focus', 'id'=>'training_title_id'));
$form->applyFilter('title', 'html_filter');
$form->addRule('title',get_lang('Required'),'required',$maxlength);

$form->addElement('static',null,null,get_lang('Ex'));
$categories_select = $form->addElement('select', 'category_code', get_lang('Fac'), $categories);
$form->applyFilter('category_code', 'html_filter');

CourseManager::select_and_sort_categories($categories_select);
$form->addElement('static',null,null, get_lang('TargetFac'));

$form->add_textfield('wanted_code', get_lang('Code'),false,array('size'=>'$maxlength','maxlength'=>$maxlength));
$form->applyFilter('wanted_code', 'html_filter');
$form->addRule('wanted_code',get_lang('Max'),'maxlength',$maxlength);
//$form->addElement('hidden','wanted_code','');

$titular= &$form->add_textfield('tutor_name', get_lang('Professors'),null,array('size'=>'60','disabled'=>'disabled'));
$form->addElement('static',null,null,get_lang('ExplicationTrainers'));
//$form->applyFilter('tutor_name', 'html_filter');

$form->addElement('select_language', 'course_language', get_lang('Ln'));
$form->applyFilter('select_language', 'html_filter');
// If e-commerce is dissabled then hide the checkbok
$e_commerce_enabled = intval(api_get_setting("e_commerce"));
if ($e_commerce_enabled <> 0) {
  $form->addElement('checkbox', 'payment', get_lang('AttachToCatalogueOfProducts'),get_lang('Allowed'));
}

$form->addElement('style_submit_button', null, get_lang('CreateCourseArea'), 'class="add" id="add_training_id"');
$form->add_progress_bar();

// Set default values
$values['payment'] = 1;
if (isset($_user["language"]) && $_user["language"]!="") {
	$values['course_language'] = $_user["language"];
} else {
	$values['course_language'] = api_get_setting('platformLanguage');
}

$values['tutor_name'] = api_get_person_name($_user['firstName'], $_user['lastName'], null, null, $values['course_language']);
$form->setDefaults($values);
// Validate the form
if ($form->validate()) {
    
	$course_values = $form->exportValues();
	$wanted_code = $course_values['wanted_code'];
	$tutor_name = $course_values['tutor_name'];
	$category_code = $course_values['category_code'];
	$title = $course_values['title'];
	$course_language = $course_values['course_language'];
	$payment = $course_values['payment'];
        if(!isset($payment))
        {
            $payment = 0;
        }
	
	if (trim($wanted_code) == '') {
		$wanted_code = generate_course_code(api_substr($title,0,$maxlength));
	}
	
	$keys = define_course_keys($wanted_code, "", $_configuration['db_prefix']);

	$sql_check = sprintf('SELECT * FROM '.$table_course.' WHERE visual_code = "%s"',Database :: escape_string($wanted_code));
	$result_check = Database::query($sql_check,__FILE__,__LINE__); //I don't know why this api function doesn't work...
	if ( Database::num_rows($result_check)<1 ) {
		if (sizeof($keys)) {
			$visual_code = $keys["currentCourseCode"];
			$code = $keys["currentCourseId"];
			$db_name = $keys["currentCourseDbName"];
			$directory = $keys["currentCourseRepository"];
			$expiration_date = time() + $firstExpirationDelay;
			prepare_course_repository($directory, $code);
			update_Db_course($db_name);
			$pictures_array=fill_course_repository($directory);
			fill_Db_course($db_name, $directory, $course_language,$pictures_array);
			register_course($code, $visual_code, $directory, $db_name, $tutor_name, $category_code, $title, $course_language, api_get_user_id(), $expiration_date,$teachers,$payment);
		}
        $link = api_get_path(WEB_COURSE_PATH).$directory.'/';
		$message = get_lang('JustCreated');
		echo '<div class="actions"><div style="float: left; text-align: left; width: 100%;height:200px;" class="quiz_content_actions">';
                echo get_lang('JustCreated');
                // Display image
                echo '<div style="float: right; text-align: right; width: 100%;">';
                echo Display::return_icon('avatars/explorer.png',get_lang('CreateSite'));
                echo '</div><div class="clear"></div></div>';
                
                echo '<div style="float=right;"><form action="copy_course.php" method="get">
                <input type="hidden" name="cidReq" value="'.api_get_course_id().'">
                <input type="hidden" name="created_course" value="'.$code.'">
                <input type="submit" name="created-submit" value="Copiar curso creado" style="float=right;font-size:20px;"></div>'; 
                      
	} else {
		//Display :: display_error_message(get_lang('CourseCodeAlreadyExists'),false);
		echo get_lang('CourseCodeAlreadyExists');
		$form->display();
		//echo '<p>'.get_lang('CourseCodeAlreadyExistExplained').'</p>';
	}

} else {
	// Display the form
	$form->display();
	Display::display_normal_message(get_lang('Explanation'));
}

// close the content div
echo '</div>';

//------------------------------------------------------------------------------------------------------------- 
//-------------------------------------------------------------------------------------------------------------
 if($_GET['created-submit']){?>
	<form method="post" action="copy_course.php?<?php echo api_get_cidreq() ?>">
	<?php
	echo get_lang('SelectDestinationCourse');
	echo ' <select name="destination_course"/>';
	while ($obj = Database::fetch_object($res)) { 
    if($obj->code == $_GET['created_course']){
        echo '<option selected="selected" value="'.$obj->code.'">'.$obj->title.'</option>';
    }
    else {
		    echo '<option value="'.$obj->code.'">'.$obj->title.'</option>'; 
    }
	}
	echo '</select>'; 
  
 
?>

	<br/>
	<br/>
	<input type="radio" class="checkbox" id="copy_option_1" name="copy_option" value="full_copy"/>
	<label for="copy_option_1"><?php echo get_lang('FullCopy') ?></label>
	<br/>
	<input type="radio" class="checkbox" id="copy_option_2" name="copy_option" value="select_items" checked="checked"/>
	<label for="copy_option_2"><?php echo get_lang('LetMeSelectItems') ?></label>
	<br/>
	<br/>
	<?php echo get_lang('SameFilename') ?>
	<blockquote>
	<input type="radio" class="checkbox"  id="same_file_name_option_1" name="same_file_name_option" value="<?php echo FILE_SKIP ?>"/>
	<label for="same_file_name_option_1"><?php echo  get_lang('SameFilenameSkip') ?></label>
	<br/>
	<input type="radio" class="checkbox" id="same_file_name_option_2" name="same_file_name_option" value="<?php echo FILE_RENAME ?>"/>
	<label for="same_file_name_option_2"><?php echo get_lang('SameFilenameRename') ?></label>
	<br/>
	<input type="radio" class="checkbox"  id="same_file_name_option_3" name="same_file_name_option"  value="<?php echo FILE_OVERWRITE ?>"  checked="checked"/>
	<label for="same_file_name_option_3"><?php echo get_lang('SameFilenameOverwrite') ?></label>
	</blockquote>
	<br/>
	<button class="save" type="submit"><?php echo get_lang('CopyCourse') ?></button>
	</form>
	<?php
	}

} 
}
// close the content div
echo '</div>';

// display the footer
Display::display_footer();
?>
