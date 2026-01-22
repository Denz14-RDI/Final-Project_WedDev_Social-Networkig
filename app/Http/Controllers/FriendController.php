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
            ->where('status', 'Following') // ✅ match ENUM value
            ->whereNull('deleted_at')      // ✅ only active follows
            ->with('following')            // assumes you defined a relation in Friend model
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

        // Find existing row (A -> B), include soft-deleted
        $existing = Friend::withTrashed()
            ->where('user_id_1', $authUser->user_id)
            ->where('user_id_2', $user->user_id)
            ->first();

        if ($existing) {
            $existing->restore();

            if ($existing->status === 'Following') {
                return back()->with('info', 'Already following.');
            }

            $existing->update([
                'status' => 'Following',
                'deleted_at' => null,
            ]);
        } else {
            Friend::create([
                'user_id_1' => $authUser->user_id,
                'user_id_2' => $user->user_id,
                'status'    => 'Following',
            ]);
        }

        return back()->with('success', 'You are now following this user.');
    }

    // Unfollow a user
    public function unfollow($id)
    {
        $authUser = Auth::user();

        $friend = Friend::where('user_id_1', $authUser->user_id)
                        ->where('user_id_2', $id)
                        ->first();

        if (!$friend) {
            return back()->with('error', 'Follow relationship not found.');
        }

        $friend->update([
            'status' => 'Unfollow',
            'deleted_at' => now(),
        ]);

        return back()->with('success', 'You unfollowed this user.');
    }
}