# CS2 Academy

Platform edukasi Counter-Strike 2 #1 di Indonesia. Kursus interaktif, kuis praktikal, dan coaching 1-on-1 dengan pro player.

## Stack

- **Laravel 12.x** (PHP 8.3+, `laravel/framework ^13.8`)
- **MySQL** — database relasional
- **Laravel Breeze** — authentication (login, register, password reset, verify email)
- **Vanilla CSS + Blade** — no JS framework, no Tailwind. Custom design system with CSS custom properties.
- **Vite** — frontend build tool
- **Laragon** — local dev server (Windows)

## Project structure

```
app/
├── Models/
│   ├── User.php              # role (admin|user), has_paid, active_coaching_package, discord_id, avatar
│   ├── Course.php            # icon, title, body, urutan, level, durasi, type, is_popular — hasMany Module, ModuleProgress helpers
│   ├── Module.php            # course_id, title, body, youtube_url, urutan — hasMany Quiz, youtube_video_id accessor
│   ├── Quiz.php              # course_id, module_id, pertanyaan, opsi (json array), jawaban_benar (0-3), penjelasan
│   ├── ModuleProgress.php    # user_id, module_id, score, completed_at — per-module tracking
│   ├── CourseProgress.php    # user_id, course_id, score, completed_at — (legacy, mostly unused now)
│   ├── Assignment.php        # sesi coaching: user_id, judul, tugas_teks, status, balasan_admin, from_admin, completed_at — hasMany CoachingMessage
│   ├── CoachingMessage.php   # assignment_id, sender_id, message, read_at — chat messages
│   └── CoachingTransaction.php # payment: user_id, package_name, package_price, va_code, status
├── Http/Controllers/
│   ├── HomeController.php    # Landing page stats
│   ├── CourseController.php  # Course catalog grid + module detail page + ModuleProgress API
│   ├── CoachingController.php # Coaching packages, payment flow, VA code generation
│   ├── AssignmentController.php # User coaching inbox: index, reply, messages (JSON)
│   ├── AdminController.php   # Dashboard, user management, coaching sessions, course/module CRUD, chat API, transaction approval
│   └── ProfileController.php # Profile edit, avatar upload, password change
resources/views/
├── layouts/app.blade.php     # Main layout: nav, auth modal, footer, user dropdown, admin chat widget
├── home.blade.php            # Hero, stats, topics bar, CTA
├── courses/
│   ├── index.blade.php       # Grid card catalog — course cards with lock/progress
│   └── show.blade.php        # Module detail — sidebar modules + outline + YouTube + quiz engine
├── coaching/index.blade.php  # Coaching package tabs
├── assignments/index.blade.php # User coaching chat — active sessions + arsip archive
├── admin/
│   ├── dashboard.blade.php   # 5 stat cards + pending payments + coaching activity feed
│   ├── users.blade.php       # User table: search, role/status badges, pagination
│   ├── assignments.blade.php # Coaching sessions: active (chat inline) + arsip (dropdown accordion)
│   ├── courses/
│   │   ├── index.blade.php   # Level 1: course list + Level 2: module list
│   │   └── form.blade.php    # Level 3: course create/edit form (full page)
│   └── modules/
│       └── form.blade.php    # Level 3: module create/edit form (full page, quiz accordion)
├── profile/edit.blade.php    # Profile settings: avatar, info, password
├── payment/{index,pending,success}.blade.php
└── components/
    ├── cs-icon.blade.php     # SVG icon: <x-cs-icon name="trophy" size="16" />
    ├── cs-logo.blade.php     # CS2 Academy SVG logo
    └── admin-chat-widget.blade.php # Floating chat widget (admin — all pages)
public/css/
└── app.css    # Global: CSS custom properties (:root), nav, modal, footer, buttons, forms, coaching-dot animation
```

## Key architecture decisions

### Auth & roles
- Breeze handles auth scaffolding. `routes/auth.php` provides login/register/password-reset/verify-email routes.
- `User.role` is `admin` or `user` (default). Admin routes gated by `->middleware('can:admin-only')`.
- **Admin preview mode**: `POST /admin/preview/on` / `POST /admin/preview/off` toggles session key.
- Gate defined in `App\Providers\AppServiceProvider`.

### Coaching / Assignment system
`assignments` table = coaching sessions (not user-submitted tasks anymore):
- Sessions auto-created when admin approves a `CoachingTransaction`
- Prechat message auto-sent from Coach on approval (different template per package)
- Chat via `coaching_messages` table (multi-message, not single reply)
- Status flow: `menunggu` → `diproses` → `selesai`
- Admin clicks "✓ Selesaikan Sesi" → `status=selesai`, `completed_at=now`, `active_coaching_package=null`
- `balasan_admin` column is legacy (replaced by coaching_messages)

Three packages: **Textual Review**, **Panggil Pelatih**, **Demo Review**

### Payment flow (coaching)
1. User picks package → `/payment?layanan=X&harga=Y`
2. `CoachingController@store` creates `CoachingTransaction` (status=pending) + BCA VA code
3. User sees `payment.pending` view
4. Admin sees pending on dashboard → approves
5. `AdminController@approveTransaction`: sets `has_paid=true`, `active_coaching_package=name`, creates assignment, auto-sends prechat message

### Course / Module system
- **5 courses**, each with **4 modules** (20 total), each module has **1+ quizzes**
- Course catalog: grid cards with lock/progress/unlocked states
- All courses unlocked by default (no sequential unlock)
- Module detail: sidebar (done/active/locked per module) + main (outline + YouTube embed + quiz)
- Quiz completion saves `ModuleProgress` via `POST /modules/{module}/complete`
- Course progress = % modules done (from `Course::progressPercent()`)

### Admin navigation (consistent across all admin pages)
Tabs: **Dashboard** | **User** | **Sesi Coaching** | **Kelola Course**

- Dashboard: 5 stat cards + pending payments table + coaching activity feed
- User: searchable table, role (Admin/User) + status (Paid/Free) badges
- Sesi Coaching: active chat inline + arsip accordion dropdown
- Kelola Course: Level 1 (course list) → Level 2 (module list) → Level 3 (form)

### Chat system
- **Floating widget** (`<x-admin-chat-widget />`) — appears on ALL admin pages (bottom-right corner)
- Widget: session sidebar (Aktif/Arsip tabs) + chat panel + input + "Selesaikan Sesi" button
- Full-page chat at `/admin/assignments`: active sessions with inline chat + arsip accordion
- User chat at `/assignments`: active sessions with polling + auto-transition to closed state
- Polling: sidebar every 5s, chat messages every 4s
- `read_at` timestamp for unread tracking

### CSS design system
All colors are CSS custom properties in `:root` (app.css):
- Dark theme: `--bg: #100f1e`, `--bg2: #181832`, `--bg3: #20213f`, `--bg4: #2a2c52`
- Purple primary: `--purple: #8b7bff`, `--purple2: #b3a4ff`, `--purple-btn: #7c5cf5`
- Accents: `--cyan: #3fd8ff`, `--pink: #ff7ec4`, `--green: #2be6ba`, `--orange: #ffab5c`, `--blue: #5ec8ff`, `--red: #ff7272`
- Text: `--text: #f2f2fb`, `--text2: #a8a9d6`, `--text3: #75769f`
- Gradient: `--grad-primary: linear-gradient(135deg, #8b7bff, #3fd8ff)`
- Border: `--border: #2c2e54`

### CSRF & JS
- All pages have `<meta name="csrf-token" content="{{ csrf_token() }}">`
- JS fetch calls read CSRF from meta tag
- `Js::from()` used ONLY inside `<script>` tags (never in HTML attributes — causes JSON quote clash)

## Common workflows

### Local dev
```bash
php artisan serve    # or use Laragon
npm run dev          # Vite hot reload
```

### Key Artisan commands
```bash
php artisan migrate:fresh --seed  # rebuild DB
php artisan route:list            # see all routes
php artisan view:clear            # clear compiled Blade (IMPORTANT after view changes!)
```

### Adding a new course
1. Admin panel: `/admin/courses` → "+ Tambah Kursus" → fill form
2. Modules: "Kelola Modul" → "+ Tambah Modul" → fill form + add quizzes in accordion

### Creating a coaching session
1. User buys package at `/coaching`
2. Admin approves at `/admin` dashboard
3. Auto-prechat sent → session appears in widget + `/admin/assignments`
4. Both sides chat via polling
5. Admin clicks "Selesaikan Sesi" → session archived, user can buy new package

## Database notes
- `users.role` enum: `admin`, `user`
- `users.discord_id` nullable — for Panggil Pelatih sessions
- `users.avatar` nullable — path to uploaded profile photo (storage/avatars/)
- `assignments.status` enum: `menunggu`, `diproses`, `selesai`
- `assignments.from_admin` boolean — always true (all sessions are coaching)
- `assignments.completed_at` timestamp — set when session completed
- `coaching_transactions.status` enum: `pending`, `approved`, `rejected`
- `quizzes.opsi` is a JSON column (array of 4 strings), cast to array
- `coaching_messages.read_at` nullable timestamp — null = unread
- `users.has_paid` boolean — grants course access AND coaching access
- `users.active_coaching_package` string — cleared on session complete
