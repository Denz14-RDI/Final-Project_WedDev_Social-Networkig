<?php
// ------------------------------------------------------------
// AdminMiddleware
// ------------------------------------------------------------
// This middleware protects admin-only routes.
// It checks if the logged-in user has the role "admin".
// If yes, the request continues. If not, access is blocked.
// ------------------------------------------------------------

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    // --------------------
    // Handle Request
    // --------------------
    // Check if the user is logged in.
    // Verify that their role is "admin".
    // If both are true, allow the request to continue.
    // Otherwise, stop the request and return "Unauthorized".
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