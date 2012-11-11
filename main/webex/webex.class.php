<?php
/* For licensing terms, see /dokeos_license.txt */


/*
 * Load webex connect apis
 */
class WebexServices 
{
    /* webex account administrator */
    const UID = 'thomas.depraetere@zoho.com';
    const PWD = 'Isaac21';
    const SID = '550833';
    const PID = '550do';
    const XML_SITE = 'dokeos.webex.com';
    const XML_PORT = 443;
    
    protected $xsiType = array();
    protected $webexUrl;
    public  $message; 
    
    /**
     * Constructor
     */
    public function __construct() {
        
        $this->xsiType = array(
                            'LstsummaryMeeting' => 'java:com.webex.service.binding.meeting.LstsummaryMeeting',
                            'createMeeting'     => 'meet:createMeeting',
                            'setMeeting'        => 'java:com.webex.service.binding.meeting.SetMeeting',
                            'getMeeting'        => 'java:com.webex.service.binding.meeting.GetMeeting',
                            'delMeeting'        => 'java:com.webex.service.binding.meeting.DelMeeting',
                            'getjoinurlMeeting' => 'java:com.webex.service.binding.meeting.GetjoinurlMeeting',
                            'gethosturlMeeting' => 'java:com.webex.service.binding.meeting.GethosturlMeeting',
                            'createUser'        => 'java:com.webex.service.binding.user.CreateUser',
                            'lstsummaryUser'    => 'java:com.webex.service.binding.user.LstsummaryUser',
                            'getUser'           => 'java:com.webex.service.binding.user.GetUser',
                            'delUser'           => 'java:com.webex.service.binding.user.DelUser',                                      
                            'authenticateUser'  => 'java:com.webex.service.binding.user.AuthenticateUser',
                            'getloginurlUser'   => 'java:com.webex.service.binding.user.GetloginurlUser',
                            'getLoginTicket'    => 'java:com.webex.service.binding.user.GetLoginTicket'
        );
        $this->webexUrl = "http://" . self::XML_SITE . "/WBXService/XMLService";
        
    }
    
    /**
     * Call webex services by action
     * @param   string      action (xsi type) 
     */
    public function call($action, $params = array()) {
        $xml = $this->getStringXml($action, $params);
        return $this->postIt($xml);        
    }
    
    /**
     * Get string xml for webex api service
     * @param   string      Action (xsi type)
     * @return  string      Xml
     */
    public function getStringXml($action, $params = array()) {
        
        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $xml .= "<serv:message xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:serv=\"http://www.webex.com/schemas/2002/06/service\">";

        $xml .= $this->getXmlHeader($params['username'], $params['password'], $params['email']);
        
        $xml .= $this->getXmlBody($action, $params['elements'], $params['ns']);
        
        $xml .= "</serv:message>";
        return $xml;
    }
    
    /**
     * Get Xml Header for webex apis services
     * @param   string   Optional username
     * @param   string   Optional password
     * @return  string   Header xml string 
     */
    public function getXmlHeader($username = null, $password = null, $email = null) {        
        $header  = "<header>";
        $header .= "<securityContext>";
        $header .= "<webExID>".(isset($username)?$username:self::UID)."</webExID>";
        $header .= "<password>".(isset($password)?$password:self::PWD)."</password>";
        $header .= "<siteID>".self::SID."</siteID>";
        $header .= "<partnerID>".self::PID."</partnerID>";
        if (isset($email)) {
            $header .= "<email>".$email."</email>";
        }
        $header .= "</securityContext>";
        $header .= "</header>";        
        return $header;                
    }
    
    /**
     * Get Xml body for webex apis services
     * @param   string  Action (xsi type)
     * @param   array   Elements xml
     * @return  string  body xml string
     */
    public function getXmlBody($xsiType, $elements = array(), $ns = '') {
        
        $body  = "<body>";
        $body .= "<bodyContent xsi:type=\"" . $this->xsiType[$xsiType] . "\" xmlns:meet=\"http://www.webex.com/schemas/2002/06/service/meeting\">";
        
        $body .= $this->getXmlBodyContent($elements, $ns);

        $body .= "</bodyContent>";
        $body .= "</body>";
        
        return $body;
    }
    
    /**
     * get Meeting xml body content
     */
    public function getXmlBodyContent($elements, $ns = '') {        
        $content = '';
        if (!empty($ns)) { $ns = $ns.':'; }
        if (is_array($elements)) {
            foreach ($elements as $element => $value) {
                $content .= '<'.$ns.$element.'>';
                if (is_array($value)) {
                    foreach ($value as $element2 => $value2) {
                        $content .= '<'.$ns.$element2.'>';
                        if ($element == 'participants') {
                                if (count($value2) > 0) {
                                    foreach($value2 as $user) {
                                        $content .= "<meet:attendee>";
                                        $content .= "   <att:person>";
                                        $content .= "       <com:name>".$user['username']."</com:name>";
                                        $content .= "       <com:email>".$user['mail']."</com:email>";
                                        $content .= "   </att:person>";
                                        $content .= "   <att:role>ATTENDEE</att:role>";
                                        $content .= "   <att:emailInvitations>true</att:emailInvitations>";
                                        $content .= "   <att:timeZoneID>23</att:timeZoneID>";
                                        $content .= "</meet:attendee>";
                                    }
                                }
                        }
                        else {
                            $content .= $value2;
                        }
                        $content .= '</'.$ns.$element2.'>';
                    }
                } 
                else {
                    $content .= $value;
                }
                $content .= '</'.$ns.$element.'>';
            }
        }
        return $content;        
    }
    
    /**
     * Send service to webex
     * @param   string     xml string
     * @return  string     xml response from webex
     */
    public function postIt($xml) {
      //  Strip http:// from the URL if present
      $url = preg_replace("%^http://%", "", $this->webexUrl);
      if (strpos($this->webexUrl, 'http://') !== FALSE) {
          $url = str_replace('http://', '', $this->webexUrl);
      } 
      
      
      //  Separate into Host and URI
      $Host = substr($url, 0, strpos($url, "/"));
      $URI = strstr($url, "/");     
      $url = $Host;
      
      
      
      $fp = fsockopen($url, 80, $errno, $errstr);
      $Post = "POST /WBXService/XMLService HTTP/1.0\n";
      $Post .= "Host: $url\n";
      $Post .= "Content-Type: application/x-www-form-urlencoded\n";
      $Post .= "Content-Length: " . strlen($xml) . "\n\n";
      $Post .= "$xml\n";
      /*if ($this->Debug_Mode) {
         echo "<hr>XML Sent:<br><textarea cols=\"50\" rows=\"25\">" . htmlspecialchars($xml) . "</textarea><hr>";
      }*/
      if ($fp) {
         fwrite($fp, $Post);
         $response = "";
         while (!feof($fp)) {
            $response .= fgets($fp, 1024);
         }
         $response = strstr($response, '<?xml version="1.0" encoding="UTF-8"?>');
         $response = str_replace('meet:', '', $response);
         $response = str_replace('serv:', '', $response);
         $response = str_replace('use:', '', $response);
         $response = str_replace('att:', '', $response);
         $response = str_replace('com:', '', $response);
         if ($this->Debug_Mode) {
            echo "<br>XML Received:<br><textarea cols=\"50\" rows=\"25\">" . htmlspecialchars($response) . "</textarea><hr>";
         }         
         return $response;
      } else {
         echo "$errstr ($errno)<br />\n";
         return false;
      }
   }
   
   /**
    * Check if webex service has an error 
    * @param    object      Response
    * @return   boolean
    */
   public function isError($result) {
      $simpleXml = @simplexml_load_string($result);      
      $response = $simpleXml->header->response;
      $result = (string)$response->result;
      if($result === "FAILURE"){
         $this->message = (string)$response->reason;
         return true;
      }
      return false;
   }
   
}


?>
