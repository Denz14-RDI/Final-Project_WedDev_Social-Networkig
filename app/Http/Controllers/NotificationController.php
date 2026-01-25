<?php
// ------------------------------------------------------------
// NotificationController
// ------------------------------------------------------------
// Manages user notifications.
// Provides methods for displaying notifications in Blade views,
// and marking notifications as read.
// ------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // --------------------
    // Notifications Page
    // --------------------
    // Retrieves all notifications for the logged-in user,
    // counts unread notifications, and returns the Blade view.
    public function page()
    {
        $authId = Auth::user()->user_id;

        $notifications = Notification::where('user_id', $authId)
            ->orderByDesc('created_at')
            ->get();

        $unreadCount = Notification::where('user_id', $authId)
            ->whereNull('read_at')
            ->count();

        return view('notifications', compact('notifications', 'unreadCount'));
    }

    // --------------------
    // Notifications
    // --------------------
    // Returns all notifications for the logged-in user
    public function index()
    {
        $authId = Auth::user()->user_id;

        $notifications = Notification::where('user_id', $authId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($notifications);
    }

    // --------------------
    // Unread Count 
    // --------------------
    // Returns the count of unread notifications
    public function unread()
    {
        $authId = Auth::user()->user_id;

        $count = Notification::where('user_id', $authId)
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    // --------------------
    // Mark One Notification as Read
    // --------------------
    // Marks a single notification as read if it belongs
    // to the logged-in user, then returns updated unread count.
    public function markAsRead(Notification $notification)
    {
        $authId = Auth::user()->user_id;

        // Ensure the notification belongs to the logged-in user
        if ((int) $notification->user_id !== (int) $authId) {
            abort(403, 'Unauthorized');
        }

        // Update only if still unread
        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }

        // Return updated unread count
        $count = Notification::where('user_id', $authId)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'ok' => true,
            'count' => $count,
        ]);
    }

    // --------------------
    // Mark All Notifications as Read
    // --------------------
    // Marks all unread notifications for the logged-in user
    // as read
    public function markAllAsRead()
    {
        $authId = Auth::user()->user_id;

        Notification::where('user_id', $authId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'ok' => true,
            'count' => 0,
        ]);
    }
}