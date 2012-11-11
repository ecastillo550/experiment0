<?php
require_once api_get_path( SYS_PATH ) . 'main/core/dao/ecommerce/EcommerceCourseDao.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/course/CourseModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueManager.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueFactory.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueCourseModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueSessionModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueModuleModel.php';

class EcommerceCatalog
{
    
    public $currentValue = '';
    public $optionValues = array ();
    
    public static function create()
    {
        return new EcommerceCatalog();
    }
    
    public function deleteCourseEcommerce( $courseCode )
    {
        $tblCourseEcommerce = Database::get_main_table( TABLE_MAIN_COURSE_ECOMMERCE );
        $courseCode = trim( $courseCode );
        
        if ( $courseCode == '' )
        {
            return 0;
        }
        
        $sql = "DELETE FROM $tblCourseEcommerce WHERE course_code = '$courseCode';";
        
        Database::query( $sql, __FILE__, __LINE__ );
        
        return Database::affected_rows();
    }
    
    public function getCatalogSettings()
    {
        $table_main_settings = Database::get_main_table( TABLE_MAIN_SETTINGS_CURRENT );
        $table_main_settings_options = Database::get_main_table( TABLE_MAIN_SETTINGS_OPTIONS );
        
        $sql = "SELECT sc.variable,sc.type,sc.category,sc.selected_value, sc.title, sc.comment, so.display_text
        FROM $table_main_settings as sc
        JOIN $table_main_settings_options as so
        ON sc.variable = so.variable AND sc.selected_value = so.value
        WHERE sc.variable = 'e_commerce_catalog_type' LIMIT 1";
        
        $result = Database::query( $sql, __FILE__, __LINE__ );
        $this->currentValue = Database::fetch_object( $result );
        
        return $this->currentValue;
    }
    
    public function getCatalogTypeOptions()
    {
        $this->optionValues = array ();
        
        $table_main_settings = Database::get_main_table( TABLE_MAIN_SETTINGS_CURRENT );
        $table_main_settings_options = Database::get_main_table( TABLE_MAIN_SETTINGS_OPTIONS );
        
        $sql = "SELECT * FROM $table_main_settings_options WHERE variable = 'e_commerce_catalog_type'";
        
        $result = Database::query( $sql, __FILE__, __LINE__ );
        
        $row = true;
        while ( $row )
        {
            $row = Database::fetch_object( $result );
            if ( $row !== FALSE )
            {
                $this->optionValues[$row->value] = $row;
            }
        }
        
        return $this->optionValues;
    }
    
    public function getCourseByCode( $courseCode )
    {
        
        $currentCatalogType = intval( get_setting( 'e_commerce_catalog_type' ), 10 );
        
        $response = array ();
        
        switch ( $currentCatalogType )
        {
            case CatalogueModel::TYPE_COURSE :
                $response = CatalogueCourseModel::create()->getCourseByCode( $courseCode );
                break;
            case CatalogueModel::TYPE_MODULES :
                $response = CatalogueModuleModel::create()->getById( $courseCode );
                break;
            case CatalogueModel::TYPE_SESSION :
                $response = CatalogueSessionModel::create()->getProgrammeByCode( $courseCode );
                break;
        }
        
        return $response;
    }
    
    public function getCourseByCodeObj( $courseCode )
    {
        return EcommerceCourseDao::create()->getEcommerceCourseByCourseCode( $courseCode );
    }
    
    public function getModuleByCodeObj( $moduleCode )
    {
        return EcommerceCourseDao::create()->getEcommerceModuleByModuleCode( $moduleCode );
    }
    
    public function getCourseCatalogButtonList( $code, $url_params, $row )
    {
        return        

        // '<a
        // href="'.api_get_path(WEB_COURSE_PATH).$row[11].'/index.php">'.Display::return_icon('course_home.gif',
        // get_lang('CourseHomepage')).'</a>&nbsp;'.
        '<a href="ecommerce_course_edit.php?course_code=' . $code . '">' . Display::return_icon( 'pixel.gif', get_lang( 'Edit' ), array (
            'class' => 'actionplaceholdericon actionedit' ) ) . '</a>&nbsp;&nbsp;' . '<a href="ecommerce_courses.php?action=delete&course_code=' . $code . '"  onclick="javascript:if(!confirm(' . "'" . addslashes( api_htmlentities( get_lang( "ConfirmYourChoice" ), ENT_QUOTES, $charset ) ) . "'" . ')) return false;">' . Display::return_icon( 'pixel.gif', get_lang( 'Delete' ), array (
            'class' => 'actionplaceholdericon actiondelete' ) ) . '</a>';
    
    }
    
    public function getCourseEcommerceData( $from = 0, $number_of_items = 100, $column = 1, $direction = ' ASC ', $get = array() )
    {
        // Database table definition
        $tableEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        $currentItemType = intval( get_setting( 'e_commerce_catalog_type' ), 10 );
        
        $response = array ();
        switch ( $currentItemType )
        {
            case CatalogueModel::TYPE_COURSE :
                $response = CatalogueCourseModel::create()->getCourseEcommerceData( $from, $number_of_items, $column, $direction, $get );
                break;
        /**
         *
         * @todo Implement methods for other types!
         */
        
        }
        
        return $response;
    }
    
    public function getCoursesList()
    {
        $tableMainCourse = Database::get_main_table( TABLE_MAIN_COURSE );
        $tableMainCourseEcommerce = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        
        $response = array ();
        
        $courseType = CatalogueModel::TYPE_COURSE;
        
        $sql = "SELECT c.code, c.title,c.visibility,ce.cost,ce.status,ce.date_start,ce.date_end FROM $tableMainCourse AS c
        LEFT JOIN $tableMainCourseEcommerce AS ce ON c.code = ce.code AND ce.item_type = '$courseType';";
        
        $result = Database::query( $sql, __FILE__, __LINE__ );
        
        $row = true;
        while ( $row )
        {
            $row = Database::fetch_object( $result );
            if ( $row !== FALSE )
            {
                $response[] = $row;
            }
        }
        return $response;
    }
    
    public function getCurrency()
    {
        $response = NULL;
    
    }
    
    public function getFormForCourseEcommerceByCode( $courseCode )
    {
        
        $objEcommerceCourse = $this->getCourseByCode( $courseCode );
        
        if ( is_null( $objEcommerceCourse ) )
        {
            return null;
        }
        
        $form = new FormValidator( 'frmEditEcommerceCourse', 'post', 'ecommerce_course_edit.php?course_code=' . $courseCode );
        
        if ( $form->validate() )
        {
            $submitted = $form->getSubmitValues();
            
            if ( is_array( $submitted['date_start'] ) && (isset( $submitted['date_start']['d'] ) && isset( $submitted['date_start']['M'] ) && isset( $submitted['date_start']['Y'] )) )
            {
                $submitted['date_start'] = $submitted['date_start']['Y'] . '-' . $submitted['date_start']['M'] . '-' . $submitted['date_start']['d'];
            }
            if ( is_array( $submitted['date_end'] ) && (isset( $submitted['date_end']['d'] ) && isset( $submitted['date_end']['M'] ) && isset( $submitted['date_end']['Y'] )) )
            {
                $submitted['date_end'] = $submitted['date_end']['Y'] . '-' . $submitted['date_end']['M'] . '-' . $submitted['date_end']['d'];
            }
            
            $currentCatalogType = intval( get_setting( 'e_commerce_catalog_type' ), 10 );
            
            $response = array ();
            
            switch ( $currentCatalogType )
            {
                case CatalogueModel::TYPE_COURSE :
                    CatalogueCourseModel::create()->saveItemEcommerce( $submitted );
                    $objEcommerceCourse = CatalogueCourseModel::create()->getCourseByCode( $courseCode );
                    break;
            
                /**
             *
             * @todo implement other types
             *       THIS SHOULD BE USED I
             */
            }
            
        
        }
        
        $form->addElement( 'hidden', 'course_code' );
        $form->addElement( 'text', 'txtTitle', get_lang( 'Name' ), array (
            'size' => 40, 'readonly' => 'readonly', 'class' => 'grayBg' ) );
        
        $form->addElement( 'text', 'cost', get_lang( 'Cost' ), array (
            'size' => 10 ) );
        
        $form->addElement( 'radio', 'status', get_lang( 'Status' ) . ':', get_lang( 'Active' ), 1 );
        $form->addElement( 'radio', 'status', null, get_lang( 'Inactive' ), 0 );
        
        $form->addElement( 'date', 'date_start', get_lang( 'StartDate' ) );
        $form->addElement( 'date', 'date_end', get_lang( 'EndDate' ) );
        
        $form->addRule( 'txtTitle', get_lang( 'ThisFieldIsRequired' ), 'required' );
        $form->addElement( 'style_submit_button', 'submit', get_lang( 'Save' ), array (
            'class' => 'save' ) );
        
        $defaults = array ();
        $defaults['txtTitle'] = $objEcommerceCourse->title;
        $defaults['course_code'] = $objEcommerceCourse->code;
        $defaults['cost'] = $objEcommerceCourse->cost;
        $defaults['visibility'] = $objEcommerceCourse->visibility;
        $defaults['status'] = $objEcommerceCourse->status;
        $defaults['date_start'] = $objEcommerceCourse->date_start;
        $defaults['date_end'] = $objEcommerceCourse->date_end;
        
        $form->setDefaults( $defaults );
        
        return $form;
    }
    
    public function getItemEcommerceData( $ecommerceItemId )
    {
    	$ecommerceItemId = intval( $ecommerceItemId, 10 );
    
    	$tableEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
    	$sql = "SELECT * FROM $tableEcommerceItems WHERE id = '$ecommerceItemId' LIMIT 1;";
    	$res = Database::query( $sql, __FILE__, __LINE__ );
    	$ecommerceItem = Database::fetch_object( $res, 'EcommerceModel' );
    }
    
    public function getProductList()
    {
        
        //sets the currentValue (of the catalog to be used in the next switch)
        $this->getCatalogSettings();
                
        $response = '';
        
        $objCatalogue = CatalogueFactory::getObject();
        $response =  $objCatalogue->getShoppingCartList();
   
        return $response;
    }
    
    public function getTotalNumberCourseEcommerce()
    {
        $tableEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        $currentItemType = intval( get_setting( 'e_commerce_catalog_type' ), 10 );
        $sql = "SELECT COUNT(*) AS total FROM $tableEcommerceItems WHERE item_type = '$currentItemType'";
        $res = Database::query( $sql, __FILE__, __LINE__ );
        $course = Database::fetch_row( $res );
        return intval( $course[0], 10 );
    }
    
    public function getValidCatalogCurrencyOptions()
    {
        $objCatalogueModel = CatalogueFactory::getObject();
        $valid = $objCatalogueModel->getValidCatalogCurrencyOptions();
        
        return $valid;
    }
    
    public function updateCurrentCatalogTypeValue( $currentValue )
    {
        $currentValue = intval( $currentValue, 10 );
        
        $table_main_settings = Database::get_main_table( TABLE_MAIN_SETTINGS_CURRENT );
        
        $sql = "UPDATE $table_main_settings SET selected_value = $currentValue WHERE variable = 'e_commerce_catalog_type' LIMIT 1";
        
        $result = Database::query( $sql, __FILE__, __LINE__ );
        
        return Database::affected_rows();
    }
    
    protected function _getListCoursesCatalog()
    {
       
    }
  
    
    protected function _getListModuleCatalog()
    {
       
    }
    
    
    
    public function saveCatalog( $catalogue )
    {
        $catalogue_table = Database::get_main_table( TABLE_MAIN_CATALOGUE );
        
        $objCatalog = $this->getCatalogue();
        
        if ( $objCatalog === false )
        {
            $sql = "INSERT INTO " . $catalogue_table . " SET " . "title	= '" . Database::escape_string( $catalogue['title'] ) . "',
            economic_model		= '" . Database::escape_string( $catalogue['economic_model'] ) . "',
            visible				= '" . Database::escape_string( $catalogue['visible'] ) . "',
            company_logo 	= '" . $catalogue['company_logo'] . "',
            payment 				= '" . implode( ',', $catalogue['payments'] ) . "',
            company_address	= '" . Database::escape_string( $catalogue['company_address'] ) . "',
            cheque_message	= '" . Database::escape_string( $catalogue['cheque_message'] ) . "',
            cc_payment_message	= '" . Database::escape_string( $catalogue['cc_payment_message'] ) . "',
            installment_payment_message	= '" . Database::escape_string( $catalogue['install_payment_message'] ) . "',
            options_selection	= '" . Database::escape_string( $catalogue['opt_selection_text'] ) . "',
            terms_conditions	= '" . Database::escape_string( $catalogue['termsconditions'] ) . "',
            tva_description	= '" . Database::escape_string( $catalogue['tvadescription'] ) . "',
            bank_details	= '" . Database::escape_string( $catalogue['bank_details'] ) . "' ,
            currency	= '" . $catalogue['catalog_currency'] . "' ";
        }
        else
        {     
            
            $sql = "UPDATE " . $catalogue_table . " SET " . " 
            title				= '" . Database::escape_string( $catalogue['title'] ) . "',
            economic_model		= '" . Database::escape_string( $catalogue['economic_model'] ) . "',
            visible				= '" . Database::escape_string( $catalogue['visible'] ) . "',
            payment 				= '" . implode( ',', $catalogue['payments'] ) . "',
            company_address	= '" . Database::escape_string( $catalogue['company_address'] ) . "',
            cheque_message	= '" . Database::escape_string( $catalogue['cheque_message'] ) . "',
            cc_payment_message	= '" . Database::escape_string( $catalogue['cc_payment_message'] ) . "',
            installment_payment_message	= '" . Database::escape_string( $catalogue['install_payment_message'] ) . "',
            options_selection	= '" . Database::escape_string( $catalogue['opt_selection_text'] ) . "',
            terms_conditions	= '" . Database::escape_string( $catalogue['termsconditions'] ) . "',
            tva_description	= '" . Database::escape_string( $catalogue['tvadescription'] ) . "',";
            if ( ! empty( $_FILES['file']['tmp_name'] ) )
            {
                $sql .= " company_logo 	= '" . $catalogue['company_logo'] . "',";
            }
            $sql .= " currency	= '" . $catalogue['catalog_currency'] . "', 
                bank_details	= '" . Database::escape_string( $catalogue['bank_details'] ) . "' WHERE id = " . $objCatalog['id'];
         
        }

        
        Database::query( $sql, __FILE__, __LINE__ );
        
        return true;   
    }
    
    
    public function getCatalogue()
    {
        $catalogue_table = Database :: get_main_table(TABLE_MAIN_CATALOGUE);        
        $sql = "SELECT * FROM $catalogue_table";
        $res = Database::query($sql,__FILE__,__LINE__);
        $num_rows = Database::num_rows($res);
        $row = Database::fetch_array($res);
        
        return $row;
    }
    
    
    
    public function getCatalogForm(FormValidator $form)
    {
        $objCatalog = new EcommerceCatalog();
        $catalogRow = $objCatalog->getCatalogue();
        
        $form->addElement('header', '', get_lang('CatalogueManagement'));
        
        $form->addElement('text', 'title', get_lang('Title'), 'class="focus";style="width:300px;"');
        
        $radios_economic_model[] = FormValidator :: createElement('radio', null, null, get_lang('Commercial'), '1');
        $radios_economic_model[] = FormValidator :: createElement('radio', null, null, get_lang('NonCommercial'), '0');
        $form->addGroup($radios_economic_model, 'economic_model', get_lang('EconomicModel'));
        
        $radios_visible[] = FormValidator :: createElement('radio', null, null, get_lang('Onhomepage'), '1');
        $radios_visible[] = FormValidator :: createElement('radio', null, null, get_lang('NotVisible'), '0');
        $form->addGroup($radios_visible, 'visible', get_lang('Visible'));
        
        $form->addElement('html','</table>');
        
        $form->addElement('html','<table width="100%" border="0"><tr><td><div class="row"><div class="label">'.get_lang('PaymentMethods').'</div><div class="formw"><input name="payment_methods[]" type="checkbox" value="Online"');
        
        if(strpos($catalogRow['payment'],"Online") !== false){
            $form->addElement('html',' checked ');
        }
        
        $form->addElement('html','>'.get_lang('Online').'<input name="payment_methods[]" type="checkbox" value="Cheque"');
        if(strpos($catalogRow['payment'],"Cheque") !== false){
            $form->addElement('html',' checked ');
        }
        
        $form->addElement('html','>'.get_lang('Cheque'));
        
        $form->addElement('html','</div></div></td></tr>');
        $form->addElement('html','</table>');
        
        /*$form->addElement('header', '', get_lang('EcommerceCatalogTypeTitle'));
        
        foreach($objCatalog->getCatalogTypeOptions() as $catalogOptions)
        {
            $radios_catalog_type[] = FormValidator :: createElement('radio', null, null, get_lang($catalogOptions->display_text), $catalogOptions->value);
        }
        $form->addGroup($radios_catalog_type, 'catalog_type', get_lang('CatalogType'));
        $defaults['catalog_type'] = intval( $objCatalog->getCatalogSettings()->selected_value , 10 );*/
        
        // adding currency
        $form->addElement('header', '', get_lang('EcommerceCatalogCurrency'));
        $arCurrencyOptions = $objCatalog->getValidCatalogCurrencyOptions();
        
        $radiosCurrencyOptions = array();
        
        foreach( $arCurrencyOptions['options'] as $currencyOptions)
        {
            $radiosCurrencyOptions[] = FormValidator :: createElement('radio', null, null, get_lang($currencyOptions->display_text), $currencyOptions->value);
        }
        
        $form->addGroup($radiosCurrencyOptions, 'catalog_currency', get_lang('Currency'));
        $defaults['catalog_currency'] = intval( $arCurrencyOptions['selected'] , 10 );
        
        $form->addElement('header', '', get_lang('InvoicingInformation'));
        $form->addElement('file', 'file', get_lang('CompanyLogo'), 'size="40"');
        
        $form->addElement('textarea','company_address',get_lang('CompanyAddress'),array ('rows' => '3', 'cols' => '60'));
        $form->addElement('textarea','bank_details',get_lang('BankDetails'),array ('rows' => '3', 'cols' => '60'));
        
        $editor_config = array('ToolbarSet' => 'Catalogue', 'Width' => '100%', 'Height' => '180');
        
        // Option selection message
        $form->addElement ('html','<div class="HideFCKEditor" id="HiddenFCKexerciseDescription" >');
        $form->add_html_editor('opt_selection_text', get_lang('OptionsSelectionText'), false, false, $editor_config);
        $form->addElement ('html','</div>');
        
        
        // Payment Messages
        $form->addElement('header', '', get_lang('PaymentMethodsMessage'));
        $form->addElement ('html','<div class="HideFCKEditor" id="HiddenFCKexerciseDescription" >');
        $form->add_html_editor('cc_payment_message', get_lang('CreditCartPaymentMessage'), false, false, $editor_config);
        $form->addElement ('html','</div>');
        
        // Installment Payment
        //$form->addElement ('html','<div class="HideFCKEditor" id="HiddenFCKexerciseDescription" >');
        //$form->add_html_editor('install_payment_message', get_lang('InstallmentPaymentMessage'), false, false, $editor_config);
        //$form->addElement ('html','</div>');
        
        // Cheque Payment
        $form->addElement ('html','<div class="HideFCKEditor" id="HiddenFCKexerciseDescription" >');
        $form->add_html_editor('cheque_message', get_lang('ChequeMessage'), false, false, $editor_config);
        $form->addElement ('html','</div>');
        
        /*
         $form->addElement('static','',get_lang('Email'),get_lang('EmailMessage'));
        $radios_email[] = FormValidator :: createElement('radio', null, null, get_lang('Yes'), '1');
        $radios_email[] = FormValidator :: createElement('radio', null, null, get_lang('No'), '0');
        $form->addGroup($radios_email, 'email', '');
        */
        
        $form->addElement('header', '', get_lang('InformationPages'));
        $editor_config = array('ToolbarSet' => 'Catalogue', 'Width' => '100%', 'Height' => '180');
        
        $form->addElement ('html','<div class="HideFCKEditor" id="HiddenFCKexerciseDescription" >');
        $form->add_html_editor('termsconditions', get_lang('TermsAndConditions'), false, false, $editor_config);
        $form->addElement ('html','</div>');
        
        $form->addElement ('html','<div class="HideFCKEditor" id="HiddenFCKexerciseDescription" >');
        $form->add_html_editor('tvadescription', get_lang('TvaDescription'), false, false, $editor_config);
        $form->addElement ('html','</div>');
        
        $form->addElement('style_submit_button', 'submit', get_lang('Ok'), 'class="save"');
        
        
        
        if( $catalogRow === false)
        {
            $defaults['economic_model'] = 1;
            $defaults['visible'] = 1;
        }
        else
        {
        
            $defaults['title'] = $catalogRow['title'];
            $defaults['economic_model'] = $catalogRow['economic_model'];
            $defaults['visible'] = $catalogRow['visible'];
            /*$defaults['atos_acno'] = $catalogRow['atos_account_number'];
             $defaults['paypal_account_ref'] = $catalogRow['paypal_account_ref'];
            $defaults['option_selection'] = $catalogRow['options_selection'];
            $defaults['payment_message'] = $catalogRow['payment_message'];
            $defaults['cc_payment_message'] = $catalogRow['cc_payment_message'];
            $defaults['installment_payment_message'] = $catalogRow['installment_payment_message'];
            $defaults['cheque_payment_message'] = $catalogRow['cheque_payment_message'];*/
            $defaults['termsconditions'] = $catalogRow['terms_conditions'];
            $defaults['tvadescription'] = $catalogRow['tva_description'];
        
            $defaults['company_address'] = $catalogRow['company_address'];
            $defaults['bank_details'] = $catalogRow['bank_details'];
        
            $defaults['opt_selection_text'] = $catalogRow['options_selection'];
            $defaults['cc_payment_message'] = $catalogRow['cc_payment_message'];
            $defaults['cheque_message'] = $catalogRow['cheque_message'];
            //$defaults['install_payment_message'] = $row['installment_payment_message'];
            //$defaults['email'] = $row['email'];
        }
        
        $form->setDefaults($defaults);
        
        
        return $form;
    }

}