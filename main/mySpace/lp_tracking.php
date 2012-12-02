<?php
/* For licensing terms, see /dokeos_license.txt */

/*
 * Created on 26 mars 07 by Eric Marguin
 * Script to display the tracking of the students in the learning paths.
 */

$language_file = array ('registration', 'index', 'tracking', 'exercice', 'scorm', 'learnpath');
//$cidReset = true;

require '../inc/global.inc.php';

$TBL_TRACK_EXERCICES	= Database::get_statistic_table(TABLE_STATISTIC_TRACK_E_EXERCICES);
$TBL_TRACK_ATTEMPT		= Database::get_statistic_table(TABLE_STATISTIC_TRACK_E_ATTEMPT);
$TBL_EXERCICE_QUESTION 	= Database::get_course_table(TABLE_QUIZ_TEST_QUESTION);
$TBL_QUESTIONS         	= Database::get_course_table(TABLE_QUIZ_QUESTION);
$id = $_GET['id'];


$from_myspace = false;
$from_link = '';
if (isset($_GET['from']) && $_GET['from'] == 'myspace') {
	$from_link = '&from=myspace';
	$this_section = "session_my_space";
} else {
	$this_section = SECTION_COURSES;
}
include_once api_get_path(LIBRARY_PATH).'tracking.lib.php';
include_once api_get_path(LIBRARY_PATH).'export.lib.inc.php';
include_once api_get_path(LIBRARY_PATH).'course.lib.php';
include_once api_get_path(LIBRARY_PATH).'usermanager.lib.php';
include_once api_get_path(SYS_CODE_PATH).'newscorm/learnpath.class.php';
include_once api_get_path(SYS_CODE_PATH).'newscorm/learnpathItem.class.php';
require_once api_get_path(LIBRARY_PATH).'export.lib.inc.php';


if (isset($_GET['delete']) && $_GET['delete'] == 'yes') {
      $query = "SELECT attempts.exe_id  from ".$TBL_TRACK_ATTEMPT." as attempts  
						INNER JOIN ".$TBL_TRACK_EXERCICES." as stats_exercices ON stats_exercices.exe_id=attempts.exe_id 
						INNER JOIN ".$TBL_QUESTIONS." as questions ON questions.id=attempts.question_id 
                                                INNER JOIN ".$TBL_EXERCICE_QUESTION." as rel_questions ON rel_questions.question_id = questions.id AND rel_questions.exercice_id = stats_exercices.exe_exo_id
                                                WHERE attempts.exe_id='".Database::escape_string($id)."'                                 
                                                GROUP BY attempts.question_id 
                                                ORDER BY rel_questions.question_order ASC";                 
		$result =Database::query($query, __FILE__, __LINE__); 
    
    
    while ($row_result = Database :: fetch_array($result)) {
        $delete_query = "DELETE attempt, exercices FROM ".$TBL_TRACK_ATTEMPT." as attempt,".$TBL_TRACK_EXERCICES." as exercices WHERE attempt.exe_id=".$row_result[0]." AND exercices.exe_id=attempt.exe_id";
        Database::query($delete_query, __FILE__, __LINE__);
    }
}

$export_csv = isset($_GET['export']) && $_GET['export'] == 'csv' ? true : false;
if ($export_csv) {
	ob_start();   
}



$csv_content = array();
$user_id = intval($_GET['student_id']);

if(isset($_GET['course'])) {
	$cidReq = Security::remove_XSS($_GET['course']);
}

$user_infos = UserManager :: get_user_info_by_id($user_id);
$name = api_get_person_name($user_infos['firstname'], $user_infos['lastname']);

if (!api_is_platform_admin(true) && !CourseManager :: is_course_teacher($_user['user_id'], $cidReq) && !Tracking :: is_allowed_to_coach_student($_user['user_id'],$_GET['student_id']) && $user_infos['hr_dept_id']!==$_user['user_id']) {
	Display::display_header('');
	api_not_allowed();
	Display::display_footer();
}

$course_exits = CourseManager::course_exists($cidReq);

if (!empty($course_exits)) {
	$course = CourseManager :: get_course_information($cidReq);
} else {
	api_not_allowed();
}


$course['dbNameGlu'] = $_configuration['table_prefix'] . $course['db_name'] . $_configuration['db_glue'];

if (!empty($_GET['origin']) && $_GET['origin'] == 'user_course') {
	$interbreadcrumb[] = array ("url" => api_get_path(WEB_COURSE_PATH).$course['directory'], 'name' => $course['title']);
	$interbreadcrumb[] = array ("url" => "../user/user.php?cidReq=".$cidReq, "name" => get_lang("Users"));
} else if(!empty($_GET['origin']) && $_GET['origin'] == 'tracking_course') {
	$interbreadcrumb[] = array ("url" => api_get_path(WEB_COURSE_PATH).$course['directory'], 'name' => $course['title']);
	$interbreadcrumb[] = array ("url" => "../tracking/courseLog.php?cidReq=".$cidReq.'&studentlist=true&id_session='.$_SESSION['id_session'], "name" => get_lang("Tracking"));
} else {
	$interbreadcrumb[] = array ("url" => "index.php", "name" => get_lang('MySpace'));
	$interbreadcrumb[] = array ("url" => "student.php", "name" => get_lang("MyStudents"));
 	$interbreadcrumb[] = array ("url" => "myStudents.php?student=".Security::remove_XSS($_GET['student_id']), "name" => get_lang("StudentDetails"));
 	$nameTools=get_lang("DetailsStudentInCourse");
}
$interbreadcrumb[] = array("url" => "myStudents.php?student=".Security::remove_XSS($_GET['student_id'])."&course=".$cidReq."&details=true&origin=".Security::remove_XSS($_GET['origin']) , "name" => get_lang("DetailsStudentInCourse"));
$nameTools = get_lang('LearningPathDetails');

$htmlHeadXtra[] = '
<style>
div.title {
	font-weight : bold;
	text-align : left;
}
div.mystatusfirstrow {
	font-weight : bold;
	text-align : left;
}
div.description {
	font-family : Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: Silver;
}

.data_table {
	border-collapse: collapse;
}
.data_table th {
	padding-right: 0px;
	border: 1px  solid gray;
	background-color: #eef;
}
.data_table tr.row_odd {
	background-color: #fafafa;
}
.data_table tr.row_odd:hover, .data_table tr.row_even:hover {
	background-color: #f0f0f0;
}
.data_table tr.row_even {
	background-color: #fff;
}
.data_table td {
	padding: 5px;
	vertical-align: top;
	border-bottom: 1px solid #b1b1b1;
	border-right: 1px dotted #e1e1e1;
	border-left: 1px dotted #e1e1e1;
}

.margin_table {
	margin-left : 3px;
	width: 80%;
}
.margin_table td.title {
	background-color: #ffff99;
}
.margin_table td.content {
	background-color: #ddddff;
}
</style>';

Display :: display_header($nameTools);


$lp_id = intval($_GET['lp_id']);

$sql = 'SELECT name
	FROM '.Database::get_course_table(TABLE_LP_MAIN, $course['db_name']).'
	WHERE id='.Database::escape_string($lp_id);
$rs = Database::query($sql, __FILE__, __LINE__);
$lp_title = Database::result($rs, 0, 0);
echo '<div class ="actions"><div align="left" style="float:left;margin-top:2px;" ><strong>'.$course['title'].' - '.$lp_title.' - '.$name.'</strong></div>
	  <div  align="right">
                <a href="myStudents.php?student='.Security::remove_XSS($_GET['student_id']).'&details=true&course='.$cidReq.'&origin=tracking_course">' .Display::return_icon('pixel.gif', get_lang('Back'), array('class' => 'toolactionplaceholdericon toolactionback')) . get_lang('Back') . '</a>
        <a href="javascript: void(0);" onclick="javascript: window.print();">'.Display::return_icon('pixel.gif',get_lang('Print'),array('class'=>'toolactionplaceholdericon toolactionprint32')).''.get_lang('Print').'</a>
    		<a href="'.api_get_self().'?export=csv&'.Security::remove_XSS($_SERVER['QUERY_STRING']).'">'.Display::return_icon('pixel.gif',get_lang('ExportAsCSV'),array('class'=>'toolactionplaceholdericon toolactionexportcourse')).''.get_lang('ExportAsCSV').'</a>
		 </div></div>
	<div class="clear"></div>';echo '<div id="content">';

	


$list = learnpath :: get_flat_ordered_items_list($lp_id);
$origin = 'tracking';



if ($export_csv) {
	include_once api_get_path(SYS_CODE_PATH).'newscorm/lp_stats.php';

	//Export :: export_table_csv($csv_content, 'reporting_student');
} else {
  
	ob_start();
	include_once  api_get_path(SYS_CODE_PATH).'newscorm/lp_stats.php';
	$tracking_content = ob_get_contents();
	ob_end_clean();
	echo api_utf8_decode($tracking_content, $charset);
}


// ending div#content
echo '</div>';

// bottom actions toolbar
echo '<div class="actions">';
echo '</div>';

Display :: display_footer();