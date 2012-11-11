<?php
$cidReset = true;
$language_file = array (
    'registration', 'admin' );
// setting the help
$help_content = 'platformadministrationsessionadd';

require_once dirname( __FILE__ ) . '/../inc/global.inc.php';

require_once api_get_path( LIBRARY_PATH ) . 'sessionmanager.lib.php';
require_once api_get_path( LIBRARY_PATH ) . 'language.lib.php';
require_once api_get_path( LIBRARY_PATH ) . 'usermanager.lib.php';
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
require_once api_get_path( SYS_PATH) . 'main/core/controller/shopping_cart/shopping_cart_controller.php';

$objShoppingCartController = new ShoppingCartController();
$stepNumber = 2;

// Validate shopping cart steps
$objShoppingCartController->checkStep($stepNumber, $_SESSION);
$objForm = $objShoppingCartController->getFormByStepNumber($stepNumber, $_SESSION); 

if( $objForm->validate())
{
    $resProcessForm = $objShoppingCartController->processCheckoutFormByStep($stepNumber, $objForm, $_SESSION);
    
    if($resProcessForm)
    { 
         
        $email = $_SESSION['student_info']['email'];

        if($email!=""){
            $main_user_table = Database :: get_main_table(TABLE_MAIN_USER);
            $sql_query = 'SELECT email FROM '.$main_user_table.' WHERE email = "'.Database::escape_string($email).'"';	
            $sql_result = Database::query($sql_query, __FILE__, __LINE__);
            $result = Database :: fetch_array($sql_result);
            if($result<=0)
            {
                header("location: ". api_get_path(WEB_CODE_PATH).'payment/checkout_3_registration.php?next=3');  
            }

        }       
     } 
}
if($_SESSION['_user']['user_id'])
{
    header("location: ". api_get_path(WEB_CODE_PATH).'payment/checkout_3_registration.php?next=3');  
}

$this_section = SECTION_PLATFORM_ADMIN;
//display the header
Display::display_header(get_lang('TrainingCategory'));
?>
<div id="content">
    <?php echo $objShoppingCartController->getBreadCrumbs(&$_SESSION, &$_GET); ?>
    <div class="row">
        <div class="form_header register-payment-steps-name">
            <h2><?php echo get_lang('StudentPersonalData');?></h2>
        </div>
   </div>
   <?php  
   $objForm->display();
   ?>
</div>
<?php Display::display_footer(); 