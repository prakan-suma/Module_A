<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        dd($request->username);
        $user = User::where('user',$request->username)->first();
        return response()->json(['user'=>$user]);
    }
}
