<?php

namespace app\Controllers;

use app\Models\friendspivot;
use app\Models\images;
use app\Models\requestpivot;
use app\Models\users;

class UserController
{
    public function details()
    {
        return view('user.profile', 'Welcome to Your details page');
    }

    public function allUsers()
    {
        $user_id = session_get('user_details', 'id');
        $users =  users::query()->getAll();
        $images = images::query()->getAll();
        $requests = requestpivot::query()->where('user_from', '=', $user_id)->get('user_to');
        $friends = friendspivot::query()->where('user_from', '=', $user_id)->get('user_to');

        return view('user.all', 'Welcome to all users page', ['users' => $users, 'images' => $images,
            'requests' => $requests, 'friends' => $friends]);
    }

    public function friends()
    {
        $pivot = friendspivot::query()->where('user_from', '=', session_get('user_details', 'id'))
            ->get('user_to');

        $right = [];

        foreach ($pivot as $key => $value) {
            array_push($right, $value['user_to']);
        };

        $friends = users::query()->where('id', 'in', $right)->getAll();
        $images = images::query()->getAll();

        return view('user.friends', 'Welcome to Your friends page', ['friends' => $friends, 'images' => $images]);
    }

    public function friendRequest()
    {
        if (isset($_GET['to'])) {
            requestpivot::query()->create([
               'user_from' => session_get('user_details', 'id'),
               'user_to' => $_GET['to']
            ]);
        }

        if (isset($_GET['from']) && isset($_GET['approve'])) {
            $user = session_get('user_details', 'id');

            friendspivot::query()->create([
                'user_from' => $_GET['from'],
                'user_to' => $user
            ]);

            friendspivot::query()->create([
                'user_from' => $user,
                'user_to' => $_GET['from']
            ]);

            requestpivot::query()->where('user_from', '=', $_GET['from'])->delete();
        }
    }

//    public function approveRequest()
//    {
//
//    }

    public function notifications()
    {
        if (isAuth()) {
            $requests = requestpivot::query()->where('user_to', '=', session_get('user_details', 'id'))
                ->get('user_from');

            if (isset($requests)) {
                $right = [];

                foreach ($requests as $key => $value) {
                    array_push($right, $value['user_from']);
                };

                $users = users::query()->where('id', 'in', $right)->getAll();

                echo json_encode(['users' => $users]);
            }
            return false;
        }
        return false;
    }
}