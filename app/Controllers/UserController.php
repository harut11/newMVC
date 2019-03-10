<?php

namespace app\Controllers;

use app\Models\friendspivot;
use app\Models\images;
use app\Models\requestpivot;
use app\Models\users;
use root\forValidation;

class UserController extends forValidation
{
    public function usershow($id)
    {
        $auth_id = session_get('user_details', 'id');
        $friend = friendspivot::query()->where('user_from', '=', $auth_id)
            ->andWhere('user_to', '=', $id)->getAll();

        if (isset($id) && $friend) {
            $user = users::query()->where('id', '=', $id)->get(['first_name', 'last_name', 'email']);
            $avatar = images::query()->where('user_id', '=', $id)->get('name');

            return view('user.show', 'Welcome to friend profile', ['user' => $user, 'avatar' => $avatar]);
        }
        return redirect('/allusers');
    }

    public function details()
    {
        $user_id = session_get('user_details', 'id');
        $user = users::query()->where('id', '=', $user_id)->getAll();
        $avatar = images::query()->where('user_id', '=', $user_id)->getAll();

        return view('user.profile', 'Welcome to Your details page', ['user' => $user, 'avatar' => $avatar]);
    }

    public function editdetails()
    {
        $user_id = session_get('user_details', 'id');
        $user = users::query()->where('id', '=', $user_id)->getAll();
        $avatar = images::query()->where('user_id', '=', $user_id)->getAll();

        return view('user.edit', 'Welcome to edit page', ['user' => $user, 'avatar' => $avatar]);
    }

    public function allUsers()
    {
        $user_id = session_get('user_details', 'id');
        $users = users::query()->getAll();
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
        if (isset($_GET['to']) && isset($_GET['send_request'])) {
            $user = session_get('user_details', 'id');
            $sended = requestpivot::query()->where('user_from', '=', $_GET['to'])
                ->andWhere('user_to', '=', $user)->getAll();

            if (!$sended) {
                requestpivot::query()->create([
                    'user_from' => $user,
                    'user_to' => $_GET['to']
                ]);
            } else {
                echo 'false';
            }
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

            requestpivot::query()->where('user_from', '=', $_GET['from'])
                ->andWhere('user_to', '=', $user)->delete();

            $newFriend = users::query()->where('id', '=', $_GET['from'])->getAll();
            $avatar = images::query()->where('user_id', '=', $_GET['from'])->getAll();

            echo json_encode(['newfriend' => $newFriend, 'avatar' => $avatar]);
        }

        if (isset($_GET['from']) && isset($_GET['cancel'])) {
            requestpivot::query()->where('user_from', '=', $_GET['from'])
                ->andWhere('user_to', '=', session_get('user_details', 'id'))->delete();
        }

        if (isset($_GET['to']) && isset($_GET['delete'])) {
            $user = session_get('user_details', 'id');

            friendspivot::query()->where('user_from', '=', $user)
                ->andWhere('user_to', '=', $_GET['to'])->delete();
            friendspivot::query()->where('user_from', '=', $_GET['to'])
                ->andWhere('user_to', '=', $user)->delete();
        }
        return false;
    }

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
        }
        return false;
    }

    public function editSubmit()
    {
        $user_id = session_get('user_details', 'id');

        $this->validate($_REQUEST, $_FILES, [
            'first_name' => 'required|min:3|max:40|string',
            'last_name' => 'required|min:4|max:50|string',
            'email' => 'required|email|updateUnique',
            'avatar' => 'img'
        ]);

        if ($_FILES['avatar']['size'] !== 0) {
            $avatar= get_avatar_name(session_get('user_details', 'id'));
            unlink('public/uploads/' . $avatar);

            images::query()->where('user_id', '=', $user_id)->update([
                'name' => upload_image()
            ]);

            users::query()->where('id', '=', $user_id)->update([
                'first_name' => trim($_REQUEST['first_name']),
                'last_name' => trim($_REQUEST['last_name']),
                'email' => trim($_REQUEST['email'])
            ]);
            redirect('/details');
        } else {
            users::query()->where('id', '=', $user_id)->update([
                'first_name' => trim($_REQUEST['first_name']),
                'last_name' => trim($_REQUEST['last_name']),
                'email' => trim($_REQUEST['email'])
            ]);
            redirect('/details');
        }
    }
}