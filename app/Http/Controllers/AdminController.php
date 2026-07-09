<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard utama admin: ringkasan statistik platform
    public function dashboard()
    {
        $stats = [
            "total_users" => User::where("role", "user")->count(),
            "total_admins" => User::where("role", "admin")->count(),
            "total_paid" => User::where("has_paid", true)->count(),
            "total_courses" => Course::count(),
            "total_quizzes" => Quiz::count(),
            "total_completions" => CourseProgress::whereNotNull(
                "completed_at",
            )->count(),
            "total_assignments" => Assignment::count(),
            "assignments_menunggu" => Assignment::where(
                "status",
                "menunggu",
            )->count(),
            "assignments_diproses" => Assignment::where(
                "status",
                "diproses",
            )->count(),
            "assignments_selesai" => Assignment::where(
                "status",
                "selesai",
            )->count(),
        ];

        $recentBuyers = User::where("has_paid", true)->latest()->take(5)->get();
        $recentAssignments = Assignment::with("user")->latest()->take(5)->get();

        return view(
            "admin.dashboard",
            compact("stats", "recentBuyers", "recentAssignments"),
        );
    }

    // Aktifkan mode preview: admin melihat situs seperti tampilan role user biasa
    public function enablePreviewMode(Request $request)
    {
        $request->session()->put("admin_preview_mode", true);
        return redirect()->route("home");
    }

    // Matikan mode preview, kembali ke tampilan admin
    public function disablePreviewMode(Request $request)
    {
        $request->session()->forget("admin_preview_mode");
        return redirect()->route("admin.dashboard");
    }

    public function assignments()
    {
        $assignments = Assignment::with("user")->latest()->get();
        return view("admin.assignments", compact("assignments"));
    }

    public function updateAssignment(Request $request, Assignment $assignment)
    {
        $request->validate([
            "balasan_admin" => "required|string",
            "status" => "required|in:menunggu,diproses,selesai",
        ]);
        $assignment->update([
            "balasan_admin" => $request->balasan_admin,
            "status" => $request->status,
        ]);
        return back()->with("success", "Balasan berhasil disimpan!");
    }

    public function deleteAssignment(Assignment $assignment)
    {
        $assignment->delete();
        return back()->with("success", "Tugas berhasil dihapus!");
    }

    public function quiz()
    {
        $courses = Course::with("quizzes")->orderBy("urutan")->get();
        return view("admin.quiz", compact("courses"));
    }

    public function storeQuiz(Request $request, Course $course)
    {
        $validated = $request->validate(
            [
                "pertanyaan" => "required|string",
                "opsi" => "required|array|min:4",
                "opsi.*" => "required|string",
                "jawaban_benar" => "required|integer|min:0|max:3",
                "penjelasan" => "nullable|string",
                "youtube_url" => [
                    "nullable",
                    "url",
                    'regex:/^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/.+$/',
                ],
            ],
            [
                "youtube_url.url" =>
                    "Format link tidak valid. Harus berupa URL lengkap (contoh: https://youtube.com/watch?v=xxxx).",
                "youtube_url.regex" =>
                    "Link harus berasal dari YouTube (youtube.com atau youtu.be).",
            ],
        );

        Quiz::create([
            "course_id" => $course->id,
            "pertanyaan" => $validated["pertanyaan"],
            "opsi" => $validated["opsi"],
            "jawaban_benar" => $validated["jawaban_benar"],
            "penjelasan" => $validated["penjelasan"] ?? null,
            "youtube_url" => $validated["youtube_url"] ?? null,
        ]);

        return back()->with("success", "Soal baru berhasil ditambahkan!");
    }

    public function updateQuiz(Request $request, Quiz $quiz)
    {
        $validated = $request->validate(
            [
                "pertanyaan" => "required|string",
                "opsi" => "required|array|min:4",
                "opsi.*" => "required|string",
                "jawaban_benar" => "required|integer|min:0|max:3",
                "penjelasan" => "nullable|string",
                "youtube_url" => [
                    "nullable",
                    "url",
                    'regex:/^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/.+$/',
                ],
            ],
            [
                "youtube_url.url" =>
                    "Format link tidak valid. Harus berupa URL lengkap (contoh: https://youtube.com/watch?v=xxxx).",
                "youtube_url.regex" =>
                    "Link harus berasal dari YouTube (youtube.com atau youtu.be).",
            ],
        );

        $quiz->update([
            "pertanyaan" => $validated["pertanyaan"],
            "opsi" => $validated["opsi"],
            "jawaban_benar" => $validated["jawaban_benar"],
            "penjelasan" => $validated["penjelasan"] ?? null,
            "youtube_url" => $validated["youtube_url"] ?? null,
        ]);

        return back()->with("success", "Soal berhasil diupdate!");
    }

    public function deleteQuiz(Quiz $quiz)
    {
        $quiz->delete();
        return back()->with("success", "Soal berhasil dihapus!");
    }
}
