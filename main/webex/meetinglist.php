<?php
$meetingmanager = new MeetingManager();

if($_GET['op'] == 'delmeeting' || !isset($_GET['op'])) {
   
    if ($_GET['op'] == 'delmeeting') {
        $meetingkey = Database::escape_string(Security::remove_XSS($_GET['key']));      
        $meetingmanager->delete_meeting($meetingkey);
    }
    $user_meeting = 0;
    if (!is_allowed_to_edit()) {
        $user_meeting = api_get_user_id();
    }
    $data = $meetingmanager->get_list_meeting($user_meeting);
?>
<?php
$user_info = api_get_user_info(api_get_user_id());
$username = $user_info['username'];
?>
<table class="data_table">
   <tr class="row_odd">
      <th><?php echo get_lang('Key'); ?></th>
      <th><?php echo get_lang('Name'); ?></th>
      <th><?php echo get_lang('Author'); ?></th>
      <th><?php echo get_lang('Status'); ?></th>
      <th><?php echo get_lang('Start'); ?></th>
      <th><?php echo get_lang('Duration'); ?></th>
      <th><?php echo get_lang('Actions'); ?></th>
   </tr>
   <?php
   foreach ($data as $row) {
      ?>
      <tr class="<?php echo (($count % 2) == 0) ? 'row_odd' : 'row_even' ?>">
         <td><?php echo $row['meetingKey']; ?></td>
         <td><?php echo $row['confName']; ?></td>
         <td><?php echo $row['hostWebExID']; ?></td>
         <td><?php echo $row['status']; ?></td>
         <td><?php echo $row['startDate']; ?></td>
         <td><?php echo $row['duration']; ?></td>
         <td>          
            <?php if(is_allowed_to_edit()) { ?>
            <a href="<?php echo api_get_self().'?'.  api_get_cidreq(). '&action=newmeeting&op=edit&id='.$row['meetingKey']; ?>"><?php echo Display::return_icon('pixel.gif', get_lang('Edit'), array('class' => 'actionplaceholdericon actionedit')) ?></a>
            <a onclick="return confirm('<?php echo get_lang('langConfirmYourChoice') ?>');" href="<?php echo api_get_self().'?'.  api_get_cidreq(). '&action=listmeeting&op=delmeeting&key='.$row['meetingKey']; ?>"><?php echo Display::return_icon('pixel.gif', get_lang('Delete'), array('class' => 'actionplaceholdericon actiondelete')) ?></a>
            <a href="<?php echo api_get_self().'?'.  api_get_cidreq(). '&action=listmeeting&op=adduser&key='.$row['meetingKey']; ?>"><?php echo Display::return_icon('pixel.gif', get_lang('SubscribeUsersToMeeting'), array('class' => 'actionplaceholdericon actionadduser')) ?></a>
            <?php 
            }
                        
            $exist = $meetingmanager->exist_user($user_info['user_id']);            
            if (api_is_allowed_to_edit()) { $exist = true; }            
            if ($exist) {
                
               $start = strtotime($row['startDate']);  
               $now = strtotime(date('m/d/Y H:i:s',time()));
               $onTime = false;
               if($start <= $now && $now <= $start + (int)$row['duration'] * 60) {
                   $onTime = true;
               }

                  $user_meeting = $meetingmanager->get_user($user_info['user_id']);
                  if(is_allowed_to_edit()){
                      $login = $meetingmanager->get_login_url_user(MeetingManager::UID, MeetingManager::PWD);
                  }else{
                      $login = $meetingmanager->get_login_url_user($username, $user_meeting['password'], $user_info['mail']);
                  }                 
                  $links = $meetingmanager->get_join_url_meeting($row['meetingKey'], $username);             
                  $link = $links['inviteMeetingURL'];                  
                  $login = str_replace('BU=', 'BU='.$link, $login);
                  
                  if ($onTime) {
                      echo '<a id="meeting_start" target="_blank" href="'.$login.'">'.Display::return_icon('webex.png', get_lang('Join')).'</a>';
                  } 
                  else {
                      echo '<a id="meeting_start" href="javascript:void(0)" onclick="alert(\''.get_lang('YouAreNotOnTimeForThisMeeting').'\');">'.Display::return_icon('webex.png', get_lang('Join')).'</a>';
                  }
            }
            
            ?>
         </td>
      </tr>
      <?php
      $count += 1;
   }
   ?>
</table>
<?php
} 
else if($_GET['op'] == 'adduser') {
   if($_POST['form_sent']) {
      $users = array();
      $lists = $_POST['sessionUsersList'];
      foreach($lists as $list){
         $user_info = api_get_user_info($list);
         
         $users[] = $user_info;
      }
      $meetingkey = Database::escape_string(Security::remove_XSS($_POST['form_key']));
      $meeting = $meetingmanager->get_meeting($meetingkey);
      $confName = $meeting['confName'];
      $startDate = $meeting['startDate'];
      $duration = $meeting['duration'];
      $openTime = $meeting['openTime'];
      $data = $meetingmanager->update_meeting($meetingkey, $users, $confName, $startDate, $duration, $openTime);      
   }
   $meetingkey = Security::remove_XSS($_GET['key']);
   $meeting = $meetingmanager->get_meeting($meetingkey);
   
   if(!$meeting){
      Display::display_error_message($meetingmanager->message,true,true);
   }
   /*users of course*/
//   $users_list = CourseManager::get_student_list_from_course_code(api_get_course_id());
   $users_list = CourseManager::get_user_list_from_course_code(api_get_course_id());
   /*users of meeting*/
   
   //$users_meetings = $meeting['users'];
   $users_meetings = $meetingmanager->getDokeosMeetUsers($meetingkey);

   $users_no_meeting = array();
   $users_list_meeting = array();
   
   foreach($users_list as $user) {
      $user_id = $user['user_id'];
      $user_info = api_get_user_info($user_id);
      $mail = $user_info['mail'];
      $username = $user_info['username'];
      $is_invited = false;
      
      if ($meetingmanager->isMeetingOwner($meetingkey, $user_id)) {
          continue;
      }
      
      foreach($users_meetings as $users_meeting) {   
         if($users_meeting['name'] == $username) {           
            $is_invited = true;
            break;
         }
      }
      if(!$is_invited) {
         $users_no_meeting[] = $user_info;
      } else {
         $users_list_meeting[] = $user_info;
      }
      
   }

?>
   <script type="text/javascript">
      function moveItem(origin , destination){
         for(var i = 0 ; i<origin.options.length ; i++) {
            if(origin.options[i].selected) {
               destination.options[destination.length] = new Option(origin.options[i].text,origin.options[i].value);
               origin.options[i]=null;
               i = i-1;
            }
         }
         destination.selectedIndex = -1;
         sortOptions(destination.options);
      }
      function sortOptions(options) {
         newOptions = new Array();
         for (i = 0 ; i<options.length ; i++)
            newOptions[i] = options[i];

         newOptions = newOptions.sort(mysort);
         options.length = 0;
         for(i = 0 ; i < newOptions.length ; i++)
            options[i] = newOptions[i];
      }
      function mysort(a, b){
        if(a.text.toLowerCase() > b.text.toLowerCase()) {
                return 1;
        }
        if(a.text.toLowerCase() < b.text.toLowerCase()) {
                return -1;
        }
        return 0;
      }

      function valide(){
        var options = document.getElementById('destination_users').options;
        for (i = 0 ; i<options.length ; i++)
                options[i].selected = true;
        document.forms.formulaire.submit();
      }
   </script>
   <div class="row"><div class="form_header"><?php echo get_lang('SubscribeUsersToMeeting'); ?></div></div><br/>
   <form name="formulaire" method="post" action="<?php echo api_get_self() .'?'.  api_get_cidreq(). '&action=listmeeting&op=adduser&key='.$_GET['key'] ?>">
      <input type="hidden" value="1" name="form_sent"/>
      <input type="hidden" value="<?php echo $_GET['key'];?>" name="form_key"/>
      <table width="100%" cellspacing="0" cellpadding="5" border="0">
         <tr>
            <td align="center"><b>Portal users list :</b></td>
            <td></td>
            <td align="center"><b>List of users registered in this meeting :</b></td>
         </tr>
         <!--<tr>
            <td align="center">
               <?php echo get_lang('FirstLetterUser'); ?> :
               <select name="firstLetterUser" onchange = "xajax_search_users(this.value,'multiple')" >
                  <option value = "%">--</option>
                  <?php
                  echo Display :: get_alphabet_options();
                  ?>
               </select>
            </td>
            <td align="center">&nbsp;</td>
         </tr>-->
         <tr>
            <td align="center">
               <div id="content_source">
                  <div id="ajax_list_users_multiple">
                     <select id="origin_users" name="nosessionUsersList[]" multiple="multiple" size="15" style="width:360px;">
                        <?php
                        foreach ($users_no_meeting as $user) {
                           if($user['status'] != 6){
                        ?>
                              <option value="<?php echo $user['user_id']; ?>"> <?php echo api_get_person_name($user['firstname'], $user['lastname']) . ' (' . $user['username'] . ')'; ?></option>
                           <?php
                           }
                        }
                        ?>
                     </select>
                  </div>
               </div>
            </td>
            <td width="10%" valign="middle" align="center">
               <button class="arrowr" type="button" onclick="moveItem(document.getElementById('origin_users'), document.getElementById('destination_users'))" onclick="moveItem(document.getElementById('origin_users'), document.getElementById('destination_users'))"></button>
               <br /><br />
               <button class="arrowl" type="button" onclick="moveItem(document.getElementById('destination_users'), document.getElementById('origin_users'))" onclick="moveItem(document.getElementById('destination_users'), document.getElementById('origin_users'))"></button>
               <br /><br /><br /><br /><br /><br />
            </td>
            <td align="center">
               <select id="destination_users" name="sessionUsersList[]" multiple="multiple" size="15" style="width:360px;">

                  <?php
                  foreach ($users_list_meeting as $enreg) {
                     ?>
                     <option value="<?php echo $enreg['user_id']; ?>"><?php echo $enreg['firstname'] . ' ' . $enreg['lastname'] . ' (' . $enreg['username'] . ')'; ?></option>

                     <?php
                  }
                  ?>
               </select>
            </td>
         </tr>
         <tr>
            <td colspan="3" align="center">
            <button class="save" type="button" value="" onclick="valide()" ><?php echo get_lang('SubscribeUsersToMeeting'); ?></button>
            </td>
         </tr>
      </table>
   </form>
   <?php
}
?>
