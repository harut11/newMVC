<?php

namespace app\Controllers;

class AuthController
{
    public function __construct()
    {

    }

    public function login()
    {
        view('home.index', 'Hello World!');
    }
}