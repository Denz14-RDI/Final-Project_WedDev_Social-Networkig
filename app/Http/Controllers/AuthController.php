<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate input: login can be email or username
        $credentials = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Determine if login is email or username
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt login
        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 🚫 Block admin accounts from logging in here
            if ($user->role === 'admin') {
                Auth::logout();
                // Return generic message for security purposes
                return back()->withErrors([
                    'login' => 'Invalid credentials provided.',
                ])->onlyInput('login');
            }

            // ✅ Allow members
            return redirect()->route('feed')->with('success', 'Welcome back!');
        }

        // 🚫 If login fails
        return back()->withErrors([
            'login' => 'Invalid credentials provided.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}