<?php
// ------------------------------------------------------------
// CommentController
// ------------------------------------------------------------
// Handles all comment-related actions for posts.
// Provides routes for creating, updating, deleting, and listing comments.
// Also triggers notifications when users comment on others' posts.
// ------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // --------------------
    // Store New Comment
    // --------------------
    // Validates input, creates a new comment on a post,
    // and triggers a notification for the post owner.
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'com_content' => 'required|string|max:1000',
        ]);

        $actor = Auth::user();

        // Create new comment record
        $comment = Comment::create([
            'post_id'    => $post->post_id,
            'user_id'    => $actor->user_id,
            'com_content'=> $request->com_content,
        ]);

        $comment->load('user'); // eager load the user who made the comment

        // Create notification only if commenting on someone else's post
        if ((int)$post->user_id !== (int)$actor->user_id) {
            // Prevent Duplications
            $exists = Notification::where('user_id', $post->user_id) // receiver (post owner)
                ->where('notif_type', 'new_comment')
                ->where('entity_type', 'post')
                ->where('entity_id', $post->post_id)
                ->whereJsonContains('notif_data->comment_id', $comment->com_id)
                ->exists();

            // If comment is not exist it will create a new one
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

        // Count Comment
        $commentsCount = $post->comments()->count();

        return response()->json([
            'message'        => 'Comment added successfully.',
            'comment'        => $comment,
            'comments_count' => $commentsCount,
        ]);
    }

    // --------------------
    // Update Comment
    // --------------------
    // Validates input and updates an existing comment.
    // Only the comment owner can perform this action.
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

        $comment->load('user'); // load the user who made the comment

        return response()->json([
            'message' => 'Comment updated successfully.',
            'comment' => $comment,
        ]);
    }

    // --------------------
    // Delete Comment
    // --------------------
    // Soft deletes a comment.
    // Only the comment owner can perform this action.
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
            'message'        => 'Comment deleted successfully.',
            'deleted_id'     => $deletedId,
            'comments_count' => $commentsCount,
        ]);
    }

    // --------------------
    // List Comments
    // --------------------
    // Retrieves all comments for a specific post,
    // eager loads the user who made each comment,
    // and orders them by most recent.
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->with('user') // load the user who made the comment
            ->latest()     // order by most recent
            ->get();

        return response()->json($comments);
    }
}