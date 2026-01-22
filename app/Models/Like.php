<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'like_id'; //primary key
    protected $keyType = 'int';
    public $incrementing = true;

    // mass assignable attributes/fields
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // relationships (getting the post that was liked and the user who liked it)
    // a like belongs to a post
    public function post(){
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }
    // a like belongs to a user
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}