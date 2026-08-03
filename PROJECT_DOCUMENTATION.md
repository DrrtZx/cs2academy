# PROJECT DOCUMENTATION — CS2 Academy

> Dokumentasi teknis untuk Activity Diagram, Use Case Diagram, dan Class Diagram
> Last updated: 2026-08-01

---

## 1. RINGKASAN APLIKASI

CS2 Academy adalah platform edukasi Counter-Strike 2 berbasis web. User dapat mengakses kursus interaktif dengan kuis per modul dan membeli sesi coaching 1-on-1 dengan coach/pro player. Admin mengelola kursus, modul, kuis, user, dan sesi coaching melalui panel admin.

---

## 2. AKTOR SISTEM

### 2.1 User (Pemain)
**Deskripsi:** User yang telah terdaftar dan login ke sistem

**Hak Akses:**
- Registrasi dan login/logout
- Melihat dan mengakses kursus
- Mengerjakan quiz per modul
- Melihat progress kursus
- Membeli paket coaching
- Chat dengan coach (sesi aktif)
- Mengelola profile (avatar, nama, email, discord ID, password)

**Batasan:**
- Hanya bisa akses kursus setelah login
- Tidak bisa membeli paket coaching baru jika ada transaksi pending atau sesi aktif
- Modul kursus unlock secara berurutan (harus selesaikan modul sebelumnya)

### 2.2 Admin
**Deskripsi:** Administrator platform dengan akses penuh

**Hak Akses:**
- Semua hak akses User
- Melihat dashboard statistik
- Mengelola semua user (lihat, search)
- Approve/reject pembayaran coaching
- Chat dengan user (sesi coaching)
- Mengelola kursus (tambah, edit, hapus)
- Mengelola modul dan quiz (tambah, edit, hapus, reorder)
- Menyelesaikan sesi coaching
- Preview mode (melihat sebagai user biasa)

---

## 3. USE CASE UTAMA

### 3.1 Use Case User

#### UC-U01: Registrasi dan Login
- **Aktor:** User
- **Deskripsi:** User melakukan registrasi akun baru atau login dengan akun existing
- **Precondition:** -
- **Postcondition:** User berhasil login dan mendapat akses ke sistem
- **Flow:**
  1. User mengakses halaman register/login
  2. User mengisi form (nama, email, password)
  3. Sistem validasi data
  4. Sistem membuat akun baru (register) atau verifikasi kredensial (login)
  5. Sistem redirect ke halaman home dengan status login

#### UC-U02: Mengakses dan Menyelesaikan Kursus
- **Aktor:** User
- **Deskripsi:** User mengakses kursus, mempelajari modul, dan mengerjakan quiz
- **Precondition:** User sudah login
- **Postcondition:** Progress modul tersimpan, modul berikutnya unlock
- **Flow:**
  1. User membuka katalog kursus
  2. User memilih kursus yang ingin dipelajari
  3. Sistem menampilkan daftar modul (done/active/locked)
  4. User membuka modul aktif
  5. Sistem menampilkan outline materi dan video YouTube
  6. User menjawab semua quiz dalam modul
  7. Sistem menyimpan ModuleProgress
  8. Sistem unlock modul berikutnya

#### UC-U03: Membeli Paket Coaching
- **Aktor:** User
- **Deskripsi:** User membeli paket coaching dan menunggu approval admin
- **Precondition:** User login, tidak ada transaksi pending atau sesi aktif
- **Postcondition:** Transaksi coaching dibuat dengan status pending
- **Flow:**
  1. User membuka halaman coaching
  2. User memilih paket (Textual Review/Panggil Pelatih/Demo Review)
  3. Sistem generate Virtual Account code
  4. User konfirmasi pembayaran
  5. Sistem membuat CoachingTransaction dengan status pending
  6. Sistem menampilkan VA dan instruksi pembayaran
  7. User menunggu admin approve

#### UC-U04: Chat dengan Coach (Sesi Coaching)
- **Aktor:** User
- **Deskripsi:** User berkomunikasi dengan coach dalam sesi coaching aktif
- **Precondition:** User login, memiliki sesi coaching aktif (sudah approved admin)
- **Postcondition:** Pesan tersimpan dalam CoachingMessage
- **Flow:**
  1. User membuka halaman "Tugas Saya" (/assignments)
  2. Sistem menampilkan sesi aktif dan arsip selesai
  3. User memilih sesi aktif
  4. Sistem load pesan-pesan chat
  5. User mengetik dan mengirim pesan
  6. Sistem simpan pesan dengan sender_id = user
  7. Sistem update status assignment menjadi 'diproses'
  8. Coach/Admin menerima notifikasi pesan baru

#### UC-U05: Mengelola Profile
- **Aktor:** User
- **Deskripsi:** User mengubah data profile dan password
- **Precondition:** User sudah login
- **Postcondition:** Data profile terupdate di database
- **Flow:**
  1. User membuka halaman profile
  2. User mengubah nama, email, discord ID, atau upload avatar
  3. User klik simpan
  4. Sistem validasi dan update data
  5. Sistem tampilkan notifikasi sukses

### 3.2 Use Case Admin

#### UC-A01: Login Admin
- **Aktor:** Admin
- **Deskripsi:** Admin login dengan akun role admin
- **Precondition:** Admin memiliki akun dengan role = 'admin'
- **Postcondition:** Admin masuk ke panel admin
- **Flow:** Sama dengan UC-U01, tapi redirect ke dashboard admin

#### UC-A02: Melihat Dashboard
- **Aktor:** Admin
- **Deskripsi:** Admin melihat statistik dan aktivitas platform
- **Precondition:** Admin sudah login
- **Postcondition:** Dashboard ditampilkan dengan data real-time
- **Flow:**
  1. Admin membuka /admin
  2. Sistem hitung statistik (total user, paid user, pending payment, total course, total transaksi)
  3. Sistem load transaksi pending
  4. Sistem load feed aktivitas coaching terbaru
  5. Sistem tampilkan dashboard

#### UC-A03: Approve/Reject Pembayaran Coaching
- **Aktor:** Admin
- **Deskripsi:** Admin memverifikasi dan approve/reject pembayaran user
- **Precondition:** Admin login, ada transaksi dengan status pending
- **Postcondition:** Transaksi status berubah, jika approved maka sesi coaching dibuat
- **Flow Approve:**
  1. Admin buka dashboard atau halaman pembayaran
  2. Admin klik tombol "Approve" pada transaksi pending
  3. Sistem update transaction.status = 'approved'
  4. Sistem update user.has_paid = true
  5. Sistem update user.active_coaching_package = package_name
  6. Sistem buat Assignment baru (status = 'diproses')
  7. Sistem buat CoachingMessage prechat otomatis
  8. Sistem tampilkan notifikasi sukses
  9. User dapat akses sesi coaching di /assignments

**Flow Reject:**
  1. Admin klik tombol "Reject"
  2. Sistem update transaction.status = 'rejected'
  3. User tidak dapat akses coaching
  4. Sistem tampilkan notifikasi

#### UC-A04: Chat dengan User (Coaching)
- **Aktor:** Admin
- **Deskripsi:** Admin membalas pesan user dalam sesi coaching
- **Precondition:** Admin login, ada sesi coaching aktif
- **Postcondition:** Pesan admin tersimpan, user menerima balasan
- **Flow:**
  1. Admin buka halaman sesi coaching atau floating chat widget
  2. Sistem tampilkan sidebar daftar sesi (aktif/arsip)
  3. Admin pilih sesi yang ada pesan baru
  4. Sistem load semua pesan dalam sesi
  5. Sistem mark pesan user sebagai read (read_at = now)
  6. Admin ketik dan kirim balasan
  7. Sistem simpan CoachingMessage dengan sender_id = admin.id
  8. User menerima pesan secara real-time (polling)

#### UC-A05: Menyelesaikan Sesi Coaching
- **Aktor:** Admin
- **Deskripsi:** Admin menandai sesi coaching sebagai selesai
- **Precondition:** Admin login, ada sesi coaching aktif
- **Postcondition:** Sesi coaching status = 'selesai', user bisa beli paket baru
- **Flow:**
  1. Admin buka sesi coaching
  2. Admin klik tombol "Selesaikan Sesi"
  3. Sistem update assignment.status = 'selesai'
  4. Sistem update assignment.completed_at = now()
  5. Sistem update user.active_coaching_package = null
  6. Sistem pindahkan sesi ke tab "Arsip"
  7. User dapat membeli paket coaching baru

#### UC-A06: Mengelola Kursus (CRUD)
- **Aktor:** Admin
- **Deskripsi:** Admin membuat, mengedit, atau menghapus kursus
- **Precondition:** Admin login
- **Postcondition:** Data kursus terupdate di database
- **Flow Tambah:**
  1. Admin buka /admin/courses
  2. Admin klik "Tambah Course Baru"
  3. Admin isi form (icon, title, body, level, durasi, type, is_popular, urutan)
  4. Admin submit form
  5. Sistem validasi dan simpan ke database
  6. Sistem redirect ke list course

**Flow Edit:**
  1. Admin klik tombol Edit pada course
  2. Sistem tampilkan form dengan data existing
  3. Admin ubah data
  4. Admin submit
  5. Sistem update course di database

**Flow Hapus:**
  1. Admin klik tombol Hapus
  2. Sistem tampilkan konfirmasi
  3. Admin konfirmasi
  4. Sistem hapus course dan relasi (modules, quizzes)

#### UC-A07: Mengelola Modul dan Quiz (CRUD)
- **Aktor:** Admin
- **Deskripsi:** Admin membuat, mengedit, menghapus, atau reorder modul
- **Precondition:** Admin login, course sudah ada
- **Postcondition:** Data modul dan quiz terupdate
- **Flow Tambah Modul:**
  1. Admin buka detail course → List Modul
  2. Admin klik "Tambah Modul Baru"
  3. Admin isi form modul (title, body outline, youtube_url, urutan)
  4. Admin tambah quiz (pertanyaan, 4 opsi, jawaban_benar, penjelasan)
  5. Admin submit
  6. Sistem simpan Module dan Quiz
  7. Sistem redirect ke list modul

**Flow Edit Modul:**
  1. Admin klik Edit pada modul
  2. Sistem tampilkan form dengan data existing + quiz
  3. Admin ubah data modul dan quiz
  4. Admin submit
  5. Sistem update Module dan sync Quiz

**Flow Reorder Modul:**
  1. Admin klik tombol ▲ (naik) atau ▼ (turun)
  2. Sistem swap urutan dengan modul sebelah
  3. Sistem update urutan di database
  4. Sistem refresh list modul

**Flow Hapus Modul:**
  1. Admin klik tombol Hapus
  2. Sistem konfirmasi
  3. Admin konfirmasi
  4. Sistem hapus modul dan quiz terkait

#### UC-A08: Mengelola User
- **Aktor:** Admin
- **Deskripsi:** Admin melihat daftar user dan mencari user tertentu
- **Precondition:** Admin login
- **Postcondition:** Data user ditampilkan
- **Flow:**
  1. Admin buka /admin/users
  2. Sistem load semua user dengan pagination
  3. Sistem tampilkan tabel (avatar, nama, email, role, status paid/free, paket aktif, tanggal bergabung)
  4. Admin bisa search berdasarkan nama/email
  5. Sistem filter dan tampilkan hasil

---

## 4. CLASS DIAGRAM - MODEL DATABASE

### 4.1 Class: User
**Tabel:** `users`

**Attributes:**
- `id: bigint` (PK)
- `name: string`
- `email: string` (unique)
- `email_verified_at: timestamp` (nullable)
- `password: string`
- `role: enum` (admin, user) — default: user
- `has_paid: boolean` — default: false
- `active_coaching_package: string` (nullable)
- `discord_id: string` (nullable)
- `avatar: string` (nullable)
- `remember_token: string`
- `created_at: timestamp`
- `updated_at: timestamp`

**Methods:**
- `isAdmin(): bool`
- `hasCourseAccess(): bool`
- `hasPendingCoaching(): bool`

**Relationships:**
- `assignments: hasMany(Assignment)`
- `courseProgress: hasMany(CourseProgress)`
- `coachingTransactions: hasMany(CoachingTransaction)`
- `moduleProgress: hasMany(ModuleProgress)`

---

### 4.2 Class: Course
**Tabel:** `courses`

**Attributes:**
- `id: bigint` (PK)
- `icon: string`
- `title: string`
- `body: text`
- `level: string`
- `durasi: string`
- `type: string`
- `is_popular: boolean`
- `urutan: integer`
- `created_at: timestamp`
- `updated_at: timestamp`

**Methods:**
- `progressPercent(userId): int`
- `isUnlockedFor(userId, allCourseIds, index): bool`

**Relationships:**
- `modules: hasMany(Module)`
- `quizzes: hasMany(Quiz)`

---

### 4.3 Class: Module
**Tabel:** `modules`

**Attributes:**
- `id: bigint` (PK)
- `course_id: bigint` (FK → courses)
- `title: string`
- `body: text` (nullable)
- `youtube_url: string` (nullable)
- `urutan: integer`
- `created_at: timestamp`
- `updated_at: timestamp`

**Methods:**
- `userProgress(userId): ModuleProgress`
- `statusFor(userId, allModuleIds, index): string`

**Accessors:**
- `youtube_video_id: string`
- `youtube_embed_url: string`

**Relationships:**
- `course: belongsTo(Course)`
- `quizzes: hasMany(Quiz)`
- `progress: hasMany(ModuleProgress)`

---

### 4.4 Class: Quiz
**Tabel:** `quizzes`

**Attributes:**
- `id: bigint` (PK)
- `course_id: bigint` (FK → courses)
- `module_id: bigint` (FK → modules, nullable)
- `pertanyaan: text`
- `opsi: JSON` (array of 4 strings)
- `jawaban_benar: integer` (0-3)
- `penjelasan: text` (nullable)
- `youtube_url: string` (nullable, legacy)
- `created_at: timestamp`
- `updated_at: timestamp`

**Relationships:**
- `course: belongsTo(Course)`
- `module: belongsTo(Module)`

---

### 4.5 Class: ModuleProgress
**Tabel:** `module_progress`

**Attributes:**
- `id: bigint` (PK)
- `user_id: bigint` (FK → users)
- `module_id: bigint` (FK → modules)
- `score: integer`
- `completed_at: timestamp` (nullable)
- `created_at: timestamp`
- `updated_at: timestamp`

**Constraints:**
- UNIQUE `[user_id, module_id]`

**Relationships:**
- `user: belongsTo(User)`
- `module: belongsTo(Module)`

---

### 4.6 Class: Assignment
**Tabel:** `assignments`

**Attributes:**
- `id: bigint` (PK)
- `user_id: bigint` (FK → users)
- `from_admin: boolean` — default: true
- `judul: string`
- `tugas_teks: text`
- `status: enum` (menunggu, diproses, selesai)
- `completed_at: timestamp` (nullable)
- `balasan_admin: text` (nullable, legacy)
- `created_at: timestamp`
- `updated_at: timestamp`

**Methods:**
- `unreadCount(): int`
- `lastMessage(): CoachingMessage`

**Relationships:**
- `user: belongsTo(User)`
- `messages: hasMany(CoachingMessage)`

---

### 4.7 Class: CoachingMessage
**Tabel:** `coaching_messages`

**Attributes:**
- `id: bigint` (PK)
- `assignment_id: bigint` (FK → assignments)
- `sender_id: bigint` (FK → users)
- `message: text`
- `read_at: timestamp` (nullable)
- `created_at: timestamp`
- `updated_at: timestamp`

**Methods:**
- `markAsRead(): void`

**Relationships:**
- `assignment: belongsTo(Assignment)`
- `sender: belongsTo(User)`

---

### 4.8 Class: CoachingTransaction
**Tabel:** `coaching_transactions`

**Attributes:**
- `id: bigint` (PK)
- `user_id: bigint` (FK → users)
- `package_name: string`
- `package_price: string`
- `va_code: string`
- `status: enum` (pending, approved, rejected)
- `created_at: timestamp`
- `updated_at: timestamp`

**Scopes:**
- `pending(): Builder`
- `approved(): Builder`

**Relationships:**
- `user: belongsTo(User)`

---

### 4.9 Class: CourseProgress (Legacy)
**Tabel:** `course_progress`

**Keterangan:** 
Legacy table dari sistem lama. Sekarang progress dilacak via `ModuleProgress`.

---

## 5. ACTIVITY DIAGRAM - BUSINESS FLOW

### 5.1 Activity: User Menyelesaikan Modul Kursus

```
[START]
  ↓
User login
  ↓
User membuka katalog kursus
  ↓
User memilih kursus
  ↓
Sistem load daftar modul
  ↓
Sistem cek progress user → tentukan status modul (done/active/locked)
  ↓
User membuka modul dengan status "active"
  ↓
Sistem tampilkan outline, video YouTube, dan quiz
  ↓
User menjawab quiz (semua soal)
  ↓
<Decision: Semua jawaban benar?>
  ├─ NO → Sistem tampilkan feedback "Coba lagi"
  │          ↓
  │      User ulangi quiz
  │          ↓
  │      [Kembali ke menjawab quiz]
  │
  └─ YES → Sistem simpan ModuleProgress
             ↓
         Sistem update status modul → "done"
             ↓
         Sistem unlock modul berikutnya → "active"
             ↓
         <Decision: Masih ada modul selanjutnya?>
             ├─ YES → User bisa lanjut ke modul berikutnya
             │         ↓
             │     [Kembali ke membuka modul]
             │
             └─ NO → Kursus selesai 100%
                       ↓
                   [END]
```

---

### 5.2 Activity: User Membeli Paket Coaching

```
[START]
  ↓
User login
  ↓
User membuka halaman /coaching
  ↓
User memilih paket coaching (Textual Review / Panggil Pelatih / Demo Review)
  ↓
Sistem cek: hasPendingCoaching()?
  ↓
<Decision: Ada transaksi pending atau sesi aktif?>
  ├─ YES → Sistem tampilkan error "Anda masih punya transaksi pending"
  │          ↓
  │      User tidak bisa lanjut
  │          ↓
  │      [END]
  │
  └─ NO → Sistem redirect ke /payment
            ↓
        Sistem generate Virtual Account code (8808 + user_id + transaction_id)
            ↓
        Sistem tampilkan form pembayaran (VA, nominal, instruksi)
            ↓
        User klik "Bayar Sekarang"
            ↓
        Sistem buat CoachingTransaction (status = 'pending')
            ↓
        Sistem redirect ke /payment/pending
            ↓
        Sistem tampilkan status "Menunggu Verifikasi Admin"
            ↓
        [User menunggu]
            ↓
        Admin login → buka Dashboard
            ↓
        Admin lihat tabel "Pembayaran Menunggu Verifikasi"
            ↓
        <Decision: Admin approve atau reject?>
            ├─ REJECT → Sistem update transaction.status = 'rejected'
            │              ↓
            │          User tidak dapat akses coaching
            │              ↓
            │          [END]
            │
            └─ APPROVE → Sistem update transaction.status = 'approved'
                           ↓
                       Sistem update user.has_paid = true
                           ↓
                       Sistem update user.active_coaching_package = package_name
                           ↓
                       Sistem buat Assignment baru (status = 'diproses')
                           ↓
                       Sistem buat CoachingMessage prechat otomatis
                           ↓
                       User buka /assignments
                           ↓
                       Sistem tampilkan sesi coaching aktif + prechat message
                           ↓
                       User mulai chat dengan coach
                           ↓
                       [END]
```

---

### 5.3 Activity: User dan Admin Chat dalam Sesi Coaching

```
[START - User Side]
  ↓
User login
  ↓
User buka /assignments
  ↓
Sistem load sesi aktif (status != 'selesai') dan arsip (status = 'selesai')
  ↓
User pilih sesi aktif
  ↓
Sistem load semua CoachingMessage untuk sesi ini
  ↓
Sistem mark pesan dari admin sebagai read (read_at = now)
  ↓
Sistem tampilkan chat interface (bubble user/coach)
  ↓
User ketik pesan
  ↓
User klik "Kirim"
  ↓
Sistem simpan CoachingMessage (sender_id = user.id, read_at = null)
  ↓
Sistem update assignment.status = 'diproses' (jika sebelumnya 'menunggu')
  ↓
[Polling 4 detik] → Sistem cek pesan baru
  ↓
<Decision: Ada balasan dari admin?>
  ├─ NO → [Tetap polling]
  │
  └─ YES → Sistem tampilkan pesan admin baru
             ↓
         User baca pesan
             ↓
         [Kembali ke User ketik pesan atau END]


[START - Admin Side]
  ↓
Admin login
  ↓
Admin buka /admin/assignments atau floating chat widget
  ↓
Sistem load sidebar: daftar sesi (tab Aktif / Arsip)
  ↓
Sistem tampilkan badge unread count pada sesi dengan pesan baru
  ↓
Admin pilih sesi dengan pesan baru
  ↓
Sistem load semua CoachingMessage
  ↓
Sistem mark pesan dari user sebagai read (read_at = now)
  ↓
Sistem tampilkan chat interface
  ↓
Admin ketik balasan
  ↓
Admin klik "Kirim"
  ↓
Sistem simpan CoachingMessage (sender_id = admin.id, read_at = null)
  ↓
User menerima pesan via polling
  ↓
<Decision: Sesi sudah selesai?>
  ├─ NO → [Admin bisa lanjut balas atau END]
  │
  └─ YES → Admin klik "Selesaikan Sesi"
             ↓
         Sistem update assignment.status = 'selesai'
             ↓
         Sistem update assignment.completed_at = now()
             ↓
         Sistem update user.active_coaching_package = null
             ↓
         Sesi pindah ke tab "Arsip"
             ↓
         User bisa membeli paket coaching baru
             ↓
         [END]
```

---

### 5.4 Activity: Admin Mengelola Kursus dan Modul

```
[START]
  ↓
Admin login
  ↓
Admin buka /admin/courses
  ↓
Sistem tampilkan daftar course (Level 1)
  ↓
<Decision: Admin ingin apa?>
  │
  ├─ [Tambah Course Baru]
  │    ↓
  │  Admin klik "Tambah Course Baru"
  │    ↓
  │  Admin isi form (icon, title, body, level, durasi, type, is_popular, urutan)
  │    ↓
  │  Admin submit
  │    ↓
  │  Sistem validasi data
  │    ↓
  │  Sistem simpan Course baru
  │    ↓
  │  [Kembali ke daftar course]
  │
  ├─ [Edit Course]
  │    ↓
  │  Admin klik tombol "Edit" pada course
  │    ↓
  │  Sistem load data course
  │    ↓
  │  Admin ubah data
  │    ↓
  │  Admin submit
  │    ↓
  │  Sistem update Course
  │    ↓
  │  [Kembali ke daftar course]
  │
  ├─ [Hapus Course]
  │    ↓
  │  Admin klik tombol "Hapus"
  │    ↓
  │  Sistem tampilkan konfirmasi
  │    ↓
  │  Admin konfirmasi
  │    ↓
  │  Sistem hapus Course + Modules + Quizzes terkait
  │    ↓
  │  [Kembali ke daftar course]
  │
  └─ [Kelola Modul]
       ↓
     Admin klik "Kelola Modul" pada course
       ↓
     Sistem tampilkan daftar modul (Level 2)
       ↓
     <Decision: Admin ingin apa?>
       │
       ├─ [Tambah Modul]
       │    ↓
       │  Admin klik "Tambah Modul Baru"
       │    ↓
       │  Admin isi form modul (title, body, youtube_url, urutan)
       │    ↓
       │  Admin tambah quiz (pertanyaan, 4 opsi, jawaban_benar, penjelasan)
       │    ↓
       │  Admin bisa tambah multiple quiz
       │    ↓
       │  Admin submit
       │    ↓
       │  Sistem simpan Module + Quiz
       │    ↓
       │  [Kembali ke daftar modul]
       │
       ├─ [Edit Modul]
       │    ↓
       │  Admin klik "Edit" pada modul
       │    ↓
       │  Sistem load data modul + quiz
       │    ↓
       │  Admin ubah data
       │    ↓
       │  Admin submit
       │    ↓
       │  Sistem update Module + sync Quiz
       │    ↓
       │  [Kembali ke daftar modul]
       │
       ├─ [Reorder Modul]
       │    ↓
       │  Admin klik tombol ▲ (naik) atau ▼ (turun)
       │    ↓
       │  Sistem swap urutan modul
       │    ↓
       │  Sistem refresh daftar
       │    ↓
       │  [Kembali ke daftar modul]
       │
       └─ [Hapus Modul]
            ↓
          Admin klik "Hapus"
            ↓
          Sistem konfirmasi
            ↓
          Admin konfirmasi
            ↓
          Sistem hapus Module + Quiz terkait
            ↓
          [Kembali ke daftar modul]
            ↓
          [END]
```

---

## 6. SEQUENCE DIAGRAM - KEY INTERACTIONS

### 6.1 Sequence: User Menyelesaikan Quiz Modul

```
User -> Browser: Buka modul kursus
Browser -> CourseController: GET /courses/{course_id}
CourseController -> Module: Load modules dengan quiz
Module -> ModuleProgress: Cek progress user
ModuleProgress --> CourseController: Return data progress
CourseController --> Browser: Render halaman detail modul
Browser --> User: Tampilkan modul + quiz

User -> Browser: Jawab semua quiz dengan benar
Browser -> CourseController: POST /modules/{module_id}/complete (score)
CourseController -> ModuleProgress: updateOrCreate(user_id, module_id, score, completed_at)
ModuleProgress --> CourseController: Progress tersimpan
CourseController --> Browser: Return JSON {success: true, course_done: false}
Browser -> Browser: Update UI (modul done, unlock modul next)
Browser --> User: Tampilkan modul berikutnya unlock
```

---

### 6.2 Sequence: Admin Approve Pembayaran Coaching

```
User -> Browser: Pilih paket coaching
Browser -> CoachingController: POST /payment/store
CoachingController -> CoachingTransaction: create(status='pending', va_code=...)
CoachingTransaction --> CoachingController: Transaction created
CoachingController --> Browser: Redirect /payment/pending
Browser --> User: Tampilkan "Menunggu Verifikasi"

[...User menunggu...]

Admin -> Browser: Buka Dashboard
Browser -> AdminController: GET /admin
AdminController -> CoachingTransaction: where(status='pending')->get()
CoachingTransaction --> AdminController: List transaksi pending
AdminController --> Browser: Render dashboard
Browser --> Admin: Tampilkan tabel pembayaran pending

Admin -> Browser: Klik "Approve" pada transaksi
Browser -> AdminController: POST /admin/coaching/{transaction_id}/approve
AdminController -> CoachingTransaction: update(status='approved')
AdminController -> User: update(has_paid=true, active_coaching_package=package_name)
AdminController -> Assignment: create(user_id, from_admin=true, status='diproses')
AdminController -> CoachingMessage: create(assignment_id, sender_id=admin, message=prechat)
CoachingMessage --> AdminController: Message created
AdminController --> Browser: Redirect dengan flash success
Browser --> Admin: Tampilkan "Pembayaran berhasil diapprove"

User -> Browser: Buka /assignments
Browser -> AssignmentController: GET /assignments
AssignmentController -> Assignment: where(user_id, status!='selesai')
Assignment --> AssignmentController: Sesi aktif
AssignmentController --> Browser: Render halaman assignments
Browser --> User: Tampilkan sesi coaching aktif + prechat
```

---

### 6.3 Sequence: Chat Coaching antara User dan Admin

```
User -> Browser: Buka /assignments, pilih sesi aktif
Browser -> AssignmentController: GET /assignments/{assignment_id}/messages
AssignmentController -> CoachingMessage: where(assignment_id)->orderBy('created_at')->get()
CoachingMessage --> AssignmentController: List pesan
AssignmentController -> CoachingMessage: update(read_at=now) untuk pesan admin
AssignmentController --> Browser: Return JSON messages
Browser --> User: Tampilkan chat history

User -> Browser: Ketik pesan dan klik kirim
Browser -> AssignmentController: POST /assignments/{assignment_id}/reply (message)
AssignmentController -> CoachingMessage: create(assignment_id, sender_id=user.id, message)
AssignmentController -> Assignment: update(status='diproses')
Assignment --> AssignmentController: Updated
AssignmentController --> Browser: Return JSON {success: true, message}
Browser --> User: Tampilkan pesan user baru

[Polling 4 detik]
Browser -> AssignmentController: GET /assignments/{assignment_id}/messages
AssignmentController -> CoachingMessage: where(assignment_id)->get()
CoachingMessage --> AssignmentController: List pesan (termasuk balasan admin baru)
AssignmentController --> Browser: Return JSON
Browser --> User: Tampilkan balasan admin

[Parallel - Admin Side]
Admin -> Browser: Buka floating chat widget
Browser -> AdminController: GET /admin/coaching-inbox/summary
AdminController -> Assignment: Load semua assignment dengan unread count
Assignment --> AdminController: List sesi + unread badge
AdminController --> Browser: Return JSON sidebar
Browser --> Admin: Tampilkan sidebar dengan badge unread

Admin -> Browser: Klik sesi dengan badge unread
Browser -> AdminController: GET /admin/coaching-inbox/{assignment_id}/messages
AdminController -> CoachingMessage: where(assignment_id)->get()
CoachingMessage --> AdminController: List pesan
AdminController -> CoachingMessage: update(read_at=now) untuk pesan user
AdminController --> Browser: Return JSON messages
Browser --> Admin: Tampilkan chat + pesan user

Admin -> Browser: Ketik balasan dan kirim
Browser -> AdminController: POST /admin/coaching-inbox/{assignment_id}/reply
AdminController -> CoachingMessage: create(assignment_id, sender_id=admin.id, message)
CoachingMessage --> AdminController: Created
AdminController --> Browser: Return JSON {success: true}
Browser --> Admin: Tampilkan balasan admin

[User side polling detects new message]
Browser -> AssignmentController: GET /assignments/{assignment_id}/messages
AssignmentController --> Browser: Return messages dengan balasan admin baru
Browser --> User: Tampilkan balasan admin real-time
```

---

## 7. STATE DIAGRAM - STATUS FLOW

### 7.1 State: Assignment Status

```
[menunggu]
    ↓ (User kirim pesan pertama)
[diproses]
    ↓ (Admin klik "Selesaikan Sesi")
[selesai] — FINAL STATE
```

**Keterangan:**
- `menunggu`: Sesi baru dibuat, belum ada interaksi user
- `diproses`: User sudah kirim pesan, sesi aktif
- `selesai`: Admin tandai sesi selesai, masuk ke arsip

---

### 7.2 State: CoachingTransaction Status

```
[pending]
    ↓
    ├─ (Admin approve) → [approved] — FINAL STATE
    │
    └─ (Admin reject) → [rejected] — FINAL STATE
```

**Keterangan:**
- `pending`: Transaksi baru dibuat, menunggu verifikasi admin
- `approved`: Admin approve, sesi coaching dibuat, user dapat akses
- `rejected`: Admin reject, user tidak dapat akses coaching

---

### 7.3 State: Module Status (untuk User)

```
[locked] — Modul terkunci
    ↓ (Modul sebelumnya selesai OR modul pertama)
[active] — Modul bisa diakses
    ↓ (User selesaikan semua quiz dengan benar)
[done] — Modul selesai, unlock modul berikutnya
```

**Keterangan:**
- `locked`: User belum bisa akses, harus selesaikan modul sebelumnya
- `active`: User bisa akses, belajar, dan kerjakan quiz
- `done`: User sudah selesai, progress tersimpan

---

## 8. BUSINESS RULES & CONSTRAINTS

### 8.1 Rules untuk User

1. **Course Access:**
   - User harus login untuk akses katalog kursus
   - Semua kursus unlocked secara default (tidak ada prerequisite)

2. **Module Unlock:**
   - Modul pertama dalam kursus selalu unlock (active)
   - Modul berikutnya unlock setelah modul sebelumnya selesai (completed_at != null)
   - User harus jawab SEMUA quiz dalam modul dengan benar untuk unlock modul next

3. **Coaching Purchase:**
   - User tidak bisa membeli paket coaching baru jika:
     - Ada CoachingTransaction dengan status = 'pending', ATAU
     - Ada Assignment dengan status != 'selesai' (sesi aktif)
   - Satu user hanya bisa punya satu sesi coaching aktif

4. **Chat Coaching:**
   - User hanya bisa chat di sesi dengan status != 'selesai'
   - Setelah sesi selesai, chat menjadi read-only di tab "Arsip"

---

### 8.2 Rules untuk Admin

1. **Payment Approval:**
   - Admin bisa approve/reject transaksi dengan status = 'pending'
   - Saat approve:
     - Transaction.status → 'approved'
     - User.has_paid → true
     - User.active_coaching_package → package_name
     - Assignment dibuat otomatis (from_admin=true, status='diproses')
     - CoachingMessage prechat otomatis dibuat (beda per paket)
   - Saat reject:
     - Transaction.status → 'rejected'
     - User tidak dapat akses coaching

2. **Coaching Session:**
   - Admin bisa chat di semua sesi (aktif & arsip)
   - Admin bisa "Selesaikan Sesi":
     - Assignment.status → 'selesai'
     - Assignment.completed_at → now()
     - User.active_coaching_package → null
     - Sesi pindah ke tab Arsip
     - User bisa beli paket baru

3. **Course & Module Management:**
   - Admin bisa CRUD course tanpa batasan
   - Hapus course akan cascade delete modules dan quizzes terkait
   - Admin bisa reorder modul (swap urutan dengan modul sebelah)
   - Hapus modul akan cascade delete quizzes terkait

4. **Preview Mode:**
   - Admin bisa toggle preview mode (lihat situs sebagai user)
   - Saat preview mode ON, admin kehilangan akses admin panel
   - Admin bisa kembali ke mode admin via toggle

---

## 9. DATA VALIDATION & CONSTRAINTS

### 9.1 Validasi User Input

**Register/Login:**
- `name`: required, string, max 255
- `email`: required, email, unique di table users
- `password`: required, min 8 karakter, confirmed

**Profile Update:**
- `name`: required, string, max 255
- `email`: required, email, unique (kecuali email sendiri)
- `discord_id`: nullable, string, max 255
- `avatar`: nullable, image (jpg, jpeg, png), max 2MB

**Coaching Payment:**
- `package_name`: required, in:[Textual Review, Panggil Pelatih, Demo Review]
- `package_price`: required, string

**Chat Message:**
- `message`: required, string, tidak boleh kosong

---

### 9.2 Validasi Admin Input

**Course:**
- `icon`: required, string (emoji)
- `title`: required, string, max 255
- `body`: required, text
- `level`: required, in:[Pemula, Menengah, Lanjutan]
- `durasi`: required, string
- `type`: required, in:[Kursus Wajib, Kursus Lanjutan]
- `is_popular`: boolean
- `urutan`: required, integer, unique per course

**Module:**
- `title`: required, string, max 255
- `body`: nullable, text (outline, newline-separated)
- `youtube_url`: nullable, url, regex untuk YouTube URL
- `urutan`: required, integer, unique per course

**Quiz:**
- `pertanyaan`: required, text
- `opsi`: required, array, size 4
- `opsi.*`: required, string
- `jawaban_benar`: required, integer, between 0-3
- `penjelasan`: nullable, text

---

## 10. RELASI ANTAR ENTITY (ERD)

```
User (1) ────< (N) ModuleProgress
  │
  ├──< (N) Assignment
  │      │
  │      └──< (N) CoachingMessage
  │
  ├──< (N) CoachingTransaction
  │
  └──< (N) CourseProgress (legacy)

Course (1) ────< (N) Module
   │               │
   │               └──< (N) Quiz
   │               │
   │               └──< (N) ModuleProgress
   │
   └──< (N) Quiz (langsung ke course, optional)
```

**Keterangan Relasi:**

- `User → ModuleProgress`: One-to-Many (1 user punya banyak progress modul)
- `User → Assignment`: One-to-Many (1 user punya banyak sesi coaching)
- `User → CoachingTransaction`: One-to-Many (1 user punya banyak transaksi)
- `Assignment → CoachingMessage`: One-to-Many (1 sesi punya banyak pesan)
- `User → CoachingMessage` (sender): One-to-Many (1 user kirim banyak pesan)
- `Course → Module`: One-to-Many (1 course punya banyak modul)
- `Course → Quiz`: One-to-Many (1 course punya banyak quiz)
- `Module → Quiz`: One-to-Many (1 modul punya banyak quiz)
- `Module → ModuleProgress`: One-to-Many (1 modul punya banyak progress dari user berbeda)

**Unique Constraints:**
- `users.email`: unique
- `module_progress (user_id, module_id)`: unique (1 user hanya punya 1 progress per modul)

---

## 11. API ENDPOINTS SUMMARY

### 11.1 User Endpoints (JSON Response)

| Method | Endpoint | Fungsi | Response |
|--------|----------|--------|----------|
| POST | `/modules/{module}/complete` | Simpan progress modul | `{success: true, course_done: bool}` |
| POST | `/assignments/{assignment}/reply` | Kirim pesan chat user | `{success: true, message: {...}}` |
| GET | `/assignments/{assignment}/messages` | Ambil semua pesan chat | `{messages: [...]`} |

### 11.2 Admin Endpoints (JSON Response)

| Method | Endpoint | Fungsi | Response |
|--------|----------|--------|----------|
| GET | `/admin/users/search` | Search user (AJAX) | `{users: [...]}` |
| GET | `/admin/coaching-inbox/summary` | Sidebar chat (sesi list) | `{active: [...], completed: [...]}` |
| GET | `/admin/coaching-inbox/{assignment}/messages` | Load pesan chat | `{messages: [...]}` |
| POST | `/admin/coaching-inbox/{assignment}/reply` | Kirim balasan admin | `{success: true}` |
| POST | `/admin/coaching-inbox/{assignment}/complete` | Selesaikan sesi | `{success: true}` |

---

## 12. LOKALISASI BAHASA INDONESIA

Project menggunakan **Bahasa Indonesia** untuk seluruh UI dengan kaidah:

**Tetap bahasa asli (serapan umum):**
- Coaching, Admin, Dashboard, Discord, YouTube, Password, Email
- Textual Review, Panggil Pelatih, Demo Review
- Quiz, User, Profile, Virtual Account

**Diterjemahkan:**
- Home → **Beranda**
- Courses → **Kursus**
- Assignments → **Tugas Saya**
- Remember me → **Ingat saya**
- Forgot password → **Lupa password?**
- Log in → **Masuk**
- Register → **Daftar**
- Update Password → **Ganti Password**

**File Lokalisasi:**
- `lang/id/auth.php` — Pesan error auth
- `lang/id/pagination.php` — Label pagination
- `lang/id/passwords.php` — Pesan reset password
- `lang/id/validation.php` — 100+ aturan validasi + custom messages

**Konfigurasi:**
- `APP_LOCALE=id` di `.env`
- `config/app.php` → `locale` = `id`

---

## 13. TEKNOLOGI STACK

**Backend:**
- Laravel 11.x (PHP Framework)
- MySQL 8.0 (Database)
- Laravel Breeze (Authentication scaffold)

**Frontend:**
- Blade Templates (Laravel templating)
- Tailwind CSS 3.x (Styling)
- Alpine.js (Minimal JavaScript interactions)
- Vite (Asset bundler)

**Key Laravel Features:**
- Eloquent ORM (Models & Relationships)
- Migration & Seeder (Database versioning)
- Route Model Binding
- Policies & Gates (Authorization)
- Form Request Validation
- File Storage (Avatar upload)

**Development Tools:**
- Composer (PHP package manager)
- NPM (Node package manager)
- Laragon (Local development environment)
- Git (Version control)

---

## 14. DEPLOYMENT NOTES

**Environment Requirements:**
- PHP >= 8.2
- MySQL >= 8.0
- Node.js >= 18.x
- Composer >= 2.x

**Laravel Configuration:**
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://cs2academy.com`
- Database credentials di `.env`
- Mail driver untuk reset password
- Storage link: `php artisan storage:link`

**Build Assets:**
```bash
npm install
npm run build
```

**Database Migration:**
```bash
php artisan migrate --seed
```

**Permissions:**
- `storage/` → writable (untuk avatar upload)
- `bootstrap/cache/` → writable

---

## 15. KESIMPULAN

Dokumentasi ini mencakup seluruh aspek sistem CS2 Academy untuk keperluan pembuatan:

1. **Use Case Diagram** — Lihat section 3 (Use Case Utama)
2. **Activity Diagram** — Lihat section 5 (Activity Diagram - Business Flow)
3. **Class Diagram** — Lihat section 4 (Class Diagram - Model Database) & section 10 (ERD)
4. **Sequence Diagram** — Lihat section 6 (Sequence Diagram - Key Interactions)
5. **State Diagram** — Lihat section 7 (State Diagram - Status Flow)

**Key Points untuk Diagram:**
- **2 Aktor Utama**: User dan Admin
- **3 Domain Fitur**: Kursus (Course/Module), Coaching (Payment/Chat), Profile
- **8 Model Utama**: User, Course, Module, Quiz, ModuleProgress, Assignment, CoachingMessage, CoachingTransaction
- **Status Flow**: Assignment (menunggu → diproses → selesai), Transaction (pending → approved/rejected), Module (locked → active → done)

Semua informasi sudah lengkap dan fokus pada User dan Admin tanpa menyertakan Guest untuk memudahkan pembuatan diagram UML.

---

**END OF DOCUMENTATION**
