<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'post_id',
        'reported_by',
        'reason',
        'details',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the post that was reported.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    /**
     * Get the user that filed the report.
     */
    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by', 'user_id');
    }
}
