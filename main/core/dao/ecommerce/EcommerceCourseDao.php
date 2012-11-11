<?php
require_once api_get_path( SYS_PATH ) . 'main/core/model/ecommerce/EcommerceCourse.php';
class EcommerceCourseDao
{
    public static function create()
    {
        return new EcommerceCourseDao();
    
    }
    
    public function getEcommerceCourseByCourseCode( $courseCode )
    {
        $response = null;
        $courseCode = trim( $courseCode );
        
        if ( $courseCode != '' )
        {
            $tableEcommerceCourse = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
            $sql = "SELECT * FROM $tableEcommerceCourse as ec WHERE ec.code= '$courseCode' LIMIT 1;";
            $result = Database::query( $sql, __FILE__, __LINE__ );
            /* @var $response EcommerceCourse */
            $response = Database::fetch_object( $result, 'EcommerceCourse' );
            
            if( ! is_null($response)  && is_object($response ))
            {
                $response->getCourseFull();
            }
            
        }
        
        return $response;
    }
    
    public function getEcommerceModuleByModuleCode( $moduleCode )
    {
        $response = null;
        $moduleCode = trim( $moduleCode );
        
        if ( $moduleCode != '' )
        {
            $tableEcommerceCourse = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
            $sql = "SELECT * FROM $tableEcommerceCourse as ec WHERE ec.id= '$moduleCode' LIMIT 1;";

            $result = Database::query( $sql, __FILE__, __LINE__ );
            /* @var $response EcommerceCourse */
            $response = Database::fetch_object( $result );
            
        }

        return $response;
    }
    /**
     * 
     * @param int $visibility
     * @return array of objects
     */
    public function getListOfEcommerceCourses( $visibility = NULL )
    {
        $response = array ();
        $tblCoursesEcommerce = Database::get_main_table( TABLE_MAIN_ECOMMERCE_ITEMS );
        $tblMainCourse = Database::get_main_table( TABLE_MAIN_COURSE );

        $sql = "SELECT ce.id,ce.code, ce.cost,ce.item_type,ce.status,ce.currency,ce.date_start,ce.date_end 
        FROM $tblCoursesEcommerce AS ce JOIN $tblMainCourse  AS c ON c.code = ce.code WHERE ce.item_type = '" . CatalogueModel::TYPE_COURSE . "' AND c.payment ='1'";       

        if ( ! is_null( $visibility ) )
        {
            $visibility = intval( $visibility, 10 );
            $sql .= " AND status = '$visibility' ";
        }
        
        $rsCourses = Database::query( $sql );

        $row = TRUE;
        while ( $row )
        {
            $row = Database::fetch_object( $rsCourses,'EcommerceCourse' );
            if ( $row !== FALSE )
            {                
                $response[] = $row;
            }
        }
        return $response;
    }
    
}
