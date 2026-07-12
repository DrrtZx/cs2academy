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
Route::get("/courses/{course}", [CourseController::class, "show"])->name("courses.show");

// ✅ Coaching bisa diakses tanpa login (pop-up muncul untuk guest)
Route::get("/coaching", [CoachingController::class, "index"])->name("coaching");

// ── ROUTES AUTH (dari Breeze) ──
require __DIR__ . "/auth.php";

// ── HALAMAN YANG BUTUH LOGIN ──
Route::middleware("auth")->group(function () {
    // Payment tetap butuh login
    Route::get("/payment", [CoachingController::class, "payment"])->name("payment");
    Route::post("/payment/store", [CoachingController::class, "store"])->name("payment.store");
    Route::get("/payment/pending", [CoachingController::class, "pendingStatus"])->name("payment.pending");
    Route::get("/payment/success", [CoachingController::class, "success"])->name("payment.success");

    // Tugas User
    Route::get("/assignments", [AssignmentController::class, "index"])->name(
        "assignments.index",
    );

    // Coaching Chat — User reply
    Route::post("/assignments/{assignment}/reply", [AssignmentController::class, "reply"])->name(
        "assignments.reply",
    );

    Route::get("/assignments/{assignment}/messages", [AssignmentController::class, "messages"])->name(
        "assignments.messages",
    );

    // Progress modul (dipanggil via fetch saat user lulus quiz per modul)
    Route::post("/modules/{module}/complete", [
        CourseController::class,
        "markModuleComplete",
    ])->name("modules.complete");

    // Profil user (Breeze) — hilang saat routes/web.php dikustomisasi
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::put("/profile/password", [ProfileController::class, "updatePassword"])->name(
        "profile.password",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );

    // Admin (khusus role admin)
    Route::get("/admin", [AdminController::class, "dashboard"])
        ->name("admin.dashboard")
        ->middleware("can:admin-only");

    Route::get("/admin/users", [AdminController::class, "users"])
        ->name("admin.users")
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

    // Coaching Chat — Admin
    Route::get("/admin/coaching-inbox/summary", [AdminController::class, "inboxSummary"])
        ->name("admin.coaching.summary")
        ->middleware("can:admin-only");

    Route::get("/admin/coaching-inbox/{assignment}/messages", [AdminController::class, "inboxMessages"])
        ->name("admin.coaching.messages")
        ->middleware("can:admin-only");

    Route::post("/admin/coaching-inbox/{assignment}/reply", [AdminController::class, "replyToSession"])
        ->name("admin.coaching.reply")
        ->middleware("can:admin-only");

    Route::post("/admin/coaching-inbox/{assignment}/complete", [AdminController::class, "completeSession"])
        ->name("admin.coaching.complete")
        ->middleware("can:admin-only");

    // Kelola Course & Modul
    Route::get("/admin/courses", [AdminController::class, "courses"])
        ->name("admin.courses")
        ->middleware("can:admin-only");

    Route::post("/admin/courses", [AdminController::class, "storeCourse"])
        ->name("admin.courses.store")
        ->middleware("can:admin-only");

    Route::get("/admin/courses/create", [AdminController::class, "create"])
        ->name("admin.courses.create")
        ->middleware("can:admin-only");

    Route::get("/admin/courses/{course}/edit", [AdminController::class, "edit"])
        ->name("admin.courses.edit")
        ->middleware("can:admin-only");

    Route::put("/admin/courses/{course}", [AdminController::class, "updateCourse"])
        ->name("admin.courses.update")
        ->middleware("can:admin-only");

    Route::delete("/admin/courses/{course}", [AdminController::class, "deleteCourse"])
        ->name("admin.courses.delete")
        ->middleware("can:admin-only");

    Route::get("/admin/courses/{course}/modules/create", [AdminController::class, "createModule"])
        ->name("admin.modules.create")
        ->middleware("can:admin-only");

    Route::get("/admin/courses/{course}/modules", [AdminController::class, "modules"])
        ->name("admin.courses.modules")
        ->middleware("can:admin-only");

    Route::post("/admin/courses/{course}/modules", [AdminController::class, "storeModule"])
        ->name("admin.modules.store")
        ->middleware("can:admin-only");

    Route::get("/admin/modules/{module}/edit", [AdminController::class, "editModule"])
        ->name("admin.modules.edit")
        ->middleware("can:admin-only");

    Route::put("/admin/modules/{module}", [AdminController::class, "updateModule"])
        ->name("admin.modules.update")
        ->middleware("can:admin-only");

    Route::delete("/admin/modules/{module}", [AdminController::class, "deleteModule"])
        ->name("admin.modules.delete")
        ->middleware("can:admin-only");

    Route::post("/admin/modules/{module}/reorder", [AdminController::class, "reorderModule"])
        ->name("admin.modules.reorder")
        ->middleware("can:admin-only");

    // Kirim pesan/tugas dari admin ke user
    Route::get('/admin/users/search', [AdminController::class, 'searchUsers'])
        ->name('admin.users.search')
        ->middleware('can:admin-only');

    Route::post('/admin/send-to-user', [AdminController::class, 'sendToUser'])
        ->name('admin.send-to-user')
        ->middleware('can:admin-only');

    // Coaching transaction approval
    Route::post('/admin/coaching/{transaction}/approve', [AdminController::class, 'approveTransaction'])
        ->name('admin.coaching.approve')
        ->middleware('can:admin-only');

    Route::post('/admin/coaching/{transaction}/reject', [AdminController::class, 'rejectTransaction'])
        ->name('admin.coaching.reject')
        ->middleware('can:admin-only');
});
