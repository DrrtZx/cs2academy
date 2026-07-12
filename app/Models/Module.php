<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['course_id', 'title', 'body', 'youtube_url', 'urutan'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class)->orderBy('id');
    }

    public function progress()
    {
        return $this->hasMany(ModuleProgress::class);
    }

    /** Ekstrak Video ID dari berbagai format link YouTube */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        if (empty($this->youtube_url)) return null;
        $url = trim($this->youtube_url);
        $pattern = '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        if (preg_match($pattern, $url, $matches)) return $matches[1];
        return null;
    }

    /** URL embed siap pakai di iframe */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $videoId = $this->youtube_video_id;
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    /** Progress user saat ini untuk modul ini */
    public function userProgress(?int $userId): ?ModuleProgress
    {
        if (!$userId) return null;
        return $this->progress()->where('user_id', $userId)->first();
    }

    /** Status modul untuk user tertentu: done | active | locked */
    public function statusFor(?int $userId, array $allModuleIds, int $index): string
    {
        if (!$userId) return $index === 0 ? 'active' : 'locked';
        if ($this->userProgress($userId)?->completed_at) return 'done';
        if ($index === 0) return 'active';
        $prevId = $allModuleIds[$index - 1] ?? null;
        if ($prevId) {
            $prevProgress = ModuleProgress::where('user_id', $userId)
                ->where('module_id', $prevId)->first();
            return $prevProgress?->completed_at ? 'active' : 'locked';
        }
        return 'locked';
    }
}
