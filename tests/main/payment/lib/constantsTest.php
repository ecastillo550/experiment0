<?php
require_once '../../../simpletest/autorun.php';
require_once '../../../simpletest/unit_tester.php';
require_once '../../../../main/inc/global.inc.php';
class constantTest extends UnitTestCase
{    
    public function __construct()
    {
        $this->UnitTestCase( 'Determine the tabs function tests' );
    }
    
    public function testGetTabs()
    {
        global $_course, $rootAdminWeb, $_user;
        ob_start();//
        require_once (api_get_path( SYS_CODE_PATH ) . 'payment/lib/constants.php');
        ob_end_clean();
        
        $this->assertEqual( API_USERNAME, 'a' );
        $this->assertEqual( API_PASSWORD, 'b' );
        $this->assertEqual( API_SIGNATURE, 'c' );

    }

}