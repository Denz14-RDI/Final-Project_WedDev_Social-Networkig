<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Notification;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->user_id;
        $validated['post_id'] = $post->post_id;

        $comment = Comment::create($validated);

        // Create notification for post author
        if ($post->user_id !== auth()->user()->user_id) {
            Notification::create([
                'user_id' => $post->user_id,
                'notif_type' => 'new_comment',
                'entity_type' => 'comment',
                'entity_id' => $comment->com_id,
                'notif_data' => json_encode([
                    'message' => auth()->user()->first_name . ' commented on your post',
                    'post_id' => $post->post_id,
                    'comment_id' => $comment->com_id,
                ]),
            ]);
        }

        return back()->with('success', 'Comment added successfully.');
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        $post = $comment->post;
        return view('comments.edit', compact('comment', 'post'));
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $comment->update($request->validated());

        return back()->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $post = $comment->post;
        
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
