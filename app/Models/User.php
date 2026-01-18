<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $keyType = 'int';
    public $incrementing = true;

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
     * Get the posts authored by the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'user_id');
    }

    /**
     * Get the comments made by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'user_id');
    }

    /**
     * Get the likes made by the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id', 'user_id');
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }

    /**
     * Get the reports filed by the user.
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_by', 'user_id');
    }

    /**
     * Get friend requests and accepted friends (user_id_1 side).
     */
    public function friendRequestsSent()
    {
        return $this->hasMany(Friend::class, 'user_id_1', 'user_id');
    }

    /**
     * Get friend requests and accepted friends (user_id_2 side).
     */
    public function friendRequestsReceived()
    {
        return $this->hasMany(Friend::class, 'user_id_2', 'user_id');
    }

    /**
     * Get all friends (accepted status only).
     */
    public function friends()
    {
        return $this->friendRequestsSent()
            ->where('status', 'accepted')
            ->union($this->friendRequestsReceived()->where('status', 'accepted'));
    }
}
