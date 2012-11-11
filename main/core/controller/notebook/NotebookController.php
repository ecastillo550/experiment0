<?php
/* For licensing terms, see /license.txt */

/**
 * Controller script. Prepares the common background variables to give to the scripts corresponding to
 * the requested action 
 */
class NotebookController extends Controller {	
		
	private $toolname;
	private $view; 
        private $model;
	private $userId;
        private $courseCode;
        private $sessionId;
        private $notebookId;

	/**
	 * Constructor
	 */
	public function __construct($notebookId = null) {		
            $this->userId = api_get_user_id();
            $this->courseCode = api_get_course_id();
            $this->sessionId = api_get_session_id();
            if (isset($notebookId)) {
                $this->notebookId = $notebookId;
            }
            
            // we load the model object
            $this->model = new NotebookModel();            
            
            // load objects (eg: helper)
            $this->load('pagination', 'helper');
            
            // we load the view object
            $this->toolname = 'notebook';            
            $this->view = new View($this->toolname);
            $this->view->set_layout('layout');
	}

	public function listing() {
                $data = array();
				
                $noteList = $this->pagination_helper->generate($this->model->getNotesList($this->userId));
                
                // preparing the response
                $data['noteList'] = $noteList;
                $data['pagerLinks'] = $this->pagination_helper->links();
                $this->model->notebook_id = $this->notebookId;
                $data['notebookForm'] = $this->model->getForm();
                
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
                    $this->model->user_id     = $this->userId;
                    $this->model->course      = $this->courseCode;     
                    $this->model->session_id  = $this->sessionId;
                    $this->model->title       = !empty($_POST['title'])?$_POST['title']:get_lang('Notebook').' #'.count($this->model->getNotesList($this->userId));   
                    $this->model->description = $_POST['description'];    
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
                    $this->model->user_id     = $this->userId;
                    $this->model->course      = $this->courseCode;     
                    $this->model->session_id  = $this->sessionId;
                    $this->model->title       = !empty($_POST['title'])?$_POST['title']:get_lang('Notebook').' #'.count($this->model->getNotesList($this->userId));   
                    $this->model->description = $_POST['description']; 
                    $this->model->notebook_id = $this->notebookId;
                    $lastInsertId = $this->model->save();
                    unset($_POST);
                    unset($this->notebookId);
                    Security::clear_token();                    
                }                
            } 
            $this->listing();
        }
        
        public function destroy() {
            if ($this->notebookId) {
                $this->model->notebook_id = $this->notebookId;
                $this->model->user_id     = $this->userId;
                $this->model->delete();
                unset($this->notebookId);
            }
            $this->listing();
        }
	
}
?>
