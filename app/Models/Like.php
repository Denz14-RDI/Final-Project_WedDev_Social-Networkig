<?php

// ------------------------------------------------------------
// Like model representing a 'like' action by a user on a post
// ------------------------------------------------------------

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// ----------------------------------------------------
// Class Like
// A user can like a post, and unlike it (soft delete)
// Maps to 'likes' table in the database
// ----------------------------------------------------

class Like extends Model
{
    use HasFactory, SoftDeletes;

    // Primary key column for the likes table, data type, and auto-incrementing setting
    protected $primaryKey = 'like_id'; 
    protected $keyType = 'int';
    public $incrementing = true;

    // The attributes that are mass assignable
    protected $fillable = [
        'post_id', // ID of the liked post
        'user_id', // ID of the user who liked the post
    ];

    // Cast attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Get the post that was liked
    // Relationship: Like belongs to a Post
    public function post(){
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    // Get the user who liked the post
    // Relationship: Like belongs to a User
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}