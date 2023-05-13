<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Session;

class tokenCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->token == null || $request->user == null) {
            return response()->json(['errors' => 'Token is null']);
        }

        $session = Session::where([
            ['user_id', $request->user],
            ['token', $request->token],
        ])->first();

        if (strtotime($session->expires_at) < strtotime('-1 hour')) {
            $token = Str::uuid();
            $newSess = Session::create([
                'user_id' => $session->user_id,
                'token' => $token,
                'expires_at' => now(),
            ]);

            // Delete old token
            $session->delete();

            session(['login' => 1]);

            return response()->json([
                'user' => $newSess()->user_id,
                'token' => $token,
            ], 201);
        }
        return $next($request);
    }
}
