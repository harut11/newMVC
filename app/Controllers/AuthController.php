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
        if(isset($_REQUEST['first_name'])) {
            $this->validate($_REQUEST, [
                'first_name' => 'required|min:3|max:40|string',
                'last_name' => 'required|min:4|max:50|string',
                'email' => 'required|email|unique',
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6|confirm'
            ]);

            $token = generate_token();

            users::query()->create([
                'first_name' => trim($_REQUEST['first_name']),
                'last_name' => trim($_REQUEST['last_name']),
                'email' => trim($_REQUEST['email']),
                'password' => trim(bcrypt($_REQUEST['password'])),
                'email_verified' => $token
            ]);

            $user = users::query()->where('email_verified', '=', $token)->getAll();

            send_email($_REQUEST['email'], $token);

            if ($user) echo json_encode($user);
        }

    }

    public function loginsubmit()
    {
        $this->validate($_REQUEST, [
           'email' => 'required|exists:users',
           'password' => 'required|exists:users'
        ]);

        $email_verified = users::query()->where('email', '=', $_REQUEST['email'])
            ->get('email_verified');

        if ($email_verified[0]['email_verified'] === '') {
            $token = generate_token();
            users::query()->where('email', '=', $_REQUEST['email'])->update([
                'access_token' => $token
            ]);

            $_SESSION['access_token'] = $token;

            redirect('/');
        }
        redirect('/login');
    }

    public function verify()
    {
        $url = $_SERVER['REQUEST_URI'];
        $token = explode('token=', parse_url($url, PHP_URL_QUERY));

        $user = users::query()->where('email_verified', '=', $token[1])->getAll();

        if (!$user) {
            return view('email.verified', 'Verification Message');
        } else {
            users::query()->where('email_verified', '=', $token[1])->update([
                'email_verified' => null
            ]);
            return view('email.success', 'Verification Message');
        }
    }

    public function logout()
    {
        if(isset($_SESSION['access_token'])) {
            unset($_SESSION['access_token']);
            redirect('/');
        } else return null;
    }
}