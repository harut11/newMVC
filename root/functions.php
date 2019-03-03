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
    if(10 > 0) {
        return true;
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