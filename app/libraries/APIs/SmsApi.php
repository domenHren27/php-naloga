<?php 
    class SmsApi {
        private $url = 'http://www.smsapi.si/poslji-sms';
        private $apiUser = SMS_API_USER;
        private $apiPassword = SMS_API_PASSWORD;
        private $from = 'sms_app';
        private $cc = '386';

        
        
        public function posljiSms($to, $msg) {
            $data = array('un' => urlencode($this->apiUser),     //api username
              'ps' => urlencode($this->apiPassword),     //api pass
              'from' => urlencode($this->from),      //don't send as int
              'to' => urlencode($to),        //don't send as int
              'm' => urlencode($msg),  //msg
              'cc' => urlencode($this->cc)               //don't send as int 
             );
            // Initialisation
            $ch=curl_init();
             
            // Set parameters
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
         
            // Activate the POST method
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1) ;
             
            // Request
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
             
            // execute the connexion
            $result = curl_exec($ch);
             
            // Close it
            curl_close($ch);
             
            return $result;
        }
    }