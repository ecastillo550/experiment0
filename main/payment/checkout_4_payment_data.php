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
$stepNumber = 4;

$objShoppingCartController->checkStep($stepNumber, $_SESSION );
$this_section = SECTION_PLATFORM_ADMIN;

$payment_method = (isset($_REQUEST['txtPaymentType']))? $_REQUEST['txtPaymentType']:$_SESSION['student_info']['payment_method'];
$_SESSION['student_info']['payment_method'] = $payment_method;

if($_SESSION['_user']['user_id']){
    
    $user_data_info = Usermanager :: get_user_info_by_id($_SESSION['_user']['user_id'], true);
    
    $_SESSION['student_info']['firstname'] = $user_data_info['firstname'];
    $_SESSION['student_info']['lastname'] = $user_data_info['lastname'];
    $_SESSION['student_info']['email'] = $user_data_info['email'];
    $_SESSION['student_info']['extra_street'] = $user_data_info['extra']['street'];
    $_SESSION['student_info']['addressline2'] = $user_data_info['extra']['addressline2'];
    $_SESSION['student_info']['extra_city'] = $user_data_info['extra']['city'];
    $_SESSION['student_info']['extra_zipcode'] = $user_data_info['extra']['zipcode'];
}

$userInfo = $_SESSION['student_info'];

Display::display_header(get_lang('TrainingCategory'));
?>
<div id="content">  
    <?php switch($payment_method){
          case 1: echo '<h3 style="text-align:  center; width: 100%;">'.get_lang('CreditCardPayment').'</h3><p>'.get_lang('CreditCartPaymentMessage').'</p>';
                  break;
          case 2: echo '<h3 style="text-align:  center; width: 100%;">'.get_lang('ChequePayment').'</h3><p>'.get_lang('ChequePaymentMessage').'</p>';
                  break;
        /*case 3: echo '<h3 style="text-align:  center; width: 100%;">'.get_lang('InstallmentPayment').'</h3><p>'.get_lang('InstallmentPaymentMessage').'</p>';
                  break;*/
    }
    ?> 
        <form method="POST" action="<?php echo api_get_path(WEB_PATH);?>main/core/controller/shopping_cart/shopping_cart_controller.php" name="DoDirectPaymentForm">
            <input type="hidden" name="paymentType" value="Sale" />
            <input type="hidden" name="paymentMethod" value="<?php echo $payment_method;?>" />
            <input type="hidden" name="action" value="processPaymentCc" />
        
            <table style="width: 600px;">
                <tr>
                    <td><?php echo get_lang('FirstName'); ?>:</td>
                    <td><input type="text" size="30" maxlength="32" name="firstName" value="<?php echo $userInfo['firstname']; ?>"></td>
                </tr>
                <tr>
                    <td><?php echo get_lang('LastName'); ?>:</td>
                    <td><input type="text" size="30" maxlength="32" name="lastName" value="<?php echo $userInfo['lastname']; ?>"></td>
                </tr>
                <tr>
                    <td><?php echo get_lang('EmailAddress'); ?>:</td>
                    <td><input style="background-color: #ccc;" type="text" name="email" value="<?php echo $userInfo['email']; ?>" readonly="readonly"></td>
                </tr>
                <?php if($payment_method!='2'){ ?>
                <tr>
                    <td><?php echo get_lang('ChooseCreditCard'); ?>:</td>
                    <td>
                        <select name="creditCardType">
                            <option value="Visa" selected="selected">Visa</option>
                            <option value="MasterCard">MasterCard</option>
                            <option value="Discover">Discover</option>
                            <option value="Amex">American Express</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo get_lang('CreditCardNumber'); ?>:</td>
                    <td><input type="text" size="19" maxlength="19" name="creditCardNumber"></td>
                </tr>
                <tr>
                    <td><?php echo get_lang('CreditCardInstallmentsDates'); ?>:</td>
                    <td>
                        <select name="expDateMonth">
            				<option value="1">01</option>
            				<option value="2">02</option>
            				<option value="3">03</option>
            				<option value="4">04</option>
            				<option value="5">05</option>
            				<option value="6">06</option>
            				<option value="7">07</option>
            				<option value="8">08</option>
            				<option value="9">09</option>
            				<option value="10">10</option>
            				<option value="11">11</option>
            				<option value="12">12</option>
        				</select>
        				<select name="expDateYear">				
            				<option value="2012" selected="selected">2012</option>
            				<option value="2013">2013</option>
            				<option value="2014">2014</option>
            				<option value="2015">2015</option>
            				<option value="2016">2016</option>
        				</select>
    			</td>
    		</tr>
            <!--<tr>
                    <td><?php echo get_lang('CreditCardNumberInstallment'); ?>:</td>
                    <td><input type="text" size="5" maxlength="5" name="creditCardNumberInstallment" value="1"></td>
                </tr>-->
                <tr>
                    <td><?php echo get_lang('CardVerificationNumber'); ?>:</td>
                    <td><input type="text" size="3" maxlength="4" name="cvv2Number" value=""></td>
    		</tr>
                <?php } ?>        
    		<tr>
    		    <td><b><?php echo get_lang('BillingAddress');?>:</b></td>
    	        </tr>
    	        <tr>
    	            <td><?php echo get_lang('Street'); ?> 1:</td>
    	            <td><input type="text" size="25" maxlength="100" name="address1" value="<?php echo $userInfo['extra_street']; ?>"></td>
                </tr>
                <tr>
                    <td><?php echo get_lang('AdditionalStreet'); ?>:</td>
                    <td><input type="text"  size="25" maxlength="100" name="address2" value="<?php echo $userInfo['extra_addressline2']; ?>">(<?php echo get_lang('Optional');?>)</td>
                </tr>
                <tr>
                    <td><?php echo get_lang('City'); ?>:</td>
                    <td><input type="text" size="25" maxlength="40" name="city" value="<?php echo $userInfo['extra_city']; ?>"></td>
                </tr>
                <tr>
                    <td><?php echo get_lang('Zipcode'); ?>:</td>
                    <td><input type="text" size="10" maxlength="10" name="zip" value="<?php echo $userInfo['extra_zipcode']; ?>">(5 or 9 digits)</td>
                </tr>
                <tr>
                    <td><?php echo get_lang('Country'); ?>:</td>
                    <td><?php 
                        $countries = LanguageManager::get_countries(null,'iso');
                        $cboCountries = '<select name="cboCountry">'.PHP_EOL;
                        foreach( $countries as $countryK => $country )
                        {
                        $cboCountries .= '<option value="'.	$countryK.'"';

                        if ( $userInfo['country'] == $countryK)
                        {
                            $cboCountries .= ' selected="selected" ';
                        }
                        $cboCountries .= '>' . $country . '</option>'."\n";
                        }
                        echo $cboCountries .= '</select>';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo get_lang('Amount'); ?>:</td>
                    <td><input style="background-color: #ccc;" type="text" size="4" maxlength="7" name="amount" value="<?php echo $_SESSION['shopping_cart']['total']; ?>" readonly="readonly"> USD</td>
                </tr>
                <tr>
                    <td/>
                    <td><b>(DoDirectPayment only supports USD at this time)</b></td>
                </tr>
                <tr>
                    <td/>
                    <td><input type="Submit" id="color_button_validate" value="<?php echo get_lang('Ok');?>"></td>
                </tr>
            </table>
    </form>
</div>
<?php echo Display::display_footer(); 