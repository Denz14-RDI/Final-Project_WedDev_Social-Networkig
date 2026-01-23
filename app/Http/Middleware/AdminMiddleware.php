<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Allow only users with role = 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Block everyone else
        abort(403, 'Unauthorized');
    }
}