<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['icon', 'title', 'body', 'urutan', 'level', 'durasi', 'type', 'is_popular'];

    protected $casts = [
        'is_popular' => 'boolean',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class)->orderBy('id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('urutan');
    }

    /** Progress: berapa persen modul yang sudah selesai oleh user */
    public function progressPercent(?int $userId): int
    {
        if (!$userId) return 0;
        $total = $this->modules()->count();
        if ($total === 0) return 0;
        $done = ModuleProgress::where('user_id', $userId)
            ->whereIn('module_id', $this->modules()->pluck('id'))
            ->whereNotNull('completed_at')
            ->count();
        return (int) round(($done / $total) * 100);
    }

    /** Semua kursus terbuka — user bisa pilih mulai dari mana aja */
    public function isUnlockedFor(?int $userId, array $allCourseIds, int $index): bool
    {
        // ponytail: semua kursus langsung bisa diakses, tanpa prasyarat
        return true;
    }
}
