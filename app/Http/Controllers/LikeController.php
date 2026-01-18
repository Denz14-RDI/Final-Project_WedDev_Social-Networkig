<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Notification;

class LikeController extends Controller
{
    /**
     * Toggle like on a post.
     */
    public function toggle(Post $post)
    {
        $user = auth()->user();
        
        $like = Like::where('post_id', $post->post_id)
            ->where('user_id', $user->user_id)
            ->first();

        if ($like) {
            $like->delete();
            $message = 'Like removed.';
        } else {
            Like::create([
                'post_id' => $post->post_id,
                'user_id' => $user->user_id,
            ]);

            // Create notification for post author
            if ($post->user_id !== $user->user_id) {
                Notification::create([
                    'user_id' => $post->user_id,
                    'notif_type' => 'new_like',
                    'entity_type' => 'post',
                    'entity_id' => $post->post_id,
                    'notif_data' => json_encode([
                        'message' => $user->first_name . ' liked your post',
                        'post_id' => $post->post_id,
                    ]),
                ]);
            }

            $message = 'Post liked.';
        }

        return back()->with('success', $message);
    }

    /**
     * Get likes count for a post.
     */
    public function count(Post $post)
    {
        return response()->json(['count' => $post->likes()->count()]);
    }
}
