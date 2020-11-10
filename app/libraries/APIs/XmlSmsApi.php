<?php 
    class XmlSmsApi {
        private $url = 'https://api.smsglobal.com/soap/soapserver.php?wsdl';
        private $password = XML_SMS_API_PASSWORD;
        private $username = XML_SMS_API_USER;
        private $telefon = TELEFON;

        

        
        
        public function posljiSms($to, $msg) {
            $soapclient = new SoapClient($this->url);
            $token = $soapclient->apiValidateLogin(['user' => $this->username, 'password' => $this->password]);
            $param = ['ticket'=> $token, 'sms_form' => $this->telefon, 'sms_to' => $to, 'msg_content' => $msg];
            $response = $soapclient->apiSendSms($param);

            $array = json_decode(json_encode($response), true);
            // Initialisation

            
            return $array;
        }
    }