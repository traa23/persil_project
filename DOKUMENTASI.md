# Sistem Informasi Persil Pertanahan

Website untuk mengelola data persil/tanah dengan fitur role-based access (Admin & Guest).

## 🎯 Fitur Utama

### Admin

-   **Dashboard**: Melihat statistik persil dan guest user
-   **Manajemen Persil**: CRUD (Create, Read, Update, Delete) data persil
-   **Manajemen Dokumen**: Tambah, lihat, dan hapus dokumen pendukung persil
-   **Manajemen Peta**: Upload dan kelola peta/koordinat persil
-   **Manajemen Sengketa**: Catat dan track sengketa tanah
-   **Manajemen Guest**: Buat akun guest user, edit, dan hapus

### Guest

-   **Dashboard**: Melihat daftar persil yang ditugaskan
-   **Detail Persil**: Melihat informasi lengkap persil, dokumen, peta, dan sengketa (read-only)

## 📋 Persyaratan Sistem

-   PHP >= 8.2
-   Composer
-   MySQL/MariaDB
-   Laravel 11.x

## 🚀 Instalasi

1. **Clone atau setup project**

```bash
cd d:\framework\laragon-6.0-minimal\www\persil_project
```

2. **Install dependencies**

```bash
composer install
```

3. **Setup environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi database** (sesuaikan di file `.env`)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=persil
DB_USERNAME=root
DB_PASSWORD=
```

5. **Jalankan migrations**

```bash
php artisan migrate:fresh --seed
```

6. **Buat symlink storage**

```bash
php artisan storage:link
```

7. **Jalankan server**

```bash
php artisan serve
```

Buka browser ke `http://localhost:8000`

## 👤 Akun Demo

### Admin

-   **Email**: `admin@persil.local`
-   **Password**: `password`

### Guest 1

-   **Email**: `guest1@persil.local`
-   **Password**: `password`

### Guest 2

-   **Email**: `guest2@persil.local`
-   **Password**: `password`

## 📁 Struktur Database

### Tabel utama:

-   **users**: Data user (admin & guest)
-   **persil**: Data bidang tanah
-   **jenis_penggunaan**: Klasifikasi penggunaan lahan
-   **dokumen_persil**: Dokumen pendukung (sertifikat, SPPT, dll)
-   **peta_persil**: Peta/koordinat dan dimensi tanah
-   **sengketa_persil**: Data sengketa/perselisihan tanah

## 🔐 Keamanan

-   **Authentication**: Laravel built-in authentication
-   **Authorization**: Role-based middleware (admin/guest)
-   **File Upload**: Validasi tipe dan ukuran file
-   **Database**: Foreign keys dan cascading deletes

## 📝 Routes

### Public

-   `GET /login` - Form login
-   `POST /login` - Submit login

### Admin Routes (`/admin`)

-   `GET /dashboard` - Dashboard
-   `GET /persil` - Daftar persil
-   `GET /persil/create` - Form tambah persil
-   `POST /persil` - Submit tambah persil
-   `GET /persil/{id}` - Detail persil
-   `GET /persil/{id}/edit` - Form edit persil
-   `PUT /persil/{id}` - Submit edit persil
-   `DELETE /persil/{id}` - Hapus persil
-   `GET /persil/{persilId}/dokumen/create` - Tambah dokumen
-   `POST /persil/{persilId}/dokumen` - Submit dokumen
-   `DELETE /dokumen/{dokumenId}` - Hapus dokumen
-   `GET /persil/{persilId}/peta/create` - Kelola peta
-   `POST /persil/{persilId}/peta` - Submit peta
-   `GET /persil/{persilId}/sengketa/create` - Tambah sengketa
-   `POST /persil/{persilId}/sengketa` - Submit sengketa
-   `GET /sengketa/{sengketaId}/edit` - Edit sengketa
-   `PUT /sengketa/{sengketaId}` - Submit edit sengketa
-   `DELETE /sengketa/{sengketaId}` - Hapus sengketa
-   `GET /guest` - Daftar guest user
-   `GET /guest/create` - Tambah guest
-   `POST /guest` - Submit tambah guest
-   `GET /guest/{id}/edit` - Edit guest
-   `PUT /guest/{id}` - Submit edit guest
-   `DELETE /guest/{id}` - Hapus guest

### Guest Routes (`/guest`)

-   `GET /dashboard` - Dashboard
-   `GET /persil/{id}` - Detail persil

## 🎨 Teknologi yang Digunakan

-   **Backend**: Laravel 11
-   **Frontend**: Tailwind CSS, Font Awesome
-   **Database**: MySQL
-   **Authentication**: Laravel Auth
-   **File Upload**: Laravel Storage

## 📦 File Upload

Sistem mendukung upload file untuk:

-   **Foto persil**: JPG, PNG (max 2MB) → `/storage/persil`
-   **Dokumen**: File apa saja (max 5MB) → `/storage/dokumen`
-   **Peta**: Gambar/scan (max 5MB) → `/storage/peta`
-   **Bukti Sengketa**: File apa saja (max 5MB) → `/storage/sengketa`

## 🐛 Troubleshooting

### Storage link tidak bekerja

```bash
php artisan storage:link
```

### Database error saat migrate

```bash
php artisan migrate:fresh --seed
```

### Permission denied saat upload

Pastikan folder `storage/app/public` memiliki permission 755

### Clear cache

```bash
php artisan config:clear
php artisan cache:clear
```

## 📞 Support

Untuk pertanyaan atau laporan bug, silakan hubungi admin.

---

**Dibuat dengan ❤️ menggunakan Laravel 11 & Tailwind CSS**
