<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class ApiAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Token not provided.'], 401);
        }

        $user = User::where('api_token', hash('sha256', $token))->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Invalid token.'], 401);
        }

        // Authenticate the user for this request
        auth()->login($user);

        return $next($request);
    }
}
