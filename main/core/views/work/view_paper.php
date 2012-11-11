<div>
	<?php	
		if(strlen($remark) > 400){
			$paper_remark = substr($remark,0,400);
			$paper_remark .= '...';
		}
		else {
			$paper_remark = $remark;
		}
		$datetime = explode(" ", $sent_date);
		$dateparts = explode("-", $datetime[0]);	
		if(api_get_interface_language() == 'french'){
                    $submittedon = $dateparts[2].'-'.$dateparts[1].'-'.$dateparts[0].'&nbsp;'.$datetime[1];
		}
		else {
                    $submittedon = $dateparts[1].'-'.$dateparts[2].'-'.$dateparts[0].'&nbsp;'.$datetime[1];
		}
		$paper_desc = str_replace("<p>","",$description);
		$paper_desc = str_replace("</p>","",$paper_desc);
	?>
	<table width="100%" border="0" cellpadding="5" cellspacing="5">
		<tr>
			<td colspan="2">
				<h3 class="orange"><?php echo get_lang('MyPaper'); ?></h3>
			</td>			
		</tr>
		<tr>
			<td width="30" align="right">
				<?php echo get_lang('Paper'). ' : '; ?>
			</td>
			<td width="70%">
				<span><?php echo $title; ?></span>
			</td>
		</tr>
		<tr>
			<td  width="30" align="right">
				<?php echo get_lang('Summary'). ' : '; ?>
			</td>
			<td width="70%">
				<span><?php echo $paper_desc; ?></span>
			</td>
		</tr>
		<tr>
			<td  width="30" align="right">
				<?php echo get_lang('Author'). ' : '; ?>
			</td>
			<td width="70%">
				<span><?php echo $author; ?></span>
			</td>
		</tr>
		<tr>
			<td width="30" align="right">
				<?php echo get_lang('Submittedon'). ' : '; ?>
			</td>
			<td width="70%">
				<span><?php echo $submittedon; ?></span>
			</td>
		</tr>
		<tr>
			<td width="30" align="right">
				<?php echo get_lang('DownloadPaper'). ' : '; ?>
			</td>
			<td width="70%">
				<span><?php echo '<a href="'.api_get_self().'?'.api_get_cidReq().'&action=download&file='.$url.'">'.Display::return_icon('pixel.gif',get_lang('Download'),array('class' => 'actionplaceholdericon actionsavebackup')).'</a>'; ?></span>
			</td>
		</tr>
		<tr>
			<td width="30" align="right">
				<?php echo get_lang('Remark'). ' : '; ?>
			</td>
			<td width="70%">
				<span><?php echo $remark; ?></span>
			</td>
		</tr>
		<?php if(!empty($corrected_url) && file_exists(api_get_path(SYS_COURSE_PATH).$_course['path'].'/'.$corrected_url)) { ?>
		<tr>
			<td width="30" align="right">
				<?php echo get_lang('DownloadCorrectedPaper'). ' : '; ?>
			</td>
			<td width="70%">
				<span><?php echo '<a href="'.api_get_self().'?'.api_get_cidReq().'&action=download&file='.$corrected_url.'">'.Display::return_icon('pixel.gif',get_lang('Download'),array('class' => 'actionplaceholdericon actionsavebackup')).'</a>'; ?></span>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2" style="padding-left:220px;">
				<?php echo '<div class="quiz_content_actions" style="width:110px;">'.get_lang('Mark').' &nbsp;&nbsp;&nbsp;&nbsp;'.round($qualification,2).'/'.round($weight,2).'</div>'; ?>
			</td>			
		</tr>
	</table>  
</div>