<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\CoachingTransaction;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Module;
use App\Models\ModuleProgress;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard utama admin: ringkasan statistik platform
    public function dashboard()
    {
        $stats = [
            "total_users"            => User::where("role", "user")->count(),
            "total_admins"           => User::where("role", "admin")->count(),
            "total_paid"             => User::where("has_paid", true)->count(),
            "total_courses"          => Course::count(),
            "total_quizzes"          => Quiz::count(),
            "total_completions"      => CourseProgress::whereNotNull("completed_at")->count(),
            "total_assignments"      => Assignment::count(),
            "assignments_menunggu"   => Assignment::where("status", "menunggu")->count(),
            "assignments_diproses"   => Assignment::where("status", "diproses")->count(),
            "assignments_selesai"    => Assignment::where("status", "selesai")->count(),
            "total_pending_payments" => CoachingTransaction::pending()->count(),
        ];

        $recentAssignments = Assignment::with("user")->latest()->take(5)->get();

        // Transaksi coaching pending — untuk tabel approval admin
        $pendingTransactions = CoachingTransaction::with("user")
            ->pending()
            ->latest()
            ->get();

        // Feed aktivitas coaching terbaru (semua status) — untuk notifikasi dashboard
        $recentCoachingActivity = CoachingTransaction::with("user")
            ->latest()
            ->take(8)
            ->get();

        return view(
            "admin.dashboard",
            compact("stats", "recentAssignments", "pendingTransactions", "recentCoachingActivity"),
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

    /**
     * Approve transaksi coaching: aktifkan akses user + buat pesan template otomatis.
     */
    public function approveTransaction(CoachingTransaction $transaction)
    {
        $transaction->update(['status' => 'approved']);

        // Aktifkan akses coaching user dan simpan nama paket yang aktif
        $transaction->user->update([
            'has_paid'                => true,
            'active_coaching_package' => $transaction->package_name,
        ]);

        // Tentukan pesan template berdasarkan paket yang dibeli
        $templateMessages = [
            'Textual Review' => 'Halo! Sesi Textual Review Anda telah aktif. Silakan tulis pertanyaan mendalam Anda mengenai gameplay di bawah ini.',
            'Panggil Pelatih' => 'Halo! Sesi Panggil Pelatih aktif. Silakan masukkan ID Discord Anda beserta 3 opsi jadwal luang untuk sesi voice call.',
            'Demo Review' => 'Halo! Sesi Demo Review aktif. Silakan tempelkan link download file demo match CS2 Anda yang ingin dianalisis.',
        ];

        // Fallback jika nama paket tidak persis cocok (misal ada URL-encoding "Textual+Review")
        $cleanName = str_replace('+', ' ', $transaction->package_name);
        $templateText = $templateMessages[$cleanName]
            ?? "Halo! Sesi coaching \"{$cleanName}\" Anda telah aktif. Silakan mulai percakapan dengan coach Anda di bawah ini.";

        // Buat record assignment otomatis sebagai pesan pembuka dari sistem
        Assignment::create([
            'user_id'    => $transaction->user_id,
            'from_admin' => true,
            'judul'      => 'Sesi ' . $cleanName,
            'tugas_teks' => $templateText,
            'status'     => 'diproses',
        ]);

        return back()->with('success', "✅ Pembayaran dari {$transaction->user->name} untuk paket \"{$cleanName}\" telah disetujui. Pesan selamat datang telah dikirim otomatis.");
    }


    /**
     * Tolak transaksi coaching.
     */
    public function rejectTransaction(CoachingTransaction $transaction)
    {
        $transaction->update(['status' => 'rejected']);

        return back()->with('success', "❌ Transaksi dari {$transaction->user->name} telah ditolak.");
    }

    public function assignments()
    {
        // Tab 1: Tugas yang dikirim user sendiri (bukan dari admin)
        $assignments = Assignment::with('user')
            ->where('from_admin', false)
            ->latest()
            ->get();

        // Tab 2: Sesi coaching yang dibuat otomatis saat approval (from_admin=true)
        // Dibagi: aktif (belum selesai) dan selesai
        $coachingSessionsActive = Assignment::with('user')
            ->where('from_admin', true)
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();

        $coachingSessionsFinished = Assignment::with('user')
            ->where('from_admin', true)
            ->where('status', 'selesai')
            ->latest()
            ->get();

        // Tab 3: Riwayat pesan/tugas yang dikirim admin secara manual ke user
        $sentByAdmin = Assignment::with('user')
            ->where('from_admin', true)
            ->latest()
            ->take(20)
            ->get();

        $incomingCount = $assignments->count();
        $coachingCount = $coachingSessionsActive->count();

        return view('admin.assignments', compact(
            'assignments',
            'coachingSessionsActive',
            'coachingSessionsFinished',
            'sentByAdmin',
            'incomingCount',
            'coachingCount',
        ));
    }

    public function updateAssignment(Request $request, Assignment $assignment)
    {
        $request->validate([
            "balasan_admin" => "nullable|string",
            "status"        => "required|in:menunggu,diproses,selesai",
        ]);
        $assignment->update([
            "balasan_admin" => $request->balasan_admin,
            "status"        => $request->status,
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

    // ──────────────────────────────────────
    // KELOLA COURSE & MODUL
    // ──────────────────────────────────────

    /** Level 1: daftar semua course */
    public function courses()
    {
        $courses = Course::withCount(['modules', 'quizzes'])->orderBy('urutan')->get();
        return view('admin.courses.index', compact('courses'));
    }

    /** Form tambah course */
    public function create()
    {
        $allCourses = Course::orderBy('urutan')->get();
        return view('admin.courses.form', [
            'mode'        => 'create',
            'course'      => null,
            'allCourses'  => $allCourses,
        ]);
    }

    /** Form edit course */
    public function edit(Course $course)
    {
        $allCourses = Course::where('id', '!=', $course->id)->orderBy('urutan')->get();
        return view('admin.courses.form', [
            'mode'        => 'edit',
            'course'      => $course,
            'allCourses'  => $allCourses,
        ]);
    }

    /** Simpan course baru */
    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'icon'       => 'required|string|max:10',
            'title'      => 'required|string|max:255',
            'body'       => 'required|string',
            'level'      => 'required|string|max:50',
            'durasi'     => 'required|string|max:50',
            'type'       => 'required|string|max:100',
            'urutan'     => 'required|integer|min:0',
            'is_popular' => 'boolean',
        ]);

        $validated['is_popular'] = $request->boolean('is_popular');

        Course::create($validated);
        return redirect()->route('admin.courses')->with('success', 'Kursus baru berhasil ditambahkan!');
    }

    /** Update course */
    public function updateCourse(Request $request, Course $course)
    {
        $validated = $request->validate([
            'icon'       => 'required|string|max:10',
            'title'      => 'required|string|max:255',
            'body'       => 'required|string',
            'level'      => 'required|string|max:50',
            'durasi'     => 'required|string|max:50',
            'type'       => 'required|string|max:100',
            'urutan'     => 'required|integer|min:0',
            'is_popular' => 'boolean',
        ]);

        $validated['is_popular'] = $request->boolean('is_popular');
        $course->update($validated);
        return redirect()->route('admin.courses')->with('success', 'Kursus berhasil diupdate!');
    }

    /** Hapus course — cek progress dulu */
    public function deleteCourse(Course $course)
    {
        $hasProgress = ModuleProgress::whereIn(
            'module_id', $course->modules()->pluck('id')
        )->exists();

        if ($hasProgress) {
            return redirect()->route('admin.courses')->with('error', 'Gak bisa hapus kursus ini — udah ada user yang punya progress di dalamnya.');
        }

        $course->delete();
        return redirect()->route('admin.courses')->with('success', 'Kursus berhasil dihapus!');
    }

    /** Level 2: daftar modul dalam 1 course */
    public function modules(Course $course)
    {
        $modules = $course->modules()->with('quizzes')->withCount('quizzes')->orderBy('urutan')->get();
        return view('admin.courses.index', compact('course', 'modules'));
    }

    /** Form tambah modul baru */
    public function createModule(Course $course)
    {
        return view('admin.modules.form', [
            'mode'   => 'create',
            'course' => $course,
            'module' => null,
        ]);
    }

    /** Form edit modul existing */
    public function editModule(Module $module)
    {
        $module->load('quizzes');
        return view('admin.modules.form', [
            'mode'   => 'edit',
            'course' => $module->course,
            'module' => $module,
        ]);
    }

    /** Simpan modul + quiz sekaligus */
    public function storeModule(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'nullable|string',
            'youtube_url' => ['nullable', 'url', 'regex:/^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/.+$/'],
            'quizzes'     => 'nullable|array',
            'quizzes.*.pertanyaan'    => 'required|string',
            'quizzes.*.opsi'          => 'required|array|min:4',
            'quizzes.*.opsi.*'        => 'required|string',
            'quizzes.*.jawaban_benar' => 'required|integer|min:0|max:3',
            'quizzes.*.penjelasan'    => 'nullable|string',
        ], [
            'youtube_url.url'   => 'Format link gak valid — URL harus lengkap (contoh: https://youtube.com/watch?v=xxxx).',
            'youtube_url.regex' => 'Link harus dari YouTube (youtube.com atau youtu.be).',
        ]);

        $maxUrutan = $course->modules()->max('urutan') ?? -1;
        $module = $course->modules()->create([
            'title'       => $validated['title'],
            'body'        => $validated['body'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
            'urutan'      => $maxUrutan + 1,
        ]);

        if (!empty($validated['quizzes'])) {
            foreach ($validated['quizzes'] as $q) {
                $module->quizzes()->create([
                    'course_id'     => $course->id,
                    'pertanyaan'    => $q['pertanyaan'],
                    'opsi'          => $q['opsi'],
                    'jawaban_benar' => $q['jawaban_benar'],
                    'penjelasan'    => $q['penjelasan'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.courses.modules', $course)
            ->with('success', 'Modul baru berhasil ditambahkan!');
    }

    /** Update modul + sync quiz */
    public function updateModule(Request $request, Module $module)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'nullable|string',
            'youtube_url' => ['nullable', 'url', 'regex:/^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/.+$/'],
            'quizzes'     => 'nullable|array',
            'quizzes.*.pertanyaan'    => 'required|string',
            'quizzes.*.opsi'          => 'required|array|min:4',
            'quizzes.*.opsi.*'        => 'required|string',
            'quizzes.*.jawaban_benar' => 'required|integer|min:0|max:3',
            'quizzes.*.penjelasan'    => 'nullable|string',
        ], [
            'youtube_url.url'   => 'Format link gak valid — URL harus lengkap (contoh: https://youtube.com/watch?v=xxxx).',
            'youtube_url.regex' => 'Link harus dari YouTube (youtube.com atau youtu.be).',
        ]);

        $module->update([
            'title'       => $validated['title'],
            'body'        => $validated['body'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
        ]);

        // Sync quiz: hapus yang gak ada di request, update/create yang ada
        $existingIds = $module->quizzes()->pluck('id')->all();
        $submittedIds = [];

        if (!empty($validated['quizzes'])) {
            foreach ($validated['quizzes'] as $q) {
                if (!empty($q['id'])) {
                    $quiz = Quiz::find($q['id']);
                    if ($quiz && $quiz->module_id === $module->id) {
                        $quiz->update([
                            'pertanyaan'    => $q['pertanyaan'],
                            'opsi'          => $q['opsi'],
                            'jawaban_benar' => $q['jawaban_benar'],
                            'penjelasan'    => $q['penjelasan'] ?? null,
                        ]);
                        $submittedIds[] = $quiz->id;
                    }
                } else {
                    $newQuiz = $module->quizzes()->create([
                        'course_id'     => $module->course_id,
                        'pertanyaan'    => $q['pertanyaan'],
                        'opsi'          => $q['opsi'],
                        'jawaban_benar' => $q['jawaban_benar'],
                        'penjelasan'    => $q['penjelasan'] ?? null,
                    ]);
                    $submittedIds[] = $newQuiz->id;
                }
            }
        }

        $toDelete = array_diff($existingIds, $submittedIds);
        if (!empty($toDelete)) {
            Quiz::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.courses.modules', $module->course)
            ->with('success', 'Modul berhasil diupdate!');
    }

    /** Hapus modul — cek progress dulu */
    public function deleteModule(Module $module)
    {
        if ($module->progress()->whereNotNull('completed_at')->exists()) {
            return redirect()->route('admin.courses.modules', $module->course)
                ->with('error', 'Gak bisa hapus modul ini — udah ada user yang nyelesain.');
        }

        $course = $module->course;
        $module->delete();
        return redirect()->route('admin.courses.modules', $course)
            ->with('success', 'Modul berhasil dihapus!');
    }

    /** Reorder modul naik/turun */
    public function reorderModule(Request $request, Module $module)
    {
        $direction = $request->input('direction', 'up');
        $all = $module->course->modules()->orderBy('urutan')->get();
        $idx = $all->search(fn($m) => $m->id === $module->id);

        if ($direction === 'up' && $idx > 0) {
            $swap = $all[$idx - 1];
            $tmp = $module->urutan;
            $module->update(['urutan' => $swap->urutan]);
            $swap->update(['urutan' => $tmp]);
        } elseif ($direction === 'down' && $idx < $all->count() - 1) {
            $swap = $all[$idx + 1];
            $tmp = $module->urutan;
            $module->update(['urutan' => $swap->urutan]);
            $swap->update(['urutan' => $tmp]);
        }

        return redirect()->route('admin.courses.modules', $module->course)
            ->with('success', 'Urutan modul diupdate!');
    }

}
