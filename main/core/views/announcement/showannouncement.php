<div id="announcement-content">
    <div id="announcement-content-left">   
		<div id="announcement-content-leftinner">
			<table width="100%" class="data_table">
				<?php         
					if (!empty($announcementList)) {
						$i = 0;

						foreach ($announcementList as $announcementId => $announcement) {                   
							echo '<script>
							$(document).ready(function(){
								$("#announcement'.$announcement->id.'").click(function(){
									window.location=$(this).find("a").attr("href");
									return false;
								});
							});
							</script>';
							echo '<tr class="'.($i%2==0?'row_odd':'row_even').'"><td>';
							echo '<div id="announcement'.$announcement->id.'" class="announcement_list_item">';
							echo '<a href="index.php?action=view&amp;id='.$announcement->id.'" title="'.$announcement->title.'">';
							echo '<span class="announcements_list_date">'.$announcement->announcementdate.'</span>';
							echo shorten($announcement->title,25);
							echo '</a>';
							echo '</div>';
							echo '</td></tr>';
						   $i++;
               }              
					} 
					else {
						echo '<tr><td><div>'.get_lang('YouHaveNoAnnouncement').'</div></td></tr>';
					}
				?>  
			</table>
			</div>
        <div class="pager" align="right"><?php echo $pagerLinks; ?></div>    
    </div>
    
    <div id="announcement-content-right">
        <?php
			echo '<div style="padding:10px;">';
			echo '<div class="announcement_title"><span style="font-size:16px;font-weight:bold;">'.$ann_title.'</span></div>';
			echo  '	<br/><div class="announcement_metadata">';
			echo  '		<div class="announcement_date">'.$ann_date.'</div>';
			echo  '		<div class="announcement_sender">'.$firstname.' '.$lastname.'</div>';	
			echo  '	</div>';
			if (ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) {
				echo  '	<br/><div class="announcement_content" style="height: 333px;overflow: auto;">'.nl2br($ann_content).'</div>';
			} else {
				echo  '	<br/><div class="announcement_content" style="height: 322px;overflow: auto;">'.nl2br($ann_content).'</div>';	
			}
      // show attachment list
                $attachment_list = array();
                $attachment_list = AnnouncementManager::get_attachment($announcement_id);

                $attachment_icon = '';
                if (count($attachment_list)>0) {
                   echo ' <a href="'.api_get_path(WEB_COURSE_PATH).api_get_course_path().'/upload/announcements/'.$attachment_list['path'].'" target="_blank">'.Display::return_icon('attachment.gif','Attachment') . '</a><br><br><br>';               
                }	
			echo  '</div>';
			if(api_is_allowed_to_edit() || (api_get_course_setting('allow_user_edit_announcement') && api_get_user_id() == $insert_user_id)){
			echo  '<div class="announcements_actions" style="padding-top:0px">';
			echo  '<a href="index.php?action=edit&id='.$announcement_id.'">'.Display::return_icon('pixel.gif',get_lang('EditAnnouncement'),array('align' => 'absmiddle','class'=>'actionplaceholdericon actionedit')).' '.get_lang('EditAnnouncement').'</a>';
			echo  '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';		
			echo  '<a href="'.api_get_self().'?'.api_get_cidreq().'&action=delete&id='.$announcement_id.'" onclick="javascript:if(!confirm(\''.get_lang("ConfirmYourChoice").'\')) return false;">'.Display::return_icon('pixel.gif',get_lang('DeleteAnnouncement'),array('class'=>'actionplaceholdericon actiondelete','align' => 'absmiddle')).' '.get_lang('DeleteAnnouncement').'</a>';
			echo  '</div>';
		}
		?>
    </div>
    
</div>