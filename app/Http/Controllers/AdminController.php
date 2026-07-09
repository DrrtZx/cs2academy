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
        // Hanya tugas dari user (bukan kiriman admin) yang muncul di tab "Tugas Masuk"
        $assignments  = Assignment::with('user')
            ->where('from_admin', false)
            ->latest()
            ->get();

        // Data untuk tab "Kirim ke User"
        $sentByAdmin  = Assignment::with('user')
            ->where('from_admin', true)
            ->latest()
            ->take(20)
            ->get();

        $incomingCount = $assignments->count();

        return view('admin.assignments', compact('assignments', 'sentByAdmin', 'incomingCount'));
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

    // API: live search user by nama/email untuk form "Kirim ke User"
    public function searchUsers(Request $request)
    {
        $q = trim($request->get('q', ''));
        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $users = User::where('role', 'user')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            })
            ->orderByDesc('has_paid') // user yang sudah beli muncul duluan
            ->take(10)
            ->get(['id', 'name', 'email', 'has_paid']);

        return response()->json($users);
    }

    // Kirim assignment/pesan dari admin ke user yang dipilih
    public function sendToUser(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'judul'      => 'required|string|max:255',
            'tugas_teks' => 'required|string',
        ]);

        // Pastikan target bukan admin
        $target = User::findOrFail($request->user_id);
        if ($target->isAdmin()) {
            return back()->withErrors(['user_id' => 'Tidak bisa kirim ke sesama admin.']);
        }

        Assignment::create([
            'user_id'    => $request->user_id,
            'judul'      => $request->judul,
            'tugas_teks' => $request->tugas_teks,
            'status'     => 'diproses',
            'from_admin' => true,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim ke ' . $target->name . '!');
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
