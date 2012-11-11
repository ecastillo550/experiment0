<?php
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueInterface.php';
require_once api_get_path( SYS_PATH ) . 'main/core/dao/ecommerce/CatalogueDao.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/Currency.php';

class CatalogueModuleModel extends CatalogueModel  implements CatalogueInterface
{
    public static function create()
    {
        return new CatalogueModuleModel();
    }
    
    public function getCourseByCode( $courseCode )
    {
        $tableMainCourse = Database::get_main_table( TABLE_MAIN_COURSE );
        $tableMainEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        
        $response = null;
        
        if ( trim( $courseCode ) != '' )
        {
            $sql = "SELECT c.code, c.title,c.visibility,ce.cost,ce.status,ce.date_start,ce.date_end FROM $tableMainCourse AS c
            JOIN $tableMainEcommerceItems AS ce ON c.code = ce.code WHERE ce.code = '$courseCode' AND item_type = '" . CatalogueCourseModel::TYPE_COURSE . "'LIMIT 1;";
            
            $result = Database::query( $sql, __FILE__, __LINE__ );
            
            $row = true;
            while ( $row )
            {
                $row = Database::fetch_object( $result );
                if ( $row !== FALSE )
                {
                    $response = $row[0];
                }
            }
        }
        return $response;
    }
    
    public function getCourseEcommerceData( $from = 0, $number_of_items = 100, $column = 1, $direction = ' ASC ', $get = array() )
    {
        $courses = array ();
        
        $tableEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        
        $sql = "SELECT c.id as col0,c.code as col1, c.cost as col2, c.status as col3,c.date_start as col4, c.date_end as col5 FROM $tableEcommerceItems  AS c
        WHERE c.item_type = '" . CatalogueModel::TYPE_MODULES . "'";
        
        if ( isset( $get['keyword'] ) )
        {
            $keyword = Database::escape_string( $get['keyword'] );
            $sql .= " AND  (title LIKE '%" . $keyword . "%' OR code LIKE '%" . $keyword . "%' OR visual_code LIKE '%" . $keyword . "%')";
        } elseif ( isset( $get['keyword_code'] ) )
        {
            $keyword_code = Database::escape_string( $get['keyword_code'] );
            $keyword_title = Database::escape_string( $get['keyword_title'] );
            $keyword_category = Database::escape_string( $get['keyword_category'] );
            $keyword_language = Database::escape_string( $get['keyword_language'] );
            $keyword_visibility = Database::escape_string( $get['keyword_visibility'] );
            $keyword_subscribe = Database::escape_string( $get['keyword_subscribe'] );
            $keyword_unsubscribe = Database::escape_string( $get['keyword_unsubscribe'] );
            $sql .= " AND (code LIKE '%" . $keyword_code . "%' OR visual_code LIKE '%" . $keyword_code . "%') AND title LIKE '%" . $keyword_title . "%' AND category_code LIKE '%" . $keyword_category . "%'  AND course_language LIKE '%" . $keyword_language . "%'   AND visibility LIKE '%" . $keyword_visibility . "%'    AND subscribe LIKE '" . $keyword_subscribe . "'AND unsubscribe LIKE '" . $keyword_unsubscribe . "'";
        }
        
        $sql .= " ORDER BY col$column $direction ";
        $sql .= " LIMIT $from,$number_of_items";
        
        $res = Database::query( $sql, __FILE__, __LINE__ );
        
        $course = TRUE;
        while ( $course )
        {
            $course = Database::fetch_row( $res );
            
            if ( $course !== FALSE )
            {
                $course_rem = array (
                    $course[0], $course[0], $course[1], $course[3], $course[2], $course[4], $course[5], $course[0] );
                $courses[] = $course_rem;
            }
        }
        
        return $courses;
    }
    
    public function saveItemEcommerce( array $module )
    {
        $tblEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        $tblEcommerceLpModulePack = Database::get_main_table( TABLE_MAIN_ECOMMERCE_LP_MODULE_PACKS );
        
        $ecommerceItemId = (isset( $module['id'] )) ? $module['id'] : '';
        $lpNameBlockName = (isset( $module['txtTitle'] )) ? $module['txtTitle'] : '';
        
        $lpModuleIds = (isset( $module['cboModules'] )) ? $module['cboModules'] : array ();
        
        $courseCode = (isset( $module['code'] )) ? $module['code'] : ((isset( $module['course_code'] )) ? $module['course_code'] : '');
        
        $dateStart = (isset( $module['date_start'] )) ? $module['date_start'] : '';
        $dateEnd = (isset( $module['date_end'] )) ? $module['date_end'] : '';
        
        $status = (isset( $module['status'] )) ? $module['status'] : '0';
        $cost = (isset( $module['cost'] )) ? $module['cost'] : '0.0';
        
        $courseCode = (isset( $module['code_course'] )) ? $module['code_course'] : '';
        // e_commerce_catalog_type 2 Courses
        
        $sql = "SELECT * FROM $tblEcommerceItems WHERE `id` = '$ecommerceItemId' LIMIT 1";
        
        $result = Database::query( $sql, __FILE__, __LINE__ );
        
        $row = Database::fetch_row( $result );
        
        if ( $row === FALSE )
        {
            $sql = "INSERT INTO $tblEcommerceItems ( `code`,`cost`,`item_type`,`status`,`currency`, `date_start`, `date_end`)
             VALUES ( '$lpNameBlockName','$cost', '" . CatalogueModel::TYPE_MODULES . "', $status ,0,'$dateStart','$dateEnd')";
            Database::query( $sql, __FILE__, __LINE__ );
            $idEcommerceItems = Database::insert_id();
            
            if ( count( $lpModuleIds ) > 0 )
            {
                foreach ( $lpModuleIds as $newLpModule )
                {
                    $sql = "INSERT INTO $tblEcommerceLpModulePack ( `ecommerce_items_id`,`lp_module_lp_module_id`,`lp_module_course_code`) VALUES (
                    '$idEcommerceItems','$newLpModule', '$courseCode') ";
                    Database::query( $sql, __FILE__, __LINE__ );
                }
            }
        } else
        {
            $sql = "UPDATE $tblEcommerceItems SET `code` = '$lpNameBlockName',`status` = '$status', 
            `date_start` = '$dateStart', `date_end` = '$dateEnd', `cost` = '$cost'  WHERE `id` = '$ecommerceItemId'";
            Database::query( $sql, __FILE__, __LINE__ );
            
            $sql = "DELETE from $tblEcommerceLpModulePack WHERE `ecommerce_items_id` = '$ecommerceItemId' ";
            Database::query( $sql, __FILE__, __LINE__ );
            
            if ( count( $lpModuleIds ) > 0 )
            {
                foreach ( $lpModuleIds as $newLpModule )
                {
                    $sql = "INSERT INTO $tblEcommerceLpModulePack ( `ecommerce_items_id`,`lp_module_lp_module_id`,`lp_module_course_code`) VALUES (
                    '$ecommerceItemId','$newLpModule', '$courseCode') ";
                    Database::query( $sql, __FILE__, __LINE__ );
                }
            }
        }
        return Database::affected_rows();
    }
    
    public function saveEcommerceLpModule( array $catalog )
    {
        
        $tblEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        $tblEcommerceLpModule = Database::get_main_table( TABLE_MAIN_ECOMMERCE_LP_MODULE );
        
        $lpId = (isset( $catalog['lp_id'] )) ? $catalog['lp_id'] : '';
        $lpName = (isset( $catalog['title'] )) ? $catalog['title'] : '';
        $lpDescription = (isset( $catalog['description'] )) ? $catalog['description'] : '';
        
        $courseCode = (isset( $catalog['course_code'] )) ? $catalog['course_code'] : ((isset( $catalog['course_code'] )) ? $catalog['course_code'] : '');
        $dateStart = (isset( $catalog['date_start'] )) ? $catalog['date_start'] : '';
        $dateEnd = (isset( $catalog['date_end'] )) ? $catalog['date_end'] : '';
        $status = (isset( $catalog['status'] )) ? $catalog['status'] : '0';
        $cost = (isset( $catalog['cost'] )) ? $catalog['cost'] : '0';
        $visibility = (isset( $catalog['visibility'] )) ? $catalog['visibility'] : '0';
        
        $sql = "SELECT * FROM $tblEcommerceLpModule WHERE `course_code`='$courseCode' AND lp_module_id = '$lpId' LIMIT 1";
        
        $result = Database::query( $sql, __FILE__, __LINE__ );
        
        $row = Database::fetch_row( $result );
        
        if ( $row === FALSE )
        {
            
            $sql = "INSERT INTO $tblEcommerceLpModule (`lp_module_id`, `course_code`, `lp_title`, `lp_description`)
            VALUES ( '$lpId', '$courseCode', '$lpName', '$lpDescription' )";
        } else
        {
            $sql = "UPDATE $tblEcommerceLpModule SET `lp_title` = '$lpName', `lp_description` =  '$lpDescription' WHERE lp_module_id = '$lpId'";
        }
        
        Database::query( $sql, __FILE__, __LINE__ );
        
        return Database::affected_rows();
    }
    
    public function getById( $idItemEcommerce )
    {
        $tableMainCourse = Database::get_main_table( TABLE_MAIN_COURSE );
        $tableMainEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        
        $response = null;
        
        $idItemEcommerce = intval($idItemEcommerce , 10 );
        
            $sql = "SELECT ei.id, ei.code, ei.cost, ei.item_type, ei.status, ei.currency, ei.date_start, ei.date_end "
            ." FROM $tableMainEcommerceItems AS ei WHERE ei.id = '$idItemEcommerce' AND item_type = '" . CatalogueCourseModel::TYPE_MODULES . "'LIMIT 1;";
            
            $result = Database::query( $sql, __FILE__, __LINE__ );

            $row = true;
            while ( $row )
            {
                $row = Database::fetch_object( $result );
                if ( $row !== FALSE )
                {
                    $response = $row;
                }
            }
        
        return $response;
    
    } 
    
    
    public function getListOfEcommerceItems($status = NULL)
    {
        
        $response = array ();
        $tblEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        $sql = "SELECT * FROM $tblEcommerceItems WHERE item_type = " . CatalogueModel::TYPE_MODULES;
        if ( ! is_null( $status ) )
        {
            $status = intval( $status, 10 );
            $sql .= " AND status = '$status' ";
        }
        
        $rsCourses = Database::query( $sql );
        $row = TRUE;
        while ( $row )
        {
            $row = Database::fetch_object( $rsCourses,'EcommerceCatalogModules' );
            if ( $row !== FALSE )
            {
                $response[] = $row;
            }
        }
        return $response;
        
    }
    
    /**
     *@todo implement inherited method
     */
    public function getListForStudentPortal()
    {   
    }
    
    /* (non-PHPdoc)
     * @see CatalogueInterface::registerItemsForUser()
    */
    public function registerItemsForUser( array $session , array $transactionResult, $userId )
    {
        $modules = array_keys($session['shopping_cart']['items']);
        foreach( $modules as $module)
        {
            $params = array();
            $params['user_id'] =  $userId; 
            $params['ecommerce_items_id'] = $module;
            $params['role'] = '5';
            $params['group_id'] = '';
            $params['tutor_id'] = '';
            $params['sort'] = 0;
            $params['user_course_cat'] = '';
            
            EcommerceUserPrivilegesDao::create()->save($params);
        }
                
        
        return true;
    
    }
    public function registerItemsIntoUser(array $session,$userId){
       $modules = array_keys($session['shopping_cart']['items']);
       $courseCodes = array();
       foreach( $modules as $module) {
          $tblEcommerceLpModulePack = Database::get_main_table( TABLE_MAIN_ECOMMERCE_LP_MODULE_PACKS );
          $sql = "SELECT * FROM $tblEcommerceLpModulePack WHERE ecommerce_items_id = ".$module;
          $res = Database::query($sql);
          if(Database::num_rows($res) > 0){
             $objcourse = Database::fetch_object($res);
             if(!in_array($objcourse->lp_module_course_code, $courseCodes)){
                $courseCodes[] = $objcourse->lp_module_course_code;
             }
          }
       }
       foreach( $courseCodes as $courseCode) {
          $status = 5;
          if (CourseManager::add_user_to_course($userId, $courseCode, $status)) {
             $send = api_get_course_setting('email_alert_to_teacher_on_new_user_in_course', $courseCode);
             if ($send == 1) {
               CourseManager::email_to_tutor($userId, $courseCode, $send_to_tutor_also = false);
             } else if ($send == 2) {
               CourseManager::email_to_tutor($userId, $courseCode, $send_to_tutor_also = true);
             }
           }
       }
    }
	/* (non-PHPdoc)
     * @see CatalogueInterface::getShoppingCartList()
     */
    public function getShoppingCartList()
    {
         $response = '';
        $modules = array ();
        
        $modules = CatalogueModuleModel::create()->getListOfEcommerceItems( EcommerceCourse::ECOMMERCECOURSE_STATUS_ACTIVE );
        
        $response .= '<div style="width:95%;padding-left:20px;"><div class="section" style="padding-left:20px;line-height:2.5em;width: 95.5%;">';
        $response .= '<div class="row"><div class="form_header">' . get_lang( 'ModulePacks' ) . '</div></div>';
        $response .= '<div><table width="100%" id="shoppingCartCatalog" rel="module">';
        
        $i = 0;
        
        /*
         * @var $course EcommerceCourse
         */
        foreach ( $modules as $module )
        {
            
            if ( $i % 2 == 0 )
            {
                $response .= '<tr>';
            }
            
            // $courseFull = $module->getCourseFull();
            $langPrice = get_lang( 'Price' );
            $langAddToCart = get_lang( 'AddToCart' );
            
            $currencyIsoCode = CatalogueFactory::getObject()->getDefaultCatalogue();
            $currency = Currency::create()->getCurrencyByIsoCode( $currencyIsoCode->currency );
            $currency = $currency['symbol'];
            
            $response .= <<<EOF
<td width="33%" valign="top">
    <div class="course_catalog_container" rel="{$module->id}">
        <a href="main/catalogue/module_pack_details.php?id={$module->id}">
            <font size="2"><b>{$module->code}</b></font>
        </a><br />
        <p>{$langPrice}: {$currency} {$module->cost}</p>
        <p><a href="" class="addToCartCourse addToCartCourseClick"><span>{$langAddToCart}</span></a></p>        
    </div>
</td>            
EOF;
            
            if ( $i % 2 != 0 )
            {
                $response .= '</tr>';
            }
            
            $i ++;
        }
        $response .= '</table></div>';
        $response .= '</div></div>';
        
        return $response;
        
    }  
}
