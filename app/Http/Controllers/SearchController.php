<?php
// ------------------------------------------------------------
// SearchController
// ------------------------------------------------------------
// This controller handles the search feature.
// It lets people look up other users by name or username,
// shows whether they are already followed, and displays results
// in a clean, paginated list.
// ------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    // --------------------
    // Search Users
    // --------------------
    // Accepts a query string 'q' from the request.
    // If empty, returns no results. If not logged in,
    // searches all users. If logged in, excludes self
    // and checks follow relationships for result users.

    public function index(Request $request)
    {
        $authUser = Auth::user();
        $q = trim((string) $request->query('q', ''));

        // If no search text, return empty results
        if ($q === '') {
            return view('search', [
                'users' => collect(),
                'friendMap' => [],
                'q' => $q,
            ]);
        }

        // If not logged in, search all users
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

        // Logged-in search (exclude self)
        $users = User::query()
            ->where('user_id', '!=', $authUser->user_id)
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

        // Collect IDs from search results
        $resultIds = $users->getCollection()->pluck('user_id')->values();

        // Check follow status for these users
        $friendRows = Friend::query()
            ->where('user_id_1', $authUser->user_id)
            ->whereIn('user_id_2', $resultIds)
            ->whereNull('deleted_at')
            ->get(['friend_id', 'user_id_2', 'status']);

        // Build a simple map of follow info
        $friendMap = [];
        foreach ($friendRows as $fr) {
            $friendMap[$fr->user_id_2] = [
                'status' => $fr->status,
                'friend_id' => $fr->friend_id,
            ];
        }

        return view('search', [
            'users' => $users,
            'friendMap' => $friendMap,
            'q' => $q,
        ]);
    }
}