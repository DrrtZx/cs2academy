<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ["name", "email", "password", "role", "has_paid", "active_coaching_package"];

    protected $hidden = ["password", "remember_token"];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password"          => "hashed",
            "has_paid"          => "boolean",
        ];
    }

    // Relasi: satu user punya banyak assignment
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Relasi: satu user punya banyak progress kursus
    public function courseProgress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    // Relasi: satu user punya banyak transaksi coaching
    public function coachingTransactions()
    {
        return $this->hasMany(CoachingTransaction::class);
    }

    // Helper: cek apakah user adalah admin
    public function isAdmin(): bool
    {
        return $this->role === "admin";
    }

    // Helper: akses konten berbayar (sudah bayar ATAU admin, admin selalu punya akses penuh)
    public function hasCourseAccess(): bool
    {
        return $this->has_paid || $this->isAdmin();
    }

    // Helper: cek apakah user masih punya sesi coaching yang aktif
    // Return true jika: ada transaksi pending (menunggu verifikasi) ATAU
    // ada transaksi approved dan masih ada assignment yang belum selesai
    public function hasPendingCoaching(): bool
    {
        // Jika ada transaksi pending (menunggu verifikasi admin), blokir
        if ($this->coachingTransactions()->where('status', 'pending')->exists()) {
            return true;
        }

        // Jika ada transaksi approved, cek apakah masih ada sesi aktif
        if ($this->coachingTransactions()->where('status', 'approved')->exists()) {
            return $this->assignments()->where('status', '!=', 'selesai')->exists();
        }

        return false;
    }
}
