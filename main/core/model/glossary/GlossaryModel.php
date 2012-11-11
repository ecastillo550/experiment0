<?php
/* For licensing terms, see /license.txt */

/**
 * Glossary Model
 */
class GlossaryModel
{

    // definition tables
    protected $tableGlossary;
    protected $attributes = Array();

    /**
     * Magic method
     */
    public function __get($key){
      return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : null;
    }

    /**
     * Magic method
     */
    public function __set($key, $value) {
      $this->attributes[$key] = $value;
    }

    /**
     * Constructor
     */
    public function __construct($courseDb = '') {
        $this->tableGlossary = Database :: get_course_table(TABLE_GLOSSARY, $courseDb);
    }


    /**
     * Get information about the Glossary
     * @param   int     Glossary id
     * @return  array   Glossary information
     */
    public function getGlossaryInfo($glossaryId) {
        // Database table definition
        $t_glossary = Database :: get_course_table(TABLE_GLOSSARY);
        $t_item_propery = Database :: get_course_table(TABLE_ITEM_PROPERTY);

        $sql = "SELECT 	g.glossary_id 		AS glossary_id,
                        g.name 				AS glossary_title,
                        g.description 		AS glossary_comment,
                        g.display_order		AS glossary_display_order
                FROM $t_glossary g, $t_item_propery ip
                WHERE g.glossary_id = ip.ref
                AND tool = '".TOOL_GLOSSARY."'
                AND g.glossary_id = '".Database::escape_string($glossaryId)."' ";
        $result = Database::query($sql, __FILE__, __LINE__);
        $info = Database::fetch_array($result);
        return $info;
    }

    /**
     * Get glossary list
     */
    public function getGlossaryList ($glossary_term = '') {
        // Database table definition
        $t_glossary = Database :: get_course_table(TABLE_GLOSSARY);
        $t_item_propery = Database :: get_course_table(TABLE_ITEM_PROPERTY);

        //condition for the session
        $session_id = api_get_session_id();
        $condition_session = api_get_session_condition($session_id);
        $where_condition = '';
        if (!empty($glossary_term)) {
            $where_condition = ' AND glossary.name like "'.$glossary_term.'%"';
        }
        $sql = "SELECT
                    glossary.display_order 	as displayorder,
                    glossary.name 			as name,
                    glossary.description 	as description,
                    ip.insert_date			as insertdate,
                    ip.lastedit_date		as lasteditdate,
                    glossary.glossary_id	as id,
                    glossary.session_id as session_id
                FROM $t_glossary glossary, $t_item_propery ip
                WHERE glossary.glossary_id = ip.ref $where_condition
                AND tool = '".TOOL_GLOSSARY."' $condition_session";
        $sql .= " ORDER BY glossary.name ASC ";

        $res = Database::query($sql, __FILE__, __LINE__);

        $return = array();
        while ($data = Database::fetch_array($res)) {

            $return[] = $data;
        }

        return $return;
    }
    /**
     * Get glossary formulary
     * @return  object  Form object
     */
    public function getForm() {
      global $charset;
      $editor_config = array('ToolbarSet' => 'Glossary', 'Width' => '100%', 'Height' => '250');        // initiate the object
      $form = new FormValidator('glossary', 'post', api_get_self().'?'.api_get_cidreq().($this->glossary_id?'&action=edit&id='.intval($this->glossary_id):'&action=add'));
        if ($this->glossary_id) {
            $form->addElement('hidden', 'glossary_id', $this->glossary_id);
        }

        $form->addElement('text', 'glossary_title', get_lang('TermName'), array('size'=>'30','class'=>'focus'));

        $form->addElement('html_editor', 'glossary_comment', get_lang('Definition'), 'style="vertical-align:middle"', $editor_config);

        if ($this->glossary_id) {
            $form->addElement('html','<div align="left" style="padding-left:10px;"><a href="'.api_get_self().'?'.api_get_cidreq().'&action=delete&id='.intval($this->glossary_id).'" onclick="javascript:if(!confirm('."'".addslashes(api_htmlentities(get_lang("ConfirmYourChoice"),ENT_QUOTES,$charset))."'".')) return false;">'.Display::return_icon('pixel.gif', get_lang('Delete'), array('class' => 'actionplaceholdericon actiondelete')).'&nbsp;&nbsp;'.get_lang('Delete').'</a></div>');
        }
        $form->addElement('style_submit_button', 'SubmitNote', get_lang('Validate'), 'class="save"');

	// setting the defaults
        if ($this->glossary_id) {
            $glossaryInfo = $this->getGlossaryInfo($this->glossary_id);
            $defaults['glossary_title'] = $glossaryInfo['glossary_title'];
            $defaults['glossary_comment'] = $glossaryInfo['glossary_comment'];
            $form->setDefaults($defaults);
        }

	$token = Security::get_token();
	$form->addElement('hidden','sec_token');
	$form->setConstants(array('sec_token' => $token));

	return $form;




    }
    /**
     * Return the import form
     * @global type $charset
     * @return array FormValidator
     */
    public function getImportForm() {
        global $charset;
        // Editor config
        $editor_config = array('ToolbarSet' => 'Glossary', 'Width' => '100%', 'Height' => '250');

        $form = new FormValidator('glossary_import','post', api_get_self().'?'.api_get_cidreq().'&action='.Security::remove_XSS($_GET['action']));
        $form->addElement('file', 'file_import', get_lang('UploadFileToImport').' (xls, csv)');
        $allowed_ext_types = array ('xls', 'csv');
        $form->addRule('file_import', get_lang('ExtensionNotAllowed'), 'filetype', $allowed_ext_types);
        $form->addRule('file_import', '<div class="required">'.get_lang('ThisFieldIsRequired'), 'required');
        $form->addElement('style_submit_button', 'ImportGlossary', get_lang('Import'), 'class="save" style="margin-right:400px;"');

        // The validation or display
        if ($form->validate()) {
                $check = Security::check_token('post');
                if ($check) {
                    require_once api_get_path(LIBRARY_PATH) . 'excelreader/reader.php';
                    $import_data = array();
                    // Get the extension of the document.
                    $path_info = pathinfo($_FILES['file_import']['name']);
                    $excel_type = $path_info['extension'];

                    // Check if the document is an Excel document
                    if ($excel_type != 'xls' && $excel_type != 'csv') { return; }

                    switch ($excel_type) {
                        case 'xls':
                            // Read the Excel document
                            $data = new Spreadsheet_Excel_Reader();
                            // Set output Encoding.
                            $data->setOutputEncoding($charset);
                            // Reading the xls document.
                            $data->read($_FILES['file_import']['tmp_name']);
                            for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
                                for ($x = 1; $x <= $data->sheets[0]['numCols']; $x++) {
                                    if (preg_match('/^[A-Za-z]$/', trim($data->sheets[0]['cells'][$i][$x]))) {
                                        break;
                                    }
                                    // get name
                                    if ($x == 1) {
                                        if (empty($data->sheets[0]['cells'][$i][$x])) { break; }
                                        $import_data[$i]['glossary_title'] = isset($data->sheets[0]['cells'][$i][$x])?api_convert_encoding($data->sheets[0]['cells'][$i][$x], $charset, 'UTF-8'):'';
                                    }
                                    // get description
                                    if ($x == 2) {
                                        $import_data[$i]['glossary_comment'] = isset($data->sheets[0]['cells'][$i][$x])?api_convert_encoding($data->sheets[0]['cells'][$i][$x], $charset, 'UTF-8'):'';
                                    }
                                }
                            }
                            $count = 0;
                            if (!empty($import_data)) {
                                foreach ($import_data as $values) {
                                    $saved = $this->saveGlossary($values);
                                    if ($saved) {
                                        $count++;
                                    }
                                }
                            }
                            //echo '<div class="confirmation-message">'.get_lang('Imported').' '.intval($count).' '.get_lang('GlossaryTerms').'</div>';
                            break;
                        case 'csv':
                                $result = array ();
                                $handle = fopen($_FILES['file_import']['tmp_name'], "r");
                                if($handle === false) { return $result; }
                                $keys = fgetcsv($handle, 4096, ";");
                                $count = 0;
                                while (($row_tmp = fgetcsv($handle, 4096, ";")) !== FALSE) {
                                    if (preg_match('/^[A-Za-z]$/', trim($row_tmp[0])) || empty($row_tmp[0])) {
                                        continue;
                                    }
                                    $values = array ();
                                    $values['glossary_title'] = api_convert_encoding($row_tmp[0], $charset, 'UTF-8');
                                    $values['glossary_comment'] = api_convert_encoding($row_tmp[1], $charset, 'UTF-8');
                                    $saved = $this->saveGlossary($values);
                                    if ($saved) {
                                        $count++;
                                    }
                                }
                                fclose($handle);
                                //echo '<div class="confirmation-message">'.get_lang('Imported').' '.intval($count).' '.get_lang('GlossaryTerms').'</div>';
                            break;
                    }
                }
                Security::clear_token();
        }

        $token = Security::get_token();
        $form->addElement('hidden','sec_token');
        $form->setConstants(array('sec_token' => $token));

        return $form;
    }
    /**
     * Allow save glossary terms from a file
     * @param type $values
     * @return boolean
     */
    public function saveGlossary($values) {
	// Database table definition
	$t_glossary = Database :: get_course_table(TABLE_GLOSSARY);

	// get the maximum display order of all the glossary items
	$max_glossary_item = $this->getMaxItem();

	// session_id
	$session_id = api_get_session_id();

	// check if the glossary term already exists
	if ($this->glossaryExists($values['glossary_title'])) {
                return false;
	} else {
		$sql = "INSERT INTO $t_glossary (name, description, display_order, session_id)
				VALUES(
					'".Database::escape_string(Security::remove_XSS($values['glossary_title']))."',
					'".Database::escape_string(Security::remove_XSS(stripslashes(api_html_entity_decode($values['glossary_comment'])),COURSEMANAGERLOWSECURITY))."',
					'".(int)($max_glossary_item + 1)."',
					'".Database::escape_string($session_id)."'
					)";
		$result = Database::query($sql, __FILE__, __LINE__);
		$id = Database::insert_id();
		if ($id>0) {
			//insert into item_property
			api_item_property_update(api_get_course_info(), TOOL_GLOSSARY, $id, 'GlossaryAdded', api_get_user_id());
		}
                return $id;
	}
        return false;
 }


    /**
    * check if the glossary term exists or not
    *
    * @param String $term
    * @return Boolean
    */
    function glossaryExists($term) {
        // Database table definition
        $t_glossary = Database :: get_course_table(TABLE_GLOSSARY);

        $sql = "SELECT name FROM $t_glossary WHERE name = '".Database::escape_string($term)."'";
        $result = Database::query($sql,__FILE__,__LINE__);
        $count = Database::num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * This functions stores the glossary terms into the database
     * @return  int       Last insert id
     */
    public function save() {

            $lastInsertId = 0;
            if ($this->glossary_id) {
                // update
                Database::query("UPDATE {$this->tableGlossary} SET
                                    name           = '".Database::escape_string($this->title)."',
                                    description     = '".Database::escape_string($this->description)."'
                                 WHERE glossary_id  = '".intval($this->glossary_id)."'
                                ");
                $lastInsertId = $this->glossary_id;
                if (!empty($lastInsertId)) {
                    //insert into item_property
                    api_item_property_update(api_get_course_info($this->course), TOOL_GLOSSARY, $lastInsertId, 'GlossaryUpdated', $this->user_id);
                }
            } else {
                // insert
                Database::query("INSERT INTO {$this->tableGlossary} SET
                                    session_id      = '".intval($this->session_id)."',
                                    name           = '".Database::escape_string($this->title)."',
                                    description     = '".Database::escape_string($this->description)."',
                                    display_order   = '".(int)($this->getMaxItem() + 1)."'
                                ");
                $lastInsertId = Database::insert_id();
                if (!empty($lastInsertId)) {
                    //insert into item_property
                    api_item_property_update(api_get_course_info($this->course), TOOL_GLOSSARY, $lastInsertId, 'GlossaryAdded', $this->user_id);
                }
            }
            return $lastInsertId;
    }

    /**
     * Delete a glossary term
     * @return  int     Affected rows
     */
    public function delete() {
        $affectedRow = 0;
        if ($this->glossaryId) {
            Database::query("DELETE FROM {$this->tableGlossary} WHERE glossary_id='".intval($this->glossaryId)."'");
            $affectedRow = Database::affected_rows();
            //update item_property (delete)
            api_item_property_update(api_get_course_info(), TOOL_GLOSSARY, $this->glossaryId, 'delete', $this->user_id);
        }
        return $affectedRow;
    }

    function getMaxItem() {
        $get_max = "SELECT MAX(display_order) FROM {$this->tableGlossary} ";
        $res_max = Database::query($get_max, __FILE__, __LINE__);
        $dsp=0;
        $row = Database::fetch_array($res_max);
        return $row[0];
   }

} // end class