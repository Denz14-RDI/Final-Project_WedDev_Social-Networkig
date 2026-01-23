<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // ✅ Blade page: /notifications
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

    // ✅ JSON list (optional): /notifications/json
    public function index()
    {
        $authId = Auth::user()->user_id;

        $notifications = Notification::where('user_id', $authId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($notifications);
    }

    // ✅ JSON unread count: /notifications/unread
    public function unread()
    {
        $authId = Auth::user()->user_id;

        $count = Notification::where('user_id', $authId)
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    // ✅ Mark ONE as read: /notifications/{notification}/read
    public function markAsRead(Notification $notification)
    {
        $authId = Auth::user()->user_id;

        if ((int) $notification->user_id !== (int) $authId) {
            abort(403, 'Unauthorized');
        }

        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }

        $count = Notification::where('user_id', $authId)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'ok' => true,
            'count' => $count,
        ]);
    }

    // ✅ Mark ALL as read: /notifications/read-all
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
