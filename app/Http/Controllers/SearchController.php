<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $q = trim((string) $request->query('q', ''));

        // If no query, show empty results
        if ($q === '') {
            return view('search', [
                'users' => collect(),
                'friendMap' => [],
                'q' => $q, // optional (if your view uses it)
            ]);
        }

        // Safety: if somehow not logged in, just search all (or return empty)
        if (!$authUser) {
            $users = User::query()
                ->where(function ($query) use ($q) {
                    $like = "%{$q}%";
                    $query->where('first_name', 'like', $like)
                          ->orWhere('last_name', 'like', $like)
                          ->orWhere('username', 'like', $like)
                          ->orWhere(DB::raw("CONCAT(first_name,' ',last_name)"), 'like', $like)
                          ->orWhere(DB::raw("CONCAT(last_name,' ',first_name)"), 'like', $like);
                })
                ->orderBy('first_name')
                ->paginate(20)
                ->withQueryString();

            return view('search', [
                'users' => $users,
                'friendMap' => [],
                'q' => $q,
            ]);
        }

        // ✅ Search users (exclude self) + supports full name with spaces
        $users = User::query()
            ->where('user_id', '!=', $authUser->user_id)
            ->where(function ($query) use ($q) {
                $like = "%{$q}%";

                $query->where('first_name', 'like', $like)
                      ->orWhere('last_name', 'like', $like)
                      ->orWhere('username', 'like', $like)

                      // ✅ Full name search: "first last"
                      ->orWhere(DB::raw("CONCAT(first_name,' ',last_name)"), 'like', $like)

                      // ✅ Optional: "last first"
                      ->orWhere(DB::raw("CONCAT(last_name,' ',first_name)"), 'like', $like);
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
            // optional but recommended if you soft-delete via deleted_at:
            ->whereNull('deleted_at')
            ->get(['friend_id', 'user_id_2', 'status']);

        // Build map: other_user_id => [status, friend_id]
        $friendMap = [];
        foreach ($friendRows as $fr) {
            $friendMap[$fr->user_id_2] = [
                'status' => $fr->status,      // following | unfollow | follow
                'friend_id' => $fr->friend_id,
            ];
        }

        return view('search', [
            'users' => $users,
            'friendMap' => $friendMap,
            'q' => $q, // optional (if your view uses it)
        ]);
    }
}
