<?php

namespace root;

use app\Controllers\HomeController;

class router
{
    public function __construct()
    {
        $action = $this->getAction();

       $result = $this->setController();
       $result->$action();
    }

    public function setController()
    {
        $action = strtolower($this->getAction());
        $controller = null;

        switch ($action) {
            case 'index':
                $controller = new HomeController();
                break;
            case 'login':
                $controller = new \app\Controllers\AuthController();
                break;
            case 'register':
                $controller =  new \app\Controllers\AuthController();
                break;
            default:
                break;
        }
        return $controller;
    }

    public function getAction()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $path = explode('/', parse_url($uri, PHP_URL_PATH));
        $action = $path[1] ? $path[1] : 'index';

        return $action;
    }
}