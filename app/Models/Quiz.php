<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'course_id', 'module_id', 'pertanyaan', 'opsi', 'jawaban_benar', 'penjelasan',
    ];

    protected $casts = [
        'opsi' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
