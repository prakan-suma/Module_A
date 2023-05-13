<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function signin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Get admin where adminname
        $admin = Admin::where('username', $request->username)->first();

        // Hash check
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['error' => 'Invali password or adminname.']);
        }

        // Create a new session token
        $token = Str::uuid();
        session(['admin' => $admin]);
        session(['token' => $token]);

        // Insert session to database.
        session::create([
            'user_id' => $admin->id,
            'token' => $token,
        ]);

        return redirect('/');


    }

    public function signout()
    {
        Session::where([
            ['user_id', session('admin')->id],
            ['token', session('token')],
        ])->delete();

        session()->flush();

        return redirect('/');
    }
}
