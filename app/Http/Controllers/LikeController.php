<?php

namespace App\Http\Controllers;

use App\Models\Like;
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
        }

        $post->loadCount('likes');

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes_count,
        ]);
    }
}
