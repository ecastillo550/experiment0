<?php
/* For licensing terms, see /dokeos_license.txt */

/**
* @author Bart Mollet
* @package dokeos.admin
*/

// name of the language file that needs to be included
$language_file = array ('registration','admin');

// resetting the course id
$cidReset = true;

// setting the help
$help_content = 'platformadministrationsessionadd';

// including the global Dokeos file
require_once '../inc/global.inc.php';

// including additional libraries
require_once api_get_path(LIBRARY_PATH).'sessionmanager.lib.php';
require_once '../inc/lib/xajax/xajax.inc.php';
require_once api_get_path(LIBRARY_PATH).'certificatemanager.lib.php';

// setting the section (for the tabs)
$this_section = SECTION_PLATFORM_ADMIN;

// Access restrictions
api_protect_admin_script(true);

// setting breadcrumbs
$interbreadcrumb[]=array('url' => 'index.php',"name" => get_lang('PlatformAdmin'));
$interbreadcrumb[]=array('url' => "session_list.php","name" => get_lang('SessionList'));

// Database Table Definitions
$tbl_user		= Database::get_main_table(TABLE_MAIN_USER);
$tbl_session	= Database::get_main_table(TABLE_MAIN_SESSION);

// additional javascript, css, ...
$xajax = new xajax();
//$xajax->debugOn();
$xajax -> registerFunction ('search_coachs');
$htmlHeadXtra[] = $xajax->getJavascript('../inc/lib/xajax/');
$htmlHeadXtra[] = '
<script type="text/javascript">
function fill_coach_field (username) {
	document.getElementById("coach_username").value = username;
	document.getElementById("ajax_list_coachs").innerHTML = "";
}
</script>';

$formSent=0;
$errorMsg='';
$xajax -> processRequests();

if ($_POST['formSent']) {

	$formSent=1;
	$name= $_POST['name'];
   // $max_seats  =   $_POST['max_seats'];
        $cost  =   $_POST['cost'];
	$description=   $_POST['description'];
	$year_start= $_POST['year_start'];
	$month_start=$_POST['month_start'];
	$day_start=$_POST['day_start'];
	$year_end=$_POST['year_end'];
	$month_end=$_POST['month_end'];
	$day_end=$_POST['day_end'];
	$nolimit=$_POST['nolimit'];
	$coach_username=$_POST['coach_username'];
	$id_session_category = $_POST['session_category'];
        
        if (api_get_setting('enable_certificate') === 'true') {
            // preparing params of certificate in session
            $certif_template = 0;
            $certif_tool = '';
            $certif_min_score = $certif_min_progress = 0.00;
            if (!empty($_POST['certificate_template'])) {
                $certif_template = intval($_POST['certificate_template']);
                $certif_tool = $_POST['certificate_tool'];
                if ($_POST['certif_evaluation_type'] == 2 || $_POST['certificate_tool'] == 'quiz') {
                    // score
                    $certif_min_score = $_POST['certificate_min_score'];
                    $certif_min_progress = 0.00;
                } else {
                    // progress
                    $certif_min_progress = $_POST['certificate_min_score'];
                    $certif_min_score = 0.00;
                }
            }
        }
        
        
	$return = SessionManager::create_session($name,$description,$year_start,$month_start,$day_start,$year_end,$month_end,$day_end,$nolimit,$coach_username, $id_session_category, $cost, $certif_template, $certif_tool, $certif_min_score, $certif_min_progress);
	if ($return == strval(intval($return))) {
		// integer => no error on session creation
  global $_configuration;
		require_once (api_get_path(LIBRARY_PATH).'urlmanager.lib.php');
		if ($_configuration['multiple_access_urls']==true) {
			$tbl_user_rel_access_url= Database::get_main_table(TABLE_MAIN_ACCESS_URL_REL_USER);
			$access_url_id = api_get_current_access_url_id();
			UrlManager::add_session_to_url($return,$access_url_id);
		} else {
			// we are filling by default the access_url_rel_session table
			UrlManager::add_session_to_url($return,1);
		}
		header('Location: add_courses_to_session.php?id_session='.$return.'&add=true&msg=');
		exit();
	}
}



$nb_days_acess_before = 0;
$nb_days_acess_after = 0;

$thisYear=date('Y');
$thisMonth=date('m');
$thisDay=date('d');

// certificate object
$objCertificate = new CertificateManager();

$htmlHeadXtra[] = '
    <style> 
        .media { display:none;}
        #session-certificate-thumb {
            text-align:left;
            margin-top: 0px;
        }
        #session-certificate-thumb img {
            border: 2px solid #aaa;
        }
        .session-certificate-score {
            '.($formSent && $certif_template?'display:block':'display:none').';
        }        
    </style>
    <script>
        $(document).ready(function() { 
           // change certificate template
           $("#session-certificate").change(function(){            
                var tpl_id = $(this).val();
                $(".session-certificate-score").hide();
                if (tpl_id == 0) {
                    $(".session-certificate-score input[name=\'certificate_min_score\']").val(\'\');
                    $(".session-certificate-score").hide();
                } else {
                    $(".session-certificate-score").show();
                }
                $.ajax({
                    type: "GET",
                    url: "'.api_get_path(WEB_CODE_PATH).'exercice/exercise.ajax.php?'.api_get_cidReq().'&action=displayCertPicture&tpl_id="+tpl_id,
                    success: function(data) {
                        $("#session-certificate-thumb").show();
                        $("#session-certificate-thumb").html(data);
                    }
                });
           });
           
            $(".certificate-tool-radio").click(function(){
                var check = $("#certificate-tool-radio2").is(":checked");
                $(".certificate-module-eval-type").hide();
                if (check) {
                    $(".certificate-module-eval-type").hide();
                } else {
                    $(".certificate-module-eval-type").show();
                }
            });
        });
    </script>
';

//display the header
Display::display_header(get_lang('AddSession'));

echo '<div class="actions">';
/*if(api_get_setting('show_catalogue')=='true'){
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/catalogue_management.php">' . Display::return_icon('pixel.gif',get_lang('Catalogue'), array('class' => 'toolactionplaceholdericon toolactioncatalogue')) . get_lang('Catalogue') . '</a>';
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/programme_list.php">' . Display :: return_icon('pixel.gif', get_lang('Programmes'),array('class' => 'toolactionplaceholdericon toolactionprogramme')) . get_lang('Programmes') . '</a>';
}*/
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/session_list.php">' . Display :: return_icon('pixel.gif', get_lang('SessionList'),array('class' => 'toolactionplaceholdericon toolactionsession')) . get_lang('SessionList') . '</a>';
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/session_category_list.php">'.Display :: return_icon('pixel.gif', get_lang('ListSessionCategory'),array('class' => 'toolactionplaceholdericon toolactioncatalogue')).get_lang('ListSessionCategory').'</a>';
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/session_export.php">'.Display::return_icon('pixel.gif',get_lang('ExportSessionListXMLCSV'),array('class' => 'toolactionplaceholdericon toolactionexportcourse')).get_lang('ExportSessionListXMLCSV').'</a>';
echo '<a href="'.api_get_path(WEB_CODE_PATH).'admin/session_import.php">'.Display::return_icon('pixel.gif',get_lang('ImportSessionListXMLCSV'),array('class' => 'toolactionplaceholdericon toolactionimportcourse')).get_lang('ImportSessionListXMLCSV').'</a>';	        
echo '<a href="'.api_get_path(WEB_CODE_PATH).'coursecopy/copy_course_session.php">'.Display::return_icon('pixel.gif',get_lang('CopyFromCourseInSessionToAnotherSession'),array('class' => 'toolactionplaceholdericon toolsettings')).get_lang('CopyFromCourseInSessionToAnotherSession').'</a>';
echo '</div>';

// start the content div
echo '<div id="content">';

if (!empty($return)) {
	Display::display_error_message($return,false,true);
}
?>
<form method="post" name="form" action="<?php echo api_get_self(); ?>" style="margin:0px;">
<input type="hidden" name="formSent" value="1">
<div class="row"><div class="form_header"><?php echo get_lang('AddSession'); ?></div></div>
<table border="0" cellpadding="5" cellspacing="0" width="940">
<tr>
  <td width="10%"><?php echo get_lang('SessionName') ?>&nbsp;&nbsp;</td>
  <td width="90%"><input type="text" name="name" size="50" class="focus" maxlength="50" value="<?php if($formSent) echo api_htmlentities($name,ENT_QUOTES,$charset); ?>"></td>
</tr>
<tr>
  <td width="10%" valign="top"><?php echo get_lang('Description') ?>&nbsp;&nbsp;</td>
  <td width="90%">
  <?php
  if($formSent) $description =  api_htmlentities($description,ENT_QUOTES,$charset); 
  echo api_return_html_area('description', $description, '', '', null, array('ToolbarSet' => 'Survey', 'Width' => '780', 'Height' => '120'))
  ?>
  <!--<textarea name="description" class="focus" rows="5" cols="37"><?php if($formSent) echo api_htmlentities($description,ENT_QUOTES,$charset); ?></textarea>-->      
  </td>
</tr>
<?php
    $e_commerce_enabled = intval(api_get_setting("e_commerce_catalog_type"));
    if ($e_commerce_enabled == 1) {
?>
<tr>
  <td width="10%"><?php echo get_lang('Price') ?></td>
  <td width="90%"><input type="text" name="cost" size="10" maxlength="10" value="<?php if($formSent) echo api_htmlentities($cost,ENT_QUOTES,$charset); ?>"></td>
</tr>
<?php
    }
?>
<tr>
  <td width="10%"><?php echo get_lang('CoachName') ?>&nbsp;&nbsp;</td>
  <td width="90%">
<?php

$sql = 'SELECT COUNT(1) FROM '.$tbl_user.' WHERE status=1';
$rs = Database::query($sql, __FILE__, __LINE__);
$count_users = Database::result($rs, 0, 0);

if (intval($count_users)<50) {
	$order_clause = api_sort_by_first_name() ? ' ORDER BY firstname, lastname, username' : ' ORDER BY lastname, firstname, username';
	$sql="SELECT user_id,lastname,firstname,username FROM $tbl_user WHERE status='1'".$order_clause;
	global $_configuration;
	if ($_configuration['multiple_access_urls']==true) {
		$tbl_user_rel_access_url= Database::get_main_table(TABLE_MAIN_ACCESS_URL_REL_USER);
		$access_url_id = api_get_current_access_url_id();
		if ($access_url_id != -1){
			$sql = 'SELECT username, lastname, firstname FROM '.$tbl_user.' user
			INNER JOIN '.$tbl_user_rel_access_url.' url_user ON (url_user.user_id=user.user_id)
			WHERE access_url_id = '.$access_url_id.'  AND status=1'.$order_clause;
		}
	}

	$result=Database::query($sql,__FILE__,__LINE__);
	$Coaches=Database::store_result($result);
	?>
	<select name="coach_username" value="true" style="width:250px;">
		<option value="0"><?php get_lang('None'); ?></option>
		<?php foreach($Coaches as $enreg): ?>
		<option value="<?php echo $enreg['username']; ?>" <?php if($sent && $enreg['user_id'] == $id_coach) echo 'selected="selected"'; ?>><?php echo api_get_person_name($enreg['firstname'], $enreg['lastname']).' ('.$enreg['username'].')'; ?></option>
		<?php endforeach; ?>
	</select>
	<?php
} else {
	?>
	<input type="text" name="coach_username" id="coach_username" onkeyup="xajax_search_coachs(document.getElementById('coach_username').value)" />
        <div id="ajax_list_coachs">
            
        </div>
	<?php
}
?>
</td>
</tr>
<?php
	$id_session_category = '';
	$tbl_session_category = Database::get_main_table(TABLE_MAIN_SESSION_CATEGORY);
	$sql = 'SELECT id, name FROM '.$tbl_session_category.' ORDER BY name ASC';
	$result = Database::query($sql,__FILE__,__LINE__);
	$Categories = Database::store_result($result);
?>
<?php if (!empty($Categories)): ?>
<tr>
  <td width="10%"><?php echo get_lang('SessionCategory') ?></td>
  <td width="90%">
  	<select name="session_category" value="true" style="width:250px;">
		<option value="0"><?php get_lang('None'); ?></option>
		<?php foreach($Categories as $Rows): ?>
		<option value="<?php echo $Rows['id']; ?>" <?php if($Rows['id'] == $id_session_category) echo 'selected="selected"'; ?>><?php echo $Rows['name']; ?></option>
		<?php endforeach; ?>
	</select>
  </td>
</tr>
<?php endif; ?>
<tr>
  <td width="10%"><?php echo get_lang('NoTimeLimits') ?></td>
  <td width="90%">
  	<input type="checkbox" name="nolimit" onChange="setDisable(this)" />
  </td>
<tr>
  <td width="10%"><?php echo get_lang('DateStartSession') ?>&nbsp;&nbsp;</td>
  <td width="90%">
  <select name="day_start">
	<option value="1">01</option>
	<option value="2" <?php if((!$formSent && $thisDay == 2) || ($formSent && $day_start == 2)) echo 'selected="selected"'; ?> >02</option>
	<option value="3" <?php if((!$formSent && $thisDay == 3) || ($formSent && $day_start == 3)) echo 'selected="selected"'; ?> >03</option>
	<option value="4" <?php if((!$formSent && $thisDay == 4) || ($formSent && $day_start == 4)) echo 'selected="selected"'; ?> >04</option>
	<option value="5" <?php if((!$formSent && $thisDay == 5) || ($formSent && $day_start == 5)) echo 'selected="selected"'; ?> >05</option>
	<option value="6" <?php if((!$formSent && $thisDay == 6) || ($formSent && $day_start == 6)) echo 'selected="selected"'; ?> >06</option>
	<option value="7" <?php if((!$formSent && $thisDay == 7) || ($formSent && $day_start == 7)) echo 'selected="selected"'; ?> >07</option>
	<option value="8" <?php if((!$formSent && $thisDay == 8) || ($formSent && $day_start == 8)) echo 'selected="selected"'; ?> >08</option>
	<option value="9" <?php if((!$formSent && $thisDay == 9) || ($formSent && $day_start == 9)) echo 'selected="selected"'; ?> >09</option>
	<option value="10" <?php if((!$formSent && $thisDay == 10) || ($formSent && $day_start == 10)) echo 'selected="selected"'; ?> >10</option>
	<option value="11" <?php if((!$formSent && $thisDay == 11) || ($formSent && $day_start == 11)) echo 'selected="selected"'; ?> >11</option>
	<option value="12" <?php if((!$formSent && $thisDay == 12) || ($formSent && $day_start == 12)) echo 'selected="selected"'; ?> >12</option>
	<option value="13" <?php if((!$formSent && $thisDay == 13) || ($formSent && $day_start == 13)) echo 'selected="selected"'; ?> >13</option>
	<option value="14" <?php if((!$formSent && $thisDay == 14) || ($formSent && $day_start == 14)) echo 'selected="selected"'; ?> >14</option>
	<option value="15" <?php if((!$formSent && $thisDay == 15) || ($formSent && $day_start == 15)) echo 'selected="selected"'; ?> >15</option>
	<option value="16" <?php if((!$formSent && $thisDay == 16) || ($formSent && $day_start == 16)) echo 'selected="selected"'; ?> >16</option>
	<option value="17" <?php if((!$formSent && $thisDay == 17) || ($formSent && $day_start == 17)) echo 'selected="selected"'; ?> >17</option>
	<option value="18" <?php if((!$formSent && $thisDay == 18) || ($formSent && $day_start == 18)) echo 'selected="selected"'; ?> >18</option>
	<option value="19" <?php if((!$formSent && $thisDay == 19) || ($formSent && $day_start == 19)) echo 'selected="selected"'; ?> >19</option>
	<option value="20" <?php if((!$formSent && $thisDay == 20) || ($formSent && $day_start == 20)) echo 'selected="selected"'; ?> >20</option>
	<option value="21" <?php if((!$formSent && $thisDay == 21) || ($formSent && $day_start == 21)) echo 'selected="selected"'; ?> >21</option>
	<option value="22" <?php if((!$formSent && $thisDay == 22) || ($formSent && $day_start == 22)) echo 'selected="selected"'; ?> >22</option>
	<option value="23" <?php if((!$formSent && $thisDay == 23) || ($formSent && $day_start == 23)) echo 'selected="selected"'; ?> >23</option>
	<option value="24" <?php if((!$formSent && $thisDay == 24) || ($formSent && $day_start == 24)) echo 'selected="selected"'; ?> >24</option>
	<option value="25" <?php if((!$formSent && $thisDay == 25) || ($formSent && $day_start == 25)) echo 'selected="selected"'; ?> >25</option>
	<option value="26" <?php if((!$formSent && $thisDay == 26) || ($formSent && $day_start == 26)) echo 'selected="selected"'; ?> >26</option>
	<option value="27" <?php if((!$formSent && $thisDay == 27) || ($formSent && $day_start == 27)) echo 'selected="selected"'; ?> >27</option>
	<option value="28" <?php if((!$formSent && $thisDay == 28) || ($formSent && $day_start == 28)) echo 'selected="selected"'; ?> >28</option>
	<option value="29" <?php if((!$formSent && $thisDay == 29) || ($formSent && $day_start == 29)) echo 'selected="selected"'; ?> >29</option>
	<option value="30" <?php if((!$formSent && $thisDay == 30) || ($formSent && $day_start == 30)) echo 'selected="selected"'; ?> >30</option>
	<option value="31" <?php if((!$formSent && $thisDay == 31) || ($formSent && $day_start == 31)) echo 'selected="selected"'; ?> >31</option>
  </select>
  /
  <select name="month_start">
	<option value="1">01</option>
	<option value="2" <?php if((!$formSent && $thisMonth == 2) || ($formSent && $month_start == 2)) echo 'selected="selected"'; ?> >02</option>
	<option value="3" <?php if((!$formSent && $thisMonth == 3) || ($formSent && $month_start == 3)) echo 'selected="selected"'; ?> >03</option>
	<option value="4" <?php if((!$formSent && $thisMonth == 4) || ($formSent && $month_start == 4)) echo 'selected="selected"'; ?> >04</option>
	<option value="5" <?php if((!$formSent && $thisMonth == 5) || ($formSent && $month_start == 5)) echo 'selected="selected"'; ?> >05</option>
	<option value="6" <?php if((!$formSent && $thisMonth == 6) || ($formSent && $month_start == 6)) echo 'selected="selected"'; ?> >06</option>
	<option value="7" <?php if((!$formSent && $thisMonth == 7) || ($formSent && $month_start == 7)) echo 'selected="selected"'; ?> >07</option>
	<option value="8" <?php if((!$formSent && $thisMonth == 8) || ($formSent && $month_start == 8)) echo 'selected="selected"'; ?> >08</option>
	<option value="9" <?php if((!$formSent && $thisMonth == 9) || ($formSent && $month_start == 9)) echo 'selected="selected"'; ?> >09</option>
	<option value="10" <?php if((!$formSent && $thisMonth == 10) || ($formSent && $month_start == 10)) echo 'selected="selected"'; ?> >10</option>
	<option value="11" <?php if((!$formSent && $thisMonth == 11) || ($formSent && $month_start == 11)) echo 'selected="selected"'; ?> >11</option>
	<option value="12" <?php if((!$formSent && $thisMonth == 12) || ($formSent && $month_start == 12)) echo 'selected="selected"'; ?> >12</option>
  </select>
  /
  <select name="year_start">

<?php
for ($i=$thisYear-5;$i <= ($thisYear+5);$i++) {
?>
	<option value="<?php echo $i; ?>" <?php if((!$formSent && $thisYear == $i) || ($formSent && $year_start == $i)) echo 'selected="selected"'; ?> ><?php echo $i; ?></option>
<?php
}
?>

  </select>
  </td>
</tr>
<tr>
  <td width="10%"><?php echo get_lang('DateEndSession') ?>&nbsp;&nbsp;</td>
  <td width="90%">
  <select name="day_end">
	<option value="1">01</option>
	<option value="2" <?php if((!$formSent && $thisDay == 2) || ($formSent && $day_end == 2)) echo 'selected="selected"'; ?> >02</option>
	<option value="3" <?php if((!$formSent && $thisDay == 3) || ($formSent && $day_end == 3)) echo 'selected="selected"'; ?> >03</option>
	<option value="4" <?php if((!$formSent && $thisDay == 4) || ($formSent && $day_end == 4)) echo 'selected="selected"'; ?> >04</option>
	<option value="5" <?php if((!$formSent && $thisDay == 5) || ($formSent && $day_end == 5)) echo 'selected="selected"'; ?> >05</option>
	<option value="6" <?php if((!$formSent && $thisDay == 6) || ($formSent && $day_end == 6)) echo 'selected="selected"'; ?> >06</option>
	<option value="7" <?php if((!$formSent && $thisDay == 7) || ($formSent && $day_end == 7)) echo 'selected="selected"'; ?> >07</option>
	<option value="8" <?php if((!$formSent && $thisDay == 8) || ($formSent && $day_end == 8)) echo 'selected="selected"'; ?> >08</option>
	<option value="9" <?php if((!$formSent && $thisDay == 9) || ($formSent && $day_end == 9)) echo 'selected="selected"'; ?> >09</option>
	<option value="10" <?php if((!$formSent && $thisDay == 10) || ($formSent && $day_end == 10)) echo 'selected="selected"'; ?> >10</option>
	<option value="11" <?php if((!$formSent && $thisDay == 11) || ($formSent && $day_end == 11)) echo 'selected="selected"'; ?> >11</option>
	<option value="12" <?php if((!$formSent && $thisDay == 12) || ($formSent && $day_end == 12)) echo 'selected="selected"'; ?> >12</option>
	<option value="13" <?php if((!$formSent && $thisDay == 13) || ($formSent && $day_end == 13)) echo 'selected="selected"'; ?> >13</option>
	<option value="14" <?php if((!$formSent && $thisDay == 14) || ($formSent && $day_end == 14)) echo 'selected="selected"'; ?> >14</option>
	<option value="15" <?php if((!$formSent && $thisDay == 15) || ($formSent && $day_end == 15)) echo 'selected="selected"'; ?> >15</option>
	<option value="16" <?php if((!$formSent && $thisDay == 16) || ($formSent && $day_end == 16)) echo 'selected="selected"'; ?> >16</option>
	<option value="17" <?php if((!$formSent && $thisDay == 17) || ($formSent && $day_end == 17)) echo 'selected="selected"'; ?> >17</option>
	<option value="18" <?php if((!$formSent && $thisDay == 18) || ($formSent && $day_end == 18)) echo 'selected="selected"'; ?> >18</option>
	<option value="19" <?php if((!$formSent && $thisDay == 19) || ($formSent && $day_end == 19)) echo 'selected="selected"'; ?> >19</option>
	<option value="20" <?php if((!$formSent && $thisDay == 20) || ($formSent && $day_end == 20)) echo 'selected="selected"'; ?> >20</option>
	<option value="21" <?php if((!$formSent && $thisDay == 21) || ($formSent && $day_end == 21)) echo 'selected="selected"'; ?> >21</option>
	<option value="22" <?php if((!$formSent && $thisDay == 22) || ($formSent && $day_end == 22)) echo 'selected="selected"'; ?> >22</option>
	<option value="23" <?php if((!$formSent && $thisDay == 23) || ($formSent && $day_end == 23)) echo 'selected="selected"'; ?> >23</option>
	<option value="24" <?php if((!$formSent && $thisDay == 24) || ($formSent && $day_end == 24)) echo 'selected="selected"'; ?> >24</option>
	<option value="25" <?php if((!$formSent && $thisDay == 25) || ($formSent && $day_end == 25)) echo 'selected="selected"'; ?> >25</option>
	<option value="26" <?php if((!$formSent && $thisDay == 26) || ($formSent && $day_end == 26)) echo 'selected="selected"'; ?> >26</option>
	<option value="27" <?php if((!$formSent && $thisDay == 27) || ($formSent && $day_end == 27)) echo 'selected="selected"'; ?> >27</option>
	<option value="28" <?php if((!$formSent && $thisDay == 28) || ($formSent && $day_end == 28)) echo 'selected="selected"'; ?> >28</option>
	<option value="29" <?php if((!$formSent && $thisDay == 29) || ($formSent && $day_end == 29)) echo 'selected="selected"'; ?> >29</option>
	<option value="30" <?php if((!$formSent && $thisDay == 30) || ($formSent && $day_end == 30)) echo 'selected="selected"'; ?> >30</option>
	<option value="31" <?php if((!$formSent && $thisDay == 31) || ($formSent && $day_end == 31)) echo 'selected="selected"'; ?> >31</option>
  </select>
  /
  <select name="month_end">
	<option value="1">01</option>
	<option value="2" <?php if((!$formSent && $thisMonth == 2) || ($formSent && $month_end == 2)) echo 'selected="selected"'; ?> >02</option>
	<option value="3" <?php if((!$formSent && $thisMonth == 3) || ($formSent && $month_end == 3)) echo 'selected="selected"'; ?> >03</option>
	<option value="4" <?php if((!$formSent && $thisMonth == 4) || ($formSent && $month_end == 4)) echo 'selected="selected"'; ?> >04</option>
	<option value="5" <?php if((!$formSent && $thisMonth == 5) || ($formSent && $month_end == 5)) echo 'selected="selected"'; ?> >05</option>
	<option value="6" <?php if((!$formSent && $thisMonth == 6) || ($formSent && $month_end == 6)) echo 'selected="selected"'; ?> >06</option>
	<option value="7" <?php if((!$formSent && $thisMonth == 7) || ($formSent && $month_end == 7)) echo 'selected="selected"'; ?> >07</option>
	<option value="8" <?php if((!$formSent && $thisMonth == 8) || ($formSent && $month_end == 8)) echo 'selected="selected"'; ?> >08</option>
	<option value="9" <?php if((!$formSent && $thisMonth == 9) || ($formSent && $month_end == 9)) echo 'selected="selected"'; ?> >09</option>
	<option value="10" <?php if((!$formSent && $thisMonth == 10) || ($formSent && $month_end == 10)) echo 'selected="selected"'; ?> >10</option>
	<option value="11" <?php if((!$formSent && $thisMonth == 11) || ($formSent && $month_end == 11)) echo 'selected="selected"'; ?> >11</option>
	<option value="12" <?php if((!$formSent && $thisMonth == 12) || ($formSent && $month_end == 12)) echo 'selected="selected"'; ?> >12</option>
  </select>
  /
  <select name="year_end">

<?php
for ($i=$thisYear-5;$i <= ($thisYear+5);$i++) {
?>
	<option value="<?php echo $i; ?>" <?php if((!$formSent && ($thisYear+1) == $i) || ($formSent && $year_end == $i)) echo 'selected="selected"'; ?> ><?php echo $i; ?></option>
<?php
}
?>
  </select>
  </td>
</tr>

<?php if (api_get_setting('enable_certificate') === 'true'): ?>
<tr>
  <td width="10%"><?php echo get_lang('Certificate') ?></td>
  <td width="90%">
    <?php
        $current_language = api_get_interface_language();
        $certificates = $objCertificate->getCertificatesList($current_language);
        $selCertificates = array();
        if (!empty($certificates)) {
            echo '<select name="certificate_template" id="session-certificate">';
            echo '<option value="0">'.get_lang('None').'</option>';
            foreach ($certificates as $tpl_id => $certificate) {
                echo '<option value="'.$tpl_id.'" '.($formSent && $tpl_id == $certif_template?'selected="selected"':'').'>'.$certificate['title'].'</option>';
            }
            echo '</select>';
        }        
    ?>
  </td>
</tr>
<tr>
  <td width="10%">&nbsp;</td>
  <td width="90%" valign="top">
  	<div id="session-certificate-thumb" style="display:none;"></div>
  </td>
</tr>

<tr>
  <td width="10%"><div class="certificate-tool session-certificate-score"><?php echo get_lang('CertificateTool'); ?></div></td>
  <td width="90%">
      <div class="certificate-tool session-certificate-score">
        <input type="radio" name="certificate_tool" class="certificate-tool-radio" id="certificate-tool-radio1" value="module" <?php echo ($formSent && $certif_tool == 'module'?'checked=checked':($infos['certif_tool'] == 'module'?'checked="checked"':'checked=checked') )?> checked="checked" />&nbsp;<?php echo get_lang('Modules'); ?>&nbsp;&nbsp;
        <input type="radio" name="certificate_tool" class="certificate-tool-radio" id="certificate-tool-radio2" value="quiz" <?php echo ($formSent && $certif_tool == 'quiz'?'checked=checked':($infos['certif_tool'] == 'quiz'?'checked="checked"':'') )?> />&nbsp;<?php echo get_lang('Exercises'); ?>
      </div>
  </td>
</tr>

<tr>
  <td width="10%"><div class="certificate-module-eval-type session-certificate-score"><?php echo get_lang('CertifEvaluationType'); ?></div></td>
  <td width="90%">
      <div class="certificate-module-eval-type session-certificate-score">
        <input type="radio" name="certif_evaluation_type" class="certificate-module-radio" id="certificate-module-radio1" value="1" <?php echo (isset($_POST['certif_evaluation_type']) && $_POST['certif_evaluation_type'] == 1?'checked=checked':'checked=checked'); ?> />&nbsp;<?php echo get_lang('Progress'); ?>&nbsp;&nbsp;
        <input type="radio" name="certif_evaluation_type" class="certificate-module-radio" id="certificate-module-radio2" value="2" <?php echo (isset($_POST['certif_evaluation_type']) && $_POST['certif_evaluation_type'] == 2?'checked=checked':''); ?> />&nbsp;<?php echo get_lang('Score'); ?>
      </div>
  </td>
</tr>

<tr>
  <td width="10%"><div class="certificate-score session-certificate-score"><?php echo get_lang('CertificateMinEvaluation').' (%)'; ?></div></td>
  <td width="90%">
      <div class="certificate-score session-certificate-score">
        <input type="text" name="certificate_min_score" id="certificate-score-input" value="<?php echo ($formSent?$certif_min_progress:'')?>" />
      </div>
  </td>
</tr>
<?php endif; ?>


<tr>
  <td>&nbsp;</td>
  <td><button class="save" type="submit" value="<?php echo get_lang('NextStep') ?>"><?php echo get_lang('NextStep') ?></button>
 </td>
</tr>

</table>

</form>
<script type="text/javascript">

function setDisable(select){
	document.form.day_start.disabled = (select.checked) ? true : false;
	document.form.month_start.disabled = (select.checked) ? true : false;
	document.form.year_start.disabled = (select.checked) ? true : false;

	document.form.day_end.disabled = (select.checked) ? true : false;
	document.form.month_end.disabled = (select.checked) ? true : false;
	document.form.year_end.disabled = (select.checked) ? true : false;
}
</script>
<?php
// close the content div
echo '</div>';

// display the footer
Display::display_footer();


function search_coachs($needle)
{
	global $tbl_user;

	$xajax_response = new XajaxResponse();
	$return = '';
 

	if(!empty($needle))
	{
		// xajax send utf8 datas... datas in db can be non-utf8 datas
		$charset = api_get_setting('platform_charset');
		$needle = api_convert_encoding($needle, $charset, 'utf-8');

		$order_clause = api_sort_by_first_name() ? ' ORDER BY firstname, lastname, username' : ' ORDER BY lastname, firstname, username';

		// search users where username or firstname or lastname begins likes $needle
		$sql = 'SELECT username, lastname, firstname FROM '.$tbl_user.' user
				WHERE (username LIKE "'.$needle.'%"
				OR firstname LIKE "'.$needle.'%"
				OR lastname LIKE "'.$needle.'%")
				AND status=1'.
				$order_clause.
				' LIMIT 10';

		global $_configuration;
		if ($_configuration['multiple_access_urls']==true) {
			$tbl_user_rel_access_url= Database::get_main_table(TABLE_MAIN_ACCESS_URL_REL_USER);
			$access_url_id = api_get_current_access_url_id();
			if ($access_url_id != -1){

				$sql = 'SELECT username, lastname, firstname FROM '.$tbl_user.' user
				INNER JOIN '.$tbl_user_rel_access_url.' url_user ON (url_user.user_id=user.user_id)
				WHERE access_url_id = '.$access_url_id.'  AND (username LIKE "'.$needle.'%"
				OR firstname LIKE "'.$needle.'%"
				OR lastname LIKE "'.$needle.'%")
				AND status=1'.
				$order_clause.
				' LIMIT 10';

			}
		}

		$rs = Database::query($sql, __FILE__, __LINE__);
		while ($user = Database :: fetch_array($rs)) {
			$return .= '<a href="javascript: void(0);" onclick="javascript: fill_coach_field(\''.$user['username'].'\')">'.api_get_person_name($user['firstname'], $user['lastname']).' ('.$user['username'].')</a><br />';
		}
                $return = '<div class="ajax_list_coachs_style">'.$return.'</div>';
	}
        
	$xajax_response -> addAssign('ajax_list_coachs','innerHTML', api_utf8_encode($return));
   
	return $xajax_response;
}
?>
