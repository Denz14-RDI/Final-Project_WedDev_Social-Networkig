<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'post_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'post_content',
        'category',
        'link',
        'image',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that authored the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the comments on the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'post_id');
    }

    /**
     * Get the likes on the post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'post_id');
    }

    /**
     * Get the reports for the post.
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'post_id', 'post_id');
    }

    /**
     * Check if the post is liked by a specific user.
     */
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Get the count of likes.
     */
    public function getLikesCount()
    {
        return $this->likes()->count();
    }
}
