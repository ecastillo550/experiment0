<?php
// resetting the course id
$cidReset = true;
$language_file = array ('registration','admin');

// setting the help
$help_content = 'platformadministrationsessionadd';

// including the global Dokeos file
require dirname(__FILE__) . '/../inc/global.inc.php';


// including additional libraries
require_once(api_get_path(LIBRARY_PATH).'sessionmanager.lib.php');
require_once(api_get_path(LIBRARY_PATH).'language.lib.php');
require_once api_get_path(LIBRARY_PATH).'formvalidator/FormValidator.class.php';
require_once api_get_path(LIBRARY_PATH).'usermanager.lib.php';
require_once api_get_path(LIBRARY_PATH).'fileUpload.lib.php';
require_once api_get_path(SYS_PATH).'main/core/controller/shopping_cart/shopping_cart_controller.php';
require_once api_get_path(SYS_PATH).'main/core/controller/shopping_cart/CatalogueController.php';

$objShoppingCartController = new ShoppingCartController();
$stepNumber = 3;
if(isset($_REQUEST['pay'])) {
   $_SESSION['shopping_cart']['steps'][1] = true;
}
$objCommerceManager = new EcommerceManager();

$objShoppingCartController->checkStep($stepNumber, $_SESSION );
$this_section = SECTION_PLATFORM_ADMIN;

Display::display_header(get_lang('TrainingCategory'));
?>
<div id="content">
    <?php echo $objShoppingCartController->getBreadCrumbs(&$_SESSION, &$_GET); ?>
    <div style="display:none;" id="cancell_message_id"><?php echo get_lang('ConfirmYourChoice'); ?></div>
    <div class="row">
        <div class="form_header register-payment-steps-name">
            <h2><?php echo get_lang('PaymentMethods'); ?></h2>       
        </div>
        <p><?php echo get_lang('PaymentMethodsMessage '); ?></p>
    </div>
    <div class="method-payments-icons">
    <?php 
    if($_REQUEST['action']=='cancel_order')
    {
        unset($_SESSION['shopping_cart']['items']);
    }    
    if(isset($_SESSION['user_info'])){
       $_SESSION['student_info'] = $_SESSION['user_info'];
       $_SESSION['shopping_cart']['items'] = $_SESSION['selected_courses'];
       $product = SessionManager::get_session_category($_REQUEST['id']);
       $_SESSION["shopping_cart"]['total'] = $product['cost'];
    }
 
    if ((isset($_SESSION['student_info']) && isset($_SESSION['shopping_cart']['items'])) || api_get_user_id()) { ?>
        <script>
        function callPayment(pay_type) {
            if (pay_type != 4) {                
				$('form#frmPaymentMethod input#txtPaymentType').val(pay_type);
				$('form#frmPaymentMethod').submit(); 
       
                } else {
                    if(confirm('<?php echo get_lang('ConfirmYourChoice'); ?>')) {
                        window.location.href = "<?php echo api_get_path(WEB_PATH)?>main/payment/checkout_3_registration.php?action=cancel_order";               
                    }
                }
            }
         </script>
        <div>
           <?php
          $urlaction = $objCommerceManager->getCurrentPaymentMethod()->getFormUrlPayment();
          ?>
        <!--<form action="<?php echo api_get_path(WEB_PATH);?>main/payment/checkout_4_payment_data.php" method="post" id="frmPaymentMethod">
            <input id="txtPaymentType" name="txtPaymentType" type="hidden" value=""/>
        </form>-->
        <form action="<?php echo $urlaction;?>" method="post" id="frmPaymentMethod">
            <input id="txtPaymentType" name="txtPaymentType" type="hidden" value=""/>
        </form>
            <?php
            //show payment options per catalog
            echo CatalogueController::create()->getActiveCatalogPaymentOptions();
            
        } else {
            echo get_lang('YourSessionOrderIsOver').'&nbsp;<a href="'.api_get_path(WEB_PATH).'">'.get_lang('GoToCatalogue').'</a>';
    }
?>
        </div>
    </div>
    
</div><!-- end div#content -->
<?php Display::display_footer(); 