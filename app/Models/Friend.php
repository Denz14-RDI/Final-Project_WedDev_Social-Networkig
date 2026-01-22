<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Friend extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'friend_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'user_id_1',
        'user_id_2',
        'status',
    ];

    public function follower()
    {
        return $this->belongsTo(User::class, 'user_id_1');
    }

    public function following()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }   
}
