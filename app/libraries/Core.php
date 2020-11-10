<?php 
    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct() 
        {
            $url = $this->getUrl();

            
            //Lokacija je še zemraj index.php
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                // Will set a new controller
                $this->currentController = ucwords($url[0]);
                //Zbrišemo value
                
                unset($url[0]);
            }

            //Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            
            
            //Instanciramo Controller class 
            $this->currentController = new $this->currentController;
            
            if (isset($url[1])) {
                if (method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            //Dodaj parametre
            $this->params = $url ? array_values($url) : [];

            //Call a callback with array of params Kličemo metodo na controller classu
            call_user_func_array([$this->currentController, $this->currentMethod],$this->params);
            
            
        }

        public function getUrl() {
            if(isset($_GET['url'])) {
                //trima
                $url = rtrim($_GET['url'], '/');
                //odstranimo pot. škod. simbole
                $url = filter_var($url, FILTER_SANITIZE_URL);
                //Razbijemo v array
                $url = explode('/', $url);
                return $url;
            }
        }
    }