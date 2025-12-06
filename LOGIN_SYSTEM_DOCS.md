# Login & Role System Documentation

## Overview

Sistem ini telah diimplementasikan dengan fitur autentikasi dan role-based access control (RBAC) dengan dua tipe role: **Admin** dan **Guest**.

## Test Credentials

### Admin Account

-   **Email**: `admin@persil.test`
-   **Password**: `password`
-   **Role**: Admin

### Guest Accounts

1. **Guest User 1**

    - Email: `guest1@persil.test`
    - Password: `password`
    - Role: Guest

2. **Guest User 2**

    - Email: `guest2@persil.test`
    - Password: `password`
    - Role: Guest

3. **Putra**

    - Email: `putra@example.com`
    - Password: `password`
    - Role: Guest

4. **Fajar**

    - Email: `fajar@example.com`
    - Password: `password`
    - Role: Guest

5. **Anugrah**

    - Email: `anugrah@example.com`
    - Password: `password`
    - Role: Guest

6. **Traa**

    - Email: `traa@example.com`
    - Password: `password`
    - Role: Guest

7. **Toyy**
    - Email: `toyy@example.com`
    - Password: `password`
    - Role: Guest

## Fitur Admin

### 1. Admin Dashboard (`/admin/dashboard`)

-   Melihat statistik: Total Users, Guest Users, Admin Users
-   Quick actions untuk membuat user baru atau kelola users

### 2. Kelola Users (`/admin/users`)

-   **Lihat daftar semua guest users** dengan pagination
-   **Buat user baru**: Admin dapat membuat akun guest atau admin baru dan menentukan role-nya
-   **Edit user**: Dapat mengubah nama, email, dan role dari user
-   **Hapus user**: **Penting** - Ketika admin menghapus akun guest, semua data Persil milik guest tersebut akan otomatis terhapus juga (cascade delete)
-   **Lihat detail user**: Melihat semua data Persil yang dimiliki oleh seorang guest

### 3. Lihat Detail Guest (`/admin/users/{id}`)

-   Informasi lengkap user (nama, email, foto profil, role)
-   Daftar semua Persil yang dimiliki guest tersebut
-   Dapat melihat detail setiap Persil

## Fitur Guest

### 1. CRUD Data Persil (`/guest`)

Guest dapat:

-   **Membuat** data Persil baru (sebanyak yang diinginkan)
-   **Membaca/Melihat** semua data Persil milik mereka sendiri
-   **Mengubah/Edit** data Persil yang mereka buat
-   **Menghapus** data Persil yang mereka buat

**Penting**: Guest hanya bisa melihat dan mengelola data Persil yang mereka buat sendiri. Data pemilik_warga_id otomatis diset ke user yang login saat membuat Persil baru.

### 2. Dokumen Persil, Peta Persil, Sengketa Persil, Jenis Penggunaan

Guest dapat melakukan CRUD seperti biasa untuk resources terkait Persil.

## Alur Login

1. Akses `/login`
2. Masukkan email dan password sesuai test credentials
3. Jika role **admin**: Redirect ke `/admin/dashboard`
4. Jika role **guest**: Redirect ke `/guest` (daftar Persil mereka)

## Logout

-   Klik tombol Logout (biasanya di navbar/header)
-   Route: `POST /logout`
-   Redirect kembali ke `/`

## Middleware Protection

### Protected Routes

-   `/admin/*` - Hanya accessible oleh user dengan role `admin`
-   `/guest/*` - Hanya accessible oleh user yang sudah login (auth required)

### Unauthorized Access

Jika user tanpa login akses `/admin` atau `/guest`, akan redirect ke login page.
Jika user dengan role guest akses `/admin`, akan dapat error 403 Forbidden.

## Key Implementation Details

### 1. Cascade Delete

Ketika admin menghapus user guest melalui `/admin/users/{id}` DELETE:

-   User akan dihapus dari tabel `users`
-   Semua Persil yang dimiliki user akan otomatis dihapus (cascade delete pada foreign key `pemilik_warga_id`)
-   Semua dokumen, peta, sengketa yang terkait dengan Persil juga akan dihapus

### 2. Guest Data Isolation

-   Guest hanya bisa melihat Persil yang mereka buat (pemilik_warga_id = auth()->id())
-   Guest tidak bisa mengakses Persil milik user lain
-   Jika guest coba access Persil milik user lain, akan dapat error 403

### 3. Auto-fill Owner pada Create

-   Saat guest membuat Persil baru, field pemilik tidak ditampilkan
-   Sistem otomatis set `pemilik_warga_id` ke user yang sedang login
-   Guest tidak bisa menentukan pemilik secara manual

### 4. Role Column di Database

-   Migration baru: `2025_12_04_000000_add_role_to_users_table`
-   Menambahkan column `role` (enum: 'admin', 'guest') ke tabel `users`
-   Default value: 'guest'

### 5. Cascade Constraint

-   Migration baru: `2025_12_04_000001_update_persil_cascade_delete`
-   Mengubah constraint pada foreign key `pemilik_warga_id` di tabel `persil` dari `nullOnDelete()` ke `cascadeOnDelete()`
-   Memastikan data Persil akan otomatis terhapus ketika user owner-nya dihapus

## Files Created/Modified

### New Controllers

-   `app/Http/Controllers/Auth/LoginController.php`
-   `app/Http/Controllers/Admin/AdminUserController.php`

### New Middleware

-   `app/Http/Middleware/IsAdmin.php`
-   `app/Http/Middleware/IsGuest.php`

### New Views

-   `resources/views/auth/login.blade.php`
-   `resources/views/admin/dashboard.blade.php`
-   `resources/views/admin/users/index.blade.php`
-   `resources/views/admin/users/create.blade.php`
-   `resources/views/admin/users/edit.blade.php`
-   `resources/views/admin/users/show.blade.php`

### Modified Files

-   `app/Models/User.php` - Tambah fillable 'role', relasi persils()
-   `routes/web.php` - Tambah auth routes, admin routes
-   `bootstrap/app.php` - Register middleware aliases
-   `database/seeders/DatabaseSeeder.php` - Call AdminUserSeeder
-   `database/seeders/AdminUserSeeder.php` - Buat test users
-   `database/migrations/2025_10_20_101556_create_persil_table.php` - Change to cascadeOnDelete
-   `resources/views/guest/persil/create.blade.php` - Remove pemilik selection
-   `resources/views/guest/persil/edit.blade.php` - Simplify pemilik display
-   `app/Http/Controllers/GuestPersilController.php` - Filter by owner, check ownership

## Testing Checklist

### Admin Testing

-   [ ] Login dengan admin@persil.test / password
-   [ ] Access `/admin/dashboard` (should work)
-   [ ] Buat user baru (guest atau admin)
-   [ ] Edit user yang ada
-   [ ] Lihat detail guest dan data Persilnya
-   [ ] Hapus guest user dan verifikasi data Persilnya terhapus juga

### Guest Testing

-   [ ] Login dengan guest1@persil.test / password
-   [ ] Access `/guest` (should work)
-   [ ] Buat Persil baru
-   [ ] Edit Persil yang dibuat
-   [ ] Hapus Persil yang dibuat
-   [ ] Coba akses Persil milik guest lain (should get 403)
-   [ ] Logout

### Security Testing

-   [ ] Tanpa login, coba akses `/admin` (should redirect to login)
-   [ ] Tanpa login, coba akses `/guest` (should redirect to login)
-   [ ] Login sebagai guest, coba akses `/admin` (should get 403)
-   [ ] Login sebagai guest, coba akses Persil milik guest lain (should get 403)

## Notes

-   Semua password di-hash dengan bcrypt
-   Session management menggunakan Laravel's built-in session
-   CSRF protection active pada semua forms
-   Email harus unique (database constraint)

---

**Last Updated**: 4 December 2025
