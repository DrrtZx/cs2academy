<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseProgress;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('quizzes')->orderBy('urutan')->get();

        $coursesJson = $courses->map(function ($c) {
            return [
                'id'    => $c->id,
                'ic'    => $c->icon,
                'title' => $c->title,
                'body'  => $c->body,
                'quiz'  => $c->quizzes->map(function ($q) {
                    return [
                        'q'        => $q->pertanyaan,
                        'opts'     => $q->opsi,
                        'ans'      => $q->jawaban_benar,
                        'ex'       => $q->penjelasan ?? '',
                        'video_id' => $q->youtube_video_id, // ← tambahan baru
                    ];
                })->values()->all(),
            ];
        })->values()->toJson();

        // Kursus yang sudah pernah diselesaikan user (untuk restore progress setelah refresh)
        $completedCourseIds = auth()->check()
            ? auth()->user()->courseProgress()->whereNotNull('completed_at')->pluck('course_id')->all()
            : [];

        return view('courses.index', compact('courses', 'coursesJson', 'completedCourseIds'));
    }

    // Simpan progress kursus (dipanggil via fetch() saat user lulus quiz)
    public function markComplete(Request $request, Course $course)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        CourseProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'course_id' => $course->id],
            ['score' => $validated['score'], 'completed_at' => now()]
        );

        return response()->json(['success' => true]);
    }
}
