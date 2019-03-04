<?php

namespace root;

class router
{
    private static $instance = null;

    private function __construct()
    {
        return $this->getAction();
    }

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function setController($action)
    {
        $controllerName = null;

        switch ($action) {
            case 'index':
                unset($_SESSION['errors']);
                unset($_SESSION['old']);
                $controllerName = 'Home';
                break;
            case 'login':
                $controllerName = 'Auth';
                break;
            case 'register':
                $controllerName =  'Auth';
                break;
            case 'registersubmit':
                $controllerName = 'Auth';
                break;
            case 'loginsubmit':
                $controllerName = 'Auth';
                break;
            case 'verify':
                $controllerName = 'Auth';
                break;
            case 'logout':
                $controllerName = 'Auth';
                break;
        }
        $controller = "\\app\\Controllers\\{$controllerName}Controller";
        return new $controller();
    }

    private function getAction()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $path = explode('/', parse_url($uri, PHP_URL_PATH));
        $action = $path[1] ? strtolower($path[1]) : 'index';

        return $this->setController($action)->$action();
    }
}