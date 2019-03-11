<?php


function dd(...$vals) {
    foreach ($vals as $val) {
        var_dump($val);
        exit();
    }
}

function view($page, $title, $data = []) {
    $result = new \root\Viewer($page, $title, $data);
    $result->getPage();
}

function isAuth() {
    $session_token = isset($_SESSION['user_details']['access_token']) ? $_SESSION['user_details']['access_token'] : null;
    $user = null;
    $email_verified = null;

    if ($session_token) {
        if($_SESSION['user_details']['email_verified'] === '') {
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

function session_get($key, $value = null) {
    if ($value !== null) {
        return isset($_SESSION[$key][$value]) ? $_SESSION[$key][$value] : null;
    } else {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

}

function cookie_get($key) {
    if (isset($_COOKIE[$key])) {
        return true;
    }
    return false;
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

function get_avatar_name($user_id) {
    if (is_string($user_id)) {
        $user_id = (int)$user_id;
    }
    $avatar = \app\Models\images::query()->where('user_id', '=', $user_id)->get('name');
    return $avatar[0]['name'];
}

function upload_image() {
    $name = $_FILES['avatar']['name'];
    $extention = explode('.', $name);
    $imgName = rand() . '.' . $extention[1];
    $tmp = $_FILES['avatar']['tmp_name'];
    $path = './public/uploads/' . $imgName;
    move_uploaded_file($tmp, $path);
    return $imgName;
}

function middleware($condition) {
    return new \root\Middleware($condition);
}