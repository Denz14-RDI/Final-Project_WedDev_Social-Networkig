<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Primary key
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function getRouteKeyName()
    {
        return 'user_id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Global scope: exclude admins only in community context
     */
    protected static function booted()
    {
        // Apply scope only when not running in admin routes
        if (!app()->runningInConsole() && request()->is('feed*', 'search*', 'community*')) {
            static::addGlobalScope('membersOnly', function (Builder $builder) {
                $builder->where('role', 'member');
            });
        }
    }

    /**
     * Optional reusable scope
     */
    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    // ✅ Relationships
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }

    public function friends()
    {
        return $this->hasMany(Friend::class, 'user_id_1')
                    ->orWhere('user_id_2', $this->user_id);
    }

    public function reports()
    {
        // User has many reports they submitted
        return $this->hasMany(Report::class, 'reported_by', 'user_id');
    }
}

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    // public function likes()
    // {
    //     return $this->hasMany(Like::class);
    // }