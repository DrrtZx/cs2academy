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
            "total_paid"             => User::where("has_paid", true)->count(),
            "total_pending_payments" => CoachingTransaction::pending()->count(),
            "total_courses"          => Course::count(),
            "total_transactions"     => CoachingTransaction::count(),
        ];

        $pendingTransactions = CoachingTransaction::with("user")
            ->pending()
            ->latest()
            ->get();

        $recentCoachingActivity = CoachingTransaction::with("user")
            ->latest()
            ->take(8)
            ->get();

        return view(
            "admin.dashboard",
            compact("stats", "pendingTransactions", "recentCoachingActivity"),
        );
    }

    /** Halaman daftar user */
    public function users(Request $request)
    {
        $search = trim($request->get('search', ''));
        $users = User::when($search, fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(15)
            ->appends(['search' => $search]);

        return view('admin.users', compact('users', 'search'));
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

        $transaction->user->update([
            'has_paid'                => true,
            'active_coaching_package' => $transaction->package_name,
        ]);

        $templateMessages = [
            'Textual Review' => 'Halo! Sesi Textual Review Anda telah aktif. Silakan tulis pertanyaan mendalam Anda mengenai gameplay di bawah ini.',
            'Panggil Pelatih' => 'Halo! Sesi Panggil Pelatih aktif. Silakan masukkan ID Discord Anda beserta 3 opsi jadwal luang untuk sesi voice call.',
            'Demo Review' => 'Halo! Sesi Demo Review aktif. Silakan tempelkan link download file demo match CS2 Anda yang ingin dianalisis.',
        ];

        $cleanName = str_replace('+', ' ', $transaction->package_name);
        $templateText = $templateMessages[$cleanName]
            ?? "Halo! Sesi coaching \"{$cleanName}\" Anda telah aktif. Silakan mulai percakapan dengan coach Anda di bawah ini.";

        $assignment = Assignment::create([
            'user_id'    => $transaction->user_id,
            'from_admin' => true,
            'judul'      => 'Sesi ' . $cleanName,
            'tugas_teks' => $templateText,
            'status'     => 'diproses',
        ]);

        // Auto-kirim prechat dari Coach (beda per paket)
        $prechatMessages = [
            'Textual Review' => "Halo! Selamat datang di sesi Textual Review. 🎯\n\nSilakan tulis pertanyaan mendalam kamu soal gameplay — aim, movement, positioning, utility usage, atau game sense. Kirim aja semuanya, nanti aku review dan kasih feedback detail satu per satu.\n\nKalau ada video gameplay juga bisa kamu lampirkan link-nya. Let's get better! 💪",
            'Panggil Pelatih' => "Halo! Sesi Panggil Pelatih sudah aktif. 🎧\n\nUntuk mulai, share dulu:\n1. ID Discord kamu (username#0000)\n2. 3 opsi jadwal luang (hari + jam)\n\nNanti kita tentuin jadwal voice call 1-on-1. Sampai ketemu di Discord! 👋",
            'Demo Review' => "Halo! Sesi Demo Review sudah aktif. 🎬\n\nSilakan upload link download file demo match CS2 kamu (bisa dari Google Drive, Dropbox, atau platform lain). Pastikan link-nya bisa diakses ya.\n\nAku akan analisis gameplay kamu — dari aim, decision making, utility usage, sampai positioning — dan kasih feedback lengkap. Let's go! 🔍",
        ];

        $prechatText = $prechatMessages[$cleanName] ?? "Halo! Sesi coaching \"{$cleanName}\" kamu sudah aktif. Silakan mulai percakapan dengan coach. 🎯";
        $assignment->messages()->create([
            'sender_id' => auth()->id(),
            'message'   => $prechatText,
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

    /** Halaman Sesi Coaching (dulunya assignments) */
    public function assignments()
    {
        $coachingSessionsActive = Assignment::with(['user', 'messages'])
            ->where('from_admin', true)
            ->where('status', '!=', 'selesai')
            ->latest('updated_at')
            ->get();

        $coachingSessionsFinished = Assignment::with(['user', 'messages'])
            ->where('from_admin', true)
            ->where('status', 'selesai')
            ->latest('completed_at')
            ->get();

        $coachingCount = $coachingSessionsActive->count();

        return view('admin.assignments', compact(
            'coachingSessionsActive',
            'coachingSessionsFinished',
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

    /** API: search user untuk form "Kirim ke User" */
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
            ->orderByDesc('has_paid')
            ->take(10)
            ->get(['id', 'name', 'email', 'has_paid']);

        return response()->json($users);
    }

    /** Kirim tugas/pesan dari admin ke user */
    public function sendToUser(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'judul'      => 'required|string|max:255',
            'tugas_teks' => 'required|string',
        ]);

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

    /** Hapus assignment */
    public function deleteAssignment(Assignment $assignment)
    {
        $assignment->delete();
        return back()->with("success", "Tugas berhasil dihapus!");
    }

    // ──────────────────────────────────────
    // COACHING CHAT
    // ──────────────────────────────────────

    public function inboxSummary(Request $request)
    {
        $tab = $request->query('tab', 'aktif');

        $query = Assignment::with(['user', 'messages'])
            ->where('from_admin', true);

        if ($tab === 'arsip') {
            $query->where('status', 'selesai')->latest('completed_at');
        } else {
            $query->where('status', '!=', 'selesai')->latest('updated_at');
        }

        $sessions = $query->take(30)->get()->map(function ($s) {
            return [
                'id'           => $s->id,
                'user_name'    => $s->user->name,
                'user_initial' => mb_substr($s->user->name, 0, 1),
                'judul'        => $s->judul,
                'package'      => str_replace('Sesi ', '', $s->judul),
                'status'       => $s->status,
                'is_closed'    => $s->status === 'selesai',
                'unread'       => $s->unreadCount(),
                'last_message' => $s->lastMessage()?->message ?? $s->tugas_teks,
                'last_is_user' => $s->lastMessage() ? $s->lastMessage()->sender_id === $s->user_id : false,
                'last_time'    => ($s->lastMessage() ?? $s)->created_at->diffForHumans(),
            ];
        });

        $aktifCount = Assignment::where('from_admin', true)->where('status', '!=', 'selesai')->count();
        $arsipCount = Assignment::where('from_admin', true)->where('status', 'selesai')->count();

        return response()->json([
            'sessions' => $sessions,
            'counts'   => ['aktif' => $aktifCount, 'arsip' => $arsipCount],
        ]);
    }

    public function inboxMessages(Assignment $assignment)
    {
        $assignment->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $msgs = $assignment->messages()->with('sender')->get()->map(function ($msg) use ($assignment) {
            $isAdmin = $msg->sender_id === auth()->id();
            return [
                'id'       => $msg->id,
                'sender'   => $isAdmin ? 'Kamu (Coach)' : $assignment->user->name,
                'message'  => $msg->message,
                'is_admin' => $isAdmin,
                'time'     => $msg->created_at->format('H:i'),
                'time_ago' => $msg->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'messages'  => $msgs,
            'status'    => $assignment->status,
            'is_closed' => $assignment->status === 'selesai',
        ]);
    }

    public function replyToSession(Request $request, Assignment $assignment)
    {
        if ($assignment->status === 'selesai') {
            return response()->json(['error' => 'Sesi ini sudah selesai.'], 403);
        }

        $request->validate(['message' => 'required|string']);

        $assignment->messages()->create([
            'sender_id' => auth()->id(),
            'message'   => $request->message,
        ]);

        $assignment->update(['status' => 'diproses', 'updated_at' => now()]);

        $msg = $assignment->messages()->latest('id')->first();

        return response()->json([
            'success' => true,
            'message' => [
                'id'       => $msg->id,
                'sender'   => 'Kamu (Coach)',
                'message'  => $msg->message,
                'is_admin' => true,
                'time'     => $msg->created_at->format('H:i'),
                'time_ago' => $msg->created_at->diffForHumans(),
            ],
        ]);
    }

    public function completeSession(Assignment $assignment)
    {
        $assignment->update([
            'status'       => 'selesai',
            'completed_at' => now(),
        ]);

        // Clear paket aktif user supaya bisa beli lagi & badge di tabel user update
        $assignment->user->update(['active_coaching_package' => null]);

        return response()->json(['success' => true]);
    }

    // ──────────────────────────────────────
    // KELOLA COURSE & MODUL
    // ──────────────────────────────────────

    public function courses()
    {
        $courses = Course::withCount(['modules', 'quizzes'])->orderBy('urutan')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $allCourses = Course::orderBy('urutan')->get();
        return view('admin.courses.form', [
            'mode'       => 'create',
            'course'     => null,
            'allCourses' => $allCourses,
        ]);
    }

    public function edit(Course $course)
    {
        $allCourses = Course::where('id', '!=', $course->id)->orderBy('urutan')->get();
        return view('admin.courses.form', [
            'mode'       => 'edit',
            'course'     => $course,
            'allCourses' => $allCourses,
        ]);
    }

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

    public function modules(Course $course)
    {
        $modules = $course->modules()->with('quizzes')->withCount('quizzes')->orderBy('urutan')->get();
        return view('admin.courses.index', compact('course', 'modules'));
    }

    public function createModule(Course $course)
    {
        return view('admin.modules.form', [
            'mode'   => 'create',
            'course' => $course,
            'module' => null,
        ]);
    }

    public function editModule(Module $module)
    {
        $module->load('quizzes');
        return view('admin.modules.form', [
            'mode'   => 'edit',
            'course' => $module->course,
            'module' => $module,
        ]);
    }

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
            'youtube_url.url'   => 'Format link gak valid.',
            'youtube_url.regex' => 'Link harus dari YouTube.',
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

        return redirect()->route('admin.courses.modules', $course)->with('success', 'Modul baru berhasil ditambahkan!');
    }

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
            'youtube_url.url'   => 'Format link gak valid.',
            'youtube_url.regex' => 'Link harus dari YouTube.',
        ]);

        $module->update([
            'title'       => $validated['title'],
            'body'        => $validated['body'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
        ]);

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

        return redirect()->route('admin.courses.modules', $module->course)->with('success', 'Modul berhasil diupdate!');
    }

    public function deleteModule(Module $module)
    {
        if ($module->progress()->whereNotNull('completed_at')->exists()) {
            return redirect()->route('admin.courses.modules', $module->course)
                ->with('error', 'Gak bisa hapus modul ini — udah ada user yang nyelesain.');
        }

        $course = $module->course;
        $module->delete();
        return redirect()->route('admin.courses.modules', $course)->with('success', 'Modul berhasil dihapus!');
    }

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

        return redirect()->route('admin.courses.modules', $module->course)->with('success', 'Urutan modul diupdate!');
    }
}
