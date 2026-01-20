<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Show all posts (feed)
    public function index()
    {
        // eager load user to avoid N+1 queries
        $posts = Post::with('user')->latest()->get();
        return view('feed', compact('posts'));
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