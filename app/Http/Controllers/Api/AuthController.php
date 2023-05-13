<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Session\Store;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
        // vlidate the user input
        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'logined_at' => now(),
            'registed_at' => now(),
        ]);

        // Generate asession token
        $sessionToken = Str::uuid();

        // Store the session token
        Session::create([
            'user_id' => $user->id,
            'token' => $sessionToken,
            'expires_at' => now(),
        ]);

        return response()->json([
            'user_status' => 'user',
            'user' => $user->id,
            'token' => $sessionToken
        ]);
    }

    public function signin(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
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

         // Generate asession token
         $sessionToken = Str::uuid();

         // Store the session token
         Session::create([
             'user_id' => $user->id,
             'token' => $sessionToken,
             'expires_at' => now(),
         ]);

         return response()->json([
             'user_status' => 'user',
             'user' => $user->id,
             'token' => $sessionToken
         ]);
    }

    public function signout(Request $request)
    {
        Session::where([['user_id', $request->user], ['token', $request->token]])->delete();

        return response()->json(['status' => "success"]);
    }
}
