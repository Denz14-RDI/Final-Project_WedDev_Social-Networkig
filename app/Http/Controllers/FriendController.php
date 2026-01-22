<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
// use App\Models\Notification; // TEMP: commented out
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $following = Friend::query()
            ->where('user_id_1', $user->user_id)
            ->where('status', 'following')
            ->with(['following'])
            ->paginate(20);

        return view('friends.index', compact('following'));
    }

    public function store(User $user)
    {
        $authUser = Auth::user();
        $targetUser = $user;

        if ($authUser->user_id === $targetUser->user_id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        // Find existing row (A -> B), include soft-deleted
        $existing = Friend::withTrashed()
            ->where('user_id_1', $authUser->user_id)
            ->where('user_id_2', $targetUser->user_id)
            ->first();

        if ($existing) {
            $existing->restore();

            if ($existing->status === 'following') {
                return back();
            }

            $existing->update(['status' => 'following']);
        } else {
            Friend::create([
                'user_id_1' => $authUser->user_id,
                'user_id_2' => $targetUser->user_id,
                'status'    => 'following',
            ]);
        }

        /*
        // TEMP: Notification disabled
        Notification::create([...]);
        */

        return back()->with('success', 'Following.');
    }

    public function unfollow(Friend $friend)
    {
        $user = Auth::user();

        if ($friend->user_id_1 !== $user->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $friend->update(['status' => 'unfollow']);

        return back()->with('success', 'Unfollowed.');
    }
}
