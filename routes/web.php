<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoachingController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

// ── HALAMAN PUBLIK ──
// Override dashboard Breeze → redirect ke home
Route::get("/dashboard", function () {
    return redirect()->route("home");
})->name("dashboard");

Route::get("/", [HomeController::class, "index"])->name("home");
Route::get("/courses", [CourseController::class, "index"])->name("courses");

// ✅ Coaching bisa diakses tanpa login (pop-up muncul untuk guest)
Route::get("/coaching", [CoachingController::class, "index"])->name("coaching");

// ── ROUTES AUTH (dari Breeze) ──
require __DIR__ . "/auth.php";

// ── HALAMAN YANG BUTUH LOGIN ──
Route::middleware("auth")->group(function () {
    // Payment tetap butuh login
    Route::get("/payment", [CoachingController::class, "payment"])->name(
        "payment",
    );
    Route::post("/payment/confirm", [
        CoachingController::class,
        "confirmPayment",
    ])->name("payment.confirm");
    Route::get("/payment/success", [
        CoachingController::class,
        "success",
    ])->name("payment.success");

    // Tugas User
    Route::get("/assignments", [AssignmentController::class, "index"])->name(
        "assignments.index",
    );
    Route::post("/assignments", [AssignmentController::class, "store"])->name(
        "assignments.store",
    );

    // Progress kursus (dipanggil via fetch saat user lulus quiz)
    Route::post("/courses/{course}/complete", [
        CourseController::class,
        "markComplete",
    ])->name("courses.complete");

    // Profil user (Breeze) — hilang saat routes/web.php dikustomisasi
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );

    // Admin (khusus role admin)
    Route::get("/admin", [AdminController::class, "dashboard"])
        ->name("admin.dashboard")
        ->middleware("can:admin-only");

    Route::post("/admin/preview/on", [
        AdminController::class,
        "enablePreviewMode",
    ])
        ->name("admin.preview.on")
        ->middleware("can:admin-only");

    Route::post("/admin/preview/off", [
        AdminController::class,
        "disablePreviewMode",
    ])
        ->name("admin.preview.off")
        ->middleware("can:admin-only");

    Route::get("/admin/assignments", [AdminController::class, "assignments"])
        ->name("admin.assignments")
        ->middleware("can:admin-only");

    Route::post("/admin/assignments/{assignment}", [
        AdminController::class,
        "updateAssignment",
    ])
        ->name("admin.assignments.update")
        ->middleware("can:admin-only");

    Route::delete("/admin/assignments/{assignment}", [
        AdminController::class,
        "deleteAssignment",
    ])
        ->name("admin.assignments.delete")
        ->middleware("can:admin-only");

    // Quiz Admin
    Route::get("/admin/quiz", [AdminController::class, "quiz"])
        ->name("admin.quiz")
        ->middleware("can:admin-only");

    Route::post("/admin/quiz/{course}", [AdminController::class, "storeQuiz"])
        ->name("admin.quiz.store")
        ->middleware("can:admin-only");

    Route::put("/admin/quiz/{quiz}", [AdminController::class, "updateQuiz"])
        ->name("admin.quiz.update")
        ->middleware("can:admin-only");

    Route::delete("/admin/quiz/{quiz}", [AdminController::class, "deleteQuiz"])
        ->name("admin.quiz.delete")
        ->middleware("can:admin-only");

    // Kirim pesan/tugas dari admin ke user
    Route::get('/admin/users/search', [AdminController::class, 'searchUsers'])
        ->name('admin.users.search')
        ->middleware('can:admin-only');

    Route::post('/admin/send-to-user', [AdminController::class, 'sendToUser'])
        ->name('admin.send-to-user')
        ->middleware('can:admin-only');
});
