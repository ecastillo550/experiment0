<?php
$meetingmanager = new MeetingManager();
// Create the form
$form = new FormValidator('user_add','POST',  api_get_self().'?action=newuser');
$form->addElement('header', '', get_lang('AddUsers'));
// Firstname
$form->addElement('text', 'firstname', get_lang('FirstName'),'class="focus"');
$form->applyFilter('firstname', 'html_filter');
$form->applyFilter('firstname', 'trim');
$form->addRule('firstname', get_lang('ThisFieldIsRequired'), 'required');
// Lastname
$form->addElement('text', 'lastname', get_lang('LastName'));
$form->applyFilter('lastname', 'html_filter');
$form->applyFilter('lastname', 'trim');
$form->addRule('lastname', get_lang('ThisFieldIsRequired'), 'required');
// Username
$form->addElement('text', 'username', get_lang('LoginName'), array('maxlength' => USERNAME_MAX_LENGTH));
$form->addRule('username', get_lang('ThisFieldIsRequired'), 'required');
$form->addRule('username', sprintf(get_lang('UsernameMaxXCharacters'), (string)USERNAME_MAX_LENGTH), 'maxlength', USERNAME_MAX_LENGTH);
$form->addRule('username', get_lang('OnlyLettersAndNumbersAllowed'), 'username');
$form->addRule('username', get_lang('UserTaken'), 'username_available', $user_data['username']);
//password
$form->addElement('password', 'password', get_lang('Password'));
$form->addRule('password', get_lang('ThisFieldIsRequired'), 'required');

// Email
$form->addElement('text', 'email', get_lang('Email'), array('size' => '40'));
$form->addRule('email', get_lang('EmailWrong'), 'email');
$form->addRule('email', get_lang('EmailWrong'), 'required');

$form->addElement('style_submit_button', 'submit', get_lang('Add'), 'class="add"');
if($form->validate()) {
   $data = $form->exportValues();
   $firstName = Database::escape_string($data['firstname']);
   $lastName = Database::escape_string($data['lastname']);
   $webexId = Database::escape_string($data['username']);
   $email = Database::escape_string($data['email']);
   $password = Database::escape_string($data['password']);
   $data = $meetingmanager->createUser($firstName,$lastName,$webexId,$email,$password);
   if($data){
      
   } else {
      Display::display_error_message($meetingmanager->message,true,true);
   }
}
$form->display();
?>
