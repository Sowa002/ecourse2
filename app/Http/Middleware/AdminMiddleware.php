<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('AdminMiddleware executed');
        Log::info('Authenticated user:', ['user' => Auth::user()]);

        if (Auth::check() && Auth::user()->hasRole('admin')) {
            Log::info('User has admin role');
            return $next($request);
        }

        Log::warning('Access denied: user does not have admin role');
        return response()->json(['message' => 'Access denied'], 403);
    }
}
