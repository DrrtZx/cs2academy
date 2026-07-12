# 🇮🇩 Bahasa Indonesia — CS2 Academy

> Audit & implementasi: 13 Juli 2026  
> Kaidah: serapan umum tetap (Coaching, Admin, Discord, YouTube, Password, Email),  
> sisanya Bahasa Indonesia natural.

---

## Navbar

| Before | After |
|--------|-------|
| `Home` | **Beranda** |
| `Courses` | **Kursus** |
| `Tugas Saya` | Tetap |
| `Coaching` | Tetap (serapan gaming) |
| `Admin` | Tetap (serapan universal) |

## Admin Panel

| Lokasi | Before | After |
|--------|--------|-------|
| Tab navigasi | `Dashboard` / `Tugas User` / `Kelola Quiz` | **Dashboard** / **Sesi Coaching** / **Kelola Course** |
| Stat card | `Total Pemain Terdaftar` | **Total Pemain** |
| Stat card | `Sudah Beli Coaching` | **Sudah Bayar** |
| Stat card | `Pembayaran Menunggu` | **Menunggu Bayar** |
| Form modul | `Soal Quiz Modul Ini` | Tetap ("Quiz" udah umum) |
| Navbar admin | `Lihat sebagai User` / `Kembali ke Admin` | Tetap |

## Coaching & Chat

| Halaman | Before | After |
|---------|--------|-------|
| Assignments admin | `(read-only)` | **(hanya bisa dibaca)** |
| Assignments user | `read-only` | **hanya bisa dibaca** |
| Chat widget | `Coaching Inbox` / `Pilih sesi` / `Tulis balasan` | Tetap |
| Tombol selesai | `✓ Selesaikan Sesi` | Tetap |

## Profile

| Before | After |
|--------|-------|
| `Update Password` / `Save` | **Ganti Password** / **Simpan Perubahan** |
| `Profile Settings` / `Foto Profile` | Tetap (serapan) |

## Auth Views (Breeze)

| View | Kata kunci diganti |
|------|-------------------|
| `auth/login.blade.php` | `Remember me` → **Ingat saya**, `Forgot password` → **Lupa password?**, `Log in` → **Masuk** |
| `auth/register.blade.php` | `Name` → **Nama**, `Already registered` → **Sudah punya akun?**, `Register` → **Daftar** |
| `auth/forgot-password.blade.php` | Full kalimat natural, tombol → **Kirim Link Reset Password** |
| `auth/reset-password.blade.php` | `Confirm Password` → **Konfirmasi Password** |
| `auth/confirm-password.blade.php` | Tombol → **Konfirmasi** |

## File `lang/id/` (4 file baru)

| File | Isi utama |
|------|-----------|
| `lang/id/auth.php` | `failed` → "Email atau password tidak cocok", `throttle` → "Terlalu banyak percobaan login" |
| `lang/id/pagination.php` | `previous` → "Sebelumnya", `next` → "Berikutnya" |
| `lang/id/passwords.php` | `reset` → "Password sudah direset!", `sent` → "Link reset dikirim ke email" |
| `lang/id/validation.php` | 100+ aturan + `attributes` (nama, email, judul, discord_id, dll) + custom `avatar.max` → "Foto terlalu besar! Maksimal 2MB." |

## Konfigurasi

| File | Setting | Value |
|------|---------|-------|
| `.env` | `APP_LOCALE` | `id` |
| `config/app.php` | `locale` | `id` (default) |

---

## Daftar Kata yang Sengaja TIDAK Diterjemahkan

| Kata | Alasan |
|------|--------|
| Coaching | Istilah universal gaming/esports |
| Dashboard | Serapan universal di tech |
| Admin | Serapan universal |
| Password / Email | "Kata Sandi" / "Surel" terlalu kaku |
| Textual Review / Panggil Pelatih / Demo Review | Nama produk, 2 di antaranya sudah Indonesia |
| Discord / YouTube | Nama platform |
| BCA Virtual Account | Istilah perbankan resmi |
| Aim & Movement / Map Control / dll | Istilah CS2 — komunitas pakai aslinya |
| User | Lebih kasual dari "Pengguna" |
| Profile / Settings | Serapan umum |
| Quiz | Sudah lazim di Indonesia |

---

**Total: ~15 file diubah/dibuat, 3 konfigurasi, navbar + admin + auth + lang/id/.**
