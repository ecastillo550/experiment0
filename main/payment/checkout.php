<?php
$cidReset = true;
$language_file = array ('registration', 'admin' );

require_once dirname( __FILE__ ) . '/../inc/global.inc.php';

require_once api_get_path( LIBRARY_PATH ) . 'sessionmanager.lib.php';
require_once api_get_path( LIBRARY_PATH ) . 'language.lib.php';
require_once api_get_path( LIBRARY_PATH ) . 'usermanager.lib.php';
require_once api_get_path( SYS_PATH) . 'main/core/controller/shopping_cart/shopping_cart_controller.php';

if( $_SESSION['isShoppingCartActive'] != TRUE )
{
    header('location : ../../index.php');
}

if(!isset($_SESSION['shopping_cart']['steps']))
{
    $_SESSION['shopping_cart']['steps'] = array();
    $_SESSION['shopping_cart']['steps'][1] = TRUE;
}

$objShoppingCartController = new ShoppingCartController();
$stepNumber = 1;
$objShoppingCartController->checkStep($stepNumber, $_SESSION);
if(isset($_GET['op']) && $_GET['op'] == 'delete') {
   $code = Database::escape_string($_GET['code']);
   if ( isset( $_SESSION['shopping_cart']['items'] ) && isset( $_SESSION['shopping_cart']['items'][$code] ) )
     {
         unset( $_SESSION['shopping_cart']['items'][$code] );
     }
}
$this_section = SECTION_PLATFORM_ADMIN;
//display the header
Display::display_header(get_lang('TrainingCategory'));
?>
<div id="content">
<?php

echo $objShoppingCartController->getBreadCrumbs(&$_SESSION, &$_GET) ;?>
    <table class="data_table">
    <tr>
        <th><?php echo get_lang($_SESSION['shopping_cart']['item_type']); ?></th>    
        <th width="30px"/>
        <th><?php echo get_lang('Price'); ?></th>
    </tr>  
    <?php 
    $index = 1;
    $subTotal = 0;
    $symbol = $_SESSION['shopping_cart']['currency']['symbol'];
    if(empty($_SESSION['shopping_cart']['items'])) {
       echo '<script type="text/javascript">window.location = "'. api_get_path(WEB_PATH).'";</script>';
    }
    foreach( $_SESSION['shopping_cart']['items'] as $item ): ?>
        <tr<?php echo (($index%2) == 0) ? ' class="row_odd"' : ' class="row_even" ';?>>
            <td><a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a></td>        
            <td  style="text-align: right;padding-right:10px;"><a href="<?php echo api_get_self().'?op=delete&code='.$item['code']; ?>" title="<?php echo get_lang('Remove');?>">
               <?php echo Display::return_icon('pixel.gif',get_lang('Remove'),array('class' => 'actionplaceholdericon actiondelete'));?></a></td>
            <td  style="text-align: center;"><?php echo $symbol . ' ' . $item['price']; ?></td>
        </tr>
    <?php
    $index++;
    $subTotal += $item['price'];
    endforeach;
    
    $shoppingCartInfo = $objShoppingCartController->getShoppingCartTaxInfo();
    $taxRate = $shoppingCartInfo['taxRate'];
    $taxName = $shoppingCartInfo['taxName'];    
    $taxAmount = $taxRate * $subTotal;
    $total = $subTotal + $taxAmount;
    $_SESSION['shopping_cart']['total'] = $total;
    ?>
    <tr style="height: 30px">
        <td />
        <td style="text-align: right;"><b><?php echo get_lang('Subtotal'); ?></b></td>
        <td style="text-align: center;"><?php echo $symbol . ' ' .$subTotal; ?></td>
    </tr>
    
    <tr style="height: 30px">
        <td />
        <td style="text-align: right;"><b><?php echo $taxName; ?></b></td>
        <td style="text-align: center;"><?php echo $symbol . ' ' .$taxAmount; ?></td>
    </tr>     
    <tr style="height: 30px">
        <td />
        <td style="text-align: right;"><b><?php echo get_lang('Total'); ?></b></td>
        <td style="text-align: center;"><?php echo $symbol . ' ' .$total; ?></td>
    </tr>
    </table>
    
    <div>   
        <a href="<?php echo api_get_path(WEB_PATH); ?>main/payment/checkout_2_registration.php?id=<?php echo $_SESSION['cat_id'];?>&prev=2" class="addToCartCourse "><span><?php echo ( (api_get_user_id() != 0) ? get_lang('Ok'):get_lang('Register'))?></span></a>
    </div>
    
</div>

<?php echo Display::display_footer();
