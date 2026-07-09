<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['icon', 'title', 'body', 'urutan'];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class)->orderBy('id');
    }
}