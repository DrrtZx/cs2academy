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
        'bukti_transfer',
        'bukti_uploaded_at',
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'bukti_uploaded_at' => 'datetime',
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

    /**
     * Accessor: URL public untuk bukti transfer.
     * Uses Laravel route to serve file directly (avoids symlink 403 with artisan serve).
     */
    public function getBuktiUrlAttribute()
    {
        if (!$this->bukti_transfer) {
            return null;
        }
        return route('bukti.serve', ['filename' => $this->bukti_transfer]);
    }
}
