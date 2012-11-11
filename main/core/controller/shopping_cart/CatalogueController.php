<?php
$cidReset = TRUE;
require_once dirname( __FILE__ ) . '/../../../../main/inc/global.inc.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommerceFactory.php';
require_once api_get_path( SYS_PATH ) . 'main/core/dao/ecommerce/EcommerceCourseDao.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/ShoppingCartModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueModel.php';

$request = $_REQUEST;

$scController = new ShoppingCartController();

switch ( $request['action'] )
{
    case 'addItem' :
        $scController->addItemToShoppingCart( $request );
        echo $scController->getShoppingCartHtml();
        break;
    case 'getShoppingCartHtml' :
        $scController->getShoppingCartHtml();
        break;
    case 'removeItem' :
        $scController->removeItemShoppingCartHtml( $request );
        echo $scController->getShoppingCartHtml();
        break;
}

class CatalogueController
{
    public static function create()
    {
        return new CatalogueController();
    }
    
    public function getActiveCatalogPaymentOptions()
    {
        $response = '';
        $payment_method = api_get_setting('e_commerce_payment_method');
        
        if ( ! empty( $payment_method) )
        {
            if ($payment_method['online']=='true')
            {
                $response .= '<div class="payment-methods">' . Display::return_icon( 'credit_card.png', '', array (
                    'onclick' => 'callPayment(1)', 'style' => 'cursor:pointer;' ) ) . '<br />' . get_lang( 'Online' ) . '</div>';
            }
            if ($payment_method['cheque']=='true')
            {

               $response .= '<div class="payment-methods">' . Display::return_icon( 'cheque.png', '', array (
                    'onclick' => 'callPayment(2)', 'style' => 'cursor:pointer;' ) ) . '<br />' . get_lang( 'Cheque' ) . '</div>';
              
            }/*
            if ($payment_method['installment']=='true')
            {
                $response .= '<div class="payment-methods">' . Display::return_icon( 'installments.png', '', array (
                    'onclick' => 'callPayment(3)', 'style' => 'cursor:pointer;' ) ) . '<br />' . get_lang( 'TransferIn3Installments' ) . '</div>';
            }*/
        }
        $response .= '<div class="payment-methods">'.Display::return_icon('cancel.png','', array('id'=>'cancell_button_id','onclick' => 'callPayment(4)', 'style'=>'cursor:pointer;')).'<br />'.get_lang('CancelOrder').'</div>';//
        $response .= '</div>';

        return $response;
    }
    

}