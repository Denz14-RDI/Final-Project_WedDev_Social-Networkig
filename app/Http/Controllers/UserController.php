<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Create a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:200',
            'last_name'   => 'required|string|max:200',
            'username'    => 'required|string|max:200|unique:users',
            'email'       => [
                'required',
                'email',
                'unique:users',
                'ends_with:@iskolarngbayan.pup.edu.ph'
            ],
            'password'    => 'required|string|min:8',
            'bio'         => 'nullable|string',
            'profile_pic' => 'nullable|string',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if (empty($validated['profile_pic'])) {
            $validated['profile_pic'] = 'images/default.png';
        }

        User::create($validated);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please log in.');
    }

    // Show user profile with posts
    public function show($id)
    {
        $user = User::findOrFail($id);
        $authId = Auth::id();
        $isFollowing = false;

        if ($authId && $authId !== $user->user_id) {
            $isFollowing = Friend::where('user_id_1', $authId)
                ->where('user_id_2', $user->user_id)
                ->whereNull('deleted_at')
                ->where('status', 'Following')
                ->exists();
        }

        $posts = Post::where('user_id', $user->user_id)
            ->latest()
            ->get();

        return view('profile', compact('user', 'authId', 'isFollowing', 'posts'));
    }

    // Update user account
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'first_name'  => 'sometimes|string|max:200',
            'last_name'   => 'sometimes|string|max:200',
            'username'    => 'sometimes|string|max:200|unique:users,username,' . $id . ',user_id',
            'email'       => [
                'sometimes',
                'email',
                'unique:users,email,' . $id . ',user_id',
                'ends_with:@iskolarngbayan.pup.edu.ph'
            ],
            'current_password' => 'nullable|string',
            'password'    => 'nullable|string|min:8|confirmed',
            'bio'         => 'nullable|string',
            'profile_pic' => 'nullable|string',
        ], [
            // Custom error messages
            'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'New password and confirmation do not match.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        // Handle password change with current password validation
        if (!empty($validated['password'])) {
            if (empty($validated['current_password']) || !Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // don’t overwrite with null
        }

        if (empty($validated['profile_pic'])) {
            $validated['profile_pic'] = 'images/default.png';
        }

        $user->update($validated);

        // Redirect based on source field
        if ($request->input('source') === 'settings') {
            return redirect()->route('settings')->with('success', 'Account updated successfully!');
        }

        return redirect()->route('profile.show', ['id' => $user->user_id])
            ->with('success', 'Profile updated successfully!');
    }


    // Feed page
    public function feed()
    {
        $me = Auth::user();
        $posts = Post::with('user')->latest()->get();
        return view('feed', compact('me', 'posts'));
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('login')
            ->with('success', 'User deleted successfully.');
    }
}
