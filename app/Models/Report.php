<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // Primary key
    protected $primaryKey = 'report_id';

    // Mass assignable fields
    protected $fillable = [
        'post_id',
        'reported_by',
        'reason',
        'details',
        'status',
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by', 'user_id');
    }
}