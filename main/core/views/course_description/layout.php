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
Display::display_introduction_section(TOOL_COURSE_DESCRIPTION);

// Tracking
event_access_tool(TOOL_COURSE_DESCRIPTION);

// setting the tool constants
$tool = TOOL_COURSE_DESCRIPTION;

$description_id = isset ($_REQUEST['description_id']) ? Security::remove_XSS($_REQUEST['description_id']) : null;

$default_description_titles = array();
$default_description_titles[1]= get_lang('Objectives');
$default_description_titles[2]= get_lang('HumanAndTechnicalResources');
$default_description_titles[3]= get_lang('Assessment');
$default_description_titles[4]= get_lang('GeneralDescription');
$default_description_titles[5]= get_lang('Agenda');

$default_description_class = array();
$default_description_class[1]= 'skills';
$default_description_class[2]= 'resources';
$default_description_class[3]= 'assessment';
$default_description_class[4]= 'prerequisites';
$default_description_class[5]= 'other';

$courseDescriptionController = new CourseDescriptionController($description_id);

echo '<div class="actions">';
$courseDescriptionController->display_action($default_description_titles,$default_description_class);
echo '</div>';

echo '<div id="content">';

echo $content;

echo '</div>';


// secondary actions
echo '<div class="actions"> </div>';

// Footer
Display :: display_footer();