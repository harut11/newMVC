<?php

define('BASE_PATH', dirname(__FILE__));
define('SEPARATOR', DIRECTORY_SEPARATOR);

require BASE_PATH . SEPARATOR . 'root' . SEPARATOR . 'functions.php';

session_start();

spl_autoload_register(function ($className) {
    $class = BASE_PATH . SEPARATOR . $className . '.php';
   if(file_exists($class)) {
       require_once $class;
   } else {
       echo 'Class not found';
       exit();
   }
});

getRouter();