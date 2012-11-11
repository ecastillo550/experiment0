<?php
/* For licensing terms, see /license.txt */

// name of the language file that needs to be included
$language_file = array('notebook');

// including the global dokeos file
require_once '../../../inc/global.inc.php';

require_once api_get_path(SYS_MODEL_PATH).'notebook/NotebookModel.php';
require_once api_get_path(SYS_CONTROLLER_PATH).'notebook/NotebookController.php';
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';

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
$actions = array('listing', 'add', 'edit', 'delete');
$action = 'listing';
if (isset($_GET['action']) && in_array($_GET['action'],$actions)) {
	$action = $_GET['action'];
}

// set notebook id
$notebookId = isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):null;

// notebook controller object
$notebookController = new NotebookController($notebookId);

// distpacher actions to controller
switch ($action) {	
	case 'listing':	
                $notebookController->listing();
                break;
	case 'add':
		$notebookController->add();
		break;
	case 'edit':
		$notebookController->edit();
		break;
	case 'delete':	
		$notebookController->destroy();
		break;
	default:	
		$notebookController->listing();
}