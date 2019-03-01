<?php

namespace app\Controllers;

use root\forValidation;

class AuthController extends forValidation
{
    public function login()
    {
        echo view('auth.login', 'Welcome to Login page!');
    }

    public function register()
    {
        echo view('auth.register', 'Welcome to Register page!');
    }

    public function registersubmit()
    {
        $this->validate($_REQUEST, [
            'first_name' => 'required|min:3|max:40|string',
            'last_name' => 'required|min:4|max:50|string',
            'email' => 'required|mail'
        ]);
    }
}