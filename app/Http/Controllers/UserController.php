<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Hash password before saving
        $validated['password'] = bcrypt($validated['password']);

        // Default profile picture if none provided
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

        $authUserId = Auth::user()->user_id; // correct for your schema

        // Load posts + likes_count + liked_by_me
        $posts = Post::where('user_id', $user->user_id)
            ->latest()
            ->withCount('likes') // likes_count
            ->withCount('comments') // comments_count
            ->withCount([
                'likes as liked_by_me' => function ($q) use ($authUserId) {
                    $q->where('user_id', $authUserId);
                }
            ])
            ->get();

        $authId = $authUserId; // keep your blade logic working

        return view('profile', compact('user', 'posts', 'authId'));
    }

    // Update user profile
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

        // Default profile picture if none provided
        if (empty($validated['profile_pic'])) {
            $validated['profile_pic'] = 'images/default.png';
        }

        $user->update($validated);

        // Redirect back to profile page with correct user_id
        return redirect()->route('profile.show', ['id' => $user->user_id])
            ->with('success', 'Profile updated successfully!');
    }

    // Feed page
    public function feed()
    {
        $me = Auth::user(); // current logged-in user 
        return view('feed', compact('me'));
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
