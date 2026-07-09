<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'user_id', 'judul', 'tugas_teks', 'status', 'balasan_admin', 'from_admin',
    ];

    protected $casts = [
        'from_admin' => 'boolean',
    ];

    // Relasi: setiap assignment milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}