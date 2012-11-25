<?php
/* For licensing terms, see /dokeos_license.txt */

/**
 * Learning Path
 * @package dokeos.learnpath
 */

// Language files that should be included
//$language_file []= 'languagefile1';
//$language_file []= 'languagefile2';

// setting the help
$help_content = 'learningpath';

// including the global Dokeos file
require_once '../inc/global.inc.php';

// including additional libraries
require_once 'back_compat.inc.php';
require_once 'learnpathList.class.php';
require_once 'learnpath.class.php';
require_once 'learnpathItem.class.php';
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
require_once api_get_path(LIBRARY_PATH).'certificatemanager.lib.php';
require_once api_get_path(LIBRARY_PATH).'tracking.lib.php';
require_once api_get_path(LIBRARY_PATH).'export.lib.inc.php';
require_once api_get_path(LIBRARY_PATH).'usermanager.lib.php';
require_once api_get_path(LIBRARY_PATH).'course.lib.php';
require_once api_get_path(SYS_CODE_PATH).'newscorm/learnpath.class.php';
require_once api_get_path(SYS_CODE_PATH).'mySpace/myspace.lib.php';

$htmlHeadXtra[] = '<!--[if IE]><script language="javascript" type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jqplot/excanvas.js"></script><![endif]-->';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/thickbox.js"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jqplot/jquery.jqplot.min.js"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jqplot/plugins/jqplot.barRenderer.min.js"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jqplot/plugins/jqplot.pointLabels.min.js"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jqplot/plugins/jqplot.cursor.min.js"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jquery-ui/js/jquery-ui-1.8.1.custom.min.js"></script>';
$htmlHeadXtra[] = '<link rel="stylesheet" href="'.api_get_path(WEB_LIBRARY_PATH).'javascript/thickbox.css" type="text/css" media="screen" />';
$htmlHeadXtra[] = '<link rel="stylesheet" type="text/css" href="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jqplot/jquery.jqplot.css" />';
$htmlHeadXtra[] = '<link rel="stylesheet" type="text/css" href="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jquery-ui/css/overcast/jquery-ui-1.8.1.custom.css" />';

$htmlHeadXtra[] = '<script type="text/javascript">

function show_image(image,width,height) {
	width = parseInt(width) + 20;
	height = parseInt(height) + 20;
	window_x = window.open(image,\'windowX\',\'width=\'+ width + \', height=\'+ height + \'\');
}

</script>';


// setting the tabs
$this_section=SECTION_COURSES;
// variable initialisation
$is_allowed_to_edit = api_is_allowed_to_edit(null,true);
// Add additional javascript, css
if ($is_allowed_to_edit) {
$htmlHeadXtra[] =
"<script language='javascript' type='text/javascript'>
	function confirmation(name)
	{
		if (confirm(\" ".trim(get_lang('AreYouSureToDelete'))." \"+name+\"?\"))		return true;
		else																		return false;
	}
</script>";

$htmlHeadXtra[] = '
  <script>
        $(function(){
         $("<div id=\'hdnTypeSort\'><input type=\'hidden\' name=\'hdnType\' value=\'CourseModuleSortable\'></div>").insertBefore("body");         
         $( "#GalleryContainer" ).sortable({
            connectWith: "#GalleryContainer",
            stop: function(event) {
               $this=$(event.target);
               $("input[name=\'hdnItemOrder[]\']").each(function(i) {
                 $("input[name=\'hdnItemOrder[]\']").eq(i).val(i+1);
               });
               var query = $("#hdnTypeSort input").add($this.find("input[name=\'hdnItemId[]\']")).add($this.find("input[name=\'hdnItemOrder[]\']")).serialize();                        
               $.ajax({
                  type: "GET",
                  url: "lp_ajax_order_items_scenario.php?"+query,
                  success: function(msg){}
              })                                                
            }
       });
       $( ".imageBox" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" );
       $( "#GalleryContainer" ).disableSelection();
       


       $("#GalleryContainer .imageBox .quiz_content_actions").click(function(){
            var itemId = $(this).find("input[name=\'hdnItemId[]\']").val();
            if (itemId) {
                location.href = "'.api_get_path(WEB_CODE_PATH).'newscorm/lp_controller.php?'.api_get_cidreq().'&action=view&lp_id="+itemId;                
            }
            return false;
       });

      });
  </script>
';

$htmlHeadXtra[] = '
    <style>
        .ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; background: transparent !important; }
    </style>
';
//$htmlHeadXtra[] = '<script src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/jquery.ui.all.js" type="text/javascript" language="javascript"></script>';
}
// color box library
$htmlHeadXtra[] = '<link rel="stylesheet" href="'.api_get_path(WEB_LIBRARY_PATH).'javascript/colorbox/colorbox.css" />';
$htmlHeadXtra[] = '<script type="text/javascript" src="'.api_get_path(WEB_LIBRARY_PATH).'javascript/colorbox/jquery.colorbox.js" language="javascript"></script>';
// Unregister the session if it exists
if(isset($_SESSION['lpobject'])) {
  $oLP = unserialize($_SESSION['lpobject']);
    if(is_object($oLP)){
      api_session_unregister('oLP');
      api_session_unregister('lpobject');
    }
  } elseif (is_null($_SESSION['lpobject']) && isset($_SESSION['oLP'])) {
    api_session_unregister('oLP');
 }
 
// setting the breadcrumbs
$interbreadcrumb[] = array ("url"=>"overview.php", "name"=> get_lang('OverviewOfAllCodeTemplates'));
$interbreadcrumb[] = array ("url"=>"coursetool.php", "name"=> get_lang('CourseTool'));

// Display the header
Display::display_tool_header(get_lang('CourseTool'));
$is_allowed_to_edit = api_is_allowed_to_edit(null,true);

/*------------------------------*/

if(empty($lp_controller_touched) || $lp_controller_touched!=1){
	header('location: lp_controller.php?action=list');
}

$courseDir   = api_get_course_path().'/scorm';
$baseWordDir = $courseDir;
$display_progress_bar = true;

/**
 * Display initialisation and security checks
 */
$nameTools = get_lang(ucfirst(TOOL_LEARNPATH));
event_access_tool(TOOL_LEARNPATH);

if (! $is_allowed_in_course) api_not_allowed();

/**
 * Display
 */
/* Require the search widget and prepare the header with its stuff */
if (api_get_setting('search_enabled') == 'true') {
	require api_get_path(LIBRARY_PATH).'search/search_widget.php';
	search_widget_prepare($htmlHeadXtra);
}

/*
-----------------------------------------------------------
	Introduction section
	(editable by course admins)
-----------------------------------------------------------
*/
Display::display_introduction_section(TOOL_LEARNPATH, array(
		'CreateDocumentWebDir' => api_get_path('WEB_COURSE_PATH').api_get_course_path().'/document/',
		'CreateDocumentDir' => '../../courses/'.api_get_course_path().'/document/',
		'BaseHref' => api_get_path('WEB_COURSE_PATH').api_get_course_path().'/'
	)
);


$current_session = api_get_session_id();
$drag_style = "cursor:default";
if($is_allowed_to_edit) {
 $drag_style = "";
	echo '<script type="text/javascript">		
		function dragDropEnd(ev)
		{			
		readyToMove = false;
		moveTimer = -1;

		var orderString = "";
			var objects = document.getElementsByTagName(\'div\');
			
		for(var no=0;no<objects.length;no++){
			if(objects[no].className==\'imageBox\' || objects[no].className==\'imageBoxHighlighted\'){
				if(objects[no].id != "foo" && objects[no].parentNode.id != "dragDropContent"){ // Check if its not the fake image, or the drag&drop box
					if(orderString.length>0){
						orderString = orderString + \',\';
						}
					orderString = orderString + objects[no].id;
					}
				}					
			}	

		dragDropDiv.style.display=\'none\';
		insertionMarker.style.display=\'none\';
		
		if(destinationObject && destinationObject!=activeImage){
			var parentObj = destinationObject.parentNode;
			parentObj.insertBefore(activeImage,destinationObject);
			activeImage.className=\'imageBox\';
			activeImage = false;
			destinationObject=false;
			getDivCoordinates();	
		}		
		savelporder(orderString);
}

function savelporder(str)
	{
			var orderString = "";
			var objects = document.getElementsByTagName(\'div\');
			
			for(var no=0;no<objects.length;no++){
				if(objects[no].className==\'imageBox\' || objects[no].className==\'imageBoxHighlighted\'){
					if(objects[no].id != "foo" && objects[no].parentNode.id != "dragDropContent"){ // Check if its not the fake image, or the drag&drop box
						if(orderString.length>0){
							orderString = orderString + \',\';
							}
						orderString = orderString + objects[no].id;
						}
					}					
				}				
		if(str != orderString)
		{
		  window.location.href="lp_controller.php?'.api_get_cidReq().'&action=course&dispaction=sortlp&order="+orderString;
		}
}
		
				</script>';
	
  /*--------------------------------------
    DIALOG BOX SECTION
    --------------------------------------*/

  if (!empty($dialog_box))
  {
	  switch ($_GET['dialogtype'])
	  {
	  	case 'confirmation':	Display::display_confirmation_message($dialog_box);		break;
	  	case 'error':			Display::display_error_message($dialog_box);			break;
	  	case 'warning':			Display::display_warning_message($dialog_box);			break;
	  	default:	    		Display::display_normal_message($dialog_box);			break;
	  }
  }
  
	if (api_failure::get_last_failure())	    Display::display_normal_message(api_failure::get_last_failure());

	echo '<div class="actions">';
		echo '<a class="" href="'.api_get_self().'?'.api_get_cidReq().'">'.Display::return_icon('pixel.gif', get_lang('Author'), array('class' => 'toolactionplaceholdericon toolactionauthor')).get_lang("Author").'</a>';
	echo '</div>';
}

/*---------------------------------------------------------------------------------------------------------------------------------*/
?>
<div id="content">
	<?php	
		$list = new LearnpathList(api_get_user_id());
		$flat_list = $list->get_flat_list();
		if (is_array($flat_list) && !empty($flat_list))
		{
			echo '<div id="GalleryContainer">';	
                        $i = 0;
			foreach ($flat_list as $id => $details)
			{
                                if (intval($details['lp_visibility']) == 0) { continue; }
				$name = Security::remove_XSS($details['lp_name']);
				$progress_bar = learnpath::get_db_progress($id,api_get_user_id());	
				
				if(strlen($name) > 75)
				{
				$display_name = substr($name,0,75).'...';
				}
				else
				{
				$display_name = $name;
				}
 				$html = "<div class=\"border\" style='width:99%;height:18px;'><div class=\"progressbar\" style='width:$progress_bar;height:20px;'></div></div>";
				echo '<div class="imageBox" id="imageBox'.$id.'" style="position:relative;">';
                                
                                $obj_certificate = new CertificateManager();
                                $certif_available = $obj_certificate->isUserAllowedGetCertificate(api_get_user_id(), 'module', $id, api_get_course_id());
                                if ($certif_available) {
                                    echo '<a id="certificate-'.$id.'-link" href="#">'.Display::return_icon('certificate48x48.png', get_lang('GetCertificate'), array('style'=>'position:absolute;top:10px;right:12px;')).'</a>';
                                    $obj_certificate->displayCertificate('html', 'module', $id, api_get_course_id(), null, true);
                                }
                                
                                echo '<div class="imageBox_theImage" style="'.$drag_style.'"><div class="quiz_content_actions" style="width:200px;height:80%;">';
                                echo '<input type="hidden" name="hdnItemId[]" value="'.$id.'">
                                      <input type="hidden" name="hdnItemOrder[]" value="'.($i+1).'">';
                                echo '<table width="100%">';
				echo '<tr style="height:50px;"><td colspan="2" align="center">'.$display_name.'</td></tr>';
				echo '<tr><td>&nbsp;</td></tr></table><table width="100%">';
				echo '<tr><td width="80%" valign="top">'.$html.'</td><td align="center"><a href="lp_controller.php?'.api_get_cidReq().'&action=view&lp_id='.$id.'">'.Display::return_icon('pixel.gif', get_lang('View'), array('class' => 'actionplaceholdericon actionviewmodule')).'</a></td></tr>';
				echo '</table>';				
				echo '</div></div>';
				if (api_is_allowed_to_edit()) {
				  echo '<div align="center"><a href="lp_controller.php?'.api_get_cidReq().'&action=add_item&type=step&lp_id='.$id.'">'.Display::return_icon('pixel.gif', get_lang('Edit'), array('class' => 'actionplaceholdericon actionedit')).'</a></div>';
				}
				echo '</div>';
                                $i++;
			}
			echo '</div>
		<div id="insertionMarker">
		<img src="../img/marker_top.gif">
		<img src="../img/marker_middle.gif" id="insertionMarkerLine">
		<img src="../img/marker_bottom.gif">
		</div>
		<div id="dragDropContent">
		</div><div id="debug" style="clear:both">
		</div>';
		}
		else
		{
			echo '<div align="center"><a href="lp_controller.php?' . api_get_cidreq().'">'.get_lang('NoCourse').'</a></div>';
		}
///------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------   
// Nuevo modulo para desarrollo EP    

// getting all the students of the course
$a_students = CourseManager :: get_student_list_from_course_code($_course['id'], true, (empty($_SESSION['id_session']) ? null : $_SESSION['id_session']));
$nbStudents = count($a_students);
$course = $_GET['cidReq'];

$info_user['name'] = api_get_person_name($info_user['firstname'], $info_user['lastname']);
$info_user = UserManager :: get_user_info_by_id($student_id);


// gets course actual administrators
		$sql = "SELECT user.user_id FROM $table_user user, $TABLECOURSUSER course_user
			WHERE course_user.user_id=user.user_id AND course_user.course_code='".api_get_course_id()."' AND course_user.status <> '1' ";
		$res = Database::query($sql, __FILE__, __LINE__);

		$student_ids = array();

		while($row = Database::fetch_row($res)) {
			$student_ids[] = $row[0];
		}
		$count_students = count($student_ids);
    
if (api_is_allowed_to_edit()) { 
$course_info = CourseManager :: get_course_information($get_course_code);
$TBL_LP_ITEM_VIEW = Database :: get_course_table(TABLE_LP_ITEM_VIEW);
$sql = "SELECT max(view_count) FROM $TBL_LP_VIEW " .
"WHERE lp_id = $lp_id AND user_id = '" . $user_id . "'";
$res = Database::query($sql, __FILE__, __LINE__);
$view = '';
$num = 0;
if (Database :: num_rows($res) > 0) {
	$myrow = Database :: fetch_array($res);
	$view = $myrow[0];
}

$t_lp_view = Database :: get_course_table(TABLE_LP_VIEW, $info_course['db_name']);
$t_lp_item = Database :: get_course_table(TABLE_LP_ITEM, $info_course['db_name']);

//-----------------------------------------------------
//Comenzar tabla para revisiones
//-----------------------------------------------------
echo "<table id='studentmodule' class='data_table' style='margin-top: 15px;'> ";
for($student_id_counterloop = 0 ; $student_id_counterloop< $count_students; $student_id_counterloop++){
    $info_user = UserManager :: get_user_info_by_id($student_ids[$student_id_counterloop]); 
    $info_user['name'] = api_get_person_name($info_user['firstname'], $info_user['lastname']);
    
    $sql_needsgrading = "SELECT DISTINCT exercices.exe_id, exercices.exe_user_id, exercices.exe_result, lpiv.total_time
,exercices.exe_exo_id, lpi.title
FROM dokeos_stats.track_e_attempt AS attempt, dokeos_stats.track_e_exercices AS exercices,
$t_lp_view As lpv, $t_lp_item As lpi, $TBL_LP_ITEM_VIEW as lpiv
WHERE exercices.exe_id = attempt.exe_id
AND lpv.id=lpiv.lp_view_id
AND lpi.id=lpiv.lp_item_id
AND lpv.user_id=exercices.exe_user_id
AND lpiv.score=exercices.exe_result
AND attempt.flag =0
AND exercices.status= \"\"
AND lpv.user_id=".$student_ids[$student_id_counterloop].' 
GROUP BY exercices.exe_id';

    $query_needsgrading = Database::query($sql_needsgrading,__FILE__,__LINE__);
    $num_needsgrading = Database :: num_rows($query_needsgrading);
    

 while ($row_needsgrading = Database :: fetch_array($query_needsgrading)) {    
      $user_id = api_get_user_id();
      echo  "<tr class='row_odd'>
                 <td>
                   " . $info_user['name'] . " 
                </td>
                <td>
                   " . $row_needsgrading['title'] . " 
                </td>
                <td>
                 <a href='../exercice/exercise_show.php?origin=tracking_course&myid=". $user_id ."&id=".$row_needsgrading['exe_id']."&cidReq=$course&student=".$row_needsgrading['exe_user_id']."&total_time=".$row_needsgrading['total_time']."&my_exe_exo_id=".$row_needsgrading['exe_exo_id']."'>".
                    $row_needsgrading['exe_id'].'  <img title="Show and mark attempt" alt="Show and mark attempt" src="../../main/img/quiz.gif">'."</a><br>
                </td>
            </tr>";
    }
    
}
echo '</table>' ;

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//loop for student detailed list
for($student_id_counterloop = 0 ; $student_id_counterloop< $count_students; $student_id_counterloop++){	
    $info_user = UserManager :: get_user_info_by_id($student_ids[$student_id_counterloop]); 
    $info_user['name'] = api_get_person_name($info_user['firstname'], $info_user['lastname']); ?>
  	<!-- line about learnpaths -->
				<table id="studentmodule" class="data_table">
          <tr>
              <td align="center" colspan="6">
                  <span style="font-weight: bold; font-size: 20px;"><?php echo $info_user['name'];?></span>
              </td>
          </tr>
					<tr>
						<th>
							<?php echo get_lang('Learnpaths');?>
						</th>
						<th>
							<?php

		echo get_lang('Time');
		/*Display :: display_icon('info3.gif', get_lang('TotalTimeByCourse'), array (
			'align' => 'absmiddle',
			'hspace' => '3px'
		));*/
?>
						</th>
						<th>
							<?php

		echo get_lang('Score');
		/*Display :: display_icon('info3.gif', get_lang('LPTestScore'), array (
			'align' => 'absmiddle',
			'hspace' => '3px'
		));*/
?>
						</th>
						<th>
							<?php

		echo get_lang('Progress');
		/*Display :: display_icon('info3.gif', get_lang('LPProgressScore'), array (
			'align' => 'absmiddle',
			'hspace' => '3px'
		));*/
?>
						</th>
						<th>
							<?php

		echo get_lang('LastConnexion');
		/*Display :: display_icon('info3.gif', get_lang('LastTimeTheCourseWasUsed'), array (
			'align' => 'absmiddle',
			'hspace' => '3px'
		));*/
?>
						</th>
						<th>
							<?php echo get_lang('Details');?>
						</th> 
					</tr>
<?php

		$headerLearnpath = array (
			get_lang('Learnpath'),
			get_lang('Time'),
			get_lang('Progress'),
			get_lang('LastConnexion')
		);

		$t_lp = Database :: get_course_table(TABLE_LP_MAIN, $info_course['db_name']);
		$t_lpi = Database :: get_course_table(TABLE_LP_ITEM, $info_course['db_name']);
		$t_lpv = Database :: get_course_table(TABLE_LP_VIEW, $info_course['db_name']);
		$t_lpiv = Database :: get_course_table(TABLE_LP_ITEM_VIEW, $info_course['db_name']);

		$tbl_stats_exercices = Database :: get_statistic_table(TABLE_STATISTIC_TRACK_E_EXERCICES);
		$tbl_stats_attempts = Database :: get_statistic_table(TABLE_STATISTIC_TRACK_E_ATTEMPT);
		$tbl_quiz_questions = Database :: get_course_table(TABLE_QUIZ_QUESTION, $info_course['db_name']);

		$sql_learnpath = "	SELECT lp.name,lp.id
							FROM $t_lp AS lp ORDER BY lp.name ASC";

		$result_learnpath = Database::query($sql_learnpath, __FILE__, __LINE__);

		$csv_content[] = array ();
		$csv_content[] = array (
			get_lang('Learnpath', ''),
			get_lang('Time', ''),
			get_lang('Score', ''),
			get_lang('Progress', ''),
			get_lang('LastConnexion', '')
		);

		if (Database :: num_rows($result_learnpath) > 0) {
			$i = 0;
			while ($learnpath = Database :: fetch_array($result_learnpath)) {
				$any_result = false;
				$progress = learnpath :: get_db_progress($learnpath['id'], $student_ids[$student_id_counterloop], '%', $info_course['db_name'], true);
				if ($progress === null) {
					$progress = '0%';
				} else {
					$any_result = true;
				}

				// calculates time
				$sql = 'SELECT SUM(total_time)
												FROM ' . $t_lpiv . ' AS item_view
												INNER JOIN ' . $t_lpv . ' AS view
													ON item_view.lp_view_id = view.id
													AND view.lp_id = ' . $learnpath['id'] . '
													AND view.user_id = ' . intval($student_ids[$student_id_counterloop]);
				$rs = Database::query($sql, __FILE__, __LINE__);
				$total_time = 0;
				if (Database :: num_rows($rs) > 0) {
					$total_time = Database :: result($rs, 0, 0);
					if ($total_time > 0)
						$any_result = true;
				}

				// calculates last connection time
				$sql = 'SELECT MAX(start_time)
												FROM ' . $t_lpiv . ' AS item_view
												INNER JOIN ' . $t_lpv . ' AS view
													ON item_view.lp_view_id = view.id
													AND view.lp_id = ' . $learnpath['id'] . '
													AND view.user_id = ' . intval($student_ids[$student_id_counterloop]);
				$rs = Database::query($sql, __FILE__, __LINE__);
				$start_time = null;
				if (Database :: num_rows($rs) > 0) {
					$start_time = Database :: result($rs, 0, 0);
					if ($start_time > 0)
						$any_result = true;
				}

				//QUIZZ IN LP
				$score = Tracking :: get_avg_student_score(intval($student_ids[$student_id_counterloop]), Database :: escape_string($course), array (
					$learnpath['id']
				));

				if (empty ($score)) {
					$score = 0;
				}
				if ($i % 2 == 0) {
					$css_class = "row_odd";
				} else {
					$css_class = "row_even";
				}

				$i++;

				$csv_content[] = array (
					api_html_entity_decode(stripslashes($learnpath['name']), ENT_QUOTES, $charset),
					api_time_to_hms($total_time),
					$score . '%',
					$progress,
					date('Y-m-d', $start_time)
				);
?>
					<tr class="<?php echo $css_class;?>">
						<td>
							<?php echo stripslashes($learnpath['name']); ?>
						</td>
						<td align="center">
						<?php echo api_time_to_hms($total_time) ?>
						</td>
						<td align="center">
							<?php

							if (!is_null($score)) {
								echo $score . '%';
							} else {
								echo '-';
							}
?>
						</td>
						<td align="center">
							<?php echo $progress ?>
						</td>
						<td align="center">
							<?php
				if ($start_time != '' && $start_time > 0) {
					echo format_locale_date(get_lang('DateFormatLongWithoutDay'), $start_time);
				} else {
					echo '-';
				}
?>
						</td>
						<td align="center">
							<?php
				if ($any_result === true) {
					$from = '';
					if ($from_myspace) {
						$from ='&from=myspace';
					}
?>
					<a href="../myspace/charts/learnpath.ajax.php?width=900&height=500&cidReq=<?php echo $course; ?>&course=<?php echo $course; ?>&lp_id=<?php echo $learnpath['id'] ?>&user_id=<?php echo intval($student_ids[$student_id_counterloop]) ?>" class="thickbox" title="<?php echo sprintf(get_lang('CompareUsersOnLearnpath'),$learnpath['name']) ?>">
						<?php echo Display::return_icon('pixel.gif',get_lang('AccessDetails'), array('class' => 'actionplaceholdericon actionstatistics')) ?>
					</a>
					<a href="../myspace/lp_tracking.php?cidReq=<?php echo Security::remove_XSS($_GET['cidReq']); ?>&course=<?php echo $course; ?>&origin=<?php echo "tracking_course"; ?>&lp_id=<?php echo $learnpath['id']?>&student_id=<?php echo $student_ids[$student_id_counterloop]; ?>">
						<?php echo Display::return_icon('pixel.gif',get_lang('AccessDetails'), array('class' => 'actionplaceholdericon actionstatisticsdetails')) ?>
					</a>
					<?php
				}
?>
						</td>
					</tr>
				<?php
				$data_learnpath[$i][] = $learnpath['name'];
				$data_learnpath[$i][] = $progress . '%';
				$i++;
			}
		} else {
			echo "	<tr>
										<td colspan='6'>
											" . get_lang('NoLearnpath') . "
										</td>
									</tr>
								 ";
		}
?>
				</table>
        <?php
 ///------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------     
// 		if (api_is_allowed_to_edit()) {
// 				  echo '<script language="JavaScript" type="text/javascript">
//                 function a(){
//                   $("iframe#frm").contents().find("table#studentmodule tbody").clone().appendTo("#a");
//                 }
//                 </script>   
//           <iframe id="frm" src="../myspace/mystudents.php?student=3&details=true&course=backup" name="Name" width="960px" seamless="true" height="900px">
//           content if browser does not support
//           </iframe>
//           <div id="a"></div>';
// 				}
 ?>
	
	<!-- list of courses -->
<?php	
} }
?>	
</div><!--end of div#content-->

<?php


// bottom actions bar
echo '<div class="actions">';
echo '</div>';

// display the footer
Display::display_footer();
?>
