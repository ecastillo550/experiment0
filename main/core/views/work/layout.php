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
Display::display_introduction_section(TOOL_STUDENTPUBLICATION);

// Tracking
event_access_tool(TOOL_STUDENTPUBLICATION);

// setting the tool constants
$tool = TOOL_STUDENTPUBLICATION;

isset($_REQUEST['assignment_id'])?$assignmentId = Security :: remove_XSS($_REQUEST['assignment_id']):$assignmentId='';

$workController = new WorkController($assignmentId);
$workController->display_action();

echo '<div id="content">';

echo $content;

echo '</div>';


// secondary actions
echo '<div class="actions"> </div>';

// Footer
Display :: display_footer();