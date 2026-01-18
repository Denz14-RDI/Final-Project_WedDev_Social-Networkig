<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Get the friends list for the current user.
     */
    public function index()
    {
        $user = auth()->user();
        
        $friends = Friend::where(function ($query) use ($user) {
            $query->where('user_id_1', $user->user_id)
                ->orWhere('user_id_2', $user->user_id);
        })
        ->where('status', 'accepted')
        ->with(['userOne', 'userTwo'])
        ->paginate(20);

        return view('friends.index', compact('friends'));
    }

    /**
     * Send a friend request.
     */
    public function store(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->user_id === $user->user_id) {
            return back()->with('error', 'You cannot send a friend request to yourself.');
        }

        // Check if friendship already exists
        $existing = Friend::where(function ($query) use ($authUser, $user) {
            $query->where('user_id_1', $authUser->user_id)
                ->where('user_id_2', $user->user_id)
                ->orWhere('user_id_1', $user->user_id)
                ->where('user_id_2', $authUser->user_id);
        })->first();

        if ($existing) {
            return back()->with('error', 'Friendship already exists or request is pending.');
        }

        Friend::create([
            'user_id_1' => $authUser->user_id,
            'user_id_2' => $user->user_id,
            'status' => 'pending',
        ]);

        // Create notification
        Notification::create([
            'user_id' => $user->user_id,
            'notif_type' => 'new_friend',
            'entity_type' => 'user',
            'entity_id' => $authUser->user_id,
            'notif_data' => json_encode([
                'message' => $authUser->first_name . ' sent you a friend request',
                'from_user_id' => $authUser->user_id,
            ]),
        ]);

        return back()->with('success', 'Friend request sent.');
    }

    /**
     * Accept a friend request.
     */
    public function accept(Friend $friend)
    {
        $user = auth()->user();

        if ($friend->user_id_2 !== $user->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $friend->update(['status' => 'accepted']);

        // Create notification
        Notification::create([
            'user_id' => $friend->user_id_1,
            'notif_type' => 'new_friend',
            'entity_type' => 'user',
            'entity_id' => $user->user_id,
            'notif_data' => json_encode([
                'message' => $user->first_name . ' accepted your friend request',
                'from_user_id' => $user->user_id,
            ]),
        ]);

        return back()->with('success', 'Friend request accepted.');
    }

    /**
     * Decline a friend request.
     */
    public function decline(Friend $friend)
    {
        $user = auth()->user();

        if ($friend->user_id_2 !== $user->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $friend->update(['status' => 'declined']);

        return back()->with('success', 'Friend request declined.');
    }

    /**
     * Unfriend a user.
     */
    public function unfriend(Friend $friend)
    {
        $user = auth()->user();

        if ($friend->user_id_1 !== $user->user_id && $friend->user_id_2 !== $user->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $friend->update(['status' => 'unfriended']);

        return back()->with('success', 'Friend removed.');
    }

    /**
     * Block a user.
     */
    public function block(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->user_id === $user->user_id) {
            return back()->with('error', 'You cannot block yourself.');
        }

        $friend = Friend::where(function ($query) use ($authUser, $user) {
            $query->where('user_id_1', $authUser->user_id)
                ->where('user_id_2', $user->user_id)
                ->orWhere('user_id_1', $user->user_id)
                ->where('user_id_2', $authUser->user_id);
        })->first();

        if ($friend) {
            $friend->update(['status' => 'blocked']);
        } else {
            Friend::create([
                'user_id_1' => $authUser->user_id,
                'user_id_2' => $user->user_id,
                'status' => 'blocked',
            ]);
        }

        return back()->with('success', 'User blocked.');
    }
}
