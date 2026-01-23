<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();

        $like = Like::withTrashed()
            ->where('post_id', $post->post_id)
            ->where('user_id', $user->user_id)
            ->first();

        $liked = false;

        if ($like && !$like->trashed()) {
            $like->delete(); // already liked, so unlike (soft delete)
            $liked = false;
        } else {
            if ($like && $like->trashed()) {
                $like->restore(); // previously unliked, so restore (soft-deleted) like
            } else {
                Like::create([
                    'post_id' => $post->post_id,
                    'user_id' => $user->user_id,
                ]);
            }
            $liked = true;

            // ✅ CREATE NOTIFICATION (only if liking someone else's post)
            if ((int)$post->user_id !== (int)$user->user_id) {

                // prevent duplicates (important dahil may restore)
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
                        'entity_type' => 'post',
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

        $post->loadCount('likes');

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes_count,
        ]);
    }
}
