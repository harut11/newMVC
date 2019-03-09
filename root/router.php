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
            case 'deleteaccount':
                middleware('auth');
                $controllerName = "Auth";
                break;
            case 'details':
                middleware('auth');
                $controllerName = 'User';
                break;
            case 'allusers':
                middleware('auth');
                $controllerName = 'User';
                break;
            case 'showusers':
                middleware('auth');
                $controllerName = 'User';
                break;
            case 'friends':
                middleware('auth');
                $controllerName = 'User';
                break;
            case 'showfriends':
                middleware('auth');
                $controllerName = 'User';
                break;
            case 'friendrequest':
                middleware('auth');
                $controllerName = 'User';
                break;
            case 'notifications':
                $controllerName = 'User';
                break;
        }
        $controller = "\\app\\Controllers\\{$controllerName}Controller";
        return new $controller();
    }

    private function getAction()
    {
        $url = $_SERVER['REQUEST_URI'];
        $path = explode('/', parse_url($url, PHP_URL_PATH));
        $action = $path[1] ? strtolower($path[1]) : 'index';
        $token = parse_url($url, PHP_URL_QUERY);

        return $this->setController($action)->$action($token);
    }
}