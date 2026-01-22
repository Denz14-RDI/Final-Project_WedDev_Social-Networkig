<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{   
    // store a new comment on a post
    public function store(Request $request, Post $post){
        $request->validate([
            'com_content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $post->post_id,
            'user_id' => Auth::user()->user_id,
            'com_content' => $request->com_content,
        ]);

        $comment->load('user'); // eager load the user who made the comment

        $commentsCount = $post->comments()->count();

        return response()->json([
            'message' => 'Comment added successfully.',
            'comment' => $comment,
            'comments_count' => $commentsCount,
        ]);
    }

    // update an existing comment
    public function update(Request $request, Comment $comment){
        if ($comment->user_id !== Auth::user()->user_id){
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
    public function destroy(Comment $comment){
        if ($comment->user_id !== Auth::user()->user_id){
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
    public function index(Post $post){
        $comments = $post->comments()
            ->with('user') // eager load the user who made the comment
            ->latest() // order by most recent
            ->get();

        return response()->json($comments);
    }
}
