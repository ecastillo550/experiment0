<?php
// Language files that should be included
$language_file=array('admin','tracking');

// including the global Dokeos file
require_once '../inc/global.inc.php';
api_protect_course_script(true);

if (api_get_setting('enable_webex_tool') !== 'true') {
    api_not_allowed();
}


//require_once 'conf.php';
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
require_once api_get_path(LIBRARY_PATH).'meetingmanager.lib.php';
require_once api_get_path(LIBRARY_PATH).'usermanager.lib.php';
require_once api_get_path(LIBRARY_PATH).'course.lib.php';

$htmlHeadXtra[] = '
<script type="text/javascript">
function add_user_to_session (code, content) {

	document.getElementById("user_to_add").value = "";
	document.getElementById("ajax_list_users_single").innerHTML = "";

	destination = document.getElementById("destination_users");

	for (i=0;i<destination.length;i++) {
		if(destination.options[i].text == content) {
				return false;
		}
	}

	destination.options[destination.length] = new Option(content,code);
	destination.selectedIndex = -1;
	sortOptions(destination.options);

}
function remove_item(origin)
{
	for(var i = 0 ; i<origin.options.length ; i++) {
		if(origin.options[i].selected) {
			origin.options[i]=null;
			i = i-1;
		}
	}
}

function validate_filter() {

		document.formulaire.add_type.value = \''.$add_type.'\';
		document.formulaire.form_sent.value=0;
		document.formulaire.submit();

}

$(document).ready(function(){
   $("#meeting_start").click(function(){
      href = $(this).attr("href");
      identified = window.open(href,"WEBEX","resizable=yes,scrollbars=yes,toolbar=no");
      return false;
   });
});

</script>';

// Displaying the header
Display::display_header($nameTools);
$action = $_GET['action'];
  //echo 


?>

<div class="actions">
  
  <a href="<?php echo api_get_self().'?'.  api_get_cidreq().'&action=listmeeting' ?>"><?php echo Display::return_icon('pixel.gif', get_lang('ListMeetings'), array('class' => 'toolactionplaceholdericon toolactionlistmeeting'))?><?php echo get_lang('ListMeetings') ?></a>
  <?php
  if(is_allowed_to_edit()){
  ?>
  <a href="<?php echo api_get_self().'?'.  api_get_cidreq().'&action=newmeeting' ?>"><?php echo Display::return_icon('pixel.gif', get_lang('CreateMeetings'), array('class' => 'toolactionplaceholdericon toolactioncreate'))?><?php echo get_lang('CreateMeetings') ?></a>
  <?php
  }
  ?>
  <!--<a href="<?php echo api_get_self().'?'.  api_get_cidreq().'&action=newuser' ?>"><?php echo get_lang('CreateUsers') ?></a>
  <a href="<?php echo api_get_self().'?'.  api_get_cidreq().'&action=userlist' ?>"><?php echo get_lang('UsersList') ?></a>-->
</div>
   <div id="content">
      <?php
     
     
      switch($action){
         case 'newuser':
            require_once 'user.php';
            break;
         case 'userlist':
            require_once 'userlist.php';
            break;
         case 'newmeeting':
            require_once 'meeting.php';
            break;
         default:
            require_once 'meetinglist.php';
            break;
      }
      ?>
   </div>
<div class="actions"></div>
<?php
// display the footer
Display::display_footer();
?>
