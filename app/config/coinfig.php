<?php 
    //Database params
    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_USER', $_ENV['DB_USER']); 
    define('DB_PASS', $_ENV['DB_PASS']); 
    define('DB_NAME', $_ENV['DB_NAME']); 
    
    //APPROOT
    define('APPROOT', dirname(dirname(__FILE__))); // php-leanr\app root 

    //URLROOT
    define('URLROOT', $_ENV['URLROOT']);

    //Sitename
    define('SITENAME', 'SMS aplikacija');

    //API-s
    define('SMS_API_USER', $_ENV['SMS_API_USER']);
    define('SMS_API_PASSWORD', $_ENV['SMS_API_PASSWORD']);
    define('XML_SMS_API_USER', $_ENV['XML_SMS_API_USER']);
    define('XML_SMS_API_PASSWORD', $_ENV['XML_SMS_API_PASSWORD']);

    //Number
    define('TELEFON', $_ENV['TELEFON']);
    