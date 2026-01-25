<?php
// ------------------------------------------------------------
// FriendController
// ------------------------------------------------------------
// Handles the follow/unfollow system between users.
// Provides routes for listing followed users, following new users,
// creating notifications when a follow occurs.
// ------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    // --------------------
    // List Following
    // --------------------
    // Retrieves the list of people the logged-in user is following.
    // Filters by status = 'following'
    // eager loads related user data, and paginates results.
    public function index()
    {
        $user = Auth::user();

        $following = Friend::where('user_id_1', $user->user_id)
            ->where('status', 'following') // lowercase status
            ->whereNull('deleted_at')
            ->with('following')
            ->paginate(20);

        return view('friends.index', compact('following'));
    }

    // --------------------
    // Follow User
    // --------------------
    // Allows the logged-in user to follow another user.
    // Prevents self-follow,
    // updates status if needed, and creates a notification
    // for the user being followed.
    public function store(User $user)
    {
        $authUser = Auth::user();

        // Prevent following yourself
        if ($authUser->user_id === $user->user_id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        // Check if relationship already exists
        $existing = Friend::withTrashed()
            ->where('user_id_1', $authUser->user_id)
            ->where('user_id_2', $user->user_id)
            ->first();

        $nowFollowing = false;

        if ($existing) {
            $existing->restore();

            if ($existing->status === 'following') {
                // Already following
                $nowFollowing = false;
            } else {
                // Update status to following
                $existing->update([
                    'status' => 'following',
                    'deleted_at' => null,
                ]);
                $nowFollowing = true;
            }
        } else {
            // Create new follow record
            Friend::create([
                'user_id_1' => $authUser->user_id,
                'user_id_2' => $user->user_id,
                'status'    => 'following',
            ]);
            $nowFollowing = true;
        }

        // Create notification only if a new follow occurred
        if ($nowFollowing) {
            // Prevent duplicate follow notifications
            $exists = Notification::where('user_id', $user->user_id) // receiver
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

    // --------------------
    // Unfollow User
    // --------------------
    // Allows the logged-in user to unfollow another user.
    // Finds the Friend record by ID, ensures ownership,
    // updates status to 'unfollow', and soft-deletes the record.
    public function unfollow($friendId)
    {
        $authUser = Auth::user();

        $friend = Friend::where('friend_id', $friendId) 
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