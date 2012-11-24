<?php

/* For licensing terms, see /dokeos_license.txt */

/**
==============================================================================
*	@package dokeos.announcements
* 	@author Frederik Vermeire <frederik.vermeire@pandora.be>, UGent University Internship
* 	@author Patrick Cool <patrick.cool@UGent.be>, Ghent University, Belgium
==============================================================================
*/

/*
functionality that has been removed and will not be available in Dokeos 2.0
* survey announcement (badly coded)
* change the visibility of the announcement
* move announcement up or down

functionality that has been removed and has to be re-added for Dokeos 2.0
* send by email + configuration setting for the platform admin: never, always, let course admin decide
* configruation of the number of items that have to appear (jcarousel)
*/

// variables that will be converted into platform settings
// Maximum title messages to display
$maximum 	= '12';

// Language files that should be included
$language_file[] = 'announcements';
$language_file[] = 'group';
$language_file[] = 'survey';

// setting the help
$help_content = 'announcements';

// use anonymous mode when accessing this course tool
$use_anonymous = true;

// including the global Dokeos file
require_once '../inc/global.inc.php';

//---------------------------------------------------------
//  EP Style
//---------------------------------------------------------

require_once api_get_path(LIBRARY_PATH).'announcements.inc.php';

require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
require_once api_get_path(LIBRARY_PATH).'tracking.lib.php';

// Incomming variables
$course_db['db_name'] = Database::get_current_course_database();


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
if (isset($_GET['action']) && in_array($_GET['action'],$actions)) {
	$action = $_GET['action'];
}

// set announcement id
$announcementId = isset($_GET['cidReq']) && is_numeric($_GET['id'])?intval($_GET['id']):null;

// announcement controller object
//$AnnouncementManager = new AnnouncementManager();

//----------------------------------------------------------------------------------------
//Layout

// protect a course script
api_protect_course_script(true);

// Header
Display :: display_tool_header('');

// Introduction section
Display::display_introduction_section(TOOL_ANNOUNCEMENT);

// Tracking
event_access_tool(TOOL_ANNOUNCEMENT);

// setting the tool constants
$tool = TOOL_ANNOUNCEMENT;

// Display
echo '<div class="actions">';
if(api_is_allowed_to_edit()){
   echo '<a href="index.php?'.api_get_cidreq().'&action=add">'.Display::return_icon('pixel.gif', get_lang('AddAnnouncement'), array('class' => 'toolactionplaceholdericon toolactionannoucement')).get_lang('AddAnnouncement').'</a>';
}
echo '</div>';

echo '<div id="content">';


// distpacher actions to controller
switch ($action) {	
	case 'listing':
        $announcementslist = array();
        $announcementslist = AnnouncementManager::get_all_annoucement_by_course($course_db);
        for ($count = 0 ; $count <= count($announcementslist) ; $count++){
            for ($innercount = 0 ; $innercount <= count($announcementslist) ; $innercount++){
                echo $announcementslist[$count][$innercount] . "<br>";
            }
        }
        	    
		break;
	case 'add':
		$AnnouncementManager->add();
		break;
	case 'view':
		$AnnouncementManager->showannouncement($announcementId);
		break;
	case 'edit':
		$AnnouncementManager->edit();
		break;
	case 'delete':	
		$AnnouncementManager->destroy();
		break;
	default:	
		$AnnouncementManager->listing();
}                                                             
echo '</div>';


// secondary actions
echo '<div class="actions"> </div>';

// Footer
Display :: display_footer();
?>