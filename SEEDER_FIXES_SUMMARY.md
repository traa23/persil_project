# Ringkasan Perbaikan Seeder dan Database

## Tanggal: 6 Januari 2026

### Perbaikan yang Dilakukan

#### 1. **PersilSeeder.php** ✅

-   **Perbaikan Foreign Key**: Mengubah dari mengambil `warga_id` menjadi `user_id` dari tabel `users` dengan role 'user'
-   **Perbaikan Kolom jenis_id**: Sekarang menggunakan `jenis_id` dari tabel `jenis_penggunaan` dengan benar (foreign key reference)
-   **Penghapusan Kolom Tidak Valid**: Menghapus penggunaan kolom 'penggunaan' dan 'koordinat' yang tidak ada di migration
-   **Perbaikan RT/RW**: Mengubah dari string format '001' menjadi integer
-   **Database Consistency**: Sekarang sesuai dengan migration yang mendefinisikan:
    -   `pemilik_warga_id` -> references `users.id`
    -   `jenis_id` -> references `jenis_penggunaan.jenis_id`

#### 2. **SengketaPersilSeeder.php** ✅

-   **Perbaikan Enum Status**: Mengubah status list dari `['pending', 'proses', 'selesai']` menjadi `['baru', 'proses', 'selesai']`
-   **Database Consistency**: Sekarang sesuai dengan enum yang didefinisikan di migration

#### 3. **MediaSeeder.php** ✅

-   **Status**: Diberi komentar karena tabel 'media' tidak ada di database
-   **Action**: Seeder masih ada tapi fungsi run() tidak melakukan apa-apa
-   **Note**: Jika ingin mengimplementasikan media seeder, perlu membuat migration untuk tabel media terlebih dahulu

#### 4. **FotoPersilSeeder.php** ✅ (BARU)

-   **Deskripsi**: Seeder baru untuk mengisi data tabel `foto_persil`
-   **Fungsi**: Membuat 2-4 foto untuk setiap persil dengan struktur path yang konsisten
-   **Fields**: file_path, original_name, file_size
-   **Sesuai dengan Migration**: Menggunakan persil_id yang benar dari tabel persil

#### 5. **DatabaseSeeder.php** ✅

-   **Update Call Order**: Menambahkan FotoPersilSeeder::class pada urutan yang benar (setelah PetaPersilSeeder, sebelum SengketaPersilSeeder)
-   **Menghilangkan MediaSeeder**: Mengkomentari pemanggilan MediaSeeder karena tabel tidak ada
-   **Order yang Benar**:
    1. UserSeeder (users table)
    2. WargaSeeder (warga table)
    3. JenisPenggunaanSeeder (jenis_penggunaan table)
    4. PersilSeeder (persil table - depends on users dan jenis_penggunaan)
    5. DokumenPersilSeeder (dokumen_persil table - depends on persil)
    6. PetaPersilSeeder (peta_persil table - depends on persil)
    7. FotoPersilSeeder (foto_persil table - depends on persil)
    8. SengketaPersilSeeder (sengketa_persil table - depends on persil)

#### 6. **Model Warga** ✅ (BARU)

-   **File**: `app/Models/Warga.php`
-   **Struktur**: Model untuk tabel `warga`
-   **Relationships**: Memiliki relasi `hasMany` dengan Persil melalui pemilik_warga_id
-   **Fillable**: no_ktp, nama, jenis_kelamin, agama, pekerjaan, telp, email

### Struktur Database yang Sekarang Benar

```
users (Admin, Super Admin, User, Guest)
├── Persil (pemilik_warga_id -> users.id)
│   ├── jenis_id -> jenis_penggunaan.jenis_id
│   ├── DokumenPersil
│   ├── PetaPersil
│   ├── FotoPersil
│   └── SengketaPersil

warga (Data warga/masyarakat)
└── Persil (pemilik_warga_id -> users.id)

jenis_penggunaan
└── Persil
```

### Catatan Penting

1. **Tabel `warga`**: Adalah tabel terpisah untuk menyimpan data warga/masyarakat. Namun, untuk kepemilikan persil, menggunakan `users.id` sebagai pemilik.
2. **Foreign Key Consistency**: Semua seeder sekarang mengikuti foreign key yang didefinisikan di migration
3. **Enum Values**: Semua enum values sekarang sesuai dengan definisi di migration
4. **Model Relationships**: Semua model sudah memiliki relationships yang benar

### Testing

Untuk memverifikasi perbaikan ini, jalankan:

```bash
php artisan migrate:fresh --seed
```

Seharusnya tidak ada foreign key constraint error lagi.

---
