<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    /**
     * Update the admin's password.
     */
    public function updatePassword(Request $request)
    {
        // ✅ Validate input
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8'],
            'new_password_confirmation' => ['required', 'same:new_password'],
        ]);

        $admin = Auth::user();

        // ✅ Check if current password matches
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // ✅ Update password
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password updated successfully!');
    }
}