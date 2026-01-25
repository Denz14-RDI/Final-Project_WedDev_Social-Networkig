<?php

// ---------------------------------------------------
// Notification model representing user notifications
// ---------------------------------------------------

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// -------------------------------------------------------------------------
// Class Notification
// Notifications inform users about actions such as likes, comments, follows
// Maps to 'notifications' table in the database
// -------------------------------------------------------------------------

class Notification extends Model
{
    use HasFactory;

    // Primary key column for the notifications table, data type, and auto-incrementing setting
    protected $primaryKey = 'notif_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false; // Disable default Laravel timestamps

    // The attributes that are mass assignable
    protected $fillable = [
        'user_id', // Receiver of the notification
        'notif_type', // Type of notification (new_like, new_comment, new_friend)
        'entity_type', // Type of entity (user, post, comment)
        'entity_id', // ID of the related entity
        'notif_data', // Additional data as JSON
        'read_at', // Timestamp when notification was read
    ];

    // Cast attributes to specific data types
    protected $casts = [
        'notif_data' => 'array', // JSON to array
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // Get the user who received the notification
    // Relationship: Notification belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Get the related entity for the notification
    // Relationship: Notification belongs to various entities based on entity_type
    public function entity(){
        switch($this->entity_type){
            case 'user':
                return $this->belongsTo(User::class, 'entity_id', 'user_id');
            case 'post':
                return $this->belongsTo(Post::class, 'entity_id', 'post_id');
            case 'comment':
                return $this->belongsTo(Comment::class, 'entity_id', 'com_id');
            default:
                return null;
        }
    }
}