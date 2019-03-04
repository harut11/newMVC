<?php


function dd(...$vals) {
    if(is_array($vals)) {
        foreach ($vals as $val) {
            var_dump($val);
            exit();
        }
    }
    var_dump($vals);
    exit();
}

function view($page, $title) {
    $result = new \root\Viewer($page, $title);
    $result->getPage();
}

function isAuth() {
    $session_token = isset($_SESSION['access_token']) ? $_SESSION['access_token'] : null;
    $user = null;
    $email_verified = null;

    if ($session_token) {
        $email_verified = \app\Models\users::query()->where('access_token', '=', $session_token)
            ->get('email_verified');

        if($email_verified[0]['email_verified'] === '') {
            return true;
        }
        return false;
    }
    return false;
}

function getRouter() {
    return \root\router::getInstance();
}

function redirect($url) {
    header('Location: ' . $url);
    exit();
}

function get_connection() {
    return \root\Database\db::getInstance();
}

function session_get($key, $value) {
    return isset($_SESSION[$key][$value]) ? $_SESSION[$key][$value] : null;
}

function bcrypt($text) {
    return sha1($text);
}

function generate_token($length = 40) {
    $token = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $tokenlength = strlen($token);
    $newtoken = '';

    for ($i = 0; $i < $length; $i++) {
        $newtoken .= $token[rand(0, $tokenlength - 1)];
    }
    return $newtoken;
}

function send_email($email, $token) {
    $mailer =  new \root\mailer($email, $token);
    return $mailer->sendEmail();
}

function middleware($condition) {
    switch ($condition) {
        case 'auth':
            return isAuth();
            break;
        default:
            return true;
            break;
    }
}