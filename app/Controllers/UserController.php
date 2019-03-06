<?php

namespace app\Controllers;

class UserController
{
    public function details()
    {
        return view('user.profile', 'Welcome to Your details page');
    }

    public function allUsers()
    {
        return view('user.all', 'Welcome to all users page');
    }
}