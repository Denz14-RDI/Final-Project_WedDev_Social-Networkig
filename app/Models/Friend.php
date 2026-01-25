<?php
// --------------------------------------------------------------
// Friend model representing a follow relationship between users
// --------------------------------------------------------------

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// -----------------------------------------------------
// Class Friend
// One user (user_id_1) follows another user (user_id_2)
// Maps to 'friends' table in the database
// -----------------------------------------------------

class Friend extends Model
{
    use HasFactory, SoftDeletes;

    // Primary key column for the friends table, data type, and auto-incrementing setting
    protected $primaryKey = 'friend_id';
    protected $keyType = 'int';
    public $incrementing = true;

    // The attributes that are mass assignable
    protected $fillable = [
        'user_id_1', // User who follows
        'user_id_2', // User being followed
        'status',   // Following status
    ];

    // Get the user who followed another user
    // Relationship: Friend belongs to a User (follower)
    public function follower()
    {
        return $this->belongsTo(User::class, 'user_id_1');
    }

    // Get the user who is being followed
    // Relationship: Friend belongs to a User (following)
    public function following()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }   
}