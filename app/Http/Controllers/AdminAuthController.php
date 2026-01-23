<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Attempt authentication
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Only allow users with role = 'admin'
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // If a member tries to log in here, log them out immediately
            Auth::logout();
            return back()->withErrors([
                'email' => 'Community members cannot log in here.',
            ]);
        }

        // Invalid credentials
        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}