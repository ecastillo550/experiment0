<script type="text/javascript">
   $(document).ready(function(){
      $("#user_add [name='expiration_date[H]']").clone().attr('name', "time[H]").appendTo('#dvTime');
      $("<span>&nbsp;h&nbsp;</span>").appendTo('#dvTime');
      $("#user_add [name='expiration_date[i]']").clone().attr('name', "time[i]").appendTo('#dvTime');
      $("#user_add [name='time[H]']").val(1);
   });
</script>
<?php
$meetingmanager = new MeetingManager();
$meeting_info = false;
$titleMeeting = get_lang('CreateMeetings');
if(isset($_GET['op']) && $_GET['op'] == 'edit'){
   $titleMeeting = get_lang('EditMeetings');
   $meetingkey = Database::escape_string($_GET['id']);
   $meeting_info = $meetingmanager->get_meeting($meetingkey);
   ?>
   <script type="text/javascript">
   $(document).ready(function(){
      $("#user_add [name='time[H]']").val($("#hddH").val());
      $("#user_add [name='time[i]']").val($("#hddI").val());
   });
</script>
   <?php
}
$form = new FormValidator('user_add','post',api_get_self().'?'.api_get_cidreq().'&action=newmeeting');
$form->addElement('header', '', get_lang($titleMeeting));
$form->addElement('text', 'firstname', get_lang('Name'),'class="focus"');
$form->applyFilter('firstname', 'html_filter');
$form->applyFilter('firstname', 'trim');
$form->addRule('firstname', get_lang('ThisFieldIsRequired'), 'required');
$form->addElement('password', 'password', get_lang('Password'));
$form->addRule('password', get_lang('ThisFieldIsRequired'), 'required');
     
$form->addElement('datepicker', 'expiration_date', get_lang('DateTime'));
$form->addElement('html','<div class="row"><div class="label">'.get_lang('Duration').'</div><div class="formw"><div id="dvTime"></div></div></div>');
$form->addElement('style_submit_button', 'submit', get_lang('Add'), 'class="add"');
$defaults = array();
if(!$meeting_info){
   $defaults['expiration_date'] = array();
   $defaults['expiration_date']['d'] = date('d');
   $defaults['expiration_date']['F'] = date('m');
   $defaults['expiration_date']['Y'] = date('Y');
   $defaults['expiration_date']['H'] = date('H');
} else {
   $defaults['firstname'] = $meeting_info['confName'];
   $defaults['password'] = $meeting_info['meetingPassword'];
   $defaults['expiration_date'] = array();
   $expiration_date = $meeting_info['startDate'];
   $startDate = explode(' ', $expiration_date);
   list($m,$d,$y) = explode('/', $startDate[0]);
   $defaults['expiration_date']['d'] = $d;
   $defaults['expiration_date']['F'] = $m;
   $defaults['expiration_date']['Y'] = $y;
   list($h,$i,$s) = explode(':', $startDate[1]);
   $defaults['expiration_date']['H'] = $h;
   $defaults['expiration_date']['i'] = $i;
   
   $duration = (int)$meeting_info['duration'];
   $form->addElement('hidden','hddH',(int)($duration / 60),array('id' => 'hddH'));
   $form->addElement('hidden','hddI',($duration % 60),array('id' => 'hddI'));
   $form->addElement('hidden','hddMeeting',$meetingkey,array('id' => 'hddMeeting'));
}
$form->setDefaults($defaults);
if( $form->validate()) {
   $data = $form->exportValues();
   $confName = Database::escape_string($data['firstname']);
   $meetingPassword = Database::escape_string($data['password']);
   $expiration_date = $_POST['expiration_date'];
   $startDate = Database::escape_string($expiration_date['F']).'/'.Database::escape_string($expiration_date['d']).'/'.Database::escape_string($expiration_date['Y']).' '.Database::escape_string($expiration_date['H']).':'.Database::escape_string($expiration_date['i']).':00';
   
   $time = $_POST['time'];
   $duration = ((int)Database::escape_string($time['H']))*60 + (int)Database::escape_string($time['i']);
   $openTime = 7200;
   if(isset($_POST['hddMeeting'])){
      $meetingkey = Database::escape_string($_POST['hddMeeting']);
       $status = $meetingmanager->update_meeting($meetingkey, array(), $confName, $startDate, $duration, $openTime);
   } else {
     
      $status = $meetingmanager->create_meeting($meetingPassword, $confName, $startDate, $duration, $openTime);
      
   }
   if(!$status){
     Display::display_error_message($meetingmanager->message,true,true);
   }
   else {
      echo '<script text="javascript">window.location="index.php'.'?'.  api_get_cidreq().'&action=listmeeting";</script>';
      exit ();
   }
}
$form->display();
?>
