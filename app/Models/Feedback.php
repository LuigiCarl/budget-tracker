<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'rating',
        'status',
        'reviewed_by',
        'reviewed_at'
    ];

    protected $casts = [
        'rating' => 'integer',
        'reviewed_at' => 'datetime'
    ];

    /**
     * Get the user who submitted the feedback
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who reviewed the feedback
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
