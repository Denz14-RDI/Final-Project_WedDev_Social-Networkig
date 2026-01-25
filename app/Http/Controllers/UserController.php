<?php
// ------------------------------------------------------------
// UserController
// ------------------------------------------------------------
// This controller manages user accounts.
// It covers registration, showing profiles, and updating details
// Admin accounts are protected from community-level changes.
// ------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // --------------------
    // Register New User
    // --------------------
    // Validates registration form, sets default profile picture,
    // forces role to "member", and saves the new account.
    // Redirects to login page after success.
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
            'password'    => 'required|string|min:8|confirmed',
            'bio'         => 'nullable|string',
            'profile_pic' => 'nullable|string',
        ], [
            'password.confirmed' => 'Password and confirmation do not match.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if (empty($validated['profile_pic'])) {
            $validated['profile_pic'] = 'images/default.png';
        }

        // Force all registrations to be members
        $validated['role'] = 'member';

        User::create($validated);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please log in.');
    }

    // --------------------
    // Show User Profile
    // --------------------
    // Displays a user’s profile page with their posts,
    // follower/following counts, and follow status.
    // Admin profiles are hidden from community view.
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Block access to admin profiles
        if ($user->role === 'admin') {
            abort(404);
        }
        
        $authUserId = Auth::user()->user_id;

        // Load posts with like/comment counts
        $posts = Post::where('user_id', $user->user_id)
            ->latest()
            ->withCount('likes')
            ->withCount('comments')
            ->withCount([
                'likes as liked_by_me' => function ($q) use ($authUserId) {
                    $q->where('user_id', $authUserId);
                }
            ])
            ->get();

        $authId = $authUserId;

        // Following and followers lists
        $followingRows = Friend::query()
            ->where('user_id_1', $user->user_id)
            ->where('status', 'following')
            ->whereNull('deleted_at')
            ->with(['following'])
            ->latest()
            ->get();

        $followersRows = Friend::query()
            ->where('user_id_2', $user->user_id)
            ->where('status', 'following')
            ->whereNull('deleted_at')
            ->with(['follower'])
            ->latest()
            ->get();

        $followingCount = $followingRows->count();
        $followersCount = $followersRows->count();

        // Check if logged-in user is following this profile
        $isFollowing = false;
        $friendId = null;

        if ($authId && (int)$authId !== (int)$user->user_id) {
            $friend = Friend::query()
                ->where('user_id_1', $authId)
                ->where('user_id_2', $user->user_id)
                ->where('status', 'following')
                ->whereNull('deleted_at')
                ->first();

            $isFollowing = $friend !== null;
            $friendId = $friend?->friend_id;
        }

        return view('profile', compact(
            'user',
            'posts',
            'authId',
            'followingRows',
            'followersRows',
            'followingCount',
            'followersCount',
            'isFollowing',
            'friendId'
        ));
    }

    // --------------------
    // Update User Profile
    // --------------------
    // Allows a user to edit their account details.
    // Checks current password before changing to a new one.
    // Prevents admin accounts from being updated here.
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent admin accounts from being updated
        if ($user->role === 'admin') {
            abort(403, 'Unauthorized action.');
        }

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
            'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'New password and confirmation do not match.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        // Handle password change
        if (!empty($validated['password'])) {
            if (empty($validated['current_password']) || !Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Default profile picture if empty
        if (empty($validated['profile_pic'])) {
            $validated['profile_pic'] = 'images/default.png';
        }

        // Prevent role changes
        unset($validated['role']);

        $user->update($validated);

        if ($request->input('source') === 'settings') {
            return redirect()->route('settings')->with('success', 'Account updated successfully!');
        }

        return redirect()->route('profile.show', ['id' => $user->user_id])
            ->with('success', 'Profile updated successfully!');
    }

    // --------------------
    // Delete User Account
    // --------------------
    // Deletes a user account from the system.
    // Admin accounts cannot be deleted here.
    // For future update 
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin accounts
        if ($user->role === 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();

        return redirect()->route('login')
            ->with('success', 'User deleted successfully.');
    }
}