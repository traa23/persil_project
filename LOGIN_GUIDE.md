# Panduan Login Sistem Persil

## Akun yang Tersedia

### Admin Account

-   **Email**: `admin@persil.test`
-   **Password**: `password`
-   **Role**: admin
-   **Akses**: Dashboard admin dan manajemen pengguna

### Guest Accounts

-   **Guest 1**:

    -   Email: `guest1@persil.test`
    -   Password: `password`
    -   Role: guest

-   **Guest 2**:
    -   Email: `guest2@persil.test`
    -   Password: `password`
    -   Role: guest

## Alur Login

1. Buka halaman login di `http://127.0.0.1:8000/login`
2. Masukkan email dan password sesuai dengan akun di atas
3. Setelah login berhasil, Anda akan diarahkan ke:
    - **Admin**: `/admin/dashboard` (Dashboard Admin)
    - **Guest**: `/guest/` (Dashboard Guest - Persil Management)

## Perbaikan yang Dilakukan

### 1. Kernel.php (app/Http/Kernel.php)

-   Dibuat ulang file Kernel.php dengan middleware yang benar
-   Ditambahkan middleware `admin.role` untuk validasi admin

### 2. AdminRoleMiddleware (app/Http/Middleware/AdminRoleMiddleware.php)

-   Middleware baru untuk memeriksa apakah user memiliki role 'admin'
-   Akan mengembalikan error 403 jika user bukan admin

### 3. Routes (routes/web.php)

-   Menghapus import DashboardController yang tidak diperlukan
-   Middleware admin routes diubah dari `admin` menjadi `admin.role` untuk kejelasan

### 4. Database

-   Fresh migration dan seed database
-   Admin user dan 2 guest users berhasil dibuat

### 5. DashboardController

-   Dihapus file DashboardController.php yang tidak digunakan

## Testing Login

Untuk menguji login:

1. **Test Admin Login**:

    ```
    Email: admin@persil.test
    Password: password
    ```

    - Harusnya diarahkan ke `/admin/dashboard`

2. **Test Guest Login**:

    ```
    Email: guest1@persil.test
    Password: password
    ```

    - Harusnya diarahkan ke `/guest/` (Persil index)

3. **Test Invalid Access**:
    - Guest user mencoba akses `/admin/dashboard` → Akan mendapat error 403
    - Admin user bisa akses `/admin/dashboard` dengan normal

## File yang Telah Diperbaiki

1. ✅ `app/Http/Kernel.php` - Dibuat ulang
2. ✅ `app/Http/Middleware/AdminRoleMiddleware.php` - Dibuat baru
3. ✅ `app/Http/Middleware/AdminMiddleware.php` - Sudah ada (dari sesi sebelumnya)
4. ✅ `routes/web.php` - Diperbaiki
5. ✅ Database seeded dengan admin dan guest users
6. ✅ Cache cleared dan config cleared

## Catatan Penting

-   Session driver menggunakan `database` (SESSION_DRIVER=database)
-   CSRF token validation adalah ENABLED (bukan dikecualikan)
-   Session lifetime adalah 120 menit
-   Session enkripsi adalah ENABLED (SESSION_ENCRYPT=true)
