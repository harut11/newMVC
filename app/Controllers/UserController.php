<?php

namespace app\Controllers;

use app\Models\friendspivot;
use app\Models\images;
use app\Models\users;

class UserController
{
    public function details()
    {
        return view('user.profile', 'Welcome to Your details page');
    }

    public function allUsers()
    {
        $users =  users::query()->getAll();
        $images = images::query()->getAll();

        return view('user.all', 'Welcome to all users page', ['users' => $users, 'images' => $images]);
    }

    public function friends()
    {
        $pivot = friendspivot::query()->where('left_user_id', '=', session_get('user_details', 'id'))
            ->get('right_user_id');

        $right = [];

        foreach ($pivot as $key => $value) {
            array_push($right, $value['right_user_id']);
        };

        $friends = users::query()->where('id', 'in', $right)->getAll();
        $images = images::query()->getAll();

        return view('user.friends', 'Welcome to Your friends page', ['friends' => $friends, 'images' => $images]);
    }
}