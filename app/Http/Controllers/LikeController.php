<?php
// ------------------------------------------------------------
// LikeController
// ------------------------------------------------------------
// Handles the like/unlike system for posts.
// manages soft deletes/restores for likes, and creates notifications
// when someone likes another user's post.
// ------------------------------------------------------------

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // --------------------
    // Toggle Like
    // --------------------
    // Allows the logged-in user to like or unlike a post.
    // Uses soft deletes to handle unlikes and restores for re-likes.
    // Creates a notification for the post owner when someone else likes their post.
    public function toggle(Post $post)
    {
        $user = Auth::user();

        // Check if a like already exists (including soft-deleted)
        $like = Like::withTrashed()
            ->where('post_id', $post->post_id)
            ->where('user_id', $user->user_id)
            ->first();

        $liked = false;

        // If like exists and is active, soft delete (unlike)
        if ($like && !$like->trashed()) {
            $like->delete();
            $liked = false;
        } else {
            // If like exists but is soft-deleted, restore it
            if ($like && $like->trashed()) {
                $like->restore();
            } else {
                // Otherwise, create a new like record
                Like::create([
                    'post_id' => $post->post_id,
                    'user_id' => $user->user_id,
                ]);
            }
            $liked = true;

            // Create notification only if liking someone else's post
            if ((int)$post->user_id !== (int)$user->user_id) {
                // Prevent duplicate notifications (important when restoring likes)
                $exists = Notification::where('user_id', $post->user_id)
                    ->where('notif_type', 'new_like')
                    ->where('entity_type', 'post')
                    ->where('entity_id', $post->post_id)
                    ->whereJsonContains('notif_data->actor_id', $user->user_id)
                    ->exists();

                if (!$exists) {
                    Notification::create([
                        'user_id'    => $post->user_id,     // receiver (post owner)
                        'notif_type' => 'new_like',
                        'entity_type'=> 'post',
                        'entity_id'  => $post->post_id,
                        'notif_data' => [
                            'actor_id'   => $user->user_id,
                            'actor_name' => $user->first_name . ' ' . $user->last_name,
                            'post_id'    => $post->post_id,
                        ],
                    ]);
                }
            }
        }

        // Refresh post with updated like count
        $post->loadCount('likes');

        // Return JSON response with current like state and updated count
        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes_count,
        ]);
    }
}