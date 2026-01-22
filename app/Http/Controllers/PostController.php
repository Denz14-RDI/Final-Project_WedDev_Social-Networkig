<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    // Show all posts (feed)
    public function index()
    {
        // ✅ allowed categories (same as your validation)
        $allowed = ['academic', 'events', 'announcement', 'campus_life', 'help_wanted'];

        // ✅ get category filter from URL: /feed?category=academic
        $activeCategory = request()->query('category');

        // eager load user to avoid N+1 queries (same behavior, but filter if category is valid)
        $postsQuery = Post::with('user')->latest();

        if ($activeCategory && in_array($activeCategory, $allowed, true)) {
            $postsQuery->where('category', $activeCategory);
        } else {
            $activeCategory = null; // ignore invalid category
        }

        $posts = $postsQuery->get();

        // Highlights of the Week (last 7 days)
        $since = Carbon::now()->subDays(7);

        $counts = Post::select('category', DB::raw('COUNT(*) as total'))
            ->whereIn('category', $allowed)
            ->where('created_at', '>=', $since)
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // labels only (no icons)
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


        return view('feed', compact('posts', 'highlights', 'activeCategory'));
    }

    // Store a new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_content' => 'required|string|max:1000',
            'category'     => 'required|in:academic,events,announcement,campus_life,help_wanted',
            'link'         => 'nullable|url',
            'image'        => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Post::create($validated);

        return redirect()->route('feed')->with('success', 'Post created successfully!');
    }

    // Show edit form
    public function edit(Post $post)
    {
        // Only allow owner to edit
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    // Update post
    public function update(Request $request, Post $post)
    {
        // Only allow owner to update
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'post_content' => 'required|string|max:1000',
            'category'     => 'required|in:academic,events,announcement,campus_life,help_wanted',
            'link'         => 'nullable|url',
            'image'        => 'nullable|string',
        ]);

        $post->update($validated);

        return redirect()->route('feed')->with('success', 'Post updated successfully!');
    }

    // Delete a post (soft delete)
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('feed')->with('success', 'Post deleted successfully!');
    }
}
