<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    protected $table = 'course_progress';

    protected $fillable = [
        'user_id', 'course_id', 'score', 'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
