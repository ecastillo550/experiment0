<?php
/* For licensing terms, see /license.txt */

/**
 * Announcement Model
 */
class AnnouncementModel 
{

    // definition tables
    protected $tableAnnouncement;    
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
        $this->tableAnnouncement = Database :: get_course_table(TABLE_ANNOUNCEMENT, $courseDb);
    }        
        
    /**
     *  Get announcement list
     *  @param      int     Optional, User id 
     *  @return`    array   Announcements
     */
    public function getAnnouncementList() {
        $where = " WHERE 1=1";
       
        $announcements = array();
		$query = "SELECT id, title, content, date_format(end_date,'%b %d') AS announcementdate FROM {$this->tableAnnouncement} $where ORDER BY id DESC";
        $rs = Database::query($query);		
        if (Database::num_rows($rs) > 0) {
            while ($row = Database::fetch_object($rs)) {
                $announcements[$row->id] = $row;
            }
        }

        return $announcements;        
    }  

	/**
     *  Get max announcement id     
     *  @return`    int   announcement id
     */
    public function getLastAnnouncement() {
               
        $announcements = array();
		$query = "SELECT id FROM {$this->tableAnnouncement} ORDER BY id";
        $rs = Database::query($query);		
        if (Database::num_rows($rs) > 0) {
            while ($row = Database::fetch_object($rs)) {
                $announcementId = $row->id;
            }
        }

        return $announcementId;        
    }
	
	/**
     * Get information about the Announcement
     * @param   int     Announcement id
     * @return  array   Announcement information
     */
    public function getAnnouncementInfo($announcementId) {
        // Database table definition        
        $t_item_propery = Database :: get_course_table(TABLE_ITEM_PROPERTY);
		$table_user     = Database::get_main_table(TABLE_MAIN_USER);

        $sql = "SELECT 	ann.id		 		AS announcement_id,
                        ann.title 			AS announcement_title,
                        ann.content	 		AS announcement_content,
                        DATE_FORMAT(insert_date,'%b %d, %Y') AS announcement_date,
						user.firstname		AS firstname,
						user.lastname		AS lastname,
						ip.insert_user_id   AS insert_user_id,
						ip.to_user_id		AS to_user_id,
						ip.to_group_id		AS to_group_id,
						ip.visibility		AS visibility
                FROM {$this->tableAnnouncement} ann, $t_item_propery ip, $table_user user
                WHERE ann.id = ip.ref
                AND tool = '".TOOL_ANNOUNCEMENT."'
				AND ip.insert_user_id = user.user_id
                AND ann.id = '".Database::escape_string($announcementId)."' ";		

        $result = Database::query($sql, __FILE__, __LINE__);
        $info = Database::fetch_array($result);
        return $info;
    }

	/** 
	 * This function gets all the groups and users (or combination of these) that can see this announcement
	 * This is mainly used when editing
	 */
	function get_announcement_dest($announcementId){
		// Database table definition
		$t_item_propery = Database :: get_course_table(TABLE_ITEM_PROPERTY);

		$sql = "SELECT * FROM $t_item_propery WHERE tool='".TOOL_ANNOUNCEMENT."' AND ref='".Database::escape_string($announcementId)."'";
		$result = Database::query($sql,__FILE__,__LINE__);
		while ($row=Database::fetch_array($result,ASSOC)){
			if ($row['to_group_id'] <> 0){
				$to_group_id[]=$row['to_group_id'];
			}
			if (!empty($row['to_user_id'])){
				$to_user_id[]=$row['to_user_id'];
			}
		}

		return array('to_group_id'=>$to_group_id, 'to_user_id'=>$to_user_id);
	}
       
    
    /**
     * Get announcement formulary
     * @return  object  Form object    
     */
    public function getForm() {                
        global $charset;
	require_once(api_get_path(LIBRARY_PATH).'course.lib.php');
    // initiate the object        
	$form = new FormValidator('announcement_form', 'post', api_get_self().'?'.api_get_cidreq().($this->announcement_id?'&action=edit&id='.intval($this->announcement_id):'&action=add'));	
	$renderer = & $form->defaultRenderer();

	if ($this->announcement_id) {
		$form->addElement('hidden', 'announcement_id', $this->announcement_id);
	}
	
	if (api_is_allowed_to_edit(false,true) OR api_is_allowed_to_session_edit(false,true)){
			// The receivers: groups
			$course_groups = CourseManager::get_group_list_of_course(api_get_course_id(), intval($this->session_id));
			foreach ( $course_groups as $key => $group ) {
				$receivers ['G' . $key] = '-G- ' . $group ['name'];
			}
			// The receivers: users
			$course_users = CourseManager::get_user_list_from_course_code(api_get_course_id(), intval($this->session_id) == 0 , intval($this->session_id));
			foreach ( $course_users as $key => $user ) {
				$receivers ['U' . $key] = $user ['lastname'] . ' ' . $user ['firstname'];
			}			
	} 

        $defaults ['send_to'] ['receivers'] = 0;
	if ($this->announcement_id) {
            $announcementInfo = $this->getAnnouncementInfo($this->announcement_id);            
            $defaults['title'] = $announcementInfo['announcement_title'];
            $defaults['description'] = $announcementInfo['announcement_content'];
			
            if (!empty($announcementInfo['to_user_id'])) {
                $defaults['send_to'] ['receivers'] = 1;
                $user_group_ids = $this->get_announcement_dest($this->announcement_id);
            }
            else if(empty($announcementInfo['to_user_id']) && $announcementInfo['visibility'] == 0){
                $defaults['send_to'] ['receivers'] = -1;
            }
            else {
                $defaults['send_to'] ['receivers'] = 0;
            }

            foreach ($user_group_ids['to_user_id'] as $key=>$user_id){
                $defaults['send_to']['to'][] = 'U'.$user_id;
            }

            foreach ($user_group_ids['to_group_id'] as $key=>$group_id){
                $defaults['send_to']['to'][] = 'G'.$group_id;
            }
        }
	else {            
            if (isset($_GET['remind_inactive'])) {
                $defaults['send_to']['receivers'] = 1;
                $defaults['title'] = sprintf(get_lang('RemindInactiveLearnersMailSubject'),api_get_setting('siteName'));
                $defaults['content'] = sprintf(get_lang('RemindInactiveLearnersMailContent'),api_get_setting('siteName'), 7);
                $defaults['send_to']['to'][] = 'U'.intval($_GET['remind_inactive']);
            } 
            elseif (isset($_GET['remindallinactives']) && $_GET['remindallinactives'] == 'true') { 
                $defaults['send_to']['receivers'] = 1;
                $since = isset($_GET['since']) ? intval($_GET['since']) : 6;
                $to = Tracking :: get_inactives_students_in_course($_course['id'],$since, api_get_session_id());
                foreach($to as $user) {
                        if (!empty($user)) {
                                $defaults['send_to']['to'][] = 'U'.$user;
                        }
                }
                $defaults['title'] = sprintf(get_lang('RemindInactiveLearnersMailSubject'),api_get_setting('siteName'));
                $defaults['content'] = sprintf(get_lang('RemindInactiveLearnersMailContent'),api_get_setting('siteName'),$since);
            }
	}
        $form->setDefaults($defaults);

	$renderer->setElementTemplate('<div class="row"><div style="width:90%;float:left;padding-left:15px;">'.get_lang ( 'VisibleFor' ).'&nbsp;&nbsp;{element}</div></div>', 'send_to');
	$form->addElement ( 'receivers', 'send_to', get_lang ( 'VisibleFor' ), array ('receivers' => $receivers, 'receivers_selected' => ''));
	
	// The title
	$renderer->setElementTemplate('<div class="row"><div style="width:90%;float:left;padding-left:15px;"><!-- BEGIN error --><span class="form_error">{error}</span><br /><!-- END error -->'.get_lang ( 'Announcement' ).'&nbsp;&nbsp;{element}</div></div>', 'title');

	$form->addElement ( 'text', 'title', get_lang ( 'Announcement' ), array('size'=>'60','class'=>'focus','id'=>'announcement_title_id') );
	
	$form->add_html_editor('description','', false, false, api_is_allowed_to_edit()
		? array('ToolbarSet' => 'Announcements', 'Width' => '100%', 'Height' => '270')
		: array('ToolbarSet' => 'AnnouncementsStudent', 'Width' => '100%', 'Height' => '270', 'UserStatus' => 'student'));

	if ($this->announcement_id) {
            $form->addElement('html','<div align="left" style="padding-left:10px;"><a href="'.api_get_self().'?'.api_get_cidreq().'&action=delete&id='.intval($this->id).'" onclick="javascript:if(!confirm('."'".addslashes(api_htmlentities(get_lang("ConfirmYourChoice"),ENT_QUOTES,$charset))."'".')) return false;">'.Display::return_icon('pixel.gif', get_lang('Delete'), array('class' => 'actionplaceholdericon actiondelete')).'&nbsp;&nbsp;'.get_lang('Delete').'</a></div>');
        }        
	$form->addElement('style_submit_button', 'SubmitAnnouncement', get_lang('Validate'), 'class="save"');	

	$token = Security::get_token();
	$form->addElement('hidden','sec_token');
	$form->setConstants(array('sec_token' => $token));	
        
	return $form;        
    } 
	
	/**
     * This functions stores the note in the database
     * @return  int       Last insert id
     */
    public function save() {
		$t_item_propery = Database :: get_course_table(TABLE_ITEM_PROPERTY);
		$lastInsertId = 0;
		
		if($this->announcement_id){

			// create the SQL statement to edit the announcement
			$sql = "UPDATE {$this->tableAnnouncement} SET 
					title 		= '".Database::escape_string($this->title)."',
					content 	= '".Database::escape_string($this->description)."'
					WHERE id = '".Database::escape_string($this->announcement_id)."'";

			$result = Database::query($sql,__FILE__,__LINE__);

			// first delete all the information in item_property
			$sql = "DELETE FROM $t_item_propery WHERE tool='".TOOL_ANNOUNCEMENT."' AND ref='".Database::escape_string($this->announcement_id)."'";
			$result = Database::query($sql,__FILE__,__LINE__);

			// store in item_property (visibility, insert_date, target users/groups, visibility timewindow, ...)
			$this->store_item_property ( $this->send_receivers, $this->send_to, $this->announcement_id, 'AnnouncementEdited' );			
		}
		else {

			$result = Database::query("SELECT max(display_order) as max FROM {$this->tableAnnouncement}",__FILE__,__LINE__);
			$row = Database::fetch_array($result);
			$max = (int)$row['max'] + 1;
		
		// create the SQL statement to add the 
			$sql = "INSERT INTO {$this->tableAnnouncement} SET                                    
                                    title           = '".Database::escape_string($this->title)."',
                                    content		    = '".Database::escape_string($this->description)."',
                                    end_date	    = NOW(),
                                    display_order   = '".$max."',
                                    email_sent      = 1,
									session_id		= $this->session_id
                                ";

			$result = Database::query($sql,__FILE__,__LINE__);
			$lastInsertId = Database::insert_id();
			if (!empty($lastInsertId)) {
				$this->store_item_property ( $this->send_receivers, $this->send_to, $lastInsertId, 'AnnouncementAdded' );
			}			
		}
		$this->send_announcement_email($this->send_receivers,$this->send_to,$this->title,$this->description);
	}

	/**
     * This functions stores the note in the database
     * @return  int       Last insert id
     */
    public function store_item_property ($send_receivers, $send_to, $id , $action_string) {
		
		if ($send_receivers == 0) {
			api_item_property_update ( api_get_course_info($this->course), TOOL_ANNOUNCEMENT, $id, $action_string, $this->user_id, '', '');
		}
		if ($send_receivers == 1) {
			foreach ( $send_to as $key => $target ) {
				if (substr ( $target, 0, 1 ) == 'U') {
					$user = substr ( $target, 1 );
					api_item_property_update ( api_get_course_info($this->course), TOOL_ANNOUNCEMENT, $id, $action_string, $this->user_id, '', $user);
				}
				if (substr ( $target, 0, 1 ) == 'G') {
					$group = substr ( $target, 1 );
					api_item_property_update ( api_get_course_info($this->course), TOOL_ANNOUNCEMENT, $id, $action_string, $this->user_id, $group, '');
				}
			}
		}
		if ($send_receivers == '-1') {
			// adding to everybody
			api_item_property_update ( api_get_course_info($this->course), TOOL_ANNOUNCEMENT, $id, $action_string, $this->user_id, '', '');
			// making it invisible
			api_item_property_update(api_get_course_info($this->course), TOOL_ANNOUNCEMENT, $id, 'invisible');
		}
	}

	/**
     * Delete an announcement
     * @return  int     Affected rows
     */
    public function delete() {
        $affectedRow = 0;
        if ($this->announcement_id) {
            Database::query("DELETE FROM {$this->tableAnnouncement} WHERE id=".intval($this->announcement_id));
            $affectedRow = Database::affected_rows();
            //update item_property (delete)
            api_item_property_update(api_get_course_info(), TOOL_ANNOUNCEMENT, $this->announcement_id, 'delete', $this->user_id);
        }
        return $affectedRow;
    }
	
	/**
     * Send announcement mail
     * @return  int     Affected rows
     */
	function send_announcement_email($send_receivers, $send_to, $title, $description){

		global $_user, $_course;
		require_once(api_get_path(LIBRARY_PATH).'course.lib.php');
		require_once(api_get_path(LIBRARY_PATH).'mail.lib.inc.php');
		require_once(api_get_path(LIBRARY_PATH).'groupmanager.lib.php');
		
		$from_name = ucfirst($_user['firstname']).' '.strtoupper($_user['lastname']);
		$from_email = $_user['mail'];
		$subject = $title;
		$message = $description;

		// create receivers array
		if($send_receivers == 0)
		{ // full list of users
			$receivers = CourseManager::get_user_list_from_course_code(api_get_course_id(), intval($_SESSION['id_session']) != 0, intval($_SESSION['id_session']));
		}
		else if($send_receivers == 1) {
			$users_ids = array();
			foreach($send_to as $to)
			{
				if(strpos($to, 'G') === false)
				{
					$users_ids[] = intval(substr($to, 1));
				}
				else
				{
					$groupId = intval(substr($to, 1));
					$users_ids = array_merge($users_ids, GroupManager::get_users($groupId));
				}	
				$users_ids = array_unique($users_ids);
			}
			if(count($users_ids) > 0)
			{
				$sql = 'SELECT lastname, firstname, email 
						FROM '.Database::get_main_table(TABLE_MAIN_USER).'
						WHERE user_id IN ('.implode(',', $users_ids).')';
				$rsUsers = Database::query($sql, __FILE__, __LINE__);
				while($userInfos = Database::fetch_array($rsUsers))
				{
					$receivers[] = $userInfos;
				}
			}
		}
		else if($send_receivers == -1) {
			$receivers[] = array(
							'lastname' => $_user['lastName'],
							'firstname' => $_user['firstName'],
							'email' => $_user['mail']
							);
		}
		
		foreach($receivers as $receiver)
		{
			$to_name = ucfirst($receiver['firstname']).' '.strtoupper($receiver['lastname']);
			$to_email = $receiver['email'];
			api_mail_html($to_name, $to_email, $subject, $message, $from_name, $from_email);
		}
	}
                
} // end class