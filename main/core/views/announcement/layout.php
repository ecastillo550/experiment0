<?php
/* For licensing terms, see /license.txt */

/**
* Layout (principal view) used for structuring other views  
* @author Alberto Flores <aflores609@gmail.com>
*/

// protect a course script
api_protect_course_script(true);

// Header
Display :: display_tool_header('');

// Introduction section
Display::display_introduction_section(TOOL_ANNOUNCEMENT);

// Tracking
event_access_tool(TOOL_ANNOUNCEMENT);

// setting the tool constants
$tool = TOOL_ANNOUNCEMENT;

// Display
echo '<div class="actions">';
if(api_is_allowed_to_edit()){
   echo '<a href="index.php?'.api_get_cidreq().'&action=add">'.Display::return_icon('pixel.gif', get_lang('AddAnnouncement'), array('class' => 'toolactionplaceholdericon toolactionannoucement')).get_lang('AddAnnouncement').'</a>';
}
echo '</div>';

echo '<div id="content">';


echo $content;

echo '</div>';


// secondary actions
echo '<div class="actions"> </div>';

// Footer
Display :: display_footer();