<?php

require_once 'webex.class.php';

$webex = new WebexServices();

/*/
// Create a meeting
$params = array(
            'ns' => 'meet',
            'elements' => array (
                'accessControl' => array('meetingPassword' => '12345'),
                'metaData'      => array('confName' => 'Meetingxx01'),
                'enableOptions' => array('chat'=>'true', 'poll'=>'true', 'audioVideo'=>'true', 'autoDeleteAfterMeetingEnd'=>'false'),
                'schedule'      => array('startDate'=>'05/31/2004 10:10:10', 'timeZoneID'=>'23', 'duration'=>'20', 'openTime'=>'900')
            )    
);
$response = $webex->call('createMeeting', $params);
//*/

/*/
// Update a meeting
$params = array(
            'ns' => 'meet',
            'elements' => array (
                'metaData'      => array('confName' => 'Meetingxxxxx01'),
                'enableOptions' => array('chat'=>'true', 'poll'=>'true', 'audioVideo'=>'true', 'autoDeleteAfterMeetingEnd'=>'false'),
                'schedule'      => array('startDate'=>'05/31/2004 10:10:10', 'timeZoneID'=>'23', 'duration'=>'20', 'openTime'=>'900'),
                'meetingkey'    => '954059016',
                'participants'  => array('attendees' => array('username'=>'cfasanando1', 'mail'=>'newportal@dokeos.com'))
            )    
);
$response = $webex->call('setMeeting', $params);
//*/

/*/
// Delete a meeting
$params = array(
            'ns' => 'meet',
            'elements' => array (
                'meetingKey'    => '956970051'
            )    
);
$response = $webex->call('delMeeting', $params);
if ($webex->isError($response)) {
    var_dump($webex->message);
}
//*/

/*/
// Create a user
$params = array(
            'ns' => 'user',
            'elements' => array (
                'firstName' => 'Juan',
                'lastName'  => 'Lopez',
                'webExId'   => 'jlopez',
                'email'     => 'jlopez@gmail.com',
                'password'  => 'Aaa12345',
                'active'    => 'ACTIVATED',
                'schedulingPermission' => 'thomas.depraetere@zoho.com',
                'privilege' => array('host'=>'true')
            )    
);
$response = $webex->call('createUser', $params);
if ($webex->isError($response)) {
    var_dump($webex->message);
}
//*/ 
 
// deactive a user
$params = array(
            'ns' => 'user',
            'elements' => array (
                'webExId'   => 'jlopez',
                'syncWebOffice' => 'true'
            )    
);
$response = $webex->call('delUser', $params);
if ($webex->isError($response)) {
    var_dump($webex->message);
}



?>
