<?php

namespace app\Controllers;

use app\Models\users;

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

    public function showUsers()
    {
        echo users::query()->getAll();
    }
}