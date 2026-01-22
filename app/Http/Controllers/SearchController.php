<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $q = trim($request->query('q', ''));

        // If no query, show empty results
        if ($q === '') {
            return view('search', [
                'users' => collect(),
                'friendMap' => [],
            ]);
        }

        // Search users (exclude self)
        $users = User::query()
            ->where('user_id', '!=', $authUser->user_id)
            ->where(function ($query) use ($q) {
                $query->where('first_name', 'like', "%{$q}%")
                      ->orWhere('last_name', 'like', "%{$q}%")
                      ->orWhere('username', 'like', "%{$q}%");
            })
            ->orderBy('first_name')
            ->paginate(20)
            ->withQueryString();

        // IDs from current page results
        $resultIds = $users->getCollection()->pluck('user_id')->values();

        // ✅ Only check outgoing follow rows (authUser -> other users)
        $friendRows = Friend::query()
            ->where('user_id_1', $authUser->user_id)
            ->whereIn('user_id_2', $resultIds)
            ->get(['friend_id', 'user_id_2', 'status']);

        // Build map: other_user_id => [status, friend_id]
        $friendMap = [];
        foreach ($friendRows as $fr) {
            $friendMap[$fr->user_id_2] = [
                'status' => $fr->status,      // following | unfollow | follow (if any old rows)
                'friend_id' => $fr->friend_id,
            ];
        }

        return view('search', [
            'users' => $users,
            'friendMap' => $friendMap,
        ]);
    }
}
