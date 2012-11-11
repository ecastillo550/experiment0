<?php
/* For licensing terms, see /license.txt */

// name of the language file that needs to be included
$language_file = array('glossary');
// including the global dokeos file
require_once '../../../inc/global.inc.php';

require_once api_get_path(SYS_MODEL_PATH).'glossary/GlossaryModel.php';
require_once api_get_path(SYS_CONTROLLER_PATH).'glossary/GlossaryController.php';
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';

if (isset($_GET['action']) && $_GET['action'] != 'import') {
$htmlHeadXtra[] = '<script>
  $(document).ready(function (){
    $("div.label").attr("style","width: 100%;text-align:left");
    $("div.row").attr("style","width: 100%;text-align:left");
    $("div.formw").attr("style","width: 100%;text-align:left");
  });
</script>';
} else {

}

// get actions
$actions = array('listing', 'add', 'edit', 'delete', 'import','showterm', 'listterm');
$action = 'listing';
if (isset($_GET['action']) && in_array($_GET['action'],$actions)) {
	$action = $_GET['action'];
}

// set notebook id
$glossaryId = isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):null;
$glossaryTerm = isset($_GET['word']) && is_string($_GET['word'])? $_GET['word']:null;

// course description controller object
$glossaryController = new GlossaryController($glossaryId);

// distpacher actions to controller
switch ($action) {
	case 'listing':
         $glossaryController->listing();
         break;
	case 'add':
		if (api_is_allowed_to_edit(null, true)) {
			$glossaryController->add();
		}
		break;
	case 'edit':
		if (api_is_allowed_to_edit(null,true)) {
			$glossaryController->edit();
		}

		break;
	case 'delete':
		if (api_is_allowed_to_edit(null,true)) {
			$glossaryController->destroy();
		}
		break;
	case 'import':
		if (api_is_allowed_to_edit(null,true)) {
            $glossaryController->import();
		}
         break;
	case 'showterm':
            $glossaryController->showterm($glossaryId);
         break;
	case 'listterm':
            $glossaryController->listing($glossaryTerm);
         break;
	default:
		$glossaryController->listing();
}