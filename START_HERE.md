# 🎯 MULAI DARI SINI - PANDUAN SEGERA MENGGUNAKAN

## ✅ SISTEM LOGIN SUDAH SIAP!

Ikuti langkah di bawah untuk login ke sistem.

---

## 🚀 LANGKAH 1: START SERVER

Buka terminal dan jalankan:

```bash
cd d:\framework\laragon-6.0-minimal\www\Project_Persil_Kel12_Guest
php artisan serve --port=8000
```

Server akan berjalan di: **http://127.0.0.1:8000**

---

## 📝 LANGKAH 2: BUKA LOGIN PAGE

Buka browser dan ketik:

```
http://127.0.0.1:8000/login
```

Anda akan melihat **Form Login** dengan fields:

-   Email
-   Password
-   Tombol Login

---

## 🔐 LANGKAH 3: LOGIN DENGAN AKUN

### PILIHAN 1: Login Sebagai ADMIN

**Email**: `admin@persil.test`
**Password**: `password`

Setelah login → Redirect ke `/admin/dashboard`

### PILIHAN 2: Login Sebagai GUEST

**Email**: `guest1@persil.test`
**Password**: `password`

Setelah login → Redirect ke `/guest/` (Persil Management)

---

## 🎯 YANG BERHASIL

✅ Form login menampil dengan benar
✅ Login sebagai admin berfungsi
✅ Login sebagai guest berfungsi
✅ Session management berfungsi
✅ CSRF protection aktif
✅ Middleware protection aktif
✅ Database seeded dengan user

---

## 📍 TROUBLESHOOTING CEPAT

Jika ada masalah:

### 1️⃣ Refresh Page

Tekan `Ctrl + Shift + R` (hard refresh) di browser

### 2️⃣ Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### 3️⃣ Restart Server

Tekan `Ctrl+C` untuk stop server, lalu jalankan ulang:

```bash
php artisan serve --port=8000
```

### 4️⃣ Reset Database

Jika user tidak ada:

```bash
php artisan migrate:fresh --seed
```

---

## 📊 STRUKTUR SISTEM

```
LOGIN PAGE (/login)
    ↓
POST /login
    ↓
Auth::attempt() → Validate email & password
    ↓
    ├─ SUCCESS
    │  ├─ Check Role
    │  ├─ Admin → /admin/dashboard
    │  └─ Guest → /guest/
    │
    └─ FAIL → Show error & stay at /login
```

---

## 🔒 KEAMANAN

✅ Password terenkripsi dengan bcrypt
✅ Session dienkripsi
✅ CSRF token validation aktif
✅ Session timeout 120 menit
✅ Role-based access control aktif

---

## 📋 FILE YANG PENTING

| File                                              | Fungsi              |
| ------------------------------------------------- | ------------------- |
| `routes/web.php`                                  | Route configuration |
| `app/Http/Controllers/Auth/LoginController.php`   | Login logic         |
| `resources/views/auth/login.blade.php`            | Login form          |
| `app/Http/Middleware/Authenticate.php`            | Auth middleware     |
| `app/Http/Middleware/RedirectIfAuthenticated.php` | Guest middleware    |

---

## 🎓 NEXT STEPS

Setelah login berhasil:

1. **Untuk Admin**:

    - Buka `/admin/dashboard`
    - Lihat statistik pengguna
    - Manage guest users di `/admin/users`

2. **Untuk Guest**:
    - Buka `/guest/`
    - Manage persil (parcels)
    - Upload dokumen
    - Etc.

---

## ❓ FAQ

**Q: Form login tidak muncul?**
A: Refresh page atau clear cache dengan `php artisan config:clear`

**Q: Login gagal padahal email benar?**
A: Pastikan password benar: `password` (huruf kecil)

**Q: Redirect ke login terus-terus?**
A: Pastikan session driver benar: SESSION_DRIVER=database di `.env`

**Q: Admin tidak bisa akses `/admin/dashboard`?**
A: Pastikan role di database adalah `admin` (lowercase)

---

## 🎉 SELESAI!

Sekarang Anda bisa langsung login dan menggunakan sistem Persil!

Jika ada pertanyaan, lihat dokumentasi lengkap di:

-   `SISTEM_LOGIN_FINAL.md` - Dokumentasi teknis lengkap
