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
Display::display_introduction_section(TOOL_NOTEBOOK);

// Tracking
event_access_tool(TOOL_NOTEBOOK);

// setting the tool constants
$tool = TOOL_NOTEBOOK;

// Display
echo '<div class="actions">
        <a href="index.php?'.api_get_cidreq().'&action=add">'.Display::return_icon('pixel.gif', get_lang('NewNote'), array('class' => 'toolactionplaceholdericon tooladdnewnote')).get_lang('NewNote').'</a>
      </div>';

echo '<div id="content">';


echo $content;

echo '</div>';


// secondary actions
echo '<div class="actions"> </div>';

// Footer
Display :: display_footer();