<?php
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommerceInterface.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommerceAbstract.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/user/UserModel.php';
require_once api_get_path( SYS_PATH ) . 'main/inc/lib/paypal/PaypalModel.php';


if ( ! class_exists( 'EcommercePaypal' ) )
{    
    class EcommercePaypal extends EcommerceAbstract implements EcommerceInterface
    {
        /*
         * (non-PHPdoc) @see EcommerceInterface::getForm()
         */
        public function getForm()
        {
            $form = new FormValidator( 'frmEcommerce' );
            $form->addElement( 'text', 'txtUserName', 'API ' . get_lang( 'UserName' ), array (
                'size' => 40 ) );
            $form->addElement( 'text', 'txtPassword', 'API ' . get_lang( 'Password' ), array (
                'size' => 40 ) );
            $form->addElement( 'text', 'txtSignature', 'API ' . get_lang( 'Signature' ), array (
                'size' => 40 ) );
            $form->addRule( 'txtUserName', get_lang( 'ThisFieldIsRequired' ), 'required' );
            $form->addRule( 'txtPassword', get_lang( 'ThisFieldIsRequired' ), 'required' );
            $form->addElement( 'style_submit_button', 'submit', get_lang( 'Save' ), array (
                'class' => 'save' ) );
            
            $this->_gatewayDetailValues = $this->getGatewaySettings();
            
            $defaults['txtUserName'] = $this->_gatewayDetailValues['username']->value;
            $defaults['txtPassword'] = $this->_gatewayDetailValues['password']->value;
            $defaults['txtSignature'] = $this->_gatewayDetailValues['signature']->value;
            $form->setDefaults( $defaults );
            
            return $form;
        }
        
        /*
         * (non-PHPdoc) @see EcommerceInterface::save()
         */
        public function save( array $post, array $files )
        {
            $paypalValues['username'] = trim( $post['txtUserName'] );
            $paypalValues['password'] = trim( $post['txtPassword'] );
            $paypalValues['signature'] = trim( $post['txtSignature'] );
            $idGateway = parent::getGateway();
            
            parent::saveDataPaymentGateway( $paypalValues );
        }
        
        public function proccessPayment( $request )
        {       
            $response = array ();            
            $objPaypal = new PaypalModel();
            $product = count( $_SESSION['shopping_cart']['items'] );
            $objPaypal->setProduct( $product );            
            $response = $objPaypal->processForm( $_SESSION, $request );
            
            return $response;
        }    
    }
}