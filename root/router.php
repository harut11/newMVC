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
                session_unset();
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