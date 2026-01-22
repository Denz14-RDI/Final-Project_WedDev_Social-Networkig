<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    // List of people the logged-in user is following
    public function index()
    {
        $user = Auth::user();

        $following = Friend::where('user_id_1', $user->user_id)
            ->where('status', 'following') // ✅ lowercase
            ->whereNull('deleted_at')
            ->with('following')
            ->paginate(20);

        return view('friends.index', compact('following'));
    }

    // Follow a user
    public function store(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->user_id === $user->user_id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        $existing = Friend::withTrashed()
            ->where('user_id_1', $authUser->user_id)
            ->where('user_id_2', $user->user_id)
            ->first();

        if ($existing) {
            $existing->restore();

            if ($existing->status === 'following') {
                return back()->with('info', 'Already following.');
            }

            $existing->update([
                'status' => 'following',
                'deleted_at' => null,
            ]);
        } else {
            Friend::create([
                'user_id_1' => $authUser->user_id,
                'user_id_2' => $user->user_id,
                'status'    => 'following',
            ]);
        }

        return back()->with('success', 'You are now following this user.');
    }

    // Unfollow a user (by Friend record ID)
    public function unfollow($friendId)
    {
        $authUser = Auth::user();

        $friend = Friend::where('friend_id', $friendId) // or 'id' if your PK is 'id'
                        ->where('user_id_1', $authUser->user_id)
                        ->first();

        if (!$friend) {
            return back()->with('error', 'Follow relationship not found.');
        }

        $friend->update([
            'status' => 'unfollow',
            'deleted_at' => now(),
        ]);

        return back()->with('success', 'You unfollowed this user.');
    }
}