<?php
$cidReset = TRUE;
// Language files that should be included
$language_file = array('admin', 'registration');
require_once dirname( __FILE__ ) . '/../../../../main/inc/global.inc.php';
require_once api_get_path( SYS_PATH ) . 'main/core/dao/ecommerce/EcommerceCourseDao.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommerceFactory.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/ShoppingCartModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommerceManager.php';
require_once api_get_path( SYS_PATH ) . 'main/core/controller/ecommerce/EcommerceController.php';

$request = $_REQUEST;

if ( ! empty( $request ) )
{
    $scController = new ShoppingCartController();
    
    switch ( $request['action'] )
    {
        case 'addItem' :
            $scController->addItemToShoppingCart( $request );
            echo api_utf8_encode($scController->getShoppingCartHtml());
            break;
        case 'getShoppingCartHtml' :
            $scController->getShoppingCartHtml();
            break;
        case 'removeItem' :
            $scController->removeItemShoppingCartHtml( $request );
            echo api_utf8_encode($scController->getShoppingCartHtml());
            break;
        case 'processPaymentCc' :
            $scController->processPaymentCc( $request );
            break;
    }
}

class ShoppingCartController
{
    public static function create()
    {
        return new ShoppingCartController();
    }
    
    public function __construct()
    {
        $this->_init();
    }
    
    public function addItemToShoppingCart( array $request )
    {
        
        if ( ! isset( $_SESSION['shopping_cart'] ) )
        {
            $this->_init();
        }
        
        if ( ! in_array( $request['code'], $_SESSION['shopping_cart']['items'][$request['code']] ) )
        {
            $newItem = $this->getItemDataByCodeAndType( $request['code'], $request['type'] );
            $_SESSION['shopping_cart']['items'][$newItem['code']] = $newItem;
            $_SESSION['shopping_cart']['total'] += $newItem['price'];
        }
        
        $_SESSION['shopping_cart']['item_type'] = $request['type'];
    
    }
    
    public function checkStep( $stepNumber, &$session )
    {
        return ShoppingCartModel::create()->checkStep( $stepNumber, $session );
    }
    
    public function getBreadCrumbs( &$session, &$get )
    {
        return ShoppingCartModel::create()->getBreadCrumbs( $session, $get );
    }
           
    public function getFormByStepNumber( $stepNumber, array &$session )
    {
        $response = null;        
        switch ( $stepNumber )
        {
            case 2 :                
              $response = ShoppingCartModel::create()->getFormCheckoutRegistration( $session );
              break;             
        }
        return $response;
    }
    
    public function getItemDataByCodeAndType( $code, $type )
    {
        $type = strtolower( $type );
        $item = array ();
        $item['price'] = 0;
        
        switch ( $type )
        {
            case 'course' :
                /* @var $objCourse EcommerceCourse */
                $objCourse = EcommerceCourseDao::create()->getEcommerceCourseByCourseCode( $code );
                
                if ( $objCourse !== false )
                {
                    $item['price'] = intval( $objCourse->cost, 10 );
                    $item['type'] = 'course';
                    $item['code'] = $objCourse->getCode();
                    $item['name'] = $objCourse->getCourseFull()->title;
                    $item['url'] = '/main/catalogue/course_details.php?course_code=' . $code;
                }
                break;
            case 'module' :
                    /* @var $objCourse EcommerceCourse */
                    $objModule= EcommerceCatalogModules::create()->getCourseByCode($code);                
                if ( $objModule !== false )
                {
                    $item['price'] = intval( $objModule->cost, 10 );
                    $item['type'] = 'module';
                    $item['code'] = $objModule->id;
                    $item['name'] = $objModule->code;
                    $item['url'] = '/main/catalogue/module_pack_details.php?id=' . $objModule->id;
                }
                break;
            case 'session' :
                    /* @var $objCourse EcommerceCourse */
                    $objSession= EcommerceCatalogModules::create()->getCourseByCode($code);                
                if ( $objSession !== false )
                {
                    $item['price'] = intval( $objSession->cost, 10 );
                    $item['type'] = 'session';  
                    $item['code'] = $objSession->id;
                    $item['name'] = $objSession->name;
                    $item['url'] = '/main/catalogue/session_details.php?id=' . $objSession->id;
                }
                break;
        }
        
        return $item;
    }
    
    public function getShoppingCartHtml()
    {
        
        $langShoppingCart = get_lang( 'ShoppingCart' );
        $imageShoppingCart= Display::return_icon('pixel.gif',$langShoppingCart,array('class'=>'actionplaceholderminiicon actionminiiconecommerce'));
        $itemsHtml = '';
        $subtotal = 0;
        $total = 0;
        $itemCount = 0;
        $currencySymbol = $_SESSION['shopping_cart']['currency']['symbol'];
        
        if ( isset( $_SESSION['shopping_cart']['items'] ) && count( $_SESSION['shopping_cart']['items'] ) > 0 )
        {
            $itemCount = count( $_SESSION['shopping_cart']['items'] );
            $langSubTotal = get_lang( 'SubTotal' );
            
            $itemsHtml .= '<table class="cart">' . PHP_EOL;
            
            foreach ( $_SESSION['shopping_cart']['items'] as $item )
            {
                
                $itemsHtml .= '
<tr>
    <td class="name">
        <a href="' . $item['url'] . '">' . $item['name'] . '</a>
            <div></div>
    </td>
    <td class="total">' . $currencySymbol . ' ' . $item['price'] . '</td>
    <td class="remove"><img src="/main/img/button_delete.gif" title="Remove" alt="' . $item['code'] . '" /></td>
</tr>';
                
                $subtotal += $item['price'];
            }
            
            $itemsHtml .= '</tbody></table>' . PHP_EOL;
            
            $tempTaxInfo = ShoppingCartModel::create()->getTaxInfo();
            $langTaxes = $tempTaxInfo['taxName'];
            $taxRate = $tempTaxInfo['taxRate'];
            ;
            $taxAmount = $subtotal * $taxRate;
            
            $total = $subtotal + $taxAmount;
            $itemsHtml .= <<<EOF
<table class="total">
    <tbody><tr>
    <td align="left"><b>{$langSubTotal}</b></td>
    <td align="right">{$currencySymbol} {$subtotal}</td>
  </tr>
    <tr>
    <td align="left"><b>{$langTaxes}</b></td>
    <td align="right">{$currencySymbol} {$taxAmount}</td>
  </tr>
    <tr>
    <td align="left"><b>Total</b></td>
    <td align="right">{$currencySymbol} {$total}</td>
  </tr>
  </tbody></table>
<div class="checkout"><a href="/main/payment/checkout.php" class="button"><span>Checkout</span></a></div>

EOF;
        
        } else
        {
            $itemsHtml = '<div class="empty">' . get_lang( 'ShoppingCartIsEmpty' ) . '</div>';
        }
        
        $langItems = get_lang( 'ItemsInShoppingCart' );
        $response = <<<EOF
<div id="cart">
    <div class="heading">
        <h4>{$imageShoppingCart}{$langShoppingCart}</h4>
        <a><span id="cart_total">{$itemCount } {$langItems} - {$currencySymbol} {$total}</span></a>
    </div>
    <div class="content">
    {$itemsHtml}
    </div>
</div>
EOF;
        
        return $response;
    }
    
    public function getShoppingCartSummary()
    {
    
    }
    
    public function getShoppingCartTaxInfo()
    {
        return ShoppingCartModel::create()->getTaxInfo();
    }
    
    public function getShoppingCartSummaryView()
    {
    
    }
    
    public function isShoppingCartEnabled()
    {
        $isPaymentEnabled = ( bool ) (EcommerceFactory::getEcommerceObject()->getGateway() != EcommerceAbstract::E_COMMERCE_LIB_GATEWAY_NONE);
        $isCatalogEnabled = ( bool ) (api_get_setting( 'show_catalogue' ) == 'true');
        
        return ( bool ) ($isCatalogEnabled && $isPaymentEnabled);
    }
    
    public function processCheckoutFormByStep( $stepNumber, FormValidator &$form, array &$session )
    {
        $response = null;
        
        switch ( $stepNumber )
        {
            case 2 :
                $response = ShoppingCartModel::create()->processFormDataFromCheckout2( $form, $session );
                break;
        }
        
        return $response;
    }
    
    public function processPaymentCc( $request )
    {
        $objEcommerceManager = new EcommerceManager();
        if ( ! $_SESSION['shopping_cart']['transaction_result']['completed'])
        {
            $_SESSION['shopping_cart']['transaction_result'] = $objEcommerceManager->processPayment( $request );

            if ( $_SESSION['shopping_cart']['transaction_result']['completed'] )
            {
                unset( $_SESSION['nvpReqArray'] );
            }
        
        }
        $urlFeedBackStep5 = $objEcommerceManager->getCurrentPaymentMethod()->urlFeedBack();
        if($urlFeedBackStep5 != "") {
            $urlFeedBackStep5 = api_get_path( WEB_PATH ) . 'main/payment/checkout_5_payment_feedback.php';
            header( 'location: ' . $urlFeedBackStep5 );
        }
    }
    
    public function responsePaymentCc($request) {
       $objEcommerceManager = new EcommerceManager();
       $_SESSION['shopping_cart']['transaction_result'] = $objEcommerceManager->processResponse( $request );
       $urlFeedBackStep5 = api_get_path( WEB_PATH ) . 'main/payment/checkout_5_payment_feedback.php?pay=atos';
       header( 'Location: ' . $urlFeedBackStep5 );
    }
    
    public function removeItemShoppingCartHtml( $code )
    {
        if ( is_array( $code ) )
        {
            $code = $code['code'];
        }
        
        if ( isset( $_SESSION['shopping_cart']['items'] ) && isset( $_SESSION['shopping_cart']['items'][$code] ) )
        {
            unset( $_SESSION['shopping_cart']['items'][$code] );
        }
    }
    
    
    
    protected function _init()
    {
        if ( ! isset( $_SESSION['shopping_cart'] ) )
        {
            $_SESSION['shopping_cart']['items'] = array ();
            $_SESSION['shopping_cart']['total'] = 0;
            $_SESSION['shopping_cart']['type'] = '';
            $currencyIsoCode = CatalogueFactory::getObject()->getDefaultCatalogue();
            $_SESSION['shopping_cart']['currency'] = Currency::create()->getCurrencyByIsoCode( $currencyIsoCode->currency );
        }
        
        return $_SESSION['shopping_cart'];
    }
    
    
}