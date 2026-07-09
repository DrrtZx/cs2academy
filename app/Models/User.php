<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ["name", "email", "password", "role", "has_paid"];

    protected $hidden = ["password", "remember_token"];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "has_paid" => "boolean",
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
}
