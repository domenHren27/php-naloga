<?php 
    //Bodoča implementacija callbacka
    function getUrlParam() {
        if(isset($_GET['url'])) {
            //trima
            $url = rtrim($_GET['url'], '/');
            //odstranimo pot. škod. simbole
            $url = filter_var($url, FILTER_SANITIZE_URL);
            //Razbijemo v array
            $url = explode('/', $url);
            
            if(!empty($url[2])) {
                if(is_numeric($url[2])) {
                    return $url[2];
                } else {
                    echo "Bad parameter";
                }                
            }
            else {
                echo "Ta Stran ne obstaja";
            }
        }
    }