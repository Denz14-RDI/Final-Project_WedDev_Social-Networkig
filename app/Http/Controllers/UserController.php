<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Show user profile.
     */
    public function show(User $user)
    {
        $posts = $user->posts()->with(['comments', 'likes'])->orderBy('created_at', 'desc')->paginate(10);
        return view('profile', compact('user', 'posts'));
    }

    /**
     * Show edit profile form.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('settings', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        if ($request->hasFile('profile_pic')) {
            if ($user->profile_pic) {
                Storage::disk('public')->delete($user->profile_pic);
            }
            $validated['profile_pic'] = $request->file('profile_pic')->store('profile-pics', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
