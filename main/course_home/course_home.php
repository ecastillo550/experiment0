<?php // $Id: course_home.php 22294 2009-07-22 19:27:47Z iflorespaz $

/*
==============================================================================
	Dokeos - elearning and course management software

	Copyright (c) Dokeos SPRL

	For a full list of contributors, see "credits.txt".
	For licensing terms, see "dokeos_license.txt"

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	See the GNU General Public License for more details.

	http://www.dokeos.com
==============================================================================
*/

/**
==============================================================================
*         HOME PAGE FOR EACH COURSE
*
*	This page, included in every course's index.php is the home
*	page. To make administration simple, the teacher edits his
*	course from the home page. Only the login detects that the
*	visitor is allowed to activate, deactivate home page links,
*	access to the teachers tools (statistics, edit forums...).
*
*	@package dokeos.course_home
==============================================================================
*/

// Name of the language file that needs to be included.
$language_file[] = 'course_home';
$language_file[] = 'widgets';
$language_file[] = 'chat';
$use_anonymous = true;

// Inlcuding the global initialization file.
require_once '../../main/inc/global.inc.php';
include_once(api_get_path(LIBRARY_PATH).'document.lib.php');
include_once(api_get_path(LIBRARY_PATH).'text.lib.php');
include_once (api_get_path(LIBRARY_PATH).'fileUpload.lib.php');


$css_name = api_get_setting('allow_course_theme') == 'true'?(api_get_course_setting('course_theme', null, true)?api_get_course_setting('course_theme', null, true):api_get_setting('stylesheets')):api_get_setting('stylesheets');

$GLOBALS['learner_view'] = false;

$session_id = intval($_SESSION['id_session']);
$group_id 	= intval($_SESSION['_gid']);

// Check if we have a CSS with tablet support
$css_info = array();
$css_info = api_get_css_info($css_name);
$css_type = !is_null($css_info['type']) ? $css_info['type'] : '';

$htmlHeadXtra[]='<script>jQuery(document).ready( function($) { $("#header1, #header2").show(); });</script>';
$post_path = api_get_path(WEB_PATH)."main/chat/room/post.php?".api_get_cidreq();

// Create chat file according to course access, for example if users is inside a group or if is out of them
$dateNow=date('Y-m-d');

$basepath_chat = '';
$documentPath=api_get_path(SYS_COURSE_PATH).$_course['path'].'/document';
$documentwebPath = api_get_path(WEB_COURSE_PATH).$_course['path'].'/document';
if (!empty($group_id)) {
	$group_info = GroupManager :: get_group_properties($group_id);
	$basepath_chat = $group_info['directory'].'/chat_files';
} else {
	$basepath_chat = '/chat_files';
}
$chatPath=$documentPath.$basepath_chat.'/';
$web_chat_path = $documentwebPath.$basepath_chat.'/';

$TABLEITEMPROPERTY= Database::get_course_table(TABLE_ITEM_PROPERTY);

if(!is_dir($chatPath)) {
	if(is_file($chatPath)) {
		@unlink($chatPath);
	}
	if (!api_is_anonymous()) {
		$perm = api_get_setting('permissions_for_new_directories');
		$perm = octdec(!empty($perm)?$perm:'0770');
		@mkdir($chatPath,$perm);
		@chmod($chatPath,$perm);
		// save chat files document for group into item property
		if (!empty($group_id)) {
			$doc_id=add_document($_course,$basepath_chat,'folder',0,'chat_files');
			$sql = "INSERT INTO $TABLEITEMPROPERTY (tool,insert_user_id,insert_date,lastedit_date,ref,lastedit_type,lastedit_user_id,to_group_id,to_user_id,visibility)
			VALUES ('document',1,NOW(),NOW(),$doc_id,'FolderCreated',1,$group_id,NULL,0)";
			Database::query($sql,__FILE__,__LINE__);
		}
	}
}

$timeNow=date('d/m/y H:i:s');

$basename_chat = '';
if (!empty($group_id)) {
	$basename_chat = 'messages-'.$dateNow.'_gid-'.$group_id;
} else if (!empty($session_id)) {
	$basename_chat = 'messages-'.$dateNow.'_sid-'.$session_id;
} else {
	$basename_chat = 'messages-'.$dateNow;
}

if (!api_is_anonymous()) {
	
			if(!file_exists($chatPath.$basename_chat.'.log.html')) {
				$doc_id=add_document($_course,$basepath_chat.'/'.$basename_chat.'.log.html','file',0,$basename_chat.'.log.html');
	
				api_item_property_update($_course, TOOL_DOCUMENT, $doc_id, 'DocumentAdded', $_user['user_id'],$group_id,null,null,null,$session_id);
				api_item_property_update($_course, TOOL_DOCUMENT, $doc_id, 'invisible', $_user['user_id'],$group_id,null,null,null,$session_id);
				item_property_update_on_folder($_course,$basepath_chat, $_user['user_id']);
			} else {
				$doc_id = DocumentManager::get_document_id($_course,$basepath_chat.'/'.$basename_chat.'.log.html');
			}
		   $chat_file = $web_chat_path.$basename_chat.'.log.html';
		   $fp=fopen($chatPath.$basename_chat.'.log.html','a');
	
		   fclose($fp);
		   $chat_size=filesize($chatPath.$basename_chat.'.log.html');
	
		   update_existing_document($_course, $doc_id,$chat_size);
		   item_property_update_on_folder($_course,$basepath_chat, $_user['user_id']);

}

// Close create chat file
$htmlHeadXtra[]='
    <style>
        #chat_box_content {
            overflow: hidden;
        }
     </style>
<script language="javascript">    



$(document).ready(function(){    
    // Chat functions
	$("#submitmsg").live("click", function(){
		var clientmsg = $("#usermsg").val();
		$.post("'.$post_path.'", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		return false;
	});
			
    // Chat box
    $(".chatajax").live("click", function(){
    $( "#chat_box_content").dialog({
            modal: true,
            resizable:false,
            close: function(ev, ui) {
                 $.post("'.$post_path.'", {action: "close"});	
                             location.reload(); 
                    },
                      beforeClose: function(event, ui) {

             if(event.keyCode == 27) { 	
                location.reload();   
             }             
        },
        open: function ()
        {
            $(this).load("'.api_get_path(WEB_PATH).'main/chat/room/index.php?'.api_get_cidreq().'");
        },         
        height: 500,
        width: 620,
        title: "'.get_lang('WelcomeToOnlineConf').'"
        });
    });	
});
</script>';

    $htmlHeadXtra[]='
        <script language="javascript">
            //Load the file containing the chat log        
            function loadLog(){	
                   // Get the chat conversation	
                    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;                
                    $.ajax({
                            url: "'.$chat_file.'",
                            cache: false,
                            success: function(html){
                                    html = html.split(":-)").join("<img title=\"'.get_lang('Smile').'\" alt=\"'.get_lang('Smile').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_smile.png\">");
                                    html = html.split(":-D").join("<img title=\"'.get_lang('BigGrin').'\" alt=\"'.get_lang('BigGrin').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_biggrin.png\">");
                                    html = html.split(";-)").join("<img title=\"'.get_lang('Wink').'\" alt=\"'.get_lang('Wink').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_wink.png\">");
                                    html = html.split(":-P").join("<img title=\"'.get_lang('Avid').'\" alt=\"'.get_lang('Avid').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_razz.png\">");
                                    html = html.split("8-)").join("<img title=\"'.get_lang('Cool').'\" alt=\"'.get_lang('Cool').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_cool.png\">");
                                    html = html.split(":-o)").join("<img title=\"'.get_lang('Surprised').'\" alt=\"'.get_lang('Surprised').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_surprised.png\">");
                                    html = html.split("=;").join("<img title=\"'.get_lang('Hello').'\" alt=\"'.get_lang('Hello').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_hand.png\">");
                                    html = html.split(":-k").join("<img title=\"'.get_lang('Think').'\" alt=\"'.get_lang('Think').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_think.png\">");
                                    html = html.split(":-|)").join("<img title=\"'.get_lang('Neutral').'\" alt=\"'.get_lang('Neutral').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_neutral.png\">");
                                    html = html.split(":-?").join("<img title=\"'.get_lang('Confused').'\" alt=\"'.get_lang('Confused').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_confused.png\">");
                                    html = html.split(":-8").join("<img title=\"'.get_lang('To blush').'\" alt=\"'.get_lang('To blush').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_redface.png\">");
                                    html = html.split(":-=").join("<img title=\"'.get_lang('Silence').'\" alt=\"'.get_lang('Silence').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_shhh.png\">");
                                    html = html.split(":-#").join("<img title=\"'.get_lang('Silenced').'\" alt=\"'.get_lang('Silenced').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_silenced.png\">");
                                    html = html.split(":-(").join("<img title=\"'.get_lang('Sad').'\" alt=\"'.get_lang('Sad').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_sad.png\">");
                                    html = html.split(":-[8").join("<img title=\"'.get_lang('Angry').'\" alt=\"'.get_lang('Angry').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_angry.png\">");
                                    html = html.split("--)").join("<img title=\"'.get_lang('Arrow').'\" alt=\"'.get_lang('Arrow').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_arrow.png\">");
                                    html = html.split(":!:").join("<img title=\"'.get_lang('Exclamation').'\" alt=\"'.get_lang('Exclamation').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_exclaim.png\">");
                                    html = html.split(":?:").join("<img title=\"'.get_lang('question').'\" alt=\"'.get_lang('question').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_question.png\">");
                                    html = html.split("0-").join("<img title=\"'.get_lang('Idea').'\"  alt=\"'.get_lang('Idea').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/icon_idea.png\">");
                                    html = html.split("*").join("<img title=\"'.get_lang('AskPermissionSpeak').'\"  alt=\"'.get_lang('AskPermissionSpeak').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/waiting.png\">");
                                    html = html.split(":speak:").join("<img title=\"'.get_lang('GiveTheFloorTo').'\"  alt=\"'.get_lang('GiveTheFloorTo').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/flag_green_small.png\">");
                                    html = html.split(":pause:").join("<img title=\"'.get_lang('Pause').'\"  alt=\"'.get_lang('Pause').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/flag_yellow_small.png\">");
                                    html = html.split(":stop:").join("<img title=\"'.get_lang('Stop').'\"  alt=\"'.get_lang('Stop').'\" src=\"'.api_get_path(WEB_IMG_PATH).'smileys/flag_red_small.png\">");
                                    $("#chatbox").html(html); //Insert chat log into the #chatbox div				
                                    var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
                                    if(newscrollHeight > oldscrollHeight){
                                            $("#chatbox").animate({ scrollTop: newscrollHeight }, "normal"); //Autoscroll to bottom of div
                                    }
                                    // Get the chat users online
				                    $.ajax({
				                            url: "'.api_get_path(WEB_AJAX_PATH).'online.php?action=get_users_from_course_level&'.api_get_cidreq().'",
				                            cache: false,
				                            success: function(rhtml){		
				                                  $("#chatbox-usersonline").html(rhtml);
				                            }
				                    });				
                            }
                    });
                    
            }
            setInterval (loadLog, 2500);	//Reload file every 2.5 seconds
        </script>';    

// include additional libraries
require 'course_home_functions.php';
include_once(api_get_path(LIBRARY_PATH) . 'course.lib.php');
include_once(api_get_path(LIBRARY_PATH) . 'debug.lib.inc.php');

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    //Get information of path
    $info = explode('courses',api_get_self());
    $path_work = substr($info[0],0,strlen($info[0])-1);
} else {
    $path_work = "";
} 

if (!isset($cidReq)) {
	$cidReq = api_get_course_id(); // To provide compatibility with previous systems.
	global $error_msg,$error_no;
	$classError = "init";
	$error_no[$classError][] = "2";
	$error_level[$classError][] = "info";
	$error_msg[$classError][] = "[".__FILE__."][".__LINE__."] cidReq was Missing $cidReq take $dbname;";
}

if (isset($_SESSION['_gid'])) {
	unset($_SESSION['_gid']);
}

// The section for the tabs
$this_section = SECTION_COURSES;


/*
-----------------------------------------------------------
	Constants
-----------------------------------------------------------
*/
define ('TOOL_PUBLIC', 'Public');
define ('TOOL_PUBLIC_BUT_HIDDEN', 'PublicButHide');
define ('TOOL_COURSE_ADMIN', 'courseAdmin');
define ('TOOL_PLATFORM_ADMIN', 'platformAdmin');
define ('TOOL_AUTHORING', 'toolauthoring');
define ('TOOL_INTERACTION', 'toolinteraction');
define ('TOOL_ADMIN', 'tooladmin');
define ('TOOL_ADMIN_PLATEFORM', 'tooladminplatform');
// ('TOOL_ADMIN_PLATFORM_VISIBLE', 'tooladminplatformvisible');
//define ('TOOL_ADMIN_PLATFORM_INVISIBLE', 'tooladminplatforminvisible');
//define ('TOOL_ADMIN_COURS_INVISIBLE', 'tooladmincoursinvisible');
define ('TOOL_STUDENT_VIEW', 'toolstudentview');
define ('TOOL_ADMIN_VISIBLE', 'tooladminvisible');

// variables
$user_id = api_get_user_id();
$course_code = $_course['sysCode'];
$course_info = Database::get_course_info($course_code);

$return_result = CourseManager::determine_course_title_from_course_info($_user['user_id'], $course_info);
$course_title = $return_result['title'];
$course_code = $return_result['code'];

$_course['name'] = $course_title;
$_course['official_code'] = $course_code;

api_session_unregister('toolgroup');

// Is the user allowed here?
if($is_allowed_in_course == false) 
{
	api_not_allowed(true);
}

/*
-----------------------------------------------------------
	SWITCH TO A DIFFERENT HOMEPAGE VIEW
	the setting homepage_view is adjustable through
	the platform administration section
-----------------------------------------------------------
*/

if (api_get_setting('homepage_view') == 'activity' && $css_type != 'tablet') {
	require_once 'activity.php';
} elseif(api_get_setting('homepage_view') == '2column' && $css_type != 'tablet') {
	require_once '2column.php';
} elseif($css_type == 'tablet') {
	require_once 'tablet.php';
} elseif(api_get_setting('homepage_view') == '3column' && $css_type != 'tablet') {
	require_once '3column.php';
} elseif(api_get_setting('homepage_view') == "widget" && $css_type != 'tablet') {
	require_once 'widget.php';
}

// Display the footer
Display::display_footer();
?>