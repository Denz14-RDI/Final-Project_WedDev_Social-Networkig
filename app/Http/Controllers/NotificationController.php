<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    
    // Get all notifications for the authenticated user.
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->user_id ?? $user->id)
            ->orderByDesc('created_at')
            ->get();
        return response()->json($notifications);
    }

    // Get only unread notifications for the authenticated user.
    public function unread(){

        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->user_id ?? $user->id)
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->get();
        return response()->json($notifications);
    }

    // Mark a specific notification as read
    public function markAsRead(Notification $notification){
        if ($notification->user_id !== Auth::id()){
            abort(403, 'Unauthorized');
        }

        $notification->update([
            'read_at' => now(),
        ]);
        
        return response()->json(['message' => 'Notification marked as read.']);
    }
}
