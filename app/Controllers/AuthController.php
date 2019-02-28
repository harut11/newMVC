<?php

namespace app\Controllers;

class AuthController
{
    public function login()
    {
        echo view('auth.login', 'Welcome to Login page!');
    }

    public function register()
    {
        echo view('auth.register', 'Welcome to Register page!');
    }
}