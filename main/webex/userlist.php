<?php
$meetingmanager = new MeetingManager();

if($_GET['op'] == 'deluser') {
   $webExId = Database::escape_string($_GET['user']);
   $meetingmanager->delete_user($webExId);
}
$data = $meetingmanager->get_list_user();
if(!$data){
   Display::display_error_message($meetingmanager->message,true,true);
} else {
   ?>
   <table class="data_table">
   <tr class="row_odd">
      <th><?php echo get_lang('FirstName'); ?></th>
      <th><?php echo get_lang('LastName'); ?></th>
      <th><?php echo get_lang('LoginName'); ?></th>
      <th><?php echo get_lang('Email'); ?></th>
      <th><?php echo get_lang('Status'); ?></th>
      <th><?php echo get_lang('Detail'); ?></th>
   </tr>
   <?php
   $count = 1;
   foreach ($data as $row) {
      ?>
      <tr class="<?php echo (($count % 2) == 0) ? 'row_odd' : 'row_even' ?>">
         <td><?php echo $row['firstName']; ?></td>
         <td><?php echo $row['lastName']; ?></td>
         <td><?php echo $row['webExId']; ?></td>
         <td><?php echo $row['email']; ?></td>
         <td><?php echo Display::return_icon(($row['active'] == "ACTIVATED") ? "visible.gif":'invisible.gif','', array('class' => 'actionplaceholdericon')); ?></td>
         <td>
            <a href="<?php echo api_get_self() . '?action=userlist&op=deluser&user='.$row['webExId']; ?>"><?php echo Display::return_icon('delete.png', get_lang('Delete'), array('class' => 'actionplaceholdericon actiondelete')) ?></a>
         </td>
      </tr>
      <?php
      $count += 1;
   }
   ?>
</table>
<?php
}
?>
