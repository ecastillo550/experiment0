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
include_once api_get_path(LIBRARY_PATH)."fckeditor/fckeditor.php";

require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
require_once api_get_path(LIBRARY_PATH).'tracking.lib.php';
require_once api_get_path(LIBRARY_PATH).'fileUpload.lib.php';
require_once api_get_path(LIBRARY_PATH).'course.lib.php';

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

header('Location: '.api_get_path(WEB_VIEW_PATH).'announcement/index.php?'.api_get_cidreq());
exit();
 /*
$htmlHeadXtra[] = AnnouncementManager::user_group_filter_javascript();
$htmlHeadXtra[] = AnnouncementManager::to_javascript();

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
   echo '<a href="announcements.php?'.api_get_cidreq().'&action=add">'.Display::return_icon('pixel.gif', get_lang('AddAnnouncement'), array('class' => 'toolactionplaceholdericon toolactionannoucement')).get_lang('AddAnnouncement').'</a>';
}
echo '</div>';

echo '<div id="content">';


// distpacher actions to controller
switch ($action) {	
	case 'listing':
        announcement:
        echo "<div style='width:855px;margin-left: 35px;'>";
        $announcementslist = array();
        $announcementslist = AnnouncementManager::get_all_annoucement_by_course($course_db);
        // $count = rows
        // $innercount = elements
        echo "<table id=''  style='margin-top: 15px;'> ";
        for ($count = 0 ; $count < count($announcementslist) ; $count++){
            for ($innercount = 1 ; $innercount < 3 ; $innercount++){
             echo  "<tr class='row_odd'>";
              if($innercount == 1){
                  echo '<b style="font-size: 18px;">' . $announcementslist[$count][$innercount] . '</b>';
                  }
              else{
                  echo $announcementslist[$count][$innercount];
                  }
                 echo "<br>";
                }
                // show attachment list
                $attachment_list = array();
                $attachment_list = AnnouncementManager::get_attachment($announcementslist[$count][0]);

                $attachment_icon = '';
                if (count($attachment_list)>0) {
                   echo ' <a href="'.api_get_path(WEB_COURSE_PATH).api_get_course_path().'/upload/announcements/'.$attachment_list['path'].'" target="_blank">'.Display::return_icon('attachment.gif','Attachment') . '</a><br><br><br>';               
                }
         if(api_is_allowed_to_edit()){
             echo '<a style="float: left;" href="announcements.php?action=edit&cidReq='.api_get_course_path().'&announcement-id='.$announcementslist[$count][0].'"><img src="'.api_get_path(WEB_PATH).'/main/img/edit_link.png" alt="modificar"> </a> ';
             echo '<a style="margin-left: 10px;float: left;" href="announcements.php?action=delete&cidReq='.api_get_course_path().'&announcement-id='.$announcementslist[$count][0].'"><img src="'.api_get_path(WEB_PATH).'/main/img/delete_data.gif" alt="eliminar"> </a> <br><br><hr>';
         }   
        }
        echo '</tr></table>'; 
      echo '</div>';  	    
		break;
	case 'add':
  if(api_is_allowed_to_edit()){
      if(isset($_GET['posto']) && $_GET['posto'] == 'yes'){
      $emailTitle = $_POST['emailtitle'];
      $newContent = $_POST['content'];
      $file = $_FILES['user_upload'];
      echo   'Anuncio Guardado';
      
      AnnouncementManager::add_announcement($emailTitle, $newContent, $order, $to, $file, $file_comment=''); 
      
      goto announcement;

      } else {
     $sent_to_array['users'] = AnnouncementManager::get_course_users();
     $sent_to_array['groups'] = AnnouncementManager::get_course_groups();
        
//      // The receivers: groups
// 			$course_groups = CourseManager::get_group_list_of_course(api_get_course_id(), intval($this->session_id));
// 			foreach ( $course_groups as $key => $group ) {
// 				$receivers ['G' . $key] = '-G- ' . $group ['name'];
// 			}
// 			// The receivers: users
// 			$course_users = CourseManager::get_user_list_from_course_code(api_get_course_id(), intval($this->session_id) == 0 , intval($this->session_id));
// 			foreach ( $course_users as $key => $user ) {
// 				$receivers ['U' . $key] = $user ['lastname'] . ' ' . $user ['firstname'];
// 			}			
//       $defaults ['send_to'] ['receivers'] = 0;
//       $defaults['title'] = $announcementInfo['announcement_title'];
//             $defaults['description'] = $announcementInfo['announcement_content'];
// 			
//             if (!empty($announcementInfo['to_user_id'])) {
//                 $defaults['send_to'] ['receivers'] = 1;
//                 $user_group_ids = $this->get_announcement_dest($this->announcement_id);
//             }
//             else if(empty($announcementInfo['to_user_id']) && $announcementInfo['visibility'] == 0){
//                 $defaults['send_to'] ['receivers'] = -1;
//             }
//             else {
//                 $defaults['send_to'] ['receivers'] = 0;
//             }
// 
//             foreach ($user_group_ids['to_user_id'] as $key=>$user_id){
//                 $defaults['send_to']['to'][] = 'U'.$user_id;
//             }
// 
//             foreach ($user_group_ids['to_group_id'] as $key=>$group_id){
//                 $defaults['send_to']['to'][] = 'G'.$group_id;
//             }
//         }
// 	else {            
//             if (isset($_GET['remind_inactive'])) {
//                 $defaults['send_to']['receivers'] = 1;
//                 $defaults['title'] = sprintf(get_lang('RemindInactiveLearnersMailSubject'),api_get_setting('siteName'));
//                 $defaults['content'] = sprintf(get_lang('RemindInactiveLearnersMailContent'),api_get_setting('siteName'), 7);
//                 $defaults['send_to']['to'][] = 'U'.intval($_GET['remind_inactive']);
//             } 
//             elseif (isset($_GET['remindallinactives']) && $_GET['remindallinactives'] == 'true') { 
//                 $defaults['send_to']['receivers'] = 1;
//                 $since = isset($_GET['since']) ? intval($_GET['since']) : 6;
//                 $to = Tracking :: get_inactives_students_in_course($_course['id'],$since, api_get_session_id());
//                 foreach($to as $user) {
//                         if (!empty($user)) {
//                                 $defaults['send_to']['to'][] = 'U'.$user;
//                         }
//                 }
//                 $defaults['title'] = sprintf(get_lang('RemindInactiveLearnersMailSubject'),api_get_setting('siteName'));
//                 $defaults['content'] = sprintf(get_lang('RemindInactiveLearnersMailContent'),api_get_setting('siteName'),$since);
//             }
// 	}  
      
      echo "<form action='announcements.php?posto=yes&action=add&cidReq=".api_get_course_path()."' method='post' enctype='multipart/form-data'>
      Titulo del anuncio <input type='text' value='' name='emailtitle'><div style='width: 900px; position: relative;'>" ;
      
      $oFCKeditor = new FCKeditor('content') ;
      $oFCKeditor->BasePath = '/fckeditor/' ;
      $oFCKeditor->Value = '' ; 
      $oFCKeditor->Create() ;
      
      echo '</div><input type="file" name="user_upload" size="50"><br> <input type="submit" value="Submit"> </form>' ;
		   //$addAnnouncement = AnnouncementManager::add_announcement($emailTitle, $newContent, $order, $to, $file = array(), $file_comment='');
       }
    }
		break;
	case 'view':
		
		break;
	case 'edit':
      if(api_is_allowed_to_edit()){
      $announcement_id = $_GET['announcement-id'];
		  if(isset($_GET['modsto']) && $_GET['modsto'] == 'yes'){
      $emailTitle = $_POST['emailtitle'];
      $newContent = $_POST['content'];
      $file = $_FILES['user_upload'];

        AnnouncementManager::edit_announcement($announcement_id, $emailTitle, $newContent, $to, $file, $file_comment=''); 
        if(isset($_POST['delete_file']) && $_POST['delete_file'] == 'yes'){
              AnnouncementManager::delete_attatchment_entry(api_get_course_info(), $announcement_id);
              echo 'eliminado';
          } 
          
          goto announcement;       
      
      } else {
      
      $to = AnnouncementManager::load_edit_users("announcement", $announcement_id);
      
      //$sent_to_array = AnnouncementManager::sent_to("announcement", $announcement_id);
      
      AnnouncementManager::sent_to_form($to);
      
      $announcement = array();
      $announcement = AnnouncementManager::display_announcement_array($announcement_id);
      
      echo "<form action='announcements.php?modsto=yes&action=edit&cidReq=".api_get_course_path()."&announcement-id=".$announcement_id."' method='post' enctype='multipart/form-data'>
      Titulo del anuncio <input type='text' value='".$announcement['title']."' name='emailtitle'><div style='width: 900px; position: relative;'>" ;
      $oFCKeditor = new FCKeditor('content') ;
      $oFCKeditor->BasePath = '/fckeditor/' ;
      $oFCKeditor->Value = ''.$announcement['content'] ; 
      $oFCKeditor->Create() ;
      
      echo '</div><input type="file" name="user_upload" size="50"> <br> Borrar Archivo<input type="checkbox" name="delete_file" value="yes"> <br><input type="submit" value="Submit"> </form>' ;
		   //$addAnnouncement = AnnouncementManager::add_announcement($emailTitle, $newContent, $order, $to, $file = array(), $file_comment='');
       }
    }
		break;
	case 'delete':
      if(api_is_allowed_to_edit()){
      $announcement_id = $_GET['announcement-id'];
      if(isset($_GET['eliminar']) && $_GET['eliminar'] == 'yes'){
          AnnouncementManager::delete_announcement(api_get_course_info(), $announcement_id);
          echo 'eliminado';
          goto announcement;    
          
      }	else {
      
      $announcement = array();
      $announcement = AnnouncementManager::display_announcement($announcement_id);
      echo "<form action='announcements.php?eliminar=yes&action=delete&cidReq=".api_get_course_path()."&announcement-id=".$announcement_id."' method='post' enctype='multipart/form-data'>";
      echo '<input type="submit" value="Eliminar"> </form>' ;
      }
		 }
		break;
	default:	
		$AnnouncementManager->listing();
}                                                             
echo '</div>';


// secondary actions
echo '<div class="actions"> </div>';

// Footer
Display :: display_footer(); 

*/
?>