<?php
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommerceAbstract.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommerceInterface.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommercePaypal.php';

class EcommerceManager
{
    
    private $_gatewayObj = null;
    private $_userId = 0;
    
    public function __construct()
    {
        $selectedGateway = intval( api_get_setting( 'e_commerce' ), 10 );
        $this->_gatewayObj = EcommerceFactory::getEcommerceObject( $selectedGateway );
    }
    
    /**
     *
     * @return EcommerceInterface
     */
    public function getCurrentPaymentMethod()
    {
        return $this->_gatewayObj;
    }
    
    public function processPayment( array $request )
    {   
        $response = $this->_gatewayObj->proccessPayment( $request );        
        
        if ( $response['completed'] )
        {
            $newUserId = $this->registerNewUser( $_SESSION);            
            $this->logPayment($response,$request);
            if($_SESSION['_user']['user_id'])
            {
                $this->registerUserIntoCourses( $_SESSION, $response, $_SESSION['_user']['user_id']);
            }
            else{
                $this->registerUserIntoCourses( $_SESSION, $response, $this->_userId);
                
            }
            unset($_SESSION['shopping_cart']['items']);     
        }
        if($_SESSION['student_info']['payment_method']=='2')
        {
            $newUserId = $this->registerNewUser( $_SESSION);
            $this->logPayment($response,$request);
            if(!$_SESSION['_user']['user_id'])
            {              
                $this->registerUserIntoCourses( $_SESSION, $response, $this->_userId);               
            }
            unset($_SESSION['shopping_cart']['items']);
            $response['completed'] = true;         
        }      
        return $response;
    }
    
    public function processResponse(array $request) {
       $response = $this->_gatewayObj->processResponse( $request );
       if ( $response['completed'] ) {
            $newUserId = $this->registerNewUser( $_SESSION,$request );            
            $this->logPayment($response);
            $this->registerUserIntoCourses( $_SESSION, $response, $this->_userId);         
        }

        return $response;
    }
    
    public function logPayment( $transactionResult,$request  )
    {      
        $params = array ();
        $params['user_id'] = $this->_userId;
        $params['sess_id'] = '0';
        $params['pay_type'] = $_SESSION['student_info']['payment_method']; // MEANS IT IS ONLINE!
        $params['ecommerce_gateway'] = EcommerceFactory::getEcommerceObject()->getGateway();
        $params['pay_data'] = serialize( $transactionResult['details']    );
        $params['transaction_id'] =  $transactionResult['transactionId'];
        $params['curr_quota'] = $request['creditCardNumberInstallment'];
        SessionManager::save_payment_log( $params );               
    }
    
    public function registerUserIntoCourses( array $session, array $transactionResult , $userId )
    {   
       $objEcommerce = CatalogueFactory::getObject();
       $objEcommerce->registerItemsIntoUser($session, $userId);
       return $objEcommerce->registerItemsForUser($session, $transactionResult,$userId);
    }
     
    public function registerNewUser( $session)
    {
         
        $lastname = $session['student_info']['lastname'];
        $firstname = $session['student_info']['firstname'];
        $country_code = $session['student_info']['country'];
        $payment_method = $session['student_info']['payment_method'];
        $status = 5;
        ($session['student_info']['payment_method']=='2')? $active = 0 : $active=1;
        $hash = api_generate_password( 3 );
        $part1 = $firstname[0];
        $exp_lname = explode( ' ', $lastname );
        $part2 = (is_array( $exp_lname ) && count( $exp_lname ) > 1) ? $exp_lname[0] : $lastname;
        $genera_uname = strtolower( $part1 . $part2 . $hash );
        $genera_uname = replace_accents( $genera_uname );
        $username = $genera_uname;
        $email = $session['student_info']['email'];
        $subject = '';
        $password = api_generate_password();
        if ( api_get_user_id() < 1 )
        {
            if( $username != '')
            {      
                    $this->_userId = UserManager::create_user( $firstname, $lastname, $status, $email, $username, $password,$official_code = '', $language = '', $phone = '', $picture_uri = '', $auth_source = PLATFORM_AUTH_SOURCE, $expiration_date = '0000-00-00 00:00:00', $active, $hr_dept_id = 0, $extra = null,$country_code,$civility);  
            }                
            $extras = array ();
            foreach ( $session['student_info'] as $key => $value )
            {
                if ( substr( $key, 0, 6 ) == 'extra_' )
                { // an extra field
                    $myres = UserManager::update_extra_field_value( $this->_userId, substr( $key, 6 ), $value );
                }
            }
            
            $user_info = api_get_user_info( $this->_userId  );
            $extra_field = UserManager::get_extra_user_data( $this->_userId  );
            $_user ['firstName'] = $user_info ['firstname'];
            $_user ['lastName'] = $user_info ['lastname'];
            $_user ['mail'] = $user_info ['mail'];
            $_user ['language'] = $user_info ['language'];
            $_user ['user_id'] = $this->_userId;
            
            $is_allowedCreateCourse = $user_info ['status'] == 1;
            api_session_register( '_user' );
            api_session_register( 'is_allowedCreateCourse' );
            
            $recipient_name = $_user ['firstName'] . ' ' . $_user ['lastName'];
            // stats
            event_login();
            // last user login date is now
            $user_last_login_datetime = 0; // used as a unix timestamp it will
            // correspond to : 1 1 1970
            api_session_register( 'user_last_login_datetime' );
            $recipient_name = api_get_person_name($firstname, $lastname, null, PERSON_NAME_EMAIL_ADDRESS);		
            $sender_name = api_get_person_name(api_get_setting('administratorName'), api_get_setting('administratorSurname'), null, PERSON_NAME_EMAIL_ADDRESS);
            $email_admin = api_get_setting('emailAdministrator'); 
            $c=1;$programme ='';
            $courseCodes = array_keys($session['shopping_cart']['items']);
            foreach( $courseCodes as $courseCode) {
                    $programme.= $c.'.- '.$session['shopping_cart']['items'][$courseCode]['name'].'<br/>';
                    $c++;
            }              
            if($session['student_info']['payment_method']!='2'){
            $subject = '['.api_get_setting('siteName').'] '.get_lang('YourReg').' '.api_get_setting('siteName'); 
            UserManager::send_mail_to_new_user_for_credit_card_or_installment($recipient_name, $email,$subject,$firstname, $lastname,$username,$password,$programme,$sender_name, $email_admin);           
            }else{    
            $subject = '['.api_get_setting('siteName').'] '.get_lang('YourReg').' '.api_get_setting('siteName');          
            UserManager::send_mail_to_new_user_for_cheque($recipient_name, $email,$subject,$firstname, $lastname,$username,$password,$programme,$sender_name, $email_admin);
            $subject = '['.api_get_setting('siteName').'] '.get_lang('NewUserRegForCheque').' '.api_get_setting('siteName');  
            UserManager::send_mail_to_new_user_for_cheque_to_admin($sender_name, $email_admin,$subject,$firstname, $lastname,$username,$password,$programme,$sender_name, $email_admin);
            }
        }
        else
        {
            $this->_userId = api_get_user_id() ;
            $recipient_name = api_get_person_name($firstname, $lastname, null, PERSON_NAME_EMAIL_ADDRESS);		
            $sender_name = api_get_person_name(api_get_setting('administratorName'), api_get_setting('administratorSurname'), null, PERSON_NAME_EMAIL_ADDRESS);
            $email_admin = api_get_setting('emailAdministrator'); 
            $c=1;$programme ='';
            $courseCodes = array_keys($session['shopping_cart']['items']);
            foreach( $courseCodes as $courseCode) {
                    $programme.= $c.'.- '.$session['shopping_cart']['items'][$courseCode]['name'].'<br/>';
                    $c++;
            }              
            if($session['student_info']['payment_method']!='2'){
            $subject = '['.api_get_setting('siteName').'] '.get_lang('YourReg').' '.api_get_setting('siteName'); 
            UserManager::send_mail_add_programmes_for_credit_card_or_installment($recipient_name, $email,$subject,$firstname, $lastname,$programme,$sender_name, $email_admin);           
            }else{    
            $subject = '['.api_get_setting('siteName').'] '.get_lang('YourReg').' '.api_get_setting('siteName');          
            UserManager::send_mail_add_programmes_for_cheque($recipient_name, $email,$subject,$firstname, $lastname,$username,$password,$programme,$sender_name, $email_admin);
            $subject = '['.api_get_setting('siteName').'] '.get_lang('NewUserRegForCheque').' '.api_get_setting('siteName');  
            UserManager::send_mail_add_programmes_for_cheque_to_admin($sender_name, $email_admin,$subject,$firstname, $lastname,$username,$password,$programme,$sender_name, $email_admin);
            }
        }
       
        return $this->_userId;    
    }
    
    /**
     * 
     */
    public function getContentMail($firstname, $lastname,$username,$password){
         global $language_interface;
         $table_emailtemplate 	= Database::get_main_table(TABLE_MAIN_EMAILTEMPLATES);	
         $sql = "SELECT * FROM $table_emailtemplate WHERE description = 'Userregistration' AND language= '".$language_interface."'";
         $result = api_sql_query($sql, __FILE__, __LINE__);
         $content = "";
         while($row = Database::fetch_array($result))
         {				
                 $content = $row['content'];
         }
         if(empty($content))
         {
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
         $content =  str_replace('{Name}',stripslashes(api_get_person_name($firstname, $lastname)), $content); 
         $content =  str_replace('{siteName}',api_get_setting('siteName'), $content); 
         $content =  str_replace('{username}',$username, $content); 
         $content =  str_replace('{password}',stripslashes($password), $content); 			
         $content =  str_replace('{administratorSurname}',api_get_person_name(api_get_setting('administratorName'), api_get_setting('administratorSurname')), $content); 
         $content =  str_replace('{administratorTelephone}',api_get_setting('administratorTelephone'), $content); 
         $content =  str_replace('{emailAdministrator}',api_get_setting('emailAdministrator'), $content); 
         
         if ($_configuration['multiple_access_urls'] == true) {
              $access_url_id = api_get_current_access_url_id();
              if ($access_url_id != -1) {
                   $url = api_get_access_url($access_url_id);
                   $content =  str_replace('{url}',$url['url'], $content); 
              }
         }
         else {
              $content =  str_replace('{url}',$_configuration['root_web'], $content); 
         }
         return $content;
    }
    public function getContentMailNewCourse($firstname, $lastname,$username,$password){
         global $language_interface;
         $table_emailtemplate 	= Database::get_main_table(TABLE_MAIN_EMAILTEMPLATES);	
         $sql = "SELECT * FROM $table_emailtemplate WHERE description = 'Userregistration' AND language= '".$language_interface."'";
         $result = api_sql_query($sql, __FILE__, __LINE__);
         $content = "";
         while($row = Database::fetch_array($result))
         {				
                 $content = $row['content'];
         }
         if(empty($content))
         {
              $content = get_lang('Dear')." {Name} ,\n\n";   
              $content .= get_lang('Address')." {siteName} ".get_lang('Is')." - {url} \n\n";
              $content .= get_lang('Problem')."\n\n".get_lang('Formula').",\n";
              $content .= "{administratorSurname} \n";
              $content .= get_lang('Manager')."\n";
              $content .= "{administratorTelephone} \n";
              $content .= get_lang('Email')." : {emailAdministrator}";
         }
         $content =  str_replace('{Name}',stripslashes(api_get_person_name($firstname, $lastname)), $content); 
         $content =  str_replace('{siteName}',api_get_setting('siteName'), $content); 
         $content =  str_replace('{username}',$username, $content); 
         $content =  str_replace('{password}',stripslashes($password), $content); 			
         $content =  str_replace('{administratorSurname}',api_get_person_name(api_get_setting('administratorName'), api_get_setting('administratorSurname')), $content); 
         $content =  str_replace('{administratorTelephone}',api_get_setting('administratorTelephone'), $content); 
         $content =  str_replace('{emailAdministrator}',api_get_setting('emailAdministrator'), $content); 
         
         if ($_configuration['multiple_access_urls'] == true) {
              $access_url_id = api_get_current_access_url_id();
              if ($access_url_id != -1) {
                   $url = api_get_access_url($access_url_id);
                   $content =  str_replace('{url}',$url['url'], $content); 
              }
         }
         else {
              $content =  str_replace('{url}',$_configuration['root_web'], $content); 
         }
         return $content;
    }
}
;