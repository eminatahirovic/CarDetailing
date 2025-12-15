<?php

//Reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED)); 
error_reporting(E_ALL);



// DB credentials

define('DB_NAME', 'carDetailing');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1'); //localhost
define('JWT_SECRET', 'password'); // JWT Secret Key Definition

class Config {
  public static function JWT_SECRET() {
    return JWT_SECRET;
  }
}