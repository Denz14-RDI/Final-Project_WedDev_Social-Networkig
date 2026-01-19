<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    // Primary key
    protected $primaryKey = 'post_id';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'post_content',
        'category',
        'link',
        'image',
        'status',
    ];

    // Relationship: Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}