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
            // 👇 add confirmed here
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

        User::create($validated);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please log in.');
    }

    // ✅ Show profile + posts + followers/following + follow state
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Posts of this profile user
        $posts = $user->posts()->latest()->get();

        $authId = Auth::id();

        // FOLLOWING (profile user follows others)
        $followingRows = Friend::query()
            ->where('user_id_1', $user->user_id)
            ->where('status', 'following')
            ->whereNull('deleted_at')
            ->with(['following']) // user_id_2
            ->latest()
            ->get();

        // FOLLOWERS (others follow profile user)
        $followersRows = Friend::query()
            ->where('user_id_2', $user->user_id)
            ->where('status', 'following')
            ->whereNull('deleted_at')
            ->with(['follower']) // user_id_1
            ->latest()
            ->get();

        $followingCount = $followingRows->count();
        $followersCount = $followersRows->count();

        // ✅ follow button state (AUTH viewing someone)
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

    // ✅ Update user profile
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
            'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'New password and confirmation do not match.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        // Password change (requires current password)
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

        if ($request->input('source') === 'settings') {
            return redirect()->route('settings')->with('success', 'Account updated successfully!');
        }

        return redirect()->route('profile.show', ['id' => $user->user_id])
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('login')
            ->with('success', 'User deleted successfully.');
    }
}
