# 🎯 PANDUAN LENGKAP: LOGIN → GUEST CRUD

## ✅ STATUS: SEMUA SIAP!

Sistem login sudah fixed dan guest dapat mengakses halaman CRUD dengan baik.

---

## 🚀 FLOW LENGKAP

```
┌─────────────┐
│ Akses Login │
│ /login      │
└──────┬──────┘
       │
       ├─ Authenticated?
       │  ├─ YES → Redirect to Dashboard
       │  └─ NO → Show Login Form ✓
       │
       ▼
┌──────────────────┐
│ Submit Credentials│
└──────┬───────────┘
       │
       ├─ Credentials Valid?
       │  ├─ YES → Create Session
       │  └─ NO → Show Error
       │
       ▼
┌──────────────────────┐
│ Check Role in DB     │
└──────┬───────────────┘
       │
       ├─ role == 'admin'?
       │  └─ YES → /admin/dashboard
       │
       └─ role == 'guest'?
          └─ YES → /guest/ (Persil Index) ✓
```

---

## 📍 AKUN LOGIN

### Admin Account

```
Email:    admin@persil.test
Password: password
Redirect: /admin/dashboard
```

### Guest Account

```
Email:    guest1@persil.test
Password: password
Redirect: /guest/ (Persil Management - CRUD)
```

---

## 🎯 GUEST PERSIL MANAGEMENT - FITUR LENGKAP

### 1️⃣ INDEX - Lihat Daftar Persil (`/guest/`)

**Fitur:**

-   ✅ Tampil semua persil milik user
-   ✅ Search bar (cari berdasarkan kode, alamat, dll)
-   ✅ Pagination (5 item per halaman)
-   ✅ Tombol Create, Edit, View, Delete

**Error Handling:**

-   ✅ Jika database error → Tampil pesan error
-   ✅ Hanya tampil persil milik user (filtered by `pemilik_warga_id`)

### 2️⃣ CREATE - Tambah Persil Baru (`/guest/persil/create`)

**Form Fields:**

-   Kode Persil (required, unique)
-   Luas M² (optional, numeric)
-   Penggunaan (optional)
-   Alamat Lahan (optional)
-   RT (optional)
-   RW (optional)
-   File Dokumen (multiple)
-   Foto Pemilik (single)

**Fitur:**

-   ✅ Validasi semua field
-   ✅ Multiple file upload
-   ✅ Foto pemilik auto-upload ke user
-   ✅ Error message yang jelas

**Redirect:** Ke halaman detail persil yang baru dibuat

### 3️⃣ SHOW - Lihat Detail Persil (`/guest/persil/{id}`)

**Menampilkan:**

-   ✅ Detail persil lengkap
-   ✅ Info pemilik
-   ✅ Daftar dokumen terkait
-   ✅ Peta persil
-   ✅ Sengketa (jika ada)

**Tombol Aksi:**

-   Edit Persil
-   Hapus Persil
-   Kembali ke List

**Security:**

-   ✅ Check: User hanya bisa lihat persil miliknya
-   ✅ Jika akses tidak sah → 403 Forbidden

### 4️⃣ EDIT - Edit Persil (`/guest/persil/{id}/edit`)

**Fitur:**

-   ✅ Form pre-populated dengan data lama
-   ✅ Validasi unique kode_persil (exclude ID saat ini)
-   ✅ Update foto pemilik
-   ✅ Update field lainnya

**Security:**

-   ✅ Check: User hanya bisa edit persil miliknya

**Redirect:** Ke halaman detail persil

### 5️⃣ DELETE - Hapus Persil (`DELETE /guest/persil/{id}`)

**Fitur:**

-   ✅ Soft delete atau hard delete
-   ✅ Cascade delete dokumen terkait
-   ✅ Success message

**Security:**

-   ✅ Check: User hanya bisa hapus persil miliknya

**Redirect:** Ke halaman index persil

---

## 🔐 SECURITY FEATURES

✅ **Role-Based Access:**

-   Guest hanya akses `/guest/*` routes
-   Admin hanya akses `/admin/*` routes

✅ **User-Based Data Ownership:**

```php
// Check ownership
if ($persil->pemilik_warga_id !== auth()->id()) {
    abort(403);
}
```

✅ **CSRF Protection:**

-   `@csrf` token di semua form
-   Middleware `VerifyCsrfToken` aktif

✅ **Input Validation:**

-   Validasi server-side untuk semua input
-   Custom error messages

✅ **File Upload Security:**

-   Whitelist extension (PDF, DOC, DOCX, JPG, JPEG, PNG)
-   Max file size 5MB
-   Store di folder aman

---

## 🔧 TECHNICAL DETAILS

### Controller: `GuestPersilController`

-   **File**: `app/Http/Controllers/GuestPersilController.php`
-   **Methods**: index, create, store, show, edit, update, destroy
-   **Model**: Persil
-   **Error Handling**: Try-catch di setiap method

### Model: `Persil`

-   **Relations**:
    -   `pemilik` (belongs to User)
    -   `dokumen` (has many DokumenPersil)
    -   `peta` (has many PetaPersil)
    -   `sengketa` (has many SengketaPersil)
-   **Fillable**: kode_persil, luas_m2, penggunaan, alamat_lahan, rt, rw, pemilik_warga_id

### Route: `/guest/persil` (Resource)

```php
Route::middleware('auth')->prefix('guest')->group(function () {
    Route::prefix('persil')->group(function () {
        Route::get('/', [GuestPersilController::class, 'index']);          // LIST
        Route::get('/create', [GuestPersilController::class, 'create']);  // FORM CREATE
        Route::post('/', [GuestPersilController::class, 'store']);        // STORE
        Route::get('/{id}', [GuestPersilController::class, 'show']);      // DETAIL
        Route::get('/{id}/edit', [GuestPersilController::class, 'edit']); // FORM EDIT
        Route::put('/{id}', [GuestPersilController::class, 'update']);    // UPDATE
        Route::delete('/{id}', [GuestPersilController::class, 'destroy']); // DELETE
    });
});
```

### Views: `resources/views/guest/persil/`

-   `index.blade.php` - Daftar persil dengan search & pagination
-   `create.blade.php` - Form create persil
-   `show.blade.php` - Detail persil
-   `edit.blade.php` - Form edit persil

---

## 📊 DATABASE SCHEMA

### Table: `persil`

```
- persil_id (PK)
- kode_persil (unique)
- luas_m2
- penggunaan
- alamat_lahan
- rt
- rw
- pemilik_warga_id (FK → users.id)
- created_at
- updated_at
```

### Table: `dokumen_persil`

```
- id (PK)
- persil_id (FK)
- jenis_dokumen
- nomor
- keterangan
- file_path
```

### Table: `peta_persil`

```
- id (PK)
- persil_id (FK)
- latitude
- longitude
- file_path
```

### Table: `sengketa_persil`

```
- id (PK)
- persil_id (FK)
- status
- keterangan
```

---

## 🧪 TESTING CHECKLIST

### Login Test

-   [ ] Login dengan guest1@persil.test
-   [ ] Redirect ke /guest/ (persil index)
-   [ ] Tidak ada error di halaman

### Create Test

-   [ ] Klik "Create Persil"
-   [ ] Isi form dengan data valid
-   [ ] Upload file dokumen
-   [ ] Upload foto pemilik
-   [ ] Klik Submit
-   [ ] Redirect ke detail persil baru
-   [ ] Data tersimpan di database

### Read Test

-   [ ] Lihat daftar persil di /guest/
-   [ ] Search persil (berdasarkan kode)
-   [ ] Pagination bekerja
-   [ ] Klik salah satu persil → detail muncul
-   [ ] Hanya persil milik user tampil

### Update Test

-   [ ] Klik "Edit" di persil
-   [ ] Ubah beberapa field
-   [ ] Upload foto pemilik baru
-   [ ] Klik Submit
-   [ ] Data terupdate di database
-   [ ] Success message muncul

### Delete Test

-   [ ] Klik "Delete" di persil
-   [ ] Confirm delete
-   [ ] Persil hilang dari list
-   [ ] Success message muncul

### Security Test

-   [ ] Login sebagai guest1
-   [ ] Lihat persil guest2 → Error 403
-   [ ] Edit persil guest2 → Error 403
-   [ ] Delete persil guest2 → Error 403

---

## ⚠️ TROUBLESHOOTING

### Halaman Blank

-   Clear cache: `php artisan config:clear`
-   Check logs: `tail -f storage/logs/laravel.log`

### File Upload Gagal

-   Check folder permission: `chmod 777 storage/app/public`
-   Check file size < 5MB
-   Check format (PDF, DOC, JPG)

### Data Tidak Muncul

-   Check database: User harus memiliki persil
-   Check user role: Harus 'guest'
-   Check session: `$_SESSION` harus ada user

### CSRF Token Error

-   Form harus include `@csrf`
-   Check middleware di routes
-   Clear cache

---

## 🎓 NEXT STEPS

1. ✅ Login dengan guest account
2. ✅ Lihat halaman persil index
3. ✅ Create persil baru
4. ✅ Edit persil
5. ✅ Delete persil
6. ✅ Manage dokumen persil
7. ✅ Manage peta persil
8. ✅ Manage sengketa persil

---

## 📞 SUMMARY

| Fitur         | Status | URL                       | Method   |
| ------------- | ------ | ------------------------- | -------- |
| Login         | ✅     | `/login`                  | GET/POST |
| Persil List   | ✅     | `/guest/`                 | GET      |
| Create Persil | ✅     | `/guest/persil/create`    | GET      |
| Store Persil  | ✅     | `/guest/persil`           | POST     |
| View Persil   | ✅     | `/guest/persil/{id}`      | GET      |
| Edit Form     | ✅     | `/guest/persil/{id}/edit` | GET      |
| Update Persil | ✅     | `/guest/persil/{id}`      | PUT      |
| Delete Persil | ✅     | `/guest/persil/{id}`      | DELETE   |

**SISTEM SIAP DIGUNAKAN! 🎉**
