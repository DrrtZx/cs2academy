<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachingMessage extends Model
{
    protected $fillable = ['assignment_id', 'sender_id', 'message', 'read_at'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /** Mark as read */
    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }
}
