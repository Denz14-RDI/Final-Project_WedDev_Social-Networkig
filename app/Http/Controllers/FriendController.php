<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Notification;
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

        $nowFollowing = false;

        if ($existing) {
            $existing->restore();

            if ($existing->status === 'following') {
                // already following
                $nowFollowing = false;
            } else {
                $existing->update([
                    'status' => 'following',
                    'deleted_at' => null,
                ]);
                $nowFollowing = true;
            }
        } else {
            Friend::create([
                'user_id_1' => $authUser->user_id,
                'user_id_2' => $user->user_id,
                'status'    => 'following',
            ]);
            $nowFollowing = true;
        }

        // ✅ CREATE NOTIFICATION (only if became "following")
        if ($nowFollowing) {
            // optional: prevent duplicate follow notifications
            $exists = Notification::where('user_id', $user->user_id) // receiver = the one being followed
                ->where('notif_type', 'new_friend')
                ->where('entity_type', 'user')
                ->where('entity_id', $authUser->user_id) // actor id
                ->whereNull('read_at')
                ->exists();

            if (!$exists) {
                Notification::create([
                    'user_id'     => $user->user_id,       // receiver
                    'notif_type'  => 'new_friend',
                    'entity_type' => 'user',
                    'entity_id'   => $authUser->user_id,   // actor
                    'notif_data'  => [
                        'actor_id'   => $authUser->user_id,
                        'actor_name' => $authUser->first_name . ' ' . $authUser->last_name,
                    ],
                ]);
            }
        }

        if (!$nowFollowing) {
            return back()->with('info', 'Already following.');
        }

        return back()
            ->with('success', 'You are now following this user.')
            ->with('just_followed', $user->user_id);
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
