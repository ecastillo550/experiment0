<?php
/* For licensing terms, see /dokeos_license.txt */

/**
* @package dokeos.admin
*/


// name of the language file that needs to be included
$language_file = array ('registration','admin','exercice','work', 'generateTemplate');

// resetting the course id
$cidReset = true;

// setting the help
$help_content = 'platformadministrationplatformnews';

// including the global Dokeos file
require ('../inc/global.inc.php');

// including additional libraries
require_once (api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php');
require_once (api_get_path(LIBRARY_PATH).'sessionmanager.lib.php');

// setting the section (for the tabs)
$this_section = SECTION_PLATFORM_ADMIN;

// Access restrictions
api_protect_admin_script(true);  

// setting breadcrumbs
$interbreadcrumb[]=array("url" => "index.php","name" => get_lang('PlatformAdmin'));
$tool_name = get_lang('Emailtemplates');

// javascript extras
$htmlHeadXtra[] = ' 
   <style>
        #emailtemplatelang {
            margin-bottom:20px;
            margin-left:-120px;
        }
    </style>
    <script>
        function change_language(value){	
            document.location.href = "'.api_get_self().'?language="+value;
        }
        
        function generateTemplate(lang)
        {
            document.location.href = "'.api_get_self().'?action=generateTemplate&language="+lang;
        }
    </script>
';

// Displaying the header
Display::display_header();

echo '<div class="actions">';
if(isset($_GET['action']) && $_GET['action'] == 'edit'){
	echo '<a href="emailtemplates.php">'.Display::return_icon('pixel.gif', get_lang('Emailtemplates'), array('class' => 'toolactionplaceholdericon toolactionback')).get_lang('Emailtemplates').'</a>';
}
echo '</div>';

echo '<div id="content">';
$table_emailtemplate 	= Database::get_main_table(TABLE_MAIN_EMAILTEMPLATES);	
if(isset($_GET['action']) && $_GET['action'] == 'edit')
{	
	$sql =DataBase::query( "SELECT * FROM $table_emailtemplate WHERE id = ".Security::remove_XSS($_GET['id']));
	
	while($row = Database::fetch_array($sql))
	{
		$title = $row['title'];
		$description = $row['description'];
		$content = $row['content'];
		$db_language = $row['language'];
		$temp = $db_language;
	}
	$statictext = get_lang('Dontedittext');
	$language_interface = $temp;
	$action = "emailtemplates.php?action=submit";
	$form = new FormValidator('emailtemplates','post',$action);
	$form->addElement('header', '', $tool_name);
	$form->addElement('text', 'title', get_lang('Title'),'class="focus"');
	$form->addElement('static','', '','<div style="width:100%;">'.$statictext.'</div>');
        
        $languages = api_get_languages();
        if (!empty($languages)) {
            foreach ($languages['params'] as $langforlder => $langname) {
                $cbo_languages[$langforlder] = $langname;
            }
        }  
        $form->addElement('select', 'language', get_lang('Language'), $cbo_languages);
        
        $form->addElement('html_editor', 'content', get_lang('Content'), null,
		api_is_allowed_to_edit(null,true)
			? array('ToolbarSet' => 'AdminTemplates', 'Width' => '100%', 'Height' => '300')
			: array('ToolbarSet' => 'AdminTemplates', 'Width' => '100%', 'Height' => '300', 'UserStatus' => 'student')
	);
	$form->addElement('hidden','id',Security::remove_XSS($_GET['id']));
	$form->addElement('style_submit_button', 'submit', get_lang('Save'), 'class="save"');
	$defaults['title'] = $title;
        $defaults['language'] = $db_language;

	if(empty($content))
	{		
		$langpath = api_get_path(SYS_CODE_PATH).'lang/';		
		foreach ($language_files as $index => $language_file) {			
		include $langpath.'english/'.$language_file.'.inc.php';
		$langfile = $langpath.$language_interface.'/'.$language_file.'.inc.php';
		if (file_exists($langfile)) {
			include $langfile;
		}
		}
		if($description == 'Userregistration'){			
			$content = get_lang('Dear')." {Name} ,\n\n";
			$content .= get_lang('YouAreReg')." {siteName} ".get_lang('WithTheFollowingSettings')."\n\n";
			$content .= get_lang('Username').": {username} \n";	
			$content .= get_lang('Pass')." :{password} \n\n";
			$content .= get_lang('Address')." {siteName} ".get_lang('Is')." - {url} \n\n";
			$content .= get_lang('Problem')."\n\n".get_lang('Formula').",\n";
			$content .= "{administratorSurname} \n";
			$content .= get_lang('Manager')."\n";
			$content .= "{administratorTelephone} \n";
			$content .= get_lang('Email')." : {emailAdministrator}";
		}
		if($description == 'Quizreport'){
			$content = get_lang('DearStudentEmailIntroduction')."\n\n";
			$content .= get_lang('AttemptVCC')."\n\n";
			$content .= get_lang('Question').": {ques_name} \n";	
			$content .= get_lang('Exercice')." :{test} \n\n";
			$content .= get_lang('ClickLinkToViewComment')." - {url} \n\n";
			$content .= get_lang('Regards')."\n\n";			
			$content .= "{administratorSurname} \n";
			$content .= get_lang('Manager')."\n";
			$content .= "{administratorTelephone} \n";
			$content .= get_lang('Email')." : {emailAdministrator}";
		}
		if($description == 'Quizsuccess'){
			$content = get_lang('DearStudentEmailIntroduction')."\n\n";
			$content .= get_lang('AttemptVCC')."\n\n";
			$content .= get_lang('Quizsuccess')."\n\n";
			$content .= get_lang('Question').": {ques_name} \n";	
			$content .= get_lang('Exercice')." :{test} \n\n";
			$content .= get_lang('ClickLinkToViewComment')." - {url} \n\n";
			$content .= get_lang('Notes')."\n\n";
			$content .= "{notes} \n\n";
			$content .= get_lang('Regards')."\n\n";			
			$content .= "{administratorSurname} \n";
			$content .= get_lang('Manager')."\n";
			$content .= "{administratorTelephone} \n";
			$content .= get_lang('Email')." : {emailAdministrator}";
		}
		if($description == 'Quizfailure'){
			$content = get_lang('DearStudentEmailIntroduction')."\n\n";
			$content .= get_lang('AttemptVCC')."\n\n";
			$content .= get_lang('Quizfailure')."\n\n";
			$content .= get_lang('Question').": {ques_name} \n";	
			$content .= get_lang('Exercice')." :{test} \n\n";
			$content .= get_lang('ClickLinkToViewComment')." - {url} \n\n";
			$content .= get_lang('Notes')."\n\n";	
			$content .= "{notes} \n\n";
			$content .= get_lang('Regards')."\n\n";			
			$content .= "{administratorSurname} \n";
			$content .= get_lang('Manager')."\n";
			$content .= "{administratorTelephone} \n";
			$content .= get_lang('Email')." : {emailAdministrator}";
		}
		if($description == 'Newassignment'){
			$content = get_lang('Dear')." {Name} ,\n\n";
			$content .= get_lang('CreatedNewAssignment').' : '." {courseName} ". "\n\n";
			$content .= "{assignmentName}" . "\n\n";
			$content .= "{assignmentDescription}" . "\n\n";
			$content .= get_lang('Deadline').' : '. "{assignmentDeadline}" . "\n\n";
			$content .= get_lang('UploadPaper').' : '. "{siteName}" . "\n\n";
			$content .= get_lang('Yours').', '. "\n\n";
			$content .= "{authorName}" ."\n";				
		}
		if($description == 'Submitwork'){
			$content = get_lang('Dear')." {authorName} ,\n\n";
			$content .=  "{studentName}". get_lang('PublishedPaper') . "\n\n";
			$content .= "{paperName} ". "\n\n";
			$content .= get_lang('For'). "{assignmentName} - {assignmentDescription}" .get_lang('In'). " {courseName}" . "\n\n";			
			$content .= get_lang('DeadlineWas').' : '. "{assignmentDeadline}" . "\n\n";
			$content .= get_lang('PaperSubmittedOn').' : '. "{assignmentSentDate}" . "\n\n";
			$content .= get_lang('CorrectComment').' : '. "{siteName}" . "\n\n";
			$content .= get_lang('Yours').', '. "\n\n";
			$content .= "{administratorSurname}" ."\n";				
		}
		if($description == 'Correctwork'){
			$content = get_lang('Dear')." {studentName} ,\n\n";
			$content .=  get_lang('CorrectedPaper') . "\n\n";
			$content .= "{paperName} ". "\n\n";
			$content .= get_lang('For'). "{assignmentName} - {assignmentDescription}" .get_lang('In'). "{courseName}" . "\n\n";			
			$content .= get_lang('DeadlineWas').' : '. "{assignmentDeadline}" . "\n\n";
			$content .= get_lang('PaperSubmittedOn').' : '. "{assignmentSentDate}" . "\n\n";
			$content .= get_lang('CheckMark').' : '. "{siteName}" . "\n\n";
			$content .= get_lang('Yours').', '. "\n\n";
			$content .= "{authorName}" ."\n";				
		}
	}
	
	$defaults['content'] = $content;
	$defaults['language'] = $db_language;
	$form->setDefaults($defaults);	
	$form->display();
}
elseif(isset($_GET['action']) && $_GET['action'] == 'submit')
{	
        $title      = $_POST['title'];
        $content    = $_POST['content'];
        $id         = $_POST['id'];        
        $language   = $_POST['language']; 
        Database::query("UPDATE $table_emailtemplate SET title = '".Database::escape_string($title)."', content = '".Database::escape_string($content)."', language = '".Database::escape_string($language)."' WHERE id = ".$id);
        echo '<script>window.location.href = "emailtemplates.php"</script>';
}
elseif($_GET['action'] == 'generateTemplate')
{
   $html = generateCertificationFromEnglish($_REQUEST['language'], $table_emailtemplate);
   echo $html;
    //var_dump($_REQUEST['language']);
}
else
{
$platformLanguage = api_get_setting('platformLanguage');
?>
<script type="text/javascript">
	function jumpMenu(targ,selObj,restore){ //v3.0
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
</script>
<?php

$language_selected = isset($_REQUEST['language'])?Security::remove_XSS($_REQUEST['language']):api_get_interface_language();
$form = new FormValidator('emailtemplatelang', 'post', api_get_self());
$languages = api_get_languages();
if (!empty($languages)) {
    foreach ($languages['params'] as $langforlder => $langname) {
        $cbo_languages[$langforlder] = $langname;
    }
}  
$form->addElement('select', 'language', get_lang('Language'), $cbo_languages, 'onchange=change_language(this.value)');
$defaults['language'] = $language_selected;

//add button for to create templates
    $sql = "SELECT * FROM $table_emailtemplate"; 
    if(!empty($language_selected)){
        $sql .= " WHERE language = '".$language_selected."'";
    }
    $result = api_sql_query($sql, __FILE__, __LINE__);
    $numrows = Database::num_rows($result);
    if($numrows == 0)
    $form->addElement('html', '<div class="row" ><button type="button" class="save" onclick="generateTemplate(document.emailtemplatelang.language.value)" >'.get_lang('CopyFromEnglish').'</button></div>');
    //----- End add button
$form->setDefaults($defaults);
$form->display();

//dutch_unicode
$sql = "SELECT * FROM $table_emailtemplate"; 
if(!empty($language_selected)){
    $sql .= " WHERE language = '".$language_selected."'";
}
$result = api_sql_query($sql, __FILE__, __LINE__);
$numrows = Database::num_rows($result);
if ($numrows <> 0) {
	$i=0;
	$j=1;

	echo '<table class="gallery">';

	while ($row = Database::fetch_array($result)) {
		if (!empty($row['image']))
			{
				$image = api_get_path(WEB_IMG_PATH).'/'.$row['image'];
			} 
		if(!$i%4)
		{
			echo '<tr>';
		}
		
		echo '<td>';	
		echo '	<div class="section">';

		echo '<div class="sectiontitle">'.$row['title'].'</div>
				<div class="sectioncontent"><img border="0" src="'.$image.'"></div>
				<div align="center"><a href="'.api_get_self().'?action=edit&id='.$row['id'].'">'.Display::return_icon('pixel.gif', get_lang("Edit"), array('class' => 'actionplaceholdericon actionedit')).'&nbsp;&nbsp;'.Display::return_icon('pixel.gif', get_lang("Delete"), array('class' => 'actionplaceholdericon actiondelete')).'</div>
			</div>';
		echo '</td>';
		if($j==4)
		{
			echo '</tr>';
			$j=0;
		}
		$i++;
		$j++;
	}
	echo '</table>';
}
else{echo '<div class="normal-message">'.get_lang('NoTemplatePreview').'</div>';};

}//End of else
echo '</div>';
/**
 *
 * @param string $language_selected 
 */
function generateCertificationFromEnglish($language_selected, $table_emailtemplate)
{
     $sql = "SELECT * FROM $table_emailtemplate"; 
    if(!empty($language_selected)){
        $sql .= " WHERE language = '".$language_selected."'";
    }
    $result = api_sql_query($sql, __FILE__, __LINE__);
    $numrows = Database::num_rows($result);
    
    
    
    if($numrows == 0)
    {
        $sql = "SELECT * FROM $table_emailtemplate"; 
        if(!empty($language_selected)){
            $sql .= " WHERE language = 'english'";
        }
        $result = api_sql_query($sql, __FILE__, __LINE__);
        while($object = Database::fetch_object($result))
        {
            $arrayObjectTemplate[] = $object;
        }
        
        foreach($arrayObjectTemplate as $index=>$objTemplate)
        {
            $objTemplate->language = $language_selected;
            // insert
            Database::query("INSERT INTO $table_emailtemplate SET
                            title       = '".(isset($objTemplate->title)?Database::escape_string($objTemplate->title):get_lang('Empty'))."',
                            description = '".(isset($objTemplate->description)?Database::escape_string($objTemplate->description):'')."',
                            image       = '".(isset($objTemplate->image)?Database::escape_string($objTemplate->image):'')."',
                            language    = '".(isset($objTemplate->language)?Database::escape_string($objTemplate->language):$language_selected)."',
                            content     = '".(isset($objTemplate->content)?Database::escape_string($objTemplate->content):get_lang('Empty'))."'                                
                            ");
        }
        
        
        // display html for generate template
        
$language_selected = isset($_REQUEST['language'])?Security::remove_XSS($_REQUEST['language']):api_get_interface_language();
$form = new FormValidator('emailtemplatelang', 'post', api_get_self());
$languages = api_get_languages();
if (!empty($languages)) {
    foreach ($languages['params'] as $langforlder => $langname) {
        $cbo_languages[$langforlder] = $langname;
    }
}  
$form->addElement('select', 'language', get_lang('Language'), $cbo_languages, 'onchange=change_language(this.value)');
$defaults['language'] = $language_selected;

//add button for to create templates
    $sql = "SELECT * FROM $table_emailtemplate"; 
    if(!empty($language_selected)){
        $sql .= " WHERE language = '".$language_selected."'";
    }
    $result = api_sql_query($sql, __FILE__, __LINE__);
    $numrows = Database::num_rows($result);
    if($numrows == 0)
    $form->addElement('button', 'generate', 'Generate from English','onclick=generateTemplate(document.emailtemplatelang.language.value) class="save"');

//----- End add button
$form->setDefaults($defaults);
$form->display();        
        
//dutch_unicode
$sql = "SELECT * FROM $table_emailtemplate"; 
if(!empty($language_selected)){
    $sql .= " WHERE language = '".$language_selected."'";
}
$result = api_sql_query($sql);
$numrows = Database::num_rows($result);
if ($numrows <> 0) {
	$i=0;
	$j=1;

	$html= '<table class="gallery">';

	while ($row = Database::fetch_array($result)) {
		if (!empty($row['image']))
			{
				$image = api_get_path(WEB_IMG_PATH).'/'.$row['image'];
			} 
		if(!$i%4)
		{
			$html.= '<tr>';
		}
		
		$html.= '<td>';	
		$html.= '	<div class="section">';

		$html.= '<div class="sectiontitle">'.$row['title'].'</div>
				<div class="sectioncontent"><img border="0" src="'.$image.'"></div>
				<div align="center"><a href="'.api_get_self().'?action=edit&id='.$row['id'].'">'.Display::return_icon('pixel.gif', get_lang("Edit"), array('class' => 'actionplaceholdericon actionedit')).'&nbsp;&nbsp;'.Display::return_icon('pixel.gif', get_lang("Delete"), array('class' => 'actionplaceholdericon actiondelete')).'</div>
			</div>';
		$html.= '</td>';
		if($j==4)
		{
			$html.= '</tr>';
			$j=0;
		}
		$i++;
		$j++;
	}
	$html.= '</table>';
}        

    }
    
    return $html;
}

// display the footer
Display::display_footer();
?>
