<?php
/* For licensing terms, see /license.txt */

// name of the language file that needs to be included
$language_file = array('announcements','group','survey');

// including the global dokeos file
require_once '../../../inc/global.inc.php';

require_once api_get_path(SYS_MODEL_PATH).'announcement/AnnouncementModel.php';
require_once api_get_path(SYS_CONTROLLER_PATH).'announcement/AnnouncementController.php';
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
require_once api_get_path(LIBRARY_PATH).'tracking.lib.php';
require_once api_get_path(LIBRARY_PATH).'announcements.inc.php';
require_once api_get_path(LIBRARY_PATH).'course.lib.php';
require_once api_get_path(LIBRARY_PATH).'fileUpload.lib.php';
require_once api_get_path(LIBRARY_PATH).'main_api.lib.php';


// additional javascript
$htmlHeadXtra[] = '
    <style>
	form {		
		border:0px;
	}	 
	div.row div.label{
		width: 10%;
	}
	div.row div.formw{
		width: 98%;
	}
    </style>
';

// get actions
$actions = array('listing', 'add', 'view', 'edit', 'delete');
$action = 'listing';
if (isset($_GET['action']) && in_array($_GET['action'])) {
	$action = $_GET['action'];
}
if (isset($_GET['cidReq']) && in_array($_GET['cidReq'])) {
	$course = $_GET['cidReq'];
}

// set announcement id
$announcementId = isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):null;

// announcement controller object
$announcementController = new AnnouncementController($announcementId);  

// distpacher actions to controller
switch ($action) {	
	case 'listing':	
		$announcementController->listing();
		break;
	case 'add':
		$announcementController->add();
		break;
	case 'view':
		$announcementController->showannouncement($announcementId);
		break;
	case 'edit':
		$announcementController->edit();
		break;
	case 'delete':	
		$announcementController->destroy();
		break;
	default:	
		$announcementController->listing();
}                           
?>