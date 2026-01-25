<?php

// ----------------------------------------------
// Post model representing a post made by a user
// ----------------------------------------------

namespace App\Models;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// --------------------------------------
// Class Post
// Represents a post made by a user
// Maps to 'posts' table in the database
// --------------------------------------

class Post extends Model
{
    use HasFactory, SoftDeletes;

    // Primary key column for the posts table
    protected $primaryKey = 'post_id';

    // The attributes that are mass assignable
    protected $fillable = [
        'user_id', // ID of the user who created the post
        'category', // Category of the post
        'post_content', // Content of the post
        'image', // Optional image URL
        'link', // Optional link URL
    ];

    // Get the user who created the post
    // Relationship: Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Get the likes for the post
    // Relationship: Post has many Likes
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'post_id');
    }

    // Get the comments for the post
    // Relationship: Post has many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'post_id');
    }

    // Get the reports for the post
    // Relationship: Post has many Reports
    public function reports()
    {
        return $this->hasMany(Report::class, 'post_id', 'post_id');
    }

    // Use post_id for route model binding instead of default id
    public function getRouteKeyName()
    {
        return 'post_id';
    }
}
