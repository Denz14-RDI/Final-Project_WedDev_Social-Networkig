<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Only allow one specific admin email
        if (Auth::check() && Auth::user()->email === 'admin@pup.edu.ph') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}