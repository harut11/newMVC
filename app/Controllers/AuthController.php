<?php

namespace app\Controllers;

use app\Models\users;
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
            'email' => 'required|email|unique',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|confirm'
        ]);

        $token = generate_token();

        users::query()->create([
            'first_name' => $_REQUEST['first_name'],
            'last_name' => $_REQUEST['last_name'],
            'email' => $_REQUEST['email'],
            'password' => bcrypt($_REQUEST['password']),
            'email_verified' => $token
        ]);

        send_email($_REQUEST['email'], $token);
        redirect('/');
    }

    public function verify()
    {
        $url = $_SERVER['REQUEST_URI'];
        $token = explode('token=', parse_url($url, PHP_URL_QUERY));

        $user = users::query()->where('email_verified', '=', $token[1])->getAll();

        if (!$user) {
            return view('email.success', 'Verification Message');
        } else {
            return view('email.verified', 'Verification Message');
        }
    }
}