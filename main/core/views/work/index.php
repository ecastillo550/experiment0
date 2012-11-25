<?php
/* For licensing terms, see /license.txt */

// name of the language file that needs to be included
$language_file = array ('exercice','work','document','admin','group');

// including the global dokeos file
require_once '../../../inc/global.inc.php';

require_once api_get_path(SYS_MODEL_PATH).'work/WorkModel.php';
require_once api_get_path(SYS_CONTROLLER_PATH).'work/WorkController.php';
require_once (api_get_path(LIBRARY_PATH) . 'document.lib.php');
require_once (api_get_path(LIBRARY_PATH) . 'security.lib.php');
require_once (api_get_path(LIBRARY_PATH) . 'mail.lib.inc.php');
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
include_once (api_get_path(LIBRARY_PATH) . 'fileManage.lib.php');
include_once (api_get_path(LIBRARY_PATH) . 'fileUpload.lib.php');
include_once (api_get_path(LIBRARY_PATH) . 'fileDisplay.lib.php');
require_once '../../../newscorm/learnpath.class.php';
require_once '../../../newscorm/learnpathItem.class.php';

// additional javascript
$htmlHeadXtra[] = '<script type="text/javascript" src="' . api_get_path(WEB_LIBRARY_PATH) . 'javascript/jquery-1.4.2.min.js" language="javascript"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script><script>
  $(document).ready(function(){
    $("#submit_paper").validate();
    });
</script> ';

$add_lp_param = "";
if (isset($_GET['lp_id']) && $_GET['lp_id'] > 0) {
 $lp_id = intval($_GET['lp_id']);
 $htmlHeadXtra[] = '<script>
    $(document).ready(function (){
      $("a[href]").attr("href", function(index, href) {
          var param = "lp_id=' . $lp_id . '";
           var is_javascript_link = false;
           var info = href.split("javascript");

           if (info.length >= 2) {
             is_javascript_link = true;
           }
           if ($(this).attr("class") == "course_main_home_button" || $(this).attr("class") == "course_menu_button"  || $(this).attr("class") == "next_button"  || $(this).attr("class") == "prev_button" || is_javascript_link) {
             return href;
           } else {
             if (href.charAt(href.length - 1) === "?")
                 return href + param;
             else if (href.indexOf("?") > 0)
                 return href + "&" + param;
             else
                 return href + "?" + param;
           }
      });
    });
  </script>';
 $add_lp_param = "&lp_id=" . $lp_id;
}

//directories management
$base_work_dir = api_get_path(SYS_COURSE_PATH) . $_course['path'] . '/work';
$http_www = api_get_path('WEB_COURSE_PATH') . $_course['path'] . '/work';
$cur_dir_path = '';
if (isset ($_GET['curdirpath']) && $_GET['curdirpath'] != '') {
	//$cur_dir_path = preg_replace('#[\.]+/#','',$_GET['curdirpath']); //escape '..' hack attempts
	//now using common security approach with security lib
	$in_course = Security :: check_abs_path($base_work_dir . '/' . $_GET['curdirpath'], $base_work_dir);
	if (!$in_course) {
		$cur_dir_path = "/";
	} else {
		$cur_dir_path = $_GET['curdirpath'];
	}
} elseif (isset ($_POST['curdirpath']) && $_POST['curdirpath'] != '') {
	//$cur_dir_path = preg_replace('#[\.]+/#','/',$_POST['curdirpath']); //escape '..' hack attempts
	//now using common security approach with security lib
	$in_course = Security :: check_abs_path($base_work_dir . '/' . $_POST['curdirpath'], $base_work_dir);
	if (!$in_course) {
		$cur_dir_path = "/";
	} else {
		$cur_dir_path = $_POST['curdirpath'];
	}
} else {
	$cur_dir_path = '/';
}
if ($cur_dir_path == '.') {
	$cur_dir_path = '/';
}
$cur_dir_path_url = urlencode($cur_dir_path);

//prepare a form of path that can easily be added at the end of any url ending with "work/"
$my_cur_dir_path = $cur_dir_path;
if ($my_cur_dir_path == '/') {
	$my_cur_dir_path = '';
} elseif (substr($my_cur_dir_path, -1, 1) != '/') {
	$my_cur_dir_path = $my_cur_dir_path . '/';
}


// Section (for the tabs)
$this_section = SECTION_COURSES;
$ctok = $_SESSION['sec_token'];
$stok = Security::get_token();

// access control
api_protect_course_script(true);

// Lp object
if (isset($_SESSION['lpobject'])) {
 if ($debug > 0)
  error_log('New LP - SESSION[lpobject] is defined', 0);
 $oLP = unserialize($_SESSION['lpobject']);
 if (is_object($oLP)) {
  if ($debug > 0)
   error_log('New LP - oLP is object', 0);
  if ($myrefresh == 1 OR (empty($oLP->cc)) OR $oLP->cc != api_get_course_id()) {
   if ($debug > 0)
    error_log('New LP - Course has changed, discard lp object', 0);
   if ($myrefresh == 1) {
    $myrefresh_id = $oLP->get_id();
   }
   $oLP = null;
   api_session_unregister('oLP');
   api_session_unregister('lpobject');
  } else {
   $_SESSION['oLP'] = $oLP;
   $lp_found = true;
  }
 }
}

// get actions
$actions = array('listing','add','edit','delete','submit_work','view_papers','download','move_paper','delete_paper','correct_paper','download_folder','move_form','move_to','view_paper');
$action = 'listing';
if (isset($_GET['action']) && in_array($_GET['action'],$actions)) {
	$action = $_GET['action'];
}
else {
	$action = $_POST['action'];
	$delete_id = $_POST['id'];
}

// set assignment id
isset($_REQUEST['origin'])?$origin = Security :: remove_XSS($_REQUEST['origin']):$origin='';
isset($_REQUEST['assignment_id'])?$assignmentId = Security :: remove_XSS($_REQUEST['assignment_id']):$assignmentId='';
isset($_REQUEST['id'])?$paperId = Security :: remove_XSS($_REQUEST['id']):$paperId='';

// work controller object
$workController = new WorkController($assignmentId);

// distpacher actions to controller
switch ($action) {	
	case 'listing':	
		$workController->listing();
		break;	
	case 'add':	
		$workController->add($cur_dir_path);
		break;
	case 'edit':	
		$workController->edit($cur_dir_path);
		break;
	case 'delete':	
		$workController->destroy($delete_id);
		break;
	case 'submit_work':			
		$workController->submit_work($cur_dir_path);
		break;
	case 'view_papers':			
		$workController->view_papers($cur_dir_path);
		break;
	case 'move_paper':			
		$workController->move_paper($cur_dir_path,$paperId);
		break;
	case 'delete_paper':			
		$workController->delete_paper($paperId);
		break;
	case 'correct_paper':			
		$workController->correct_paper($paperId);
		break;
	case 'move_form':			
		$workController->move_form($paperId);
		break;
	case 'move_to':			
		$workController->move_to($paperId);
		break;
	case 'view_paper':			
		$workController->view_paper($paperId);
		break;
	case 'download_folder':
		include dirname(__FILE__).'/../../../work/downloadfolder.inc.php';
		break;
	case 'download':
		include dirname(__FILE__).'/../../../work/download.php';
		break;
	default:	
		$workController->listing();
}
?>