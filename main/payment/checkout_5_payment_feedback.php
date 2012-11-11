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
$stepNumber = 5;

if(isset($_REQUEST['pay'])) {
   $_SESSION['shopping_cart']['steps'][2] = true;
   $_SESSION['shopping_cart']['steps'][3] = true;
}
$objShoppingCartController->checkStep($stepNumber, $_SESSION );
$this_section = SECTION_PLATFORM_ADMIN;

$userInfo = $_SESSION['student_info'];

if( ! isset( $_SESSION['shopping_cart']['transaction_result'] ) )
{
    header('location: '.api_get_path(WEB_PATH) );
}
else {
    $transactionResult = $_SESSION['shopping_cart']['transaction_result'];        
    unset( $_SESSION['shopping_cart']['transaction_result'] );    
}

Display::display_header(get_lang('TrainingCategory'));
?>
<div id="content">

<h3><?php echo ($transactionResult['completed']) ?  (isset($_SESSION['_user']['user_id']) ? get_lang('YourOperationHasBeenSavedSucesfullyOfUser'):get_lang('YourOperationHasBeenSavedSucesfully')) : get_lang('ThereWasAPaymentProcessProblem') ;?></h3>
<?php get_lang($transactionResult['message']);?>
<?php if ($transactionResult['completed']){
$details =  $transactionResult['details'];
?>
<table>
    <?php if($details['TRANSACTIONID']!=''){ ?>
    <tr>
        <th>Transaction ID</th>
        <td><?php echo $details['TRANSACTIONID']; ?></td>
    </tr>
    <?php } if($details['AMT']!=''){?>
    <tr>
        <th>Total Charged Amount</th>
        <td><?php echo $details['AMT']; ?></td>
    </tr>
    <?php } if($details['AMT']!=''){?>
    <tr>
        <th>Transaction Date</th>
        <td><?php echo $details['TIMESTAMP']; ?></td>
    </tr>
    <?php } ?>
</table>
<?php } else{ ?>

<p><?php echo $transactionResult['message']; ?></p>
<p><a href="<?php echo api_get_path(WEB_PATH);?>main/payment/checkout_4_payment_data.php"><?php echo get_lang('Return');?></a></p>
<?php }?>

</div>
<?php echo Display::display_footer(); 