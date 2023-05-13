<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function signin()
    {
        return view('user.signin');
    }
    public function signup()
    {
        return view('user.signup');
    }

    public function show($username)
    {
        if (session('admin')) {
            $user = User::where('username', $username)->first();
        } else {
            $user = session('user');
        }

        if ($user->block_status) {
            abort(404);
        }

        return view('user.profile', ['user' => $user]);
    }
}
