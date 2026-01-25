<?php
// ------------------------------------------------------------
// AdminAuthController
// ------------------------------------------------------------
// Handles authentication specifically for admin user.
// Provides routes for showing the login form, processing login,
// enforcing role-based access, and handling logout.
// ------------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // --------------------
    // Show Login Form
    // --------------------
    // Displays the admin login page view
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    // --------------------
    // Handle Admin Login
    // --------------------
    // Validates credentials, checks role, and redirects accordingly
    public function login(Request $request)
    {
        // Validate login input fields
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Attempt authentication with provided credentials
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Allow access only if the authenticated user is an admin
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // If a non-admin tries to log in here, force logout and show error
            Auth::logout();
            return back()->withErrors([
                'email' => 'Community members cannot log in here.',
            ]);
        }

        // If authentication fails, return with error message
        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ]);
    }

    // --------------------
    // Handle Admin Logout
    // --------------------
    // Logs out the admin, clears session, and regenerates CSRF token
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Redirect back to admin login page
        return redirect()->route('admin.login');
    }
}