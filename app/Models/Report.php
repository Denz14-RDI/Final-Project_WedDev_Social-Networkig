<?php

// ---------------------------------------------------------
// Report model representing reports made by users on posts
// ---------------------------------------------------------

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// -----------------------------------------
// Class Report
// Maps to 'reports' table in the database
// -----------------------------------------

class Report extends Model
{
    // Primary key column for the reports table, data type, and auto-incrementing setting
    protected $primaryKey = 'report_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // The attributes that are mass assignable
    protected $fillable = [
        'post_id', // ID of the reported post
        'reported_by', // ID of the user who reported
        'reason', // Reason for the report
        'details', // Additional details provided by the reporter
        'status', // Status of the report (pending, resolved, dismissed)
    ];

    // Get the post that was reported
    // Relationship: Report belongs to a Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    // Get the user who reported the post
    // Relationship: Report belongs to a User (custom PK on users table)
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by', 'user_id');
    }


    // Check if report is pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Check if report is resolved
    public function isResolved()
    {
        return $this->status === 'resolved';
    }

    // Check if report is dismissed
    public function isDismissed()
    {
        return $this->status === 'dismissed';
    }
}