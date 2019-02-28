<?php

namespace root;

use app\Controllers\HomeController;
use app\Controllers\AuthController;

class router
{
    private static $instance = null;

    private function __construct()
    {
        $action = $this->getAction();
        $result = $this->setController();
        return $result->$action();
    }

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function setController()
    {
        $action = $this->getAction();
        $controller = null;

        switch ($action) {
            case 'index':
                $controller = new HomeController();
                break;
            case 'login':
                $controller = new AuthController();
                break;
            case 'register':
                $controller =  new AuthController();
                break;
            default:
                break;
        }
        return $controller;
    }

    private function getAction()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $path = explode('/', parse_url($uri, PHP_URL_PATH));
        $action = $path[1] ? $path[1] : 'index';

        return strtolower($action);
    }
}