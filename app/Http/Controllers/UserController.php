<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show($id)
    {
        $user = User::findOrFail($id);

        $posts = $user->posts()->latest()->get();

        $authId = Auth::id();

        // Following (user_id_1 = profile user, user_id_2 = target)
        $followingRows = Friend::query()
            ->where('user_id_1', $user->user_id)
            ->where('status', 'following')
            ->with(['following'])
            ->latest()
            ->get();

        // Followers (user_id_2 = profile user, user_id_1 = follower)
        $followersRows = Friend::query()
            ->where('user_id_2', $user->user_id)
            ->where('status', 'following')
            ->with(['follower'])
            ->latest()
            ->get();

        $followingCount = $followingRows->count();
        $followersCount = $followersRows->count();

        return view('profile', compact(
            'user',
            'posts',
            'authId',
            'followingRows',
            'followersRows',
            'followingCount',
            'followersCount'
        ));
    }

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
            'password'    => 'sometimes|string|min:8',
            'bio'         => 'nullable|string',
            'profile_pic' => 'nullable|string',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        if (empty($validated['profile_pic'])) {
            $validated['profile_pic'] = 'images/default.png';
        }

        $user->update($validated);

        return redirect()->route('profile.show', ['id' => $user->user_id])
            ->with('success', 'Profile updated successfully!');
    }

    public function feed()
    {
        $me = Auth::user();
        return view('feed', compact('me'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('login')
            ->with('success', 'User deleted successfully.');
    }
}
