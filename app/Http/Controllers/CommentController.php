<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // store a new comment on a post
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'com_content' => 'required|string|max:1000',
        ]);

        $actor = Auth::user();

        $comment = Comment::create([
            'post_id' => $post->post_id,
            'user_id' => $actor->user_id,
            'com_content' => $request->com_content,
        ]);

        $comment->load('user'); // eager load the user who made the comment

        // ✅ CREATE NOTIFICATION (only if commenting on someone else's post)
        if ((int)$post->user_id !== (int)$actor->user_id) {

            // optional: avoid duplicates if user spam-clicks submit etc.
            $exists = Notification::where('user_id', $post->user_id) // receiver (post owner)
                ->where('notif_type', 'new_comment')
                ->where('entity_type', 'post')
                ->where('entity_id', $post->post_id)
                ->whereJsonContains('notif_data->comment_id', $comment->com_id)
                ->exists();

            if (!$exists) {
                Notification::create([
                    'user_id'     => $post->user_id,   // receiver
                    'notif_type'  => 'new_comment',
                    'entity_type' => 'post',
                    'entity_id'   => $post->post_id,
                    'notif_data'  => [
                        'actor_id'     => $actor->user_id,
                        'actor_name'   => $actor->first_name . ' ' . $actor->last_name,
                        'post_id'      => $post->post_id,
                        'comment_id'   => $comment->com_id,
                        'comment_text' => $comment->com_content,
                    ],
                ]);
            }
        }

        $commentsCount = $post->comments()->count();

        return response()->json([
            'message' => 'Comment added successfully.',
            'comment' => $comment,
            'comments_count' => $commentsCount,
        ]);
    }

    // update an existing comment
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::user()->user_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'com_content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'com_content' => $request->com_content,
        ]);

        $comment->load('user'); // eager load the user who made the comment

        return response()->json([
            'message' => 'Comment updated successfully.',
            'comment' => $comment,
        ]);
    }

    // soft delete a comment
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::user()->user_id) {
            abort(403, 'Unauthorized');
        }

        $post = $comment->post;
        $deletedId = $comment->com_id;

        $comment->delete();

        $commentsCount = $post->comments()->count();

        return response()->json([
            'message' => 'Comment deleted successfully.',
            'deleted_id' => $deletedId,
            'comments_count' => $commentsCount,
        ]);
    }

    // get all comments for a specific post
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->with('user') // eager load the user who made the comment
            ->latest() // order by most recent
            ->get();

        return response()->json($comments);
    }
}
