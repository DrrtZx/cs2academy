# PROJECT DOCUMENTATION — CS2 Academy

> Dokumentasi teknis lengkap — dipakai untuk UML diagram & navigasi struktur.
> Last updated: 2026-07-13

---

## 1. RINGKASAN APLIKASI

CS2 Academy adalah platform edukasi Counter-Strike 2 berbasis web. User dapat mengakses kursus interaktif dengan kuis per modul dan membeli sesi coaching 1-on-1 dengan coach/pro player. Admin mengelola kursus, modul, kuis, user, dan sesi coaching melalui panel admin.

### Role / Aktor

| Role | Deskripsi | Akses |
|------|-----------|-------|
| **Guest** | Pengunjung belum login | Lihat landing page, katalog kursus (locked, popup login), halaman coaching (popup login) |
| **User (Pemain)** | User terdaftar dan login | Akses penuh katalog kursus + detail modul + quiz, beli paket coaching, chat dengan coach, profile settings |
| **Admin** | Administrator platform | Dashboard, manajemen user, approve/reject pembayaran, chat coaching, kelola course/module/quiz, preview mode (lihat sebagai user) |

---

## 2. STRUKTUR ROUTE & NAVIGASI

### 2A. Guest Routes (public — no middleware)

| Method | URL | Route Name | Controller | Keterangan |
|--------|-----|------------|------------|------------|
| GET | `/` | `home` | `HomeController@index` | Landing page + stats |
| GET | `/courses` | `courses` | `CourseController@index` | Katalog kursus (grid card, locked untuk guest) |
| GET | `/courses/{course}` | `courses.show` | `CourseController@show` | Detail modul (guest dapet modal login) |
| GET | `/coaching` | `coaching` | `CoachingController@index` | Halaman paket coaching |
| GET | `/login` | `login` | `Auth\AuthenticatedSessionController@create` | Login form |
| POST | `/login` | — | `Auth\AuthenticatedSessionController@store` | Proses login |
| GET | `/register` | `register` | `Auth\RegisteredUserController@create` | Register form |
| POST | `/register` | — | `Auth\RegisteredUserController@store` | Proses register |
| GET | `/forgot-password` | `password.request` | `PasswordResetLinkController@create` | Forgot password form |
| POST | `/forgot-password` | `password.email` | `PasswordResetLinkController@store` | Kirim reset link |
| GET | `/reset-password/{token}` | `password.reset` | `NewPasswordController@create` | Reset password form |
| POST | `/reset-password` | `password.store` | `NewPasswordController@store` | Simpan password baru |

### 2B. Auth Routes (semua role — middleware `auth`)

| Method | URL | Route Name | Controller | Keterangan |
|--------|-----|------------|------------|------------|
| GET | `/profile` | `profile.edit` | `ProfileController@edit` | Profile settings |
| PATCH | `/profile` | `profile.update` | `ProfileController@update` | Update info + avatar |
| PUT | `/profile/password` | `profile.password` | `ProfileController@updatePassword` | Ganti password |
| DELETE | `/profile` | `profile.destroy` | `ProfileController@destroy` | Hapus akun |
| POST | `/logout` | `logout` | `Auth\...SessionController@destroy` | Logout |
| GET | `/confirm-password` | `password.confirm` | `ConfirmablePasswordController@show` | Konfirmasi password |
| POST | `/confirm-password` | — | `ConfirmablePasswordController@store` | Proses konfirmasi |
| PUT | `/password` | `password.update` | `Auth\PasswordController@update` | Update password (dari Breeze) |
| POST | `/email/verification-notification` | `verification.send` | `EmailVerificationNotificationController@store` | Kirim ulang verifikasi email |
| GET | `/verify-email` | `verification.notice` | `EmailVerificationPromptController` | Notice verifikasi |
| GET | `/verify-email/{id}/{hash}` | `verification.verify` | `VerifyEmailController` | Proses verifikasi |

### 2C. User Routes (middleware `auth`)

| Method | URL | Route Name | Controller | Keterangan |
|--------|-----|------------|------------|------------|
| GET | `/assignments` | `assignments.index` | `AssignmentController@index` | Halaman chat coaching user (sesi aktif + arsip) |
| POST | `/assignments/{assignment}/reply` | `assignments.reply` | `AssignmentController@reply` | Kirim pesan chat user (JSON) |
| GET | `/assignments/{assignment}/messages` | `assignments.messages` | `AssignmentController@messages` | Ambil pesan chat (JSON) |
| POST | `/modules/{module}/complete` | `modules.complete` | `CourseController@markModuleComplete` | Simpan ModuleProgress (JSON) |
| GET | `/payment` | `payment` | `CoachingController@payment` | Halaman pembayaran |
| POST | `/payment/store` | `payment.store` | `CoachingController@store` | Buat transaksi baru |
| GET | `/payment/pending` | `payment.pending` | `CoachingController@pendingStatus` | Status pembayaran pending |
| GET | `/payment/success` | `payment.success` | `CoachingController@success` | Pembayaran sukses |

### 2D. Admin Routes (middleware `auth` + `can:admin-only`)

**Dashboard & User Management:**

| Method | URL | Route Name | Controller | Keterangan |
|--------|-----|------------|------------|------------|
| GET | `/admin` | `admin.dashboard` | `AdminController@dashboard` | Dashboard admin |
| GET | `/admin/users` | `admin.users` | `AdminController@users` | Tabel daftar user |
| GET | `/admin/users/search` | `admin.users.search` | `AdminController@searchUsers` | AJAX search user |
| POST | `/admin/preview/on` | `admin.preview.on` | `AdminController@enablePreviewMode` | Mode lihat sebagai user |
| POST | `/admin/preview/off` | `admin.preview.off` | `AdminController@disablePreviewMode` | Kembali ke admin |

**Coaching & Chat:**

| Method | URL | Route Name | Controller | Keterangan |
|--------|-----|------------|------------|------------|
| GET | `/admin/assignments` | `admin.assignments` | `AdminController@assignments` | Halaman sesi coaching |
| POST | `/admin/assignments/{assignment}` | `admin.assignments.update` | `AdminController@updateAssignment` | Update status/reply (legacy) |
| DELETE | `/admin/assignments/{assignment}` | `admin.assignments.delete` | `AdminController@deleteAssignment` | Hapus sesi |
| GET | `/admin/coaching-inbox/summary` | `admin.coaching.summary` | `AdminController@inboxSummary` | JSON sidebar chat |
| GET | `/admin/coaching-inbox/{assignment}/messages` | `admin.coaching.messages` | `AdminController@inboxMessages` | JSON pesan chat |
| POST | `/admin/coaching-inbox/{assignment}/reply` | `admin.coaching.reply` | `AdminController@replyToSession` | Kirim balasan admin |
| POST | `/admin/coaching-inbox/{assignment}/complete` | `admin.coaching.complete` | `AdminController@completeSession` | Selesaikan sesi |
| POST | `/admin/coaching/{transaction}/approve` | `admin.coaching.approve` | `AdminController@approveTransaction` | Approve pembayaran |
| POST | `/admin/coaching/{transaction}/reject` | `admin.coaching.reject` | `AdminController@rejectTransaction` | Tolak pembayaran |
| POST | `/admin/send-to-user` | `admin.send-to-user` | `AdminController@sendToUser` | Kirim pesan ke user (legacy) |

**Course & Module Management:**

| Method | URL | Route Name | Controller | Keterangan |
|--------|-----|------------|------------|------------|
| GET | `/admin/courses` | `admin.courses` | `AdminController@courses` | Level 1: List course |
| POST | `/admin/courses` | `admin.courses.store` | `AdminController@storeCourse` | Simpan course baru |
| GET | `/admin/courses/create` | `admin.courses.create` | `AdminController@create` | Form tambah course |
| GET | `/admin/courses/{course}/edit` | `admin.courses.edit` | `AdminController@edit` | Form edit course |
| PUT | `/admin/courses/{course}` | `admin.courses.update` | `AdminController@updateCourse` | Update course |
| DELETE | `/admin/courses/{course}` | `admin.courses.delete` | `AdminController@deleteCourse` | Hapus course |
| GET | `/admin/courses/{course}/modules` | `admin.courses.modules` | `AdminController@modules` | Level 2: List modul |
| GET | `/admin/courses/{course}/modules/create` | `admin.modules.create` | `AdminController@createModule` | Form tambah modul |
| POST | `/admin/courses/{course}/modules` | `admin.modules.store` | `AdminController@storeModule` | Simpan modul + quiz |
| GET | `/admin/modules/{module}/edit` | `admin.modules.edit` | `AdminController@editModule` | Form edit modul |
| PUT | `/admin/modules/{module}` | `admin.modules.update` | `AdminController@updateModule` | Update modul + sync quiz |
| DELETE | `/admin/modules/{module}` | `admin.modules.delete` | `AdminController@deleteModule` | Hapus modul |
| POST | `/admin/modules/{module}/reorder` | `admin.modules.reorder` | `AdminController@reorderModule` | Reorder up/down |

### 2E. Alur Navigasi

```
LANDING PAGE (/)
├── Register → Login
├── Courses (/courses)
│   ├── Guest: modal login saat klik card
│   └── User: klik card → Detail Modul (/courses/{id})
│       ├── Sidebar: pilih modul (done/active/locked)
│       ├── Main: outline + YouTube + quiz
│       └── Quiz selesai → ModuleProgress tersimpan → modul berikutnya unlock
│
├── Coaching (/coaching)
│   ├── Guest: popup login
│   └── User: pilih paket → Payment (/payment) → Bayar → Pending → Admin approve
│       └── Approve → Sesi coaching aktif → Chat di /assignments
│
├── Tugas Saya (/assignments)
│   ├── Tab Sesi Aktif → Chat real-time dengan coach
│   └── Tab Arsip Selesai → Read-only history
│
├── Profile Settings (/profile)
│   ├── Upload avatar
│   ├── Edit nama, email, discord ID
│   └── Ganti password
│
└── ADMIN PANEL
    ├── Dashboard (/admin)
    │   ├── 5 stat cards
    │   ├── Pembayaran menunggu verifikasi → Approve/Reject
    │   └── Feed aktivitas coaching
    │
    ├── User (/admin/users)
    │   └── Tabel user + search + summary
    │
    ├── Sesi Coaching (/admin/assignments)
    │   ├── Sesi Aktif: chat inline + tombol "Selesaikan Sesi"
    │   └── Arsip: accordion dropdown read-only
    │
    ├── Kelola Course (/admin/courses)
    │   ├── Level 1: List course → Tambah/Edit/Hapus
    │   ├── Level 2: List modul → Reorder/Tambah/Edit/Hapus
    │   └── Level 3: Form modul → Info dasar + quiz accordion
    │
    └── Floating Chat Widget (semua halaman admin)
        ├── Sidebar: Aktif | Arsip tab
        ├── Chat panel: pesan real-time
        └── Tombol "Selesaikan Sesi"
```

---

## 3. STRUKTUR DATABASE / MODEL

### 3A. Model: `User` → Tabel: `users`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `name` | string(255) | Nama lengkap |
| `email` | string(255) UNIQUE | Email login |
| `email_verified_at` | timestamp nullable | Verifikasi email |
| `password` | string(255) | Hashed password |
| `role` | enum(`admin`,`user`) | Default: `user` |
| `has_paid` | boolean | Pernah bayar coaching |
| `active_coaching_package` | string nullable | Paket aktif saat ini (null = tidak ada) |
| `discord_id` | string nullable | Discord ID (untuk Panggil Pelatih) |
| `avatar` | string nullable | Path foto profile (`avatars/xxx.jpg`) |
| `remember_token` | string | Remember me token |
| `created_at/updated_at` | timestamp | |

**Relasi:**
- `hasMany(Assignment::class)` → assignments
- `hasMany(CourseProgress::class)` → courseProgress
- `hasMany(CoachingTransaction::class)` → coachingTransactions

**Helper Methods:**
- `isAdmin(): bool` — cek role = admin
- `hasCourseAccess(): bool` — has_paid ATAU isAdmin
- `hasPendingCoaching(): bool` — ada transaksi pending ATAU (approved + assignment belum selesai)

### 3B. Model: `Course` → Tabel: `courses`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `icon` | string | Emoji (🎯, 🗺, dll) |
| `title` | string(255) | Judul kursus |
| `body` | text | Deskripsi singkat |
| `level` | string(50) | Pemula / Menengah / Lanjutan |
| `durasi` | string(50) | "45 menit", "1 jam", dll |
| `type` | string(100) | Kursus Wajib / Kursus Lanjutan |
| `is_popular` | boolean | Badge 🔥 Populer |
| `urutan` | integer | Urutan tampil di katalog |
| `created_at/updated_at` | timestamp | |

**Relasi:**
- `hasMany(Quiz::class)` → quizzes
- `hasMany(Module::class)` → modules

**Helper Methods:**
- `progressPercent(?int $userId): int` — berapa % modul selesai
- `isUnlockedFor(?int $userId, array $allCourseIds, int $index): bool` — selalu return true (semua course unlocked)

### 3C. Model: `Module` → Tabel: `modules`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `course_id` | FK → courses | |
| `title` | string(255) | Judul modul |
| `body` | text nullable | Outline/poin materi (newline-separated) |
| `youtube_url` | string nullable | Link YouTube |
| `urutan` | integer | Urutan dalam course |
| `created_at/updated_at` | timestamp | |

**Relasi:**
- `belongsTo(Course::class)` → course
- `hasMany(Quiz::class)` → quizzes
- `hasMany(ModuleProgress::class)` → progress

**Accessors:**
- `youtube_video_id` — ekstrak video ID dari URL (regex: watch?v=, youtu.be/, embed/, shorts/)
- `youtube_embed_url` — URL embed siap iframe

**Helper Methods:**
- `userProgress(?int $userId): ?ModuleProgress` — progress user untuk modul ini
- `statusFor(?int $userId, array $allModuleIds, int $index): string` — return `done` / `active` / `locked`

### 3D. Model: `Quiz` → Tabel: `quizzes`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `course_id` | FK → courses | |
| `module_id` | FK → modules nullable | |
| `pertanyaan` | text | Soal kuis |
| `opsi` | JSON | Array 4 pilihan jawaban, cast ke array |
| `jawaban_benar` | integer | Index 0-3 (jawaban yang benar) |
| `penjelasan` | text nullable | Penjelasan jawaban |
| `youtube_url` | string nullable | (legacy, dipindahkan ke modules) |
| `created_at/updated_at` | timestamp | |

**Relasi:**
- `belongsTo(Course::class)` → course
- `belongsTo(Module::class)` → module

### 3E. Model: `ModuleProgress` → Tabel: `module_progress`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `user_id` | FK → users | |
| `module_id` | FK → modules | |
| `score` | integer | Skor quiz (0-1 per soal) |
| `completed_at` | timestamp nullable | Kapan selesai |
| `created_at/updated_at` | timestamp | |
| UNIQUE | `[user_id, module_id]` | |

**Relasi:**
- `belongsTo(User::class)` → user
- `belongsTo(Module::class)` → module

### 3F. Model: `Assignment` → Tabel: `assignments`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `user_id` | FK → users | |
| `from_admin` | boolean | Selalu true (sesi coaching) |
| `judul` | string(255) | "Sesi Textual Review", dll |
| `tugas_teks` | text | Template pesan pembuka |
| `status` | enum(`menunggu`,`diproses`,`selesai`) | Status sesi |
| `completed_at` | timestamp nullable | Kapan diselesaikan |
| `balasan_admin` | text nullable | (legacy, digantikan coaching_messages) |
| `created_at/updated_at` | timestamp | |

**Relasi:**
- `belongsTo(User::class)` → user
- `hasMany(CoachingMessage::class)` → messages

**Helper Methods:**
- `unreadCount(): int` — pesan user yang belum dibaca admin
- `lastMessage(): ?CoachingMessage` — pesan terbaru

**Status Flow:** `menunggu` → `diproses` → `selesai`

### 3G. Model: `CoachingMessage` → Tabel: `coaching_messages`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `assignment_id` | FK → assignments | |
| `sender_id` | FK → users | |
| `message` | text | Isi pesan |
| `read_at` | timestamp nullable | null = unread, timestamp = read |
| `created_at/updated_at` | timestamp | |

**Relasi:**
- `belongsTo(Assignment::class)` → assignment
- `belongsTo(User::class, 'sender_id')` → sender

**Helper Methods:**
- `markAsRead(): void` — set read_at = now()

### 3H. Model: `CoachingTransaction` → Tabel: `coaching_transactions`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | bigint PK | |
| `user_id` | FK → users | |
| `package_name` | string(255) | Textual Review / Panggil Pelatih / Demo Review |
| `package_price` | string(50) | "Rp 100.000", dll |
| `va_code` | string | Kode VA dummy (prefix 8808) |
| `status` | enum(`pending`,`approved`,`rejected`) | |
| `created_at/updated_at` | timestamp | |

**Relasi:** `belongsTo(User::class)` → user
**Scopes:** `pending()`, `approved()`
**Status Flow:** `pending` → `approved` / `rejected`

### 3I. Model: `CourseProgress` → Tabel: `course_progress`

Legacy table — digunakan di sistem lama (quiz langsung per course). Sekarang progress dilacak via `ModuleProgress`.

---

## 4. CONTROLLER & LOGIC UTAMA

### 4A. `HomeController`
- `index()` — Ambil stats (total_players, total_courses, total_completions, total_coaching) → render home.blade.php

### 4B. `CourseController`
- `index()` — Ambil semua courses dengan modules.quizzes → map ke array data (progress, unlocked, quizzes_count) → render katalog grid
- `show(Course $course)` — Load modules + quizzes → map ke array (status done/active/locked, outline, quiz data, youtube_id) → render sidebar + main panel
- `markModuleComplete(Request, Module $module)` — `ModuleProgress::updateOrCreate(...)` → return JSON

### 4C. `CoachingController`
- `index()` — Render halaman paket coaching
- `payment(Request)` — Validasi `hasPendingCoaching()` → generate VA preview → render halaman payment
- `store(Request)` — Validasi + `CoachingTransaction::create(status=pending)` + generate VA code → redirect ke pending
- `pendingStatus()` — Cek transaksi user → tampilkan status
- `success()` — Render halaman sukses

### 4D. `AssignmentController`
- `index()` — Query sesi aktif (status != selesai) + arsip (status = selesai) → render
- `reply(Request, Assignment)` — Validasi ownership + status → `messages()->create(...)` → update status → return JSON
- `messages(Assignment)` — Validasi ownership → mark as read → map messages → return JSON

### 4E. `AdminController`
- `dashboard()` — Stats + pending transactions + coaching activity feed → render
- `users(Request)` — Search + paginate → render tabel user
- `approveTransaction(CoachingTransaction $transaction)` — **Alur (lihat 4F)**
- `rejectTransaction(CoachingTransaction $transaction)` — Set status=rejected
- `assignments()` — Sesi coaching aktif + selesai → render
- `inboxSummary(Request)` — JSON: semua sesi untuk sidebar chat
- `inboxMessages(Assignment)` — Mark as read + return messages JSON
- `replyToSession(Request, Assignment)` — Validasi + create message + return JSON
- `completeSession(Assignment)` — Set status=selesai + completed_at + clear `active_coaching_package` user
- `courses()` — List course + count modules/quizzes → render
- `create()` → `edit(Course)` → `storeCourse(Request)` → `updateCourse(Request, Course)` → `deleteCourse(Course)`
- `modules(Course)` — List modul + quizzes_count → render
- `createModule(Course)` → `editModule(Module)` → `storeModule(Request, Course)` → `updateModule(Request, Module)` → `deleteModule(Module)` → `reorderModule(Request, Module)`

### 4F. Logic: Alur Pembelian Coaching

```
1. User klik "Pilih Paket" di /coaching
2. GET /payment?layanan=X&harga=Y
3. CoachingController@payment:
   - Cek hasPendingCoaching() → kalau true, redirect balik + error
   - Generate VA preview → tampilkan halaman
4. User klik "Bayar Sekarang"
5. POST /payment/store
6. CoachingController@store:
   - Validasi package_name, package_price
   - Cek hasPendingCoaching() lagi
   - CoachingTransaction::create(status='pending')
   - Generate VA code (8808 + padded user_id + transaction_id)
   - Redirect ke /payment/pending
7. Admin buka /admin dashboard
8. Admin klik "✅ Approve"
9. POST /admin/coaching/{id}/approve
10. AdminController@approveTransaction:
    - Set transaction.status = 'approved'
    - Set user.has_paid = true, user.active_coaching_package = package_name
    - Assignment::create(from_admin=true, judul='Sesi X', tugas_teks=template, status='diproses')
    - CoachingMessage::create(prechat message beda per paket)
    - Kembali ke dashboard dengan flash success
11. User buka /assignments → sesi coaching muncul + pesan prechat dari coach
12. User & admin chat via polling
```

### 4G. Logic: Alur Selesai Sesi Coaching

```
1. Admin klik "✓ Selesaikan Sesi" (di widget atau /admin/assignments)
2. POST /admin/coaching-inbox/{id}/complete
3. AdminController@completeSession:
   - assignment.status = 'selesai'
   - assignment.completed_at = now()
   - assignment.user.active_coaching_package = null
4. User refresh/buka /assignments:
   - Sesi pindah ke tab "Arsip Selesai"
   - Input chat disembunyikan, muncul banner "Sesi selesai" + CTA "Pilih Paket Coaching Baru"
5. User bisa beli paket baru (hasPendingCoaching() return false)
```

### 4H. Logic: Alur Unlock Modul & Progress Kursus

```
1. User buka /courses/{course_id}
2. CourseController@show memanggil Module::statusFor() untuk setiap modul:
   - Modul 0: selalu 'active' (pertama)
   - Modul N: cek ModuleProgress modul N-1 → done ? 'active' : 'locked'
   - Modul yang sudah ada completed_at → 'done'
3. User klik modul 'active' di sidebar
4. User jawab SEMUA quiz dalam modul tersebut dengan benar
5. JS kirim POST /modules/{module_id}/complete dengan score
6. CourseController@markModuleComplete:
   - ModuleProgress::updateOrCreate(...)
   - Kembalikan JSON success + course_done flag
7. JS update sidebar: modul saat ini → 'done', modul berikutnya → 'active'
8. Progress bar update
```

---

## 5. FITUR UTAMA per HALAMAN

### 5A. User Side

| Halaman | URL | Fitur |
|---------|-----|-------|
| **Home** | `/` | Hero section, stats (total pemain, kursus, completion, coaching), topic bar, cara kerja steps, CTA |
| **Katalog Kursus** | `/courses` | Grid card: icon, badge type/populer, title, deskripsi, meta (durasi, level, modul), progress bar, locked/unlocked. Guest dapet modal login |
| **Detail Modul** | `/courses/{id}` | Sidebar: list modul (done/active/locked icons + progress bar). Main panel: module header, YouTube embed, outline poin, quiz interaktif (pertanyaan + 4 opsi + feedback + dots navigasi). Multi-quiz per module |
| **Coaching** | `/coaching` | 3 tab paket (Textual Review / Panggil Pelatih / Demo Review). CTA "Pilih Paket" mengarah ke /payment |
| **Pembayaran** | `/payment` | Tampilkan VA code + nominal + instruksi bayar. Redirect ke pending |
| **Tugas Saya** | `/assignments` | Tab: Sesi Aktif (chat real-time, bubble coach/user, input reply) + Arsip Selesai (read-only history). Polling 4 detik. Auto-transisi closed |
| **Profile** | `/profile` | Header avatar + info. Form: nama, email, avatar upload (max 2MB), discord ID. Form: ganti password |

### 5B. Admin Side

| Halaman | URL | Fitur |
|---------|-----|-------|
| **Dashboard** | `/admin` | 5 stat cards (Total Pemain, Sudah Bayar, Menunggu Bayar, Total Kursus, Total Transaksi). Tabel Pembayaran Menunggu (approve/reject). Feed aktivitas coaching |
| **User** | `/admin/users` | Tabel semua user: #, avatar, nama, email, role badge (Admin/User), status badge (Paid/Free), paket aktif, tgl bergabung. Search bar. Summary bar (total, admin, user, paid). Pagination |
| **Sesi Coaching** | `/admin/assignments` | Sesi aktif: card dengan user info + chat box inline + input reply + tombol "Selesaikan Sesi". Arsip: accordion dropdown (klik header expand chat history) |
| **Kelola Course** | `/admin/courses` | Level 1: Card list course (icon, title, badges, meta). Tombol: Kelola Modul, Edit (✎), Hapus (🗑). Level 2: List modul (reorder ▲/▼, Edit, Hapus). Level 3: Form tambah/edit modul (info dasar + outline rows + quiz accordion + YouTube preview) |
| **Floating Chat Widget** | Semua halaman admin | Tombol 💬 pojok kanan bawah dengan unread badge. Panel meluncur: sidebar sesi (tab Aktif/Arsip) + chat detail + input + "Selesaikan Sesi". Polling auto |
| **Preview Mode** | — | Admin bisa lihat situs sebagai user biasa via toggle di navbar |

---

## 6. LOKALISASI BAHASA INDONESIA

Project menggunakan Bahasa Indonesia untuk UI, dengan kaidah: **serapan umum tetap** (Coaching, Admin, Dashboard, Discord, YouTube, Password, Email — sudah lazim), **sisanya Bahasa Indonesia natural**.

### 6A. File Bahasa Laravel — `lang/id/`

| File | Fungsi |
|------|--------|
| `lang/id/auth.php` | Pesan error auth: `failed`, `password`, `throttle` |
| `lang/id/pagination.php` | Label pagination: `previous` → "Sebelumnya", `next` → "Berikutnya" |
| `lang/id/passwords.php` | Pesan reset password: `reset`, `sent`, `throttled`, `token`, `user` |
| `lang/id/validation.php` | 100+ aturan validasi + `attributes` (nama, email, judul, discord_id, dll) + custom message (avatar.max → "Foto terlalu besar! Maksimal 2MB.") |

### 6B. Konfigurasi

- `APP_LOCALE=id` di `.env` + `.env.example`
- `config/app.php` → `locale` = `id`

### 6C. Perubahan Blade (non-exhaustive)

| Area | Before | After |
|------|--------|-------|
| Navbar | `Home` / `Courses` | **Beranda** / **Kursus** |
| Auth views | `Remember me`, `Forgot password`, `Log in`, `Register` | **Ingat saya**, **Lupa password?**, **Masuk**, **Daftar** |
| Assignments | `read-only` | **hanya bisa dibaca** |
| Profile | `Update Password` | **Ganti Password** |
| Payment | `BCA Virtual Account Number` | **Nomer BCA Virtual Account** |

### 6D. Kata yang Sengaja TIDAK Diterjemahkan

Coaching, Dashboard, Admin, Password, Email, Textual Review, Panggil Pelatih, Demo Review, Discord, YouTube, BCA Virtual Account, Aim & Movement, Map Control, User, Profile, Quiz — semua dianggap serapan umum atau istilah gaming/esports.

> Detail lengkap: lihat `BAHASA.md` di root project.
