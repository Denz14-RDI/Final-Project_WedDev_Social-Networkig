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
        'user_id',
        'notif_type',
        'entity_type',
        'entity_id',
        'notif_data',
        'read_at',
    ];

    protected $casts = [
        'notif_data' => 'json',
        'created_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that receives the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead()
    {
        return $this->update(['read_at' => now()]);
    }

    /**
     * Check if notification has been read.
     */
    public function isRead()
    {
        return $this->read_at !== null;
    }
}
