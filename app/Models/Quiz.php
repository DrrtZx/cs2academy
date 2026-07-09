<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'course_id', 'pertanyaan', 'opsi', 'jawaban_benar', 'penjelasan', 'youtube_url',
    ];

    protected $casts = [
        'opsi' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * ACCESSOR: Ekstrak Video ID dari berbagai format link YouTube.
     * Dipanggil otomatis lewat $quiz->youtube_video_id
     *
     * Format yang didukung:
     * - https://www.youtube.com/watch?v=VIDEOID
     * - https://youtu.be/VIDEOID
     * - https://www.youtube.com/embed/VIDEOID
     * - https://www.youtube.com/shorts/VIDEOID
     * - youtube.com/watch?v=VIDEOID&t=10s (dengan parameter tambahan)
     */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        if (empty($this->youtube_url)) {
            return null;
        }

        $url = trim($this->youtube_url);

        // Pola regex untuk menangkap semua format link YouTube umum
        $pattern = '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Helper tambahan: langsung dapat URL embed yang siap dipakai di iframe
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $videoId = $this->youtube_video_id;
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }
}