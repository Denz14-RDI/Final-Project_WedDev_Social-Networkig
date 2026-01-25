<?php
// ---------------------------------------------------------------
// User model representing a user in the social networking system
// ---------------------------------------------------------------

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

// -----------------------------------------
// Class User
// Maps to 'users' table in the database
// -----------------------------------------

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Primary key column for the users table, data type, and auto-incrementing setting
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Use user_id for route model binding
    public function getRouteKeyName()
    {
        return 'user_id';
    }

    // The attributes that are mass assignable
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'bio',
        'profile_pic',
        'role',
    ];

    // The attributes that should be hidden for serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes to specific data types
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Global scope: exclude admins only in community context
    protected static function booted()
    {
        // Apply scope only when not running in admin routes
        if (!app()->runningInConsole() && request()->is('feed*', 'search*', 'community*')) {
            static::addGlobalScope('membersOnly', function (Builder $builder) {
                $builder->where('role', 'member');
            });
        }
    }

    // Optional reusable scope
    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    // Relationship: User has many Posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }

    // Relationship: User has many friends
    public function friends()
    {
        return $this->hasMany(Friend::class, 'user_id_1')
                    ->orWhere('user_id_2', $this->user_id);
    }

    // Relationship: User has many reports they submitted
    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_by', 'user_id');
    }

    // Relationship: User has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'user_id');
    }
}