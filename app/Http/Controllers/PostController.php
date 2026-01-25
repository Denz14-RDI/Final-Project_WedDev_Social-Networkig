<?php
// ------------------------------------------------------------
// PostController
// ------------------------------------------------------------
// Manages posts in the application (feed + explore).
// Provides methods for listing posts, creating new posts,
// showing individual posts, editing/updating posts, and deleting posts.
// Includes logic for categories, follow maps, and weekly highlights.
// ------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    // --------------------
    // Show Posts 
    // --------------------
    // Retrieves posts for the feed or explore view.
    // Supports category filtering, scope (all vs following),
    // builds follow maps for UI, and calculates weekly highlights.
    public function index()
    {
        $user = Auth::user();
        $userId = $user->user_id;

        // Allowed categories
        $allowed = ['academic', 'events', 'announcement', 'campus_life', 'help_wanted'];

        // Validate active category
        $activeCategory = request()->query('category');
        if (!in_array($activeCategory, $allowed, true)) {
            $activeCategory = null;
        }

        $scope = request()->query('scope'); // 'all' or null

        // Build follow maps for feed UI
        $followRows = Friend::query()
            ->where('user_id_1', $userId)
            ->whereIn('status', ['follow', 'following'])
            ->get(['friend_id', 'user_id_2', 'status']);

        $followMap = [];
        $followIdMap = [];
        foreach ($followRows as $r) {
            $followMap[$r->user_id_2] = $r->status;
            $followIdMap[$r->user_id_2] = $r->friend_id;
        }

        // Posts query with counts (likes + comments + liked_by_me)
        if ($scope === 'all') {
            $postsQuery = Post::with('user')
                ->withCount('likes')
                ->withCount('comments')
                ->withCount(['likes as liked_by_me' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                }])
                ->latest();

            if ($activeCategory) {
                $postsQuery->where('category', $activeCategory);
            }
        } else {
            // Only posts from following + self
            $followingIds = Friend::query()
                ->where('user_id_1', $userId)
                ->where('status', 'following')
                ->pluck('user_id_2')
                ->toArray();

            $visibleUserIds = array_unique(array_merge($followingIds, [$userId]));

            $postsQuery = Post::with('user')
                ->withCount('likes')
                ->withCount('comments')
                ->withCount(['likes as liked_by_me' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                }])
                ->whereIn('user_id', $visibleUserIds)
                ->latest();

            if ($activeCategory) {
                $postsQuery->where('category', $activeCategory);
            }
        }

        $posts = $postsQuery->get();

        // Highlights of the week (category counts in last 7 days)
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

    // --------------------
    // Store New Post
    // --------------------
    // Validates input, attaches user_id, and creates a new post.
    // Redirects back to feed with success message.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_content' => 'required|string|max:1000',
            'category'     => 'required|in:academic,events,announcement,campus_life,help_wanted',
            'link'         => 'nullable|url',
            'image'        => 'nullable|url',
        ]);

        $validated['user_id'] = Auth::user()->user_id;

        Post::create($validated);

        return redirect()->route('feed')->with('success', 'Post created successfully!');
    }

    // --------------------
    // Show Single Post
    // --------------------
    // Loads one post with counts and relationships,
    // builds follow maps, and returns feed view with singlePost flag.
    public function show(Post $post)
    {
        $user = Auth::user();

        // Load relationships and counts
        $post->load('user');
        $post->loadCount(['likes', 'comments']);

        // Build follow maps (same as index)
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

        // Wrap single post in collection
        $posts = collect([$post]);

        $singlePost = true;

        return view('feed', compact('posts', 'followMap', 'followIdMap', 'singlePost'));
    }

    // --------------------
    // Show Edit Form
    // --------------------
    // Ensures only the post owner can edit,
    // then returns the edit view.
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::user()->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    // --------------------
    // Update Post
    // --------------------
    // Validates input and updates a post.
    // Only the post owner can perform this action.
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

    // --------------------
    // Delete Post
    // --------------------
    // Deletes a post if it belongs to the logged-in user.
    // Returns success message after deletion.
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