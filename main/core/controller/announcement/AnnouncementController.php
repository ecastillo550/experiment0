<?php
/* For licensing terms, see /license.txt */

/**
 * Controller script. Prepares the common background variables to give to the scripts corresponding to
 * the requested action 
 */
class AnnouncementController extends Controller {	
		
	private $toolname;
	private $view; 
        private $model;
	private $userId;
	private $courseCode;
	private $sessionId;
	private $announcementId;

	/**
	 * Constructor
	 */
	public function __construct($announcementId = null) {		
            $this->userId = api_get_user_id();
            $this->courseCode = api_get_course_id();
            $this->sessionId = api_get_session_id();
            if (isset($announcementId)) {
                $this->announcementId = $announcementId;
            }
            
            // we load the model object
            $this->model = new AnnouncementModel();            
            
            // load objects (eg: helper)
            $this->load('pagination', 'helper');
            
            // we load the view object
            $this->toolname = 'announcement';            
            $this->view = new View($this->toolname);
            $this->view->set_layout('layout');
	}

	public function listing() {
		$data = array();
		
		$announcementList = $this->pagination_helper->generate($this->model->getAnnouncementList());
		
		// preparing the response
		$data['announcementList'] = $announcementList;
		$data['pagerLinks'] = $this->pagination_helper->links();
		$this->model->announcement_id = $this->announcementId;
		if(api_is_allowed_to_edit()){
		$data['announcementForm'] = $this->model->getForm();
		}
		else {
			$this->showannouncement($this->announcementId);
		}
                
		// render to the view
		$this->view->set_data($data);
		$this->view->set_template('list');
		$this->view->render();
	}	
	
	public function add() {
            $data = array();
            if (strtoupper($_SERVER['REQUEST_METHOD']) == "POST") {
                $check = Security::check_token(); 
        	if ($check) {
				
                    $this->model->user_id			 = $this->userId;
                    $this->model->course			 = $this->courseCode;     
                    $this->model->session_id		 = $this->sessionId;
                    $this->model->title				 = $_POST['title'];   
                    $this->model->description		 = $_POST['description'];  
					$this->model->send_receivers     = $_POST['send_to']['receivers'];
					$this->model->send_to			 = $_POST['send_to']['to'];
                    $lastInsertId = $this->model->save();
                    unset($_POST);
                    Security::clear_token();                    
                }                
            } 
            $this->listing();
	}

	public function edit() {

            $data = array();
            if (strtoupper($_SERVER['REQUEST_METHOD']) == "POST") {
                $check = Security::check_token(); 
        	if ($check) {
                    $this->model->user_id			 = $this->userId;
                    $this->model->course			 = $this->courseCode;     
                    $this->model->session_id		 = $this->sessionId;
                    $this->model->title				 = $_POST['title'];   
                    $this->model->description		 = $_POST['description'];  
					$this->model->send_receivers     = $_POST['send_to']['receivers'];
					$this->model->send_to			 = $_POST['send_to']['to'];
                    $this->model->announcement_id	 = $this->announcementId;

                    $lastInsertId = $this->model->save();
                    unset($_POST);
                    unset($this->announcementId);
                    Security::clear_token();                    
                }                
            } 
            $this->listing();
        }

	/**
     * view announcement
     */
    public function showannouncement($announcementId) {

        global $charset;

		if(empty($announcementId)){
			$announcementId = $this->model->getLastAnnouncement();
		}

        $data = array();
        $announcement_info = array();    
		$announcementList  = $this->pagination_helper->generate($this->model->getAnnouncementList());
        $announcement_info = $this->model->getAnnouncementInfo($announcementId);		

        // preparing the response        
        $data['announcement_id']  = $announcementId;        
        $data['ann_title']  = $announcement_info['announcement_title'];
        $data['ann_content'] = $announcement_info['announcement_content'];
		$data['ann_date'] = $announcement_info['announcement_date'];
		$data['firstname'] = $announcement_info['firstname'];
		$data['lastname'] = $announcement_info['lastname'];
		$data['insert_user_id'] = $announcement_info['insert_user_id'];

		$data['announcementList'] = $announcementList;
        $data['pagerLinks']   = $this->pagination_helper->links();
        $this->model->id = $announcementId;
        // render to the view
        $this->view->set_data($data);
        $this->view->set_template('showannouncement');
        $this->view->render();		
    }
	
	/**
     * delete announcement
     */
	public function destroy() {
		if ($this->announcementId) {
			$this->model->announcement_id = $this->announcementId;
			$this->model->user_id     = $this->userId;
			$this->model->delete();
			unset($this->announcementId);
		}
		$this->listing();
	}
	
}
?>
