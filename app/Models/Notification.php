<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'created_by',
        'user_id', // null = broadcast to all, set = targeted to specific user
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime'
    ];

    /**
     * Get the admin who created the notification
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the target user (if personal notification)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope for broadcast notifications (visible to all users)
     */
    public function scopeBroadcast($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Scope for notifications visible to a specific user
     * (includes broadcasts + personal notifications)
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->whereNull('user_id')  // Broadcast notifications
              ->orWhere('user_id', $userId);  // Personal notifications
        });
    }
}
