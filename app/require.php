<?php 
    //Composer
    require_once '../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    //Config
    require_once 'config/coinfig.php';
    // ORM, ki bo bil implementiran kasnje
    require 'libraries/readbean/rb.php';

    //Knjižnice
    require_once 'libraries/Core.php';
    require_once 'libraries/Controller.php';
    require_once 'libraries/Database.php';

    //Helperji
    require_once 'helpers/decode.php';
    require_once 'helpers/session_helper.php';
    require_once 'helpers/getUrlParam.php';  
      
   
    //R::setup(); 
    $init = new Core();