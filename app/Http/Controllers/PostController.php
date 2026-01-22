<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    // Show posts (feed + explore)
    public function index()
    {
        $user = Auth::user();

        $allowed = ['academic', 'events', 'announcement', 'campus_life', 'help_wanted'];

        $activeCategory = request()->query('category');
        if (!in_array($activeCategory, $allowed, true)) {
            $activeCategory = null;
        }

        $scope = request()->query('scope'); // 'all' or null

        // ✅ Build follow maps for the feed UI
        $followRows = Friend::query()
            ->where('user_id_1', $user->user_id)
            ->whereIn('status', ['follow', 'following'])
            ->get(['friend_id', 'user_id_2', 'status']);

        $followMap = [];
        $followIdMap = [];
        foreach ($followRows as $r) {
            $followMap[$r->user_id_2] = $r->status;
            $followIdMap[$r->user_id_2] = $r->friend_id;
        }

        // ✅ POSTS QUERY
        if ($scope === 'all') {
            $postsQuery = Post::with('user')->latest();

            if ($activeCategory) {
                $postsQuery->where('category', $activeCategory);
            }
        } else {
            $followingIds = Friend::query()
                ->where('user_id_1', $user->user_id)
                ->where('status', 'following')
                ->pluck('user_id_2')
                ->toArray();

            $visibleUserIds = array_unique(array_merge($followingIds, [$user->user_id]));

            $postsQuery = Post::with('user')
                ->whereIn('user_id', $visibleUserIds)
                ->latest();

            if ($activeCategory) {
                $postsQuery->where('category', $activeCategory);
            }
        }

        $posts = $postsQuery->get();

        // ✅ HIGHLIGHTS OF THE WEEK
        $since = Carbon::now()->subDays(7);

        $counts = Post::select('category', DB::raw('COUNT(*) as total'))
            ->whereIn('category', $allowed)
            ->where('created_at', '>=', $since)
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $labels = [
            'academic'      => 'Academics',
            'events'        => 'Events',
            'announcement'  => 'Announcements',
            'campus_life'   => 'Campus Life',
            'help_wanted'   => 'Help Wanted',
        ];

        $highlights = $counts->map(function ($row) use ($labels) {
            return [
                'key'   => $row->category,
                'label' => $labels[$row->category] ?? ucfirst(str_replace('_', ' ', $row->category)),
                'total' => (int) $row->total,
            ];
        });

        return view('feed', compact(
            'posts',
            'highlights',
            'activeCategory',
            'followMap',
            'followIdMap'
        ));
    }

    // Store a new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_content' => 'required|string|max:1000',
            'category'     => 'required|in:academic,events,announcement,campus_life,help_wanted',
            'link'         => 'nullable|url',
            'image'        => 'nullable|url', // ✅ better than "string"
        ]);

        // ✅ IMPORTANT: your PK is user_id, not id
        $validated['user_id'] = Auth::user()->user_id;

        Post::create($validated);

        return back()->with('success', 'Post created successfully!');
    }

    // Update post
    public function update(Request $request, Post $post)
    {
        $authId = Auth::user()->user_id;

        if ((int)$post->user_id !== (int)$authId) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'post_content' => 'required|string|max:1000',
            'category'     => 'required|in:academic,events,announcement,campus_life,help_wanted',
            'link'         => 'nullable|url',
            'image'        => 'nullable|url',
        ]);

        $post->update($validated);

        return back()->with('success', 'Post updated successfully!');
    }

    // Delete a post
    public function destroy(Post $post)
    {
        $authId = Auth::user()->user_id;

        if ((int)$post->user_id !== (int)$authId) {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }
}
