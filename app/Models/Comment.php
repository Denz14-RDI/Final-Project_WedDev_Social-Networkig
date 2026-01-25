<?php
// --------------------------------------------------
// Comment model representing comments on posts
// --------------------------------------------------

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// --------------------------------------------------
// Class Comment
// Represents a comment made by a user on a post
// Maps to 'comments' table in the database
// --------------------------------------------------

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    
    // Primary key column for the comments table, data type, and auto-incrementing setting
    protected $primaryKey = 'com_id';
    protected $keyType = 'int';
    public $incrementing = true;

    // The attributes that are mass assignable
    protected $fillable = [
        'post_id', // ID of the post being commented on
        'user_id', // ID of the user who made the comment
        'com_content', // Content of the comment
    ];

    // Cast attributes to specific data types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Get the post that this comment belongs to
    // Relationship: Comment belongs to a Post
    public function post(){
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    // Get the user who made this comment
    // Relationship: Comment belongs to a User
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
