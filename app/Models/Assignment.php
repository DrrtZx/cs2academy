<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'user_id', 'judul', 'tugas_teks', 'status', 'balasan_admin', 'from_admin', 'completed_at',
    ];

    protected $casts = [
        'from_admin'   => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relasi: setiap assignment milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: pesan-pesan chat dalam sesi ini
    public function messages()
    {
        return $this->hasMany(CoachingMessage::class)->orderBy('id');
    }

    /** Unread messages count (dari sisi admin — pesan dari user yg belum dibaca) */
    public function unreadCount(): int
    {
        return $this->messages()
            ->where('sender_id', '!=', 1) // bukan admin
            ->whereNull('read_at')
            ->count();
    }

    /** Last message preview */
    public function lastMessage(): ?CoachingMessage
    {
        return $this->messages()->latest('id')->first();
    }
}