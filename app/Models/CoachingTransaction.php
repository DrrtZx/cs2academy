<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachingTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'package_name',
        'package_price',
        'va_code',
        'status',
    ];

    /**
     * Relasi: setiap transaksi dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: transaksi yang menunggu verifikasi admin.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: transaksi yang sudah disetujui.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
