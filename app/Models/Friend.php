<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $primaryKey = 'friend_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'user_id_1',
        'user_id_2',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the first user in the friendship.
     */
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_id_1', 'user_id');
    }

    /**
     * Get the second user in the friendship.
     */
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_id_2', 'user_id');
    }
}
