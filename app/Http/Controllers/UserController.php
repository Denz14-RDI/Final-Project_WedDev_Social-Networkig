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

    public function show($id)
    {
        $user = User::findOrFail($id);

        // Block access to admin profiles in community
        if ($user->role === 'admin') {
            abort(404); // or redirect()->route('feed')->withErrors('Profile not found.');
        }

        $posts = $user->posts()->latest()->get();
        $authId = Auth::id();

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

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent admin accounts from being updated via community settings
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

        if (!empty($validated['password'])) {
            if (empty($validated['current_password']) || !Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if (empty($validated['profile_pic'])) {
            $validated['profile_pic'] = 'images/default.png';
        }

        // Prevent role changes via profile update
        unset($validated['role']);

        $user->update($validated);

        if ($request->input('source') === 'settings') {
            return redirect()->route('settings')->with('success', 'Account updated successfully!');
        }

        return redirect()->route('profile.show', ['id' => $user->user_id])
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin accounts via community
        if ($user->role === 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();

        return redirect()->route('login')
            ->with('success', 'User deleted successfully.');
    }
}