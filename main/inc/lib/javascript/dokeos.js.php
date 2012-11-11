<?php
// $cidReset is mandatory
//$cidReset= TRUE;
require_once dirname(__FILE__).'/../../global.inc.php';
?>
// this script contains all the Dokeos specific javascript
// is is a php function so that we can use php code also


jQuery(document).ready( function($) {

        // focus first input text in a form content
        $('#content form input:text:first').focus();
        
	// Expand or collapse the help
	$('#help-link').click(function () {
		$('#help-content').slideToggle('fast', function() {
			if ( $(this).hasClass('help-open') ) {
				$('#help a').css({'backgroundImage':'url("<?php echo api_get_path(WEB_PATH); ?>main/img/screen-options-right.gif")'});
				$(this).removeClass('contextual-help-open');
			} else {
				$('#help a').css({'backgroundImage':'url("<?php echo api_get_path(WEB_PATH); ?>main/img/screen-options-right-up.gif")'});
				$(this).addClass('help-open');
			}
		});
		return false;
	});

	$(window).load(function () {
		$(".focus").focus();
	});

	// Expand or collapse the who is online
	$('#online-link').click(function () {
		$('#online-content').slideToggle('fast', function() {
			if ( $(this).hasClass('help-open') ) {
				$('#online a').css({'backgroundImage':'url("<?php echo api_get_path(WEB_PATH); ?>main/img/screen-options-right.gif")'});
				$(this).removeClass('help-open');
				var action = 'closing';
			} else {
				$('#online a').css({'backgroundImage':'url("<?php echo api_get_path(WEB_PATH); ?>main/img/screen-options-right-up.gif")'});
				$(this).addClass('help-open');
				var action = 'opening';
			}
			
			if ( action == 'opening' ){
				$.ajax({
					beforeSend: function(object) {
						$("#online-content").html('<?php Display::display_icon('loadingAnimation.gif'); ?>');
					},
					contentType: "application/x-www-form-urlencoded",
					type: "GET",
					url: "<?php echo api_get_path(WEB_CODE_PATH);?>ajax.php",
					data: "action=whoisonline&display=thumbnails",
					success: function(data) {
						$("#online-content").html(data);
					}
				});
			}
		});
		return false;
	});

	// change the url of the links with class make_visible_and_invisible so that the link is not followed when clicked
	// we use this to make it backwards compatible when javascript is disabled
  	$(".make_visible_and_invisible").attr("href","javascript:void(0);");

	// when we click a link with class make_visible_and_invisible we change the visibility of the tool
	$(".make_visible_and_invisible >img").click(function () {
		
		// the visibility image is a full url. We want to know if its invisible.gif or visible.gif
		image_url = $(this).attr("src");
		image = image_url.replace("<?php echo api_get_path(WEB_IMG_PATH); ?>","");

                // This code is added in order for support the tablet style
                image_css_info = $(this).attr("class");
                current_css = image_css_info.replace("actionplaceholderminiicon","");
                current_css = jQuery.trim(current_css);
		// are we making the tool visible or invisible? This all depend on the current icon
		if (image=="closedeye_tr.png" || current_css=="toolactionhide"){
			action = "make_visible";
		} else {
			action = "make_invisible";
		}
                 
		// the id of the tool that we are changing
		tool_id = $(this).attr("id").replace("linktool_","");

		$.ajax({
			contentType: "application/x-www-form-urlencoded",
			beforeSend: function(object) {
				$(".normal-message").show();
				$("#id_confirmation_message").hide();
			},
			type: "GET",
			url: "<?php echo api_get_path(WEB_CODE_PATH);?>course_home/ajax.php",
			data: "id="+tool_id+"&action="+action+"&current_css="+current_css,
			success: function(data) {
				// make the tool visible
				if (action == 'make_visible'){
					// change the visibility icon, its alt text and its title
                                        if (current_css=='toolactionhide') {
					  $("#linktool_"+tool_id).attr("src", "<?php echo api_get_path(WEB_IMG_PATH); ?>pixel.gif");
					  $("#linktool_"+tool_id).attr("class", "actionplaceholderminiicon toolactionview");
                                        } else {
					  $("#linktool_"+tool_id).attr("src", "<?php echo api_get_path(WEB_IMG_PATH); ?>visible_link.png");
                                        }
					$("#linktool_"+tool_id).attr("alt", "<?php echo get_lang('VisibleClickToMakeInvisible'); ?>");
					$("#linktool_"+tool_id).attr("title", "<?php echo get_lang('VisibleClickToMakeInvisible'); ?>");

					// the feedback message that should be displayed
					message = "<?php echo get_lang('ToolIsNowVisible', '');?>";

					// change the visible style
					$("#tool_"+tool_id).toggleClass('invisible');
				}

				// make the tool invisible
				if (action == 'make_invisible'){
                                        if (current_css=='toolactionview') {
					  $("#linktool_"+tool_id).attr("src", "<?php echo api_get_path(WEB_IMG_PATH); ?>pixel.gif");
					  $("#linktool_"+tool_id).attr("class", "actionplaceholderminiicon toolactionhide");
                                        } else {
					  $("#linktool_"+tool_id).attr("src", "<?php echo api_get_path(WEB_IMG_PATH); ?>closedeye_tr.png");
                                        }
					$("#linktool_"+tool_id).attr("alt", "<?php echo get_lang('InvisibleClickToMakeVisible'); ?>");
					$("#linktool_"+tool_id).attr("title", "<?php echo get_lang('InvisibleClickToMakeVisible'); ?>");
					
					// the feedback message that should be displayed
					message = "<?php echo get_lang('ToolIsNowHidden', '');?>";

					// change the tool icon
					tool_image = $("#toolimage_"+tool_id).attr("src");
					
					// change the visible style
					$("#tool_"+tool_id).toggleClass('invisible');
				}

				// add or remove the invisible class to the tool link
				$("#istooldesc_"+tool_id).toggleClass("invisible");

				// hide the "processing" feedback message			
				$(".normal-message").hide();

				// display the confirmation message (with the correct feedback message)
				$("#id_confirmation_message").html(message);
				$("#id_confirmation_message").show();
			}
		});
	}); 	
});
