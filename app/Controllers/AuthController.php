<?php

namespace app\Controllers;

use app\Models\friendspivot;
use app\Models\images;
use app\Models\users;
use app\Models\requestpivot;
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
        if(isset($_POST)) {
            $this->validate($_REQUEST, $_FILES, [
                'first_name' => 'required|min:3|max:40|string',
                'last_name' => 'required|min:4|max:50|string',
                'email' => 'required|email|unique',
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6|confirm',
                'avatar' => 'required|img'
            ]);

            $token = generate_token();

            users::query()->create([
                'first_name' => trim($_REQUEST['first_name']),
                'last_name' => trim($_REQUEST['last_name']),
                'email' => trim($_REQUEST['email']),
                'password' => trim(password_hash($_REQUEST['password'], PASSWORD_BCRYPT)),
                'email_verified' => $token
            ]);

            $user_id = users::query()->where('email', '=', $_REQUEST['email'])->get('id');

            images::query()->create([
                'name' => upload_image(),
                'user_id' => $user_id[0]['id']
            ]);

            send_email($_REQUEST['email'], $token);

            setcookie('username', $_REQUEST['first_name'], time() + 3600);

            redirect('/login');
        }
        redirect('/');
    }

    public function loginsubmit()
    {
        $this->validate($_REQUEST, $_FILES, [
           'email' => 'required|registered',
           'password' => 'required|min:6'
        ]);

        $user = users::query()->where('email', '=', $_REQUEST['email'])
            ->get(['id', 'email_verified']);
        $user_avatar = images::query()->where('user_id', '=', $user[0]['id'])->get('name');

        if ($user[0] && $user[0]['email_verified'] === '') {
            $token = generate_token();
            users::query()->where('email', '=', $_REQUEST['email'])->update([
                'access_token' => $token
            ]);

            $user = users::query()->where('email', '=', $_REQUEST['email'])
                ->get(['id', 'first_name', 'last_name', 'email', 'access_token', 'email_verified']);

            $_SESSION['user_details'] = $user[0];
            $_SESSION['user_avatar'] = $user_avatar[0];

            return redirect('/details');
        } else if($user[0] && $user[0]['email_verified'] !== '') {
            setcookie('must_verify', 'status', time() + 3600);
        }
        return redirect('/login');
    }

    public function verify($token)
    {
        if(isset($token)) {
            $token = explode('token=', $token);
            $user = users::query()->where('email_verified', '=', $token[1])->getAll();

            if (!$user) {
                setcookie('email_already_verified', 'true', time() + 3600);
                return redirect('/login');
            } else {
                users::query()->where('email_verified', '=', $token[1])->update([
                    'email_verified' => null
                ]);
                setcookie('email_verified_success', 'true', time() + 3600);
                return redirect('/login');
            }
        }
        redirect('/');
        return false;
    }

    public function logout()
    {
        if(session_get('user_details', 'access_token')) {
            session_unset();
            redirect('/');
        } else return null;
    }

    public function deleteaccount()
    {
        if((session_get('user_details', 'access_token'))) {
            $user_id = session_get('user_details', 'id');

            unlink('public/uploads/' . get_avatar_name(session_get('user_details', 'id')));

            users::query()->where('email', '=', session_get('user_details', 'email'))->delete();
            friendspivot::query()->where('user_from', '=', $user_id)
                ->orWhere('user_to', '=', $user_id)->delete();
            requestpivot::query()->where('user_from', '=', $user_id)
                ->orWhere('user_to', '=', $user_id)->delete();

            session_unset();
            redirect('/');
        }
        return false;
    }
}