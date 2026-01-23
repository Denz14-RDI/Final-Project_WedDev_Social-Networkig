<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'user_id',
        'category',
        'post_content',
        'image',
        'link',
    ];

    // Relationship: Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // ✅ Relationship: Post has many Reports
    public function reports()
    {
        return $this->hasMany(Report::class, 'post_id', 'post_id');
    }
}