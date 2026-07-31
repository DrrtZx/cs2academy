# 🔧 Troubleshooting: Upload Bukti Transfer & Modal Popup

## 🐛 **MASALAH YANG SERING TERJADI:**

### **1. Tombol "Lihat Bukti" Tidak Muncul**

**Penyebab:**
- Database di-refresh/migrate:fresh tapi file upload tidak ada
- Transaksi tidak punya kolom `bukti_transfer` yang terisi

**Solusi:**
```bash
# Upload file baru melalui form di /payment/pending
# ATAU jalankan test script:
php test_insert_bukti.php
```

---

### **2. Gambar Tidak Muncul (404 / Broken Image)**

**Penyebab:**
- Storage link tidak dibuat
- File tidak ada di `storage/app/public/bukti-transfer/`
- Path URL salah

**Solusi:**

#### A. Cek Storage Link
```bash
# Windows
dir public\storage

# Jika tidak ada, buat:
php artisan storage:link
```

#### B. Cek File Ada
```bash
dir storage\app\public\bukti-transfer
```

#### C. Cek Path di Code
File disimpan di: `storage/app/public/bukti-transfer/{filename}`  
Accessible via: `public/storage/bukti-transfer/{filename}`  
URL: `http://localhost/storage/bukti-transfer/{filename}`

---

### **3. Tombol "Lihat Bukti" Tidak Bisa Diklik**

**Penyebab:**
- CSS variable tidak terdefinisi: `var(--purple-btn)`
- JavaScript tidak ter-load
- Modal element tidak ada di DOM

**Solusi:**

#### A. Cek CSS Button (sudah diperbaiki)
```html
<!-- OLD (Error) -->
background:var(--purple-btn);

<!-- NEW (Fixed) -->
background:var(--grad-primary);
```

#### B. Cek Console Browser
1. Buka Developer Tools (F12)
2. Klik tombol "Lihat Bukti"
3. Lihat Console log:
```
showBuktiModal called
Modal element: <div class="modal-overlay">
Modal opened
```

#### C. Cek Modal Element
View source dan cari `id="buktiModal"` - harus ada!

---

### **4. Modal Tidak Muncul**

**Penyebab:**
- CSS `.modal-overlay.active` tidak terdefinisi
- JavaScript error
- Element tidak ada

**Debugging:**

#### A. Cek CSS
```css
.modal-overlay { 
  display: none; /* default hidden */
}
.modal-overlay.active { 
  display: flex; /* show when active */
}
```

#### B. Test Manual di Console
```javascript
// Buka console browser dan jalankan:
showBuktiModal();

// Atau:
document.getElementById('buktiModal').classList.add('active');
```

#### C. Cek Z-Index
```css
.modal-overlay {
  z-index: 9999; /* harus tinggi */
}
```

---

### **5. Database Migration Fresh Menghapus Upload**

**Penjelasan:**
Saat `php artisan migrate:fresh`, database di-drop tapi file di `storage/` tetap ada.
Namun, referensi di database hilang.

**Solusi:**

#### Option 1: Backup & Restore
```bash
# Sebelum migrate:fresh
cp -r storage/app/public/bukti-transfer storage/app/public/bukti-transfer.backup

# Setelah migrate:fresh
# File tetap ada, tapi perlu insert ulang ke database
```

#### Option 2: Hapus File Lama
```bash
rm storage/app/public/bukti-transfer/*.*
```

#### Option 3: Gunakan Seeder
Tambahkan dummy file di `CoachingTransactionSeeder`

---

## ✅ **CHECKLIST DEBUGGING:**

Jika tombol "Lihat Bukti" tidak berfungsi, cek urutan ini:

### **Step 1: Cek Database**
```bash
php artisan tinker --execute="App\Models\CoachingTransaction::whereNotNull('bukti_transfer')->count()"
```
✅ Harus ada minimal 1 transaksi dengan bukti

### **Step 2: Cek File Fisik**
```bash
dir storage\app\public\bukti-transfer
```
✅ Harus ada file dengan nama yang sama di database

### **Step 3: Cek Storage Link**
```bash
dir public\storage
```
✅ Harus ada symbolic link ke storage/app/public

### **Step 4: Cek URL**
Buka browser:
```
http://127.0.0.1:8000/storage/bukti-transfer/{filename}
```
✅ File harus bisa diakses langsung

### **Step 5: Cek Button HTML**
View page source, cari:
```html
<button type="button" onclick="showBuktiModal()"
```
✅ Button harus ada di halaman

### **Step 6: Cek Modal HTML**
View page source, cari:
```html
<div class="modal-overlay" id="buktiModal"
```
✅ Modal harus ada di halaman

### **Step 7: Cek JavaScript**
Buka console (F12), klik button, lihat log:
```
showBuktiModal called
Modal element: <div>
Modal opened
```
✅ Function harus dipanggil tanpa error

### **Step 8: Cek CSS**
Inspect modal element, cek class:
```html
<div class="modal-overlay active">
```
✅ Class `active` harus ditambahkan saat button diklik

---

## 🧪 **CARA TESTING:**

### **Test 1: Upload Manual (Recommended)**

1. Login sebagai user (`demo@cs2.id / Demo1234!`)
2. Buka `/payment/pending`
3. Upload file JPG/PNG/PDF real (< 2MB)
4. Submit form
5. Badge "✅ Bukti sudah diupload" muncul
6. Klik "👁️ Lihat Bukti"
7. Modal popup muncul dengan preview

### **Test 2: Menggunakan Script**

```bash
php test_insert_bukti.php
```

Output:
```
Found transaction ID: 6
User: Demo User
Package: Textual Review
Created dummy file: user2_trx6_1785398411.jpg
Transaction updated!
Bukti URL: http://localhost/storage/bukti-transfer/user2_trx6_1785398411.jpg
```

Lalu login dan test.

### **Test 3: Direct Database Update**

```bash
php artisan tinker
```

```php
$t = App\Models\CoachingTransaction::where('status', 'pending')->first();
$t->update([
    'bukti_transfer' => 'dummy.jpg',
    'bukti_uploaded_at' => now()
]);
```

---

## 🔍 **DEBUGGING TOOLS:**

### **Browser Console Commands:**

```javascript
// Cek modal element
console.log(document.getElementById('buktiModal'));

// Test show modal
showBuktiModal();

// Test close modal
closeBuktiModal();

// Cek CSS classes
document.getElementById('buktiModal').className;
```

### **Laravel Tinker Commands:**

```php
// Cek semua transaksi
App\Models\CoachingTransaction::all();

// Cek transaksi dengan bukti
App\Models\CoachingTransaction::whereNotNull('bukti_transfer')->get();

// Lihat detail transaksi
$t = App\Models\CoachingTransaction::find(6);
echo $t->bukti_transfer;
echo $t->bukti_url;
```

---

## 📝 **NOTES:**

### **File Upload Path:**
```
Physical: storage/app/public/bukti-transfer/user2_trx6_123456.jpg
Symlink:  public/storage/bukti-transfer/user2_trx6_123456.jpg
URL:      http://localhost/storage/bukti-transfer/user2_trx6_123456.jpg
```

### **Accessor dalam Model:**
```php
public function getBuktiUrlAttribute() {
    return asset('storage/bukti-transfer/' . $this->bukti_transfer);
}
```

### **Blade Conditional:**
```blade
@if($transaction->bukti_transfer)
    <!-- Button muncul hanya jika bukti_transfer NOT NULL -->
    <button onclick="showBuktiModal()">Lihat Bukti</button>
@endif
```

---

## ✅ **SOLUTION SUMMARY:**

**Masalah:** Tombol tidak bisa diklik & gambar tidak muncul

**Root Cause:**
1. ❌ CSS variable `var(--purple-btn)` tidak ada
2. ❌ Database di-refresh, file upload hilang referensinya
3. ❌ Storage link mungkin tidak dibuat

**Fix Applied:**
1. ✅ Ganti button style ke `var(--grad-primary)`
2. ✅ Tambah console.log untuk debugging
3. ✅ Buat test script `test_insert_bukti.php`
4. ✅ Seed ulang dengan `db:seed`
5. ✅ Verify storage link & file exists

---

## 🚀 **QUICK FIX:**

Jika masih bermasalah, jalankan command ini:

```bash
# 1. Refresh semuanya
php artisan migrate:fresh --seed
php artisan storage:link
php artisan cache:clear
php artisan view:clear

# 2. Insert dummy bukti
php test_insert_bukti.php

# 3. Verify
dir storage\app\public\bukti-transfer
dir public\storage

# 4. Test di browser
# Login: demo@cs2.id / Demo1234!
# URL: http://127.0.0.1:8000/payment/pending
```

---

**Created:** 2026-07-30  
**Author:** Kiro AI Assistant
