<?php
/* For licensing terms, see /dokeos_license.txt */
/**
 * Responses to AJAX calls
 */
require_once '../global.inc.php';
global $_course;
$action = $_GET['action'];

	switch ($action) {
		case 'get_users_from_course_level':
			$whoisonline = Who_is_online_in_this_course(api_get_user_id(), 1, $_course['id']);
			foreach ($whoisonline as $useronline) {
				$all_user_info =  api_get_user_info($useronline['0']);
				//echo '<strong>- '.$all_user_info['username'].'</strong><br>';
                                echo '<strong>'.Display::return_icon('pixel.gif',$all_user_info['username'],array('class' => 'actionplaceholdericon actioninfo') ).$all_user_info['username'].'</strong><br>';
			}
			break;
}
