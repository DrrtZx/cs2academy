<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleProgress;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /** Katalog kursus — grid card */
    public function index()
    {
        $userId = auth()->id();
        $courses = Course::with('modules.quizzes')->orderBy('urutan')->get();
        $courseIds = $courses->pluck('id')->all();

        $coursesData = $courses->map(function ($c) use ($userId, $courseIds, $courses) {
            $idx = $courses->search(fn($co) => $co->id === $c->id);
            return [
                'id'         => $c->id,
                'icon'       => $c->icon,
                'title'      => $c->title,
                'body'       => $c->body,
                'level'      => $c->level,
                'durasi'     => $c->durasi,
                'type'       => $c->type,
                'is_popular' => $c->is_popular,
                'modules_count' => $c->modules->count(),
                'progress'   => $c->progressPercent($userId),
                'unlocked'   => $c->isUnlockedFor($userId, $courseIds, $idx),
                'quizzes_count' => $c->modules->flatMap->quizzes->count(),
            ];
        });

        return view('courses.index', compact('coursesData'));
    }

    /** Detail modul — sidebar + outline + quiz */
    public function show(Course $course)
    {
        $userId = auth()->id();
        $course->load('modules.quizzes');
        $modules = $course->modules;
        $moduleIds = $modules->pluck('id')->all();

        $modulesData = $modules->map(function ($mod, $idx) use ($userId, $moduleIds) {
            $status = $mod->statusFor($userId, $moduleIds, $idx);
            $quizzes = $mod->quizzes->map(fn($q) => [
                'id'        => $q->id,
                'q'         => $q->pertanyaan,
                'opts'      => $q->opsi,
                'ans'       => $q->jawaban_benar,
                'ex'        => $q->penjelasan ?? '',
            ])->values()->all();
            return [
                'id'           => $mod->id,
                'title'        => $mod->title,
                'body'         => $mod->body,
                'youtube_url'  => $mod->youtube_url,
                'youtube_id'   => $mod->youtube_video_id,
                'youtube_embed'=> $mod->youtube_embed_url,
                'status'       => $status,
                'quizzes'      => $quizzes,
            ];
        });

        // Modul pertama yang active, atau pertama
        $firstActive = $modulesData->firstWhere('status', 'active');
        $activeModId = $firstActive ? $firstActive['id'] : ($modulesData->first()['id'] ?? null);

        return view('courses.show', [
            'course'       => $course,
            'modulesData'  => $modulesData,
            'activeModId'  => $activeModId,
            'progress'     => $course->progressPercent($userId),
        ]);
    }

    /** Simpan progress per MODUL (bukan per course) */
    public function markModuleComplete(Request $request, Module $module)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        ModuleProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'module_id' => $module->id],
            ['score' => $validated['score'], 'completed_at' => now()]
        );

        // Cek apakah semua modul di course ini sudah selesai
        $allDone = $module->course->progressPercent(auth()->id()) === 100;

        return response()->json([
            'success'   => true,
            'course_done' => $allDone,
        ]);
    }
}
