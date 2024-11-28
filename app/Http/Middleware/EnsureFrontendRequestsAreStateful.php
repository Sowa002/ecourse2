<?php

namespace Laravel\Sanctum\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Sanctum;

class EnsureFrontendRequestsAreStateful
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        Log::info('Sanctum Middleware Triggered', ['token' => $token]);

        if ($token) {
            $personalAccessToken = Sanctum::personalAccessTokenModel()::findToken($token);

            if ($personalAccessToken) {
                Log::info('Personal Access Token Found:', ['user_id' => $personalAccessToken->tokenable_id]);
                auth()->loginUsingId($personalAccessToken->tokenable_id);
            } else {
                Log::info('Invalid Personal Access Token');
            }
        }

        return $next($request);
    }
}
