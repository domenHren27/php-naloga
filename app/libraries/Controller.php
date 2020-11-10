<?php 
    //Load the model and the view
    class Controller {
        public function model($model) {
            //Require model 
            require_once '../app/models/' . $model . '.php';
            return new $model();
        }

        public function view($view, $data = [])
        {
            if (file_exists('../app/views/' . $view . '.php')) {
                require_once '../app/views/' . $view . '.php';
            } 
            else {
                //Lahko bi implementirali error loging
                die("View dose not exists");
            }
        }

        public function api($api) {
            //Require model 
            require_once '../app/libraries/APIs/' . $api . '.php';
            return new $api();
        }
    }
