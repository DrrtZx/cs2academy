# CS2 Academy

Platform edukasi Counter-Strike 2 #1 di Indonesia. Kursus interaktif, kuis praktikal, dan coaching 1-on-1 dengan pro player.

## Stack

- **Laravel 12.x** (PHP 8.3+, `laravel/framework ^13.8`)
- **MySQL** — database relasional
- **Laravel Breeze** — authentication (login, register, password reset, verify email)
- **Vanilla CSS + Blade** — no JS framework, no Tailwind. Custom design system with CSS custom properties.
- **Vite** — frontend build tool
- **Laragon** — local dev server (Windows)

## Project structure (what matters)

```
app/
├── Models/
│   ├── User.php              # role (admin|user), has_paid, active_coaching_package
│   ├── Course.php            # icon, title, body, urutan — hasMany Quiz
│   ├── Quiz.php              # pertanyaan, opsi (json array), jawaban_benar (0-3), penjelasan, youtube_url
│   ├── CourseProgress.php    # user_id, course_id, score, completed_at — pivot tracking
│   ├── Assignment.php        # tugas/coaching: user_id, judul, tugas_teks, status (menunggu|diproses|selesai), balasan_admin, from_admin (bool)
│   └── CoachingTransaction.php # payment records: user_id, package_name, package_price, va_code, status (pending|approved|rejected)
├── Http/Controllers/
│   ├── HomeController.php    # Landing page stats
│   ├── CourseController.php  # Course listing + quiz completion via fetch()
│   ├── CoachingController.php # Coaching packages, payment flow, VA code generation
│   ├── AssignmentController.php # User assignments: index, store
│   ├── AdminController.php   # Dashboard, assignment management, quiz CRUD, coaching approval, user search
│   └── ProfileController.php # Profile edit, account deletion
resources/views/
├── layouts/app.blade.php     # Main layout: nav, auth modal (login/register), footer, dropdown
├── home.blade.php            # Hero, stats, topics bar, "cara kerja" steps, CTA
├── courses/index.blade.php   # LMS sidebar + quiz engine (client-side JS, fetch progress to server)
├── coaching/index.blade.php  # Coaching package tabs
├── assignments/index.blade.php # User coaching inbox
├── admin/dashboard.blade.php # Admin stats, coaching transaction table
├── admin/assignments.blade.php # Admin inbox: 3 tabs (incoming, coaching, sent)
├── admin/quiz.blade.php      # Quiz CRUD per course
├── payment/{index,pending,success}.blade.php
├── profile/edit.blade.php
└── components/
    ├── cs-icon.blade.php     # SVG icon component: <x-cs-icon name="trophy" size="16" />
    └── cs-logo.blade.php     # CS2 Academy SVG logo
public/css/
└── app.css    # Global: CSS custom properties (:root), nav, modal, footer, alert, buttons, form inputs
```

## Key architecture decisions

### Auth & roles
- Breeze handles auth scaffolding. `routes/auth.php` provides login/register/password-reset/verify-email routes.
- `User.role` is `admin` or `user` (default). Admin routes are gated by `->middleware('can:admin-only')` — check `App\Providers\AppServiceProvider` for the Gate definition.
- **Admin preview mode**: Admin can toggle `admin_preview_mode` session key to view the site as a regular user. Route: `POST /admin/preview/on` / `POST /admin/preview/off`.

### Coaching / Assignment system
The `assignments` table serves double-duty:
1. **User-submitted tasks** (`from_admin = false`): user uploads something for coach review
2. **Coaching sessions** (`from_admin = true`): auto-created when admin approves a coaching payment, or manually sent by admin via "Kirim ke User"

Status flow: `menunggu` → `diproses` → `selesai`. Admin replies via `balasan_admin` text field.

### Payment flow (coaching)
1. User picks package on `/coaching`, clicks "Pilih Paket" → `/payment?layanan=X&harga=Y`
2. `CoachingController@store` creates a `CoachingTransaction` with status `pending` + generates a dummy BCA VA code (`8808` prefix + padded user ID + transaction ID)
3. User sees `payment.pending` view
4. Admin sees pending transactions on dashboard → approves or rejects
5. On approve: `AdminController@approveTransaction` sets `has_paid=true`, `active_coaching_package=package_name`, creates an auto-assignment (`from_admin=true`) with a template welcome message based on package type

Three coaching packages: **Textual Review**, **Panggil Pelatih**, **Demo Review**.

### Quiz / course progress
- Quiz engine is client-side JS in `courses/index.blade.php`. Questions/answers are embedded as JSON (`$coursesJson`).
- On quiz pass (score ≥ ceil(total/2)): `fetch POST /courses/{id}/complete` saves progress via `CourseProgress`.
- Completed course IDs are hydrated from server on page load (`$completedCourseIds`) so progress survives refresh.
- Each quiz question can optionally have a `youtube_url` — rendered as embedded iframe in the quiz (video ID extracted via `Quiz::getYoutubeVideoIdAttribute()` accessor).

### CSS design system
All colors are CSS custom properties in `:root` (app.css):
- Dark theme: `--bg: #100f1e`, `--bg2: #181832`, `--bg3: #20213f`, `--bg4: #2a2c52`
- Purple primary: `--purple: #8b7bff`, `--purple2: #b3a4ff`, `--purple-btn: #7c5cf5`
- Accents: `--cyan: #3fd8ff`, `--pink: #ff7ec4`, `--green: #2be6ba`, `--orange: #ffab5c`, `--blue: #5ec8ff`, `--red: #ff7272`
- Text: `--text: #f2f2fb`, `--text2: #a8a9d6`, `--text3: #75769f`
- Gradient: `--grad-primary: linear-gradient(135deg, #8b7bff, #3fd8ff)`
- Border: `--border: #2c2e54`

### CSRF
All pages have `<meta name="csrf-token" content="{{ csrf_token() }}">`. JS fetch calls read it from the meta tag. Blade forms use `@csrf`.

## Common workflows

### Adding a new course
1. Insert into `courses` table (or use seeder): `icon`, `title`, `body`, `urutan`
2. Add quizzes via admin panel (`/admin/quiz`) or directly in `quizzes` table

### Adding a new admin
Set `role = 'admin'` on the user record in DB.

### Local dev
```bash
php artisan serve    # or use Laragon
npm run dev          # Vite hot reload
```

### Key Artisan commands
- `php artisan migrate --seed` — fresh DB + seed users & courses
- `php artisan route:list` — see all routes
- `php artisan view:clear` — clear compiled Blade views (run after view changes if pages look stale)

## Database notes
- `users.role` enum: `admin`, `user`
- `assignments.status` enum: `menunggu`, `diproses`, `selesai`
- `assignments.from_admin` boolean: distinguishes admin-initiated coaching sessions from user-submitted tasks
- `coaching_transactions.status` enum: `pending`, `approved`, `rejected`
- `quizzes.opsi` is a JSON column (array of 4 strings), cast to array in the model
- `users.has_paid` boolean — grants course access AND coaching access
- `users.active_coaching_package` string — tracks which package is currently active
