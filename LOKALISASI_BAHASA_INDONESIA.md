# 🌐 Lokalisasi Bahasa Indonesia — CS2 Academy

Ringkasan perubahan penting. Full audit: 12 Juli 2026.

> **Status setelah re-audit 13 Juli 2026:** Semua item di bawah sudah diterapkan ulang 
> dan diverifikasi. Navbar, lang/id/, read-only, auth views — semua sesuai.

---

## 🔴 Navbar (paling kelihatan)

| Before | After |
|--------|-------|
| `Home` | `Beranda` |
| `Courses` | `Kursus` |

"Coaching" tetap — lazim di ekosistem gaming.

---

## 🔴 Admin Panel

| Lokasi | Before | After |
|--------|--------|-------|
| Tab admin | `Kelola Quiz` | `Kelola Kuis` |
| Stat card | `Total Soal Quiz` | `Total Soal Kuis` |
| Subtitle quiz page | `konten quiz kursus` | `konten kuis kursus` |

---

## 🔴 Halaman Coaching — Isi & Status

**Yang ada di halaman Coaching (gak diubah — emang udah bagus):**

Halaman `/coaching` (624 baris) berisi:

- **3 paket coaching** dalam tabs:
  - `Textual Review` — Rp 100.000 (voice call 1 jam + catatan tertulis)
  - `Panggil Pelatih` — Rp 250.000 (private coaching 1-on-1 via Discord)
  - `Demo Review` — Rp 300.000 (analisis mendalam replay match + catatan detail)

- **Flow untuk guest:**
  - Pop-up "Akses Terkunci" → form login/register inline (gak perlu pindah halaman)
  - Tombol "Login untuk membeli paket coaching" di header

- **Flow untuk user login:**
  - Tombol "Pilih Paket" → redirect ke `/payment?layanan=X&harga=Y`
  - Kalau masih ada sesi aktif: diblokir, muncul error "⚠️ Kamu masih punya sesi coaching yang aktif..."

- **Status setelah beli:**
  - Admin approval → `CoachingTransaction` status `pending` → `approved`
  - Assignment otomatis dibuat dengan template pesan sesuai paket
  - User bisa langsung chat via `Tugas Saya`

**Yang baru dilokalkan di related pages:**

| Halaman | Before | After |
|---------|--------|-------|
| Payment index | `CS2 Coaching Session` | `Sesi Coaching CS2` |
| Payment index + pending | `BCA Virtual Account Number` | `Nomer BCA Virtual Account` |

---

## 🔴 Profile

| Before | After |
|--------|-------|
| `Update Password` (tombol) | `Ganti Password` |

---

## 🔴 Assignments — Chat & Arsip

| Before | After |
|--------|-------|
| `read-only` | `hanya bisa dibaca` |
| `read-only` (admin inbox) | `hanya bisa dibaca` |

---

## 🟡 Breeze Auth Views (fallback pages)

Semua `__()` directives di views ini sudah diganti jadi Bahasa Indonesia natural:

- `auth/login.blade.php` — Remember me → `Ingat saya`, Forgot password → `Lupa password?`, Log in → `Masuk`
- `auth/register.blade.php` — Name → `Nama`, Already registered → `Sudah punya akun?`, Register → `Daftar`
- `auth/forgot-password.blade.php` — Full kalimat natural, tombol → `Kirim Link Reset Password`
- `auth/reset-password.blade.php` — Confirm Password → label ubah
- `auth/verify-email.blade.php` — Semua kalimat panjang diganti natural
- `auth/confirm-password.blade.php` — Deskripsi + tombol → `Konfirmasi`

## 🟡 Breeze Profile Partials

- `update-profile-information-form.blade.php` — semua label & teks bantu
- `update-password-form.blade.php` — semua label & tombol
- `delete-user-form.blade.php` — semua teks & konfirmasi

---

## 🟢 File Bahasa Laravel — `lang/id/`

4 file baru dibuat (sebelumnya gak ada sama sekali):

| File | Isi |
|------|-----|
| `lang/id/auth.php` | `failed`, `password`, `throttle` |
| `lang/id/pagination.php` | `previous` → Sebelumnya, `next` → Berikutnya |
| `lang/id/passwords.php` | `reset`, `sent`, `throttled`, `token`, `user` |
| `lang/id/validation.php` | **Semua aturan validasi + 100+ attribute names** |

- `APP_LOCALE=id` di `.env` + `.env.example`

---

## ✅ Sengaja Gak Diterjemahkan

| Item | Alasan |
|------|--------|
| "Coaching" | Istilah universal gaming/esports |
| "Textual Review", "Panggil Pelatih", "Demo Review" | Nama produk, 2 di antaranya sudah Indonesia |
| "Dashboard", "Admin" | Serapan universal di tech |
| "Password", "Email" | "Kata Sandi" / "Surel" terlalu kaku |
| "BCA Virtual Account" | Istilah perbankan resmi |
| "Aim & Movement", "Map Control", dll. | Istilah CS2 — komunitas pakai aslinya |
| "Discord", "YouTube" | Nama platform |
| "User" | Lebih kasual dari "Pengguna" |

---

**Total: ~45 perubahan di 14 file Blade + 4 file lang baru + 2 env config.**
