<?php
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueInterface.php';
require_once api_get_path( SYS_PATH ) . 'main/core/dao/ecommerce/CatalogueDao.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/CatalogueModel.php';
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/Currency.php';

class CatalogueCourseModel extends CatalogueModel implements CatalogueInterface
{
    public static function create()
    {
        return new CatalogueCourseModel();
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
                    $response = $row;
                }
            }
        }
        return $response;
    }
    
    public function getCourseEcommerceData( $from = 0, $number_of_items = 100, $column = 1, $direction = ' ASC ', $get = array() , $payment = 1)
    {
        $courses = array ();
        
        $tableMainCourse = Database::get_main_table( TABLE_MAIN_COURSE );
        $tableEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        
        $sql = "SELECT c.code as col0, c.title  as col1,c.visibility  as col2,ce.cost as col3,
        ce.status as col4,ce.date_start as col5,ce.date_end as col6 FROM $tableMainCourse AS c
        JOIN $tableEcommerceItems AS ce ON c.code = ce.code WHERE ce.item_type = '" . CatalogueModel::TYPE_COURSE . "'";
        
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
        $sql .= " AND payment = $payment ";
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
                    $course[0], $course[0], $course[1], $course[2], $course[3], $course[5], $course[6], $course[4], $course[0] );
                
                $courses[] = $course_rem;
            }
        }
        
        return $courses;
    }
    
    public function saveItemEcommerce(array $catalog)
    {
        $tblEcommerceItems = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        $courseCode = (isset( $catalog['wanted_code'] )) ? $catalog['wanted_code'] : ((isset( $catalog['course_code'] )) ? $catalog['course_code'] : '');
        $dateStart = (isset( $catalog['date_start'] )) ? $catalog['date_start'] : '';
        $dateEnd = (isset( $catalog['date_end'] )) ? $catalog['date_end'] : '';
        $status = (isset( $catalog['status'] )) ? $catalog['status'] : '0';
        $cost = (isset( $catalog['cost'] )) ? $catalog['cost'] : '0';
        $visibility = (isset( $catalog['visibility'] )) ? $catalog['visibility'] : '0';
        // e_commerce_catalog_type 2 Courses
        
        $sql = "SELECT * FROM $tblEcommerceItems WHERE code='$courseCode' AND item_type = '" . CatalogueModel::TYPE_COURSE . "' LIMIT 1";
        
        $result = Database::query( $sql, __FILE__, __LINE__ );
        
        $row = Database::fetch_row( $result );
        
        if ( $row === FALSE )
        {
            $sql = "INSERT INTO $tblEcommerceItems ( `code`,`cost`,`item_type`,`status`,
            `currency`, `date_start`, `date_end`) VALUES (
            '$courseCode','0.00', '" . CatalogueModel::TYPE_COURSE . "', 0 ,
            0,now(),$dateEnd)";
        
        } else
        {
            $sql = "UPDATE $tblEcommerceItems SET `status` = '$status',
            `date_start`= '$dateStart' , `date_end` = '$dateEnd', `cost` = '$cost'
            WHERE  code='$courseCode' AND item_type =  '" . CatalogueModel::TYPE_COURSE . "' ";
        }
        Database::query( $sql, __FILE__, __LINE__ );
        
        return Database::affected_rows();
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
    public function registerItemsForUser( array $session, array $transactionResult, $userId )
    {
        $courseCodes = array_keys($session['shopping_cart']['items']);

        foreach( $courseCodes as $courseCode)
        {
            /** @var $objCourse EcommerceCourse */
            
            $objItem = EcommerceItemsDao::create()->getByCourseCode($courseCode);
            
            
            $params = array();
            $params['user_id'] =  $userId; 
            $params['ecommerce_items_id'] = $objItem->id;
            $params['role'] = '5';
            $params['group_id'] = '';
            $params['tutor_id'] = '';
            $params['sort'] = $objItem->id;
            $params['user_course_cat'] = '';
            
            EcommerceUserPrivilegesDao::create()->save($params);
        }
                
        
        return true;

    }
    public function registerItemsIntoUser(array $session,$userId){
       $courseCodes = array_keys($session['shopping_cart']['items']);
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
        $courses = array ();
        
        $courses = EcommerceCourseDao::create()->getListOfEcommerceCourses( EcommerceCourse::ECOMMERCECOURSE_STATUS_ACTIVE );
        
        $response .= '<div style="width:95%;padding-left:5px;"><div class="section" style="padding-left:20px;line-height:2.5em;width: 95.5%;">';
        $response .= '<div class="row"><div class="form_header">' . get_lang( 'Courses' ) . '</div></div>';
        $response .= '<div><table width="100%" id="shoppingCartCatalog" rel="course">';
        
        $i = 0;
        
        /*
         * @var $course EcommerceCourse
         */
        foreach ( $courses as $course )
        {
            
            if ( $i % 3 == 0 )
            {
                $response .= '<tr>';
            }
            
            $courseFull = $course->getCourseFull();
            $langPrice = get_lang( 'Price' );
            $langAddToCart = get_lang( 'AddToCart' );
            
            $objItem = CatalogueManager::create()->getObject();
            $currencyIsoCode = $objItem->getDefaultCatalogue();
            
            $currency = Currency::create()->getCurrencyByIsoCode( $currencyIsoCode->currency );
            $currency = $currency['symbol'];
            
            $response .= <<<EOF
<td width="33%" valign="top">
    <div class="course_catalog_container" rel="{$courseFull->code}">
        <a href="main/catalogue/course_details.php?course_code={$courseFull->code}">
            <font size="2"><b>{$courseFull->title}</b></font>
        </a><br />
        <p>{$langPrice}: {$currency} {$course->cost}</p>
        <p><a href="" class="addToCartCourse addToCartCourseClick"><span>{$langAddToCart}</span></a></p>        
    </div>
</td>            
EOF;
            
            if ( $i % 6 == 0 && $i != 0)
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
