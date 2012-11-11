<?php
$language_file = 'exercice';

require_once '../inc/global.inc.php';

require_once 'exercise.class.php';
require_once 'question.class.php';
require_once 'answer.class.php';
require_once 'exercise.lib.php';

// including additional libraries
require_once (api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php');

require_once '../newscorm/learnpath.class.php';
require_once '../newscorm/learnpathItem.class.php';
// setting the tabs
$this_section=SECTION_COURSES;

if(!api_is_allowed_to_edit()) {
	api_not_allowed(true);
}

$tool_name = TOOL_QUIZ;

/* ------------	ACCESS RIGHTS ------------ */
api_protect_course_script(true);

// additional javascript
$htmlHeadXtra[] = '
    <style>
	form {		
		border:0px;
	}	 
	div.row div.label{
		width: 10%;
		display: none;
	}
	div.row div.formw{
		width: 98%;
	}
    </style>
    <script language="javascript">
        $(document).ready(function(){
            
            $("input[name=\'randomQuestionsOpt\']").click(function(){
                if ($(this).val() == 0) {
                    $("select[name=\'randomQuestions\']").attr("disabled", true);
                    $("select[name=\'randomQuestions\']").val(0);
                } else {
                    $("select[name=\'randomQuestions\']").attr("disabled", false);
                }
            });

        });
    </script>
';

// Lp object
$learnpath_id = intval($_GET['lp_id']);
if (isset($_SESSION['lpobject'])) {
    $oLP = unserialize($_SESSION['lpobject']);
    if (is_object($oLP)) {
        if ($myrefresh == 1 OR (empty($oLP->cc)) OR $oLP->cc != api_get_course_id()) {
            if ($myrefresh == 1) {
                $myrefresh_id = $oLP->get_id();
            }
            $oLP = null;
            api_session_unregister('oLP');
            api_session_unregister('lpobject');
        } else {
            $_SESSION['oLP'] = $oLP;
            $lp_found = true;
        }
    }
}

// Add the extra lp_id parameter to some links
$add_params_for_lp = '';
if (isset($_GET['lp_id'])) {
    $add_params_for_lp = "&lp_id=".$learnpath_id;
}

$objExercise = new Exercise(1);

/*********************
 * INIT FORM
 *********************/
if (isset($_GET['exerciseId'])) {
    // Scenario 1
    $form = new FormValidator('exercice_scenario1', 'post', api_get_self().'?exerciseId='.Security::remove_XSS($_GET['exerciseId']).'&'.api_get_cidreq(), null, array('style' => 'width: 100%; border: 0px'));
    $objExercise -> read (intval($_GET['exerciseId']));
    $form -> addElement ('hidden','edit','true');
} else {
    $add_params_for_lp = '';
    if (isset($_GET['lp_id'])) {
        $add_params_for_lp = "&lp_id=".Security::remove_XSS($_GET['lp_id']);
    }
    // Scenario 1
    $form = new FormValidator('exercice_scenario1', null,  api_get_self().'?'.  api_get_cidreq().$add_params_for_lp, null, array('style' => 'width: 100%; border: 0px'));
    $form->addElement('hidden','edit','false');
}

$objExercise->createScenarioForm($form);

if ($form->validate()) {
    $objExercise->processScenarioCreation($form);
    if ($form->getSubmitValue('edit') == 'true') {
        if(isset($_SESSION['fromlp'])) {
            header('Location:exercice.php?message=ExerciseEdited&'.api_get_cidreq().'&fromlp='.$_SESSION['fromlp']);
            exit;
        } else {
            header('Location:exercice.php?message=ExerciseEdited&'.api_get_cidreq());
            exit;
        }
    } else {
        $my_quiz_id = $objExercise->id;
        header('Location:admin.php?'.api_get_cidreq().'&message=ExerciseAdded&exerciseId='.$my_quiz_id.$add_params_for_lp);     
        exit;
    }
} else {
    $no_validate = true;
}

if ($no_validate === true) {
    if (isset($_SESSION['gradebook'])) { $gradebook = $_SESSION['gradebook']; }	
    // header
    Display :: display_tool_header();		
    if(api_get_setting('search_enabled')=='true' && !extension_loaded('xapian')) {
        echo '<div class="confirmation-message">'.get_lang('SearchXapianModuleNotInstaled').'</div>';
    }
    // actions
    echo '<div class="actions">';
        if (isset($_GET['lp_id']) && $_GET['lp_id'] > 0) {
             echo '<a href="../newscorm/lp_controller.php?' . api_get_cidreq() . '">' . Display::return_icon('pixel.gif', get_lang("Author"), array('class' => 'toolactionplaceholdericon toolactionauthor')).get_lang("Author") . '</a>';
             echo '<a href="../newscorm/lp_controller.php?' . api_get_cidreq() . '&action=add_item&type=step">' . Display::return_icon('pixel.gif', get_lang("Content"), array('class' => 'toolactionplaceholdericon toolactionauthorcontent')).get_lang("Content") . '</a>';
             echo '<a href="../newscorm/lp_controller.php?' . api_get_cidreq() . '&gradebook=&action=view&lp_id='.$_GET['lp_id'].'">' . Display::return_icon('pixel.gif', get_lang("ViewRight"), array('class' => 'toolactionplaceholdericon toolactionauthorpreview')).get_lang("ViewRight") . '</a>';
        }
        if (!isset($_GET['lp_id'])) { 
            echo '<a href="exercice.php?'.api_get_cidreq().'">'.Display::return_icon('pixel.gif', get_lang('List'), array('class' => 'toolactionplaceholdericon toolactionback')) . get_lang('List').'</a>';
            echo '<a href="exercise_admin.php?'.api_get_cidreq().'">'.Display::return_icon('pixel.gif', get_lang('NewEx'), array('class' => 'toolactionplaceholdericon toolactionnewquiz')) . get_lang('NewEx').'</a>';
        }
        if (isset($_GET['exerciseId']) && $_GET['exerciseId'] > 0) {
            echo '<a href="admin.php?'.api_get_cidreq() . '&exerciseId='.Security::remove_XSS($_GET['exerciseId']).'">'.Display::return_icon('pixel.gif', get_lang('Questions'), array('class' => 'toolactionplaceholdericon toolactionquestion')) . get_lang('Questions').'</a>';
            echo '<a href="exercice_scenario.php?scenario=yes&modifyExercise=yes&'.api_get_cidreq().'&exerciseId='.Security::remove_XSS($_GET['exerciseId']).'">'.Display::return_icon('pixel.gif', get_lang('Scenario'), array('class' => 'toolactionplaceholdericon toolactionscenario')). get_lang('Scenario').'</a>';
            echo '<a href="exercice_submit.php?'.api_get_cidreq() . '&exerciseId='.Security::remove_XSS($_GET['exerciseId']).'">'.Display::return_icon('pixel.gif', get_lang('ViewRight'), array('class' => 'toolactionplaceholdericon toolactionsearch')) . get_lang('ViewRight').'</a>';
        }               
    echo '</div>'; // end actions
	
    // start the content div    
    echo '<div id="content_with_secondary_actions">';

    $sub_container_class = "";
    if (isset($_GET['modifyExercise'])) {
        $sub_container_class = "quiz_scenario_squarebox";
    }
    
    echo '<div id ="exercise_admin_container">';
    echo '  <table cellpadding="5" width="100%">
                <tr>
                    <td width="100%" valign="top">';
    echo '              <div id="exercise_admin_left_container" class="'.$sub_container_class.'">';
                            $form->display();
    echo '              </div>
                    </td>
                </tr>
            </table>
          </div>';
    
    // close the content div
    echo '</div>';
    
    // actions
    echo '<div class="actions">';    
        if(api_get_setting('show_quizcategory') == 'true'){
            echo '<a href="exercise_category.php?'.api_get_cidreq().'&action=add_category">'.Display :: return_icon("category_22.png", get_lang("Categories")) . get_lang("Categories").'</a>';
        }    
        if (!isset($_GET['lp_id'])) {
            echo '<a href="upload_exercise.php?'.api_get_cidreq().'">'.Display::return_icon('pixel.gif', get_lang('UploadQuiz'), array('class' => 'actionplaceholdericon actionuploadquiz')) . get_lang('UploadQuiz').'</a>';
        }
    echo '</div>';
    echo '<div style="clear:both"></div>'; 
}

// Foter page
Display::display_footer();
?>