# 🗄️ Database Seeding Information - CS2Academy

Database telah di-refresh dan di-seed dengan data dummy untuk testing.

---

## 📊 **DATABASE SUMMARY**

### **Users (6 total)**

#### **Admin Account (1)**
| Nama | Email | Password | Role |
|------|-------|----------|------|
| Admin CS2 | admin@cs2.id | `Admin1234!` | admin |

#### **Regular Users (5)**
| Nama | Email | Password | Role |
|------|-------|----------|------|
| Demo User | demo@cs2.id | `Demo1234!` | user |
| John Doe | john@example.com | `password` | user |
| Jane Smith | jane@example.com | `password` | user |
| Mike Johnson | mike@example.com | `password` | user |
| Sarah Williams | sarah@example.com | `password` | user |

---

### **Courses (5 total)**
✅ Data dummy courses dari `CourseSeeder`
- Beginner Course
- Intermediate Course
- Advanced Course
- Pro Course
- Expert Course

---

### **Coaching Transactions (5 total)**

#### **Pending Transactions (3)** - Untuk Testing Approve/Reject
| User | Paket | Harga | VA Code | Status | Bukti Transfer |
|------|-------|-------|---------|--------|----------------|
| Demo User | Textual Review | Rp 100.000 | 8808000020000001 | ⏳ Pending | ❌ Belum |
| John Doe | Panggil Pelatih | Rp 250.000 | 8808000030000002 | ⏳ Pending | ❌ Belum |
| Jane Smith | Demo Review | Rp 150.000 | 8808000040000003 | ⏳ Pending | ❌ Belum |

#### **Approved Transactions (1)** - User Sudah Bayar
| User | Paket | Harga | VA Code | Status | Bukti Transfer |
|------|-------|-------|---------|--------|----------------|
| Demo User | Textual Review | Rp 100.000 | 8808000020000099 | ✅ Approved | ❌ Belum |

#### **Rejected Transactions (1)** - History
| User | Paket | Harga | VA Code | Status | Bukti Transfer |
|------|-------|-------|---------|--------|----------------|
| John Doe | Panggil Pelatih | Rp 250.000 | 8808000030000088 | ❌ Rejected | ❌ Belum |

---

## 🧪 **TESTING GUIDE**

### **Login Credentials:**

#### **Admin Testing:**
```
Email: admin@cs2.id
Password: Admin1234!
```

#### **User Testing:**
```
Email: demo@cs2.id
Password: Demo1234!
```

atau

```
Email: john@example.com
Password: password
```

---

### **Test Case 1: Upload Bukti Transfer (User)**

1. Login sebagai `demo@cs2.id`
2. Buka `/payment/pending`
3. Lihat transaksi pending dengan VA Code
4. Upload bukti transfer (JPG/PNG/PDF max 2MB)
5. Klik tombol "👁️ Lihat Bukti" → Modal muncul
6. Verify preview gambar atau download PDF

**Expected Result:**
- ✅ File ter-upload ke `storage/app/public/bukti-transfer/`
- ✅ Database kolom `bukti_transfer` dan `bukti_uploaded_at` terisi
- ✅ Modal popup menampilkan preview
- ✅ Badge berubah menjadi "✅ Bukti sudah diupload"

---

### **Test Case 2: Admin Lihat Detail Transaksi**

1. Login sebagai `admin@cs2.id`
2. Buka `/admin` dashboard
3. Lihat tabel "Pembayaran Menunggu Verifikasi"
4. Klik tombol "👁️ Detail" pada salah satu row
5. Modal popup muncul dengan info lengkap
6. Verify bukti transfer (jika sudah upload)

**Expected Result:**
- ✅ Modal menampilkan nama user, email, paket, harga
- ✅ VA Code terlihat
- ✅ Status transaksi terlihat
- ✅ Bukti transfer preview (jika ada)
- ✅ Tombol close (X, ESC, overlay click) berfungsi

---

### **Test Case 3: Admin Approve/Reject Transaksi**

1. Login sebagai `admin@cs2.id`
2. Buka `/admin` dashboard
3. Pilih transaksi pending
4. Klik "✅ Approve" atau "❌ Tolak"
5. Verify status berubah

**Expected Result (Approve):**
- ✅ Status → `approved`
- ✅ User `has_paid` → true
- ✅ Assignment coaching session dibuat otomatis
- ✅ Welcome message dari coach dikirim
- ✅ User bisa akses `/assignments`

**Expected Result (Reject):**
- ✅ Status → `rejected`
- ✅ User tetap bisa order paket baru

---

### **Test Case 4: Auto-Refresh Polling**

#### **User Side:**
1. Login sebagai `demo@cs2.id`
2. Buka `/payment/pending`
3. Biarkan halaman terbuka
4. Admin approve transaksi dari dashboard
5. **Tunggu maksimal 30 detik**
6. Halaman user otomatis reload → redirect ke `/assignments`

#### **Admin Side:**
1. Login sebagai `admin@cs2.id`
2. Buka `/admin` dashboard
3. Biarkan halaman terbuka
4. User lain order paket baru (transaksi pending bertambah)
5. **Tunggu maksimal 30 detik**
6. Dashboard admin otomatis reload

**Expected Result:**
- ✅ Polling request setiap 30 detik
- ✅ Reload HANYA jika ada perubahan data
- ✅ No console errors

---

### **Test Case 5: Assignments Auto-Refresh**

1. Login sebagai `demo@cs2.id`
2. Buka `/assignments`
3. Biarkan halaman terbuka
4. Admin kirim pesan baru dari coaching inbox
5. **Tunggu maksimal 30 detik**
6. Halaman assignments otomatis reload

**Expected Result:**
- ✅ Polling setiap 30 detik
- ✅ Reload jika ada tugas baru atau pesan unread
- ✅ Counter unread message update

---

## 🔄 **Re-seeding Database**

Jika ingin refresh database lagi:

```bash
php artisan migrate:fresh --seed
```

Atau hanya jalankan seeder tanpa drop tables:

```bash
php artisan db:seed
```

Atau jalankan seeder spesifik:

```bash
php artisan db:seed --class=CoachingTransactionSeeder
```

---

## 📁 **File Structure**

### **Seeders:**
```
database/seeders/
├── DatabaseSeeder.php          # Main seeder orchestrator
├── UserSeeder.php              # 1 admin + 5 users
├── CourseSeeder.php            # 5 courses
└── CoachingTransactionSeeder.php # 5 transactions (3 pending, 1 approved, 1 rejected)
```

### **Migrations:**
```
database/migrations/
├── ...
└── 2026_07_30_073600_add_bukti_transfer_to_coaching_transactions_table.php
```

---

## ✅ **Verification Checklist**

After seeding, verify:

- [x] 6 users created (1 admin + 5 users)
- [x] 5 courses created
- [x] 5 coaching transactions created
  - [x] 3 pending (for testing approve/reject)
  - [x] 1 approved (user already paid)
  - [x] 1 rejected (history)
- [x] Storage symlink exists (`public/storage`)
- [x] Bukti transfer folder exists (`storage/app/public/bukti-transfer/`)
- [x] All routes registered
- [x] Migration ran successfully

---

## 🎯 **Quick Start Testing**

**Terminal 1 - Start Server:**
```bash
php artisan serve
```

**Browser:**
```
Admin Dashboard: http://127.0.0.1:8000/admin
User Login: http://127.0.0.1:8000/login
```

**Test Flow:**
1. Login as user (`demo@cs2.id`)
2. Upload bukti transfer di `/payment/pending`
3. Login as admin (`admin@cs2.id`)
4. Klik "Detail" untuk lihat bukti
5. Approve transaksi
6. Verify user auto-redirect setelah polling

---

## 🐛 **Troubleshooting**

### **Storage link not working:**
```bash
php artisan storage:link
```

### **Permission issues (Linux/Mac):**
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### **Clear cache:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

**Created:** 2026-07-30  
**Database Engine:** MySQL  
**Laravel Version:** 11.x
