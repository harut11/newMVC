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
    return new \root\router();
}

function redirect($url) {
    header('Location: ' . $url);
    exit();
}