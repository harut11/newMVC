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
                setcookie('username', '', time() - 3600);
                setcookie('must_verify', '', time() - 3600);
                setcookie('email_verified_success', '', time() - 3600);
                setcookie('email_already_verified', '', time() - 3600);
                $controllerName = 'Home';
                break;
            case 'login':
                middleware('guest');
                $controllerName = 'Auth';
                break;
            case 'register':
                middleware('guest');
                $controllerName =  'Auth';
                break;
            case 'registersubmit':
                middleware('guest');
                $controllerName = 'Auth';
                break;
            case 'loginsubmit':
                middleware('guest');
                $controllerName = 'Auth';
                break;
            case 'verify':
                $controllerName = 'Auth';
                break;
            case 'logout':
                middleware('auth');
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