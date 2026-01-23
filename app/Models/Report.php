<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // Custom primary key
    protected $primaryKey = 'report_id';
    public $incrementing = true;
    protected $keyType = 'int';

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
        // Report belongs to a Post (custom PK on posts table)
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function reporter()
    {
        // Report belongs to a User (custom PK on users table)
        return $this->belongsTo(User::class, 'reported_by', 'user_id');
    }

    // ✅ Helper: check if report is pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // ✅ Helper: check if report is resolved
    public function isResolved()
    {
        return $this->status === 'resolved';
    }

    // ✅ Helper: check if report is dismissed
    public function isDismissed()
    {
        return $this->status === 'dismissed';
    }
}