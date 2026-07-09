<div align="center">

# 🎯 CS2 Academy

**Platform Edukasi Counter-Strike 2 #1 di Indonesia**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

*Kuasai CS2 dengan pelatihan eksklusif, coaching 1-on-1, dan kuis praktikal dari pro player.*

</div>

---

## 📌 Tentang CS2 Academy

**CS2 Academy** adalah platform edukasi berbasis web yang dirancang khusus untuk pemain Counter-Strike 2 di Indonesia. Platform ini menyediakan berbagai layanan pembelajaran mulai dari kursus video interaktif, kuis praktikal, hingga sesi coaching langsung bersama coach profesional.

### Fitur Unggulan

| Fitur | Deskripsi |
|-------|-----------|
| 🎓 **Kursus Interaktif** | Materi pembelajaran CS2 yang terstruktur dengan video & kuis |
| 🧠 **Kuis Praktikal** | Uji pemahaman setiap materi secara langsung |
| 🎮 **Coaching 1-on-1** | Sesi coaching personal dengan pro player berpengalaman |
| 📋 **Sistem Tugas** | User bisa submit tugas dan mendapat feedback dari coach |
| 🔐 **Panel Admin** | Manajemen user, tugas, dan konten quiz secara lengkap |
| 📊 **Dashboard Statistik** | Pantau progress belajar dan aktivitas platform |

### Materi yang Diajarkan

- 🎯 Aim Training
- 🗺️ Map Knowledge
- 💰 Economy & Buy Management
- 📍 Positioning
- 💡 Game Sense
- 💨 Spray Control
- 🎬 Demo Review
- 🏆 Rank Strategy

---

## 🛠️ Tech Stack

- **Backend** — [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Frontend** — Vanilla CSS, Blade Templating
- **Database** — MySQL
- **Auth** — Laravel Breeze
- **Build Tool** — Vite
- **Dev Server** — Laragon

---

## 🚀 Instalasi & Setup

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL
- Laragon (atau XAMPP/Herd)

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/DrrtZx/cs2academy.git
cd cs2academy
```

**2. Install dependencies**
```bash
composer install
npm install
```

**3. Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi database di `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cs2academy
DB_USERNAME=root
DB_PASSWORD=
```

**5. Jalankan migrasi & seeder**
```bash
php artisan migrate --seed
```

**6. Jalankan development server**
```bash
php artisan serve
npm run dev
```

**7. Buka di browser**
```
http://localhost:8000
```

### Akun Demo

| Role | Email | Password |
|------|-------|----------|
| Demo User | `demo@cs2.id` | `Demo1234!` |
| Admin | *(set manual via seeder)* | — |

---

## 📁 Struktur Project

```
cs2academy/
├── app/
│   ├── Http/Controllers/     # Controller (Admin, Home, Coaching, dsb)
│   └── Models/               # Eloquent Models (User, Course, Quiz, dsb)
├── database/
│   ├── migrations/           # Skema database
│   └── seeders/              # Data awal (courses, users)
├── public/
│   └── css/
│       ├── app.css           # CSS global (nav, modal, footer)
│       ├── home.css          # CSS halaman home
│       └── admin.css         # CSS panel admin
├── resources/
│   └── views/
│       ├── layouts/          # Template utama (app.blade.php)
│       ├── admin/            # Halaman admin (dashboard, assignments, quiz)
│       ├── courses/          # Halaman kursus
│       ├── coaching/         # Halaman coaching
│       └── components/       # Blade components (cs-icon, cs-logo, dsb)
└── routes/
    └── web.php               # Definisi semua route
```

---

## 🗺️ Daftar Route Utama

| Route | Method | Deskripsi |
|-------|--------|-----------|
| `/` | GET | Halaman utama (home) |
| `/courses` | GET | Daftar kursus |
| `/coaching` | GET | Layanan coaching |
| `/assignments` | GET | Tugas saya (user) |
| `/admin/dashboard` | GET | Dashboard admin |
| `/admin/assignments` | GET/POST | Kelola tugas user |
| `/admin/quiz` | GET/POST | Kelola soal quiz |

---

## 👨‍💻 Kontribusi

Pull request dan saran sangat welcome! Untuk perubahan besar, buka issue terlebih dahulu untuk diskusi.

---

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

<div align="center">

Dibuat dengan ❤️ untuk komunitas CS2 Indonesia

**[⭐ Star repo ini](https://github.com/DrrtZx/cs2academy)** jika bermanfaat!

</div>
