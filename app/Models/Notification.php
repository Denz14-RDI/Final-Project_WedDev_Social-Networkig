<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notif_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'notif_type',
        'entity_type',
        'entity_id',
        'notif_data',
        'read_at',
    ];

    protected $casts = [
        'notif_data' => 'array', // JSON to array
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function entity(){
        switch($this->entity_type){
            case 'user':
                return $this->belongsTo(User::class, 'entity_id', 'user_id');
            case 'post':
                return $this->belongsTo(Post::class, 'entity_id', 'post_id');
            case 'comment':
                return $this->belongsTo(Comment::class, 'entity_id', 'comment_id');
            default:
                return null;
        }
    }
}