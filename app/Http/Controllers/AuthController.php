<?php

namespace App\Http\Controllers;

use App\Models\session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Get user where username
        $user = User::where('username', $request->username)->first();

        // Hash check
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['error' => 'Invali password or username.']);
        } elseif ($user->block_status) {
            return response()->json(['Reason' => $user->block_reason]);
        }



        // Create a new session token
        $token = Str::uuid();
        session(['user' => $user]);
        session(['token' => $token]);

        // Insert session to database.
        session::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        return redirect('/');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);

        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'registed_at' => now(),
        ]);

        if (!$user) {
            return back()->withError(['error' => 'Create user fail!.']);
        }

        // Create the token
        $token = Str::uuid();
        session(['user' => $user]);
        session(['token' => $token]);

        // Insert session to database
        Session::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        return redirect('/');
    }

    public function signout()
    {
        Session::where([
            ['user_id', session('user')->id],
            ['token', session('token')],
        ])->delete();

        session()->flush();

        return redirect('/');
    }
}
