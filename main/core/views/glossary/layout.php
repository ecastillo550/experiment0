<?php
/* For licensing terms, see /license.txt */

/**
* Layout (principal view) used for structuring other views
* @author Isaac flores <florespaz_isaac@hotmail.com>
*/

// protect a course script
api_protect_course_script(true);

// Header
Display :: display_tool_header('');

// Introduction section
Display::display_introduction_section(TOOL_GLOSSARY);

// Tracking
event_access_tool(TOOL_GLOSSARY);

// setting the tool constants
$tool = TOOL_GLOSSARY;

// Display
echo '<div class="actions">';

if (api_is_allowed_to_edit(null,true)) {
    if (isset($_GET['action'])) {
        echo '<a href="'.api_get_self().'?'.api_get_cidreq().'">'.Display::return_icon('pixel.gif', get_lang('Back'), array('class' => 'toolactionplaceholdericon toolactionback')).' '.get_lang('Back').'</a>';
    }
    echo '<a href="'.api_get_self().'?'.api_get_cidreq().'&action=add">'.Display::return_icon('pixel.gif', get_lang('NewTerm'), array('class' => 'toolactionplaceholdericon toolglossaryadd')) .'&nbsp;&nbsp;'.get_lang('NewTerm').'</a>';
    echo '<a href="'.api_get_self().'?'.api_get_cidreq().'&action=import">'.Display::return_icon('pixel.gif',get_lang('ImportGlossaryTerms'), array('class' => 'toolactionplaceholdericon toolactionexportcourse')).' '.get_lang('ImportGlossaryTerms').'</a>';
} else {
    echo get_lang('Glossary');
}
echo '</div>';

echo '<div id="content" class="rel">';


echo $content;

echo '</div>';


// secondary actions
echo '<div class="actions"> </div>';

// Footer
Display :: display_footer();