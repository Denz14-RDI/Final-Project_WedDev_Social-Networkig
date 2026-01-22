<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'com_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'post_id',
        'user_id',
        'com_content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // get the post that this comment belongs to
    public function post(){
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    // get the user who made this comment
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
