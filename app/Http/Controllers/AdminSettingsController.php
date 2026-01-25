<?php
// ------------------------------------------------------------
// AdminSettingsController
// ------------------------------------------------------------
// Handles admin account settings.
// Provides functionality for updating the admin's password
// with validation and role-based security
// ------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    // --------------------
    // Update Admin Password
    // --------------------
    // Validates input, checks current password, and updates
    // the admin's password securely using hashing.
    public function updatePassword(Request $request)
    {
        // Validate input fields with custom error messages
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8'],
            'new_password_confirmation' => ['required', 'same:new_password'],
        ], [
            'current_password.required' => 'Please enter your current password.',
            'new_password.required' => 'Please enter a new password.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password_confirmation.required' => 'Please confirm your new password.',
            'new_password_confirmation.same' => 'New password and confirmation do not match.',
        ]);

        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        // Check if the provided current password matches the stored one
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password securely using Eloquent's update() and Hash::make()
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Return success message after update
        return back()->with('success', 'Password updated successfully!');
    }
}