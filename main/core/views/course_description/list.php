<?php
	// the actual content
	if (isset($descriptions) && count($descriptions) > 0) {
			foreach ($descriptions as $id => $description) {
					echo '<div class="section_white">';
					echo '	<div class="sectiontitle">'.$description->title.'</div>';	
					echo '	<div class="sectioncontent">';
					echo 	text_filter($description->content);
					echo '	</div>';
					echo '</div>';
					echo '<div class="float_r">';
					if (api_is_allowed_to_edit()) {
							//delete
							echo '<a class="" href="'.api_get_self().'?'.api_get_cidreq().'&amp;action=delete&amp;description_id='.$description->id.'&showlist=1" onclick="javascript:if(!confirm(\''.addslashes(api_htmlentities(get_lang('ConfirmYourChoice'),ENT_QUOTES,$charset)).'\')) return false;">';
							echo Display::return_icon('pixel.gif', get_lang('Delete'), array('class' => 'actionplaceholdericon actiondelete'));
							echo '</a> ';
							//edit
							echo '<a class="" href="'.api_get_self().'?'.api_get_cidreq().'&amp;action=edit&amp;description_id='.$description->id.'&amp;description_type='.$description->description_type.'">';
							echo Display::return_icon('pixel.gif', get_lang('Modify'), array('class' => 'actionplaceholdericon actionedit'));
							echo '</a> ';
					}
					echo '</div>';
					echo '<div>&nbsp;</div>';
					echo '<div>&nbsp;</div>';
			}
	} else {
			echo '<em>'.get_lang('ThisCourseDescriptionIsEmpty').'</em>';
	}
?>