<?php

define('BASE_PATH', dirname(__FILE__));
define('SEPARATOR', DIRECTORY_SEPARATOR);

require BASE_PATH . SEPARATOR . 'root' . SEPARATOR . 'functions.php';

spl_autoload_register(function ($className) {
    $class = BASE_PATH . SEPARATOR . $className . '.php';
   if(file_exists($class)) {
       ob_start();
       require_once $class;
       return ob_get_clean();
   } else {
       echo 'Class not found';
       exit();
   }
});

getRouter();