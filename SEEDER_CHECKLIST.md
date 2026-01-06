# Checklist Perbaikan Seeder dan Database

## ✅ Perbaikan Seeder

### UserSeeder.php

-   [x] Struktur sudah benar
-   [x] Menggunakan Hash::make() untuk password
-   [x] Roles: admin, super_admin, user sesuai dengan enum di migration
-   [x] Fields: name, email, password, role

### WargaSeeder.php

-   [x] Struktur sudah benar
-   [x] Membuat 100 data warga
-   [x] Fields benar: no_ktp, nama, jenis_kelamin, agama, pekerjaan, telp, email
-   [x] Generate KTP dengan format 16 digit
-   [x] Generate email dengan domain lokal

### JenisPenggunaanSeeder.php

-   [x] Struktur sudah benar
-   [x] Membuat 10 jenis penggunaan dasar
-   [x] Fields benar: nama_penggunaan, keterangan
-   [x] Tidak ada duplikat nama_penggunaan (unique constraint)

### PersilSeeder.php

-   [x] **FIXED**: Mengambil user_id dari users table (bukan warga)
-   [x] **FIXED**: Menggunakan jenis_id dari jenis_penggunaan
-   [x] **FIXED**: Menghapus kolom 'penggunaan' (tidak ada di migration)
-   [x] **FIXED**: Menghapus kolom 'koordinat' (tidak ada di migration)
-   [x] **FIXED**: Mengubah RT/RW ke integer (bukan string '001')
-   [x] Fields benar: kode_persil, pemilik_warga_id, luas_m2, jenis_id, alamat_lahan, rt, rw
-   [x] Foreign keys sesuai:
    -   pemilik_warga_id -> users.id
    -   jenis_id -> jenis_penggunaan.jenis_id

### DokumenPersilSeeder.php

-   [x] Struktur sudah benar
-   [x] Mengambil persil_id dari persil table
-   [x] Membuat 100 dokumen persil
-   [x] Fields benar: persil_id, jenis_dokumen, nomor, keterangan
-   [x] Generate nomor dokumen dengan prefix yang sesuai

### PetaPersilSeeder.php

-   [x] Struktur sudah benar
-   [x] Mengambil persil_id dari persil table
-   [x] Membuat GeoJSON polygon yang valid
-   [x] Fields benar: persil_id, geojson, panjang_m, lebar_m

### FotoPersilSeeder.php ⭐ BARU

-   [x] File baru dibuat: `database/seeders/FotoPersilSeeder.php`
-   [x] Mengambil persil_id dari persil table
-   [x] Membuat 2-4 foto untuk setiap persil
-   [x] Fields benar: persil_id, file_path, original_name, file_size
-   [x] Path file konsisten: persil/{persil_id}/{file_name}

### SengketaPersilSeeder.php

-   [x] **FIXED**: Mengubah status enum dari 'pending' menjadi 'baru' (sesuai migration)
-   [x] Status list sekarang: 'baru', 'proses', 'selesai'
-   [x] Mengambil persil_id dari persil table
-   [x] Mengambil nama dari warga table untuk pihak_1 dan pihak_2
-   [x] Membuat 30 data sengketa (diperkecil dari 100)

### MediaSeeder.php

-   [x] **FIXED**: Dikosongkan karena tabel 'media' tidak ada
-   [x] Ditambahkan komentar penjelasan
-   [x] Fungsi run() tidak melakukan apa-apa (safe)

## ✅ Perbaikan DatabaseSeeder.php

-   [x] Menambahkan FotoPersilSeeder::class
-   [x] Urutan seeder benar (mempertimbangkan dependencies)
-   [x] Menghilangkan/mengkomentari MediaSeeder::class
-   [x] Call order:
    1. UserSeeder
    2. WargaSeeder
    3. JenisPenggunaanSeeder
    4. PersilSeeder
    5. DokumenPersilSeeder
    6. PetaPersilSeeder
    7. FotoPersilSeeder
    8. SengketaPersilSeeder

## ✅ Perbaikan Models

### User.php

-   [x] Relationships sudah benar
-   [x] Fillable fields benar
-   [x] Ada relasi ke Persil via pemilik_warga_id

### Persil.php

-   [x] Primary key: persil_id
-   [x] Table name: persil
-   [x] Fillable fields benar
-   [x] Relationships:
    -   [x] pemilik() -> belongsTo(User::class)
    -   [x] jenisPenggunaan() -> belongsTo(JenisPenggunaan::class)
    -   [x] dokumenPersil() -> hasMany(DokumenPersil::class)
    -   [x] petaPersil() -> hasOne(PetaPersil::class)
    -   [x] sengketa() -> hasMany(SengketaPersil::class)
    -   [x] fotoPersil() -> hasMany(FotoPersil::class)

### JenisPenggunaan.php

-   [x] Primary key: jenis_id
-   [x] Table name: jenis_penggunaan
-   [x] Relationships: persil() -> hasMany

### DokumenPersil.php

-   [x] Primary key: dokumen_id
-   [x] Table name: dokumen_persil
-   [x] Relationships: persil() -> belongsTo

### PetaPersil.php

-   [x] Primary key: peta_id
-   [x] Table name: peta_persil
-   [x] Relationships: persil() -> belongsTo

### SengketaPersil.php

-   [x] Primary key: sengketa_id
-   [x] Table name: sengketa_persil
-   [x] Relationships: persil() -> belongsTo

### FotoPersil.php

-   [x] Relationships: persil() -> belongsTo

### Warga.php ⭐ BARU

-   [x] File baru dibuat: `app/Models/Warga.php`
-   [x] Table name: warga
-   [x] Primary key: id (default)
-   [x] Fillable fields benar
-   [x] Relationships: persil() -> hasMany

## ✅ Dokumentasi

-   [x] SEEDER_FIXES_SUMMARY.md - Ringkasan perbaikan
-   [x] DATABASE_RELATIONSHIPS.md - Dokumentasi relasi database
-   [x] CHECKLIST (file ini) - Checklist perbaikan

## ✅ Foreign Key Constraints

-   [x] users.id <- persil.pemilik_warga_id (CASCADE DELETE)
-   [x] jenis_penggunaan.jenis_id <- persil.jenis_id (SET NULL)
-   [x] persil.persil_id <- dokumen_persil.persil_id (CASCADE DELETE)
-   [x] persil.persil_id <- peta_persil.persil_id (CASCADE DELETE)
-   [x] persil.persil_id <- foto_persil.persil_id (CASCADE DELETE)
-   [x] persil.persil_id <- sengketa_persil.persil_id (CASCADE DELETE)

## ✅ Enum Values

-   [x] users.role: admin, super_admin, user, guest
-   [x] sengketa_persil.status: baru, proses, selesai

## 🧪 Testing

Untuk memverifikasi semua perbaikan:

```bash
# Fresh migrate dan seed
php artisan migrate:fresh --seed

# Jika berhasil, tidak ada error
# Data yang seharusnya terbuat:
# - 100 users
# - 100 warga
# - 10 jenis_penggunaan
# - 20 persil
# - 100 dokumen_persil
# - 20 peta_persil
# - 40-80 foto_persil (2-4 per persil)
# - 30 sengketa_persil
```

## ⚠️ Notes

1. **Penting**: `pemilik_warga_id` di persil mengacu ke `users.id`, BUKAN `warga.id`
2. **Tabel warga**: Adalah tabel terpisah untuk data demografi warga
3. **Enum status**: HARUS 'baru', 'proses', 'selesai' - jangan gunakan 'pending'
4. **Urutan seeder**: HARUS diikuti karena ada dependencies
5. **Foreign keys**: HARUS sesuai dengan migration

---

**Status**: ✅ SEMUA PERBAIKAN SELESAI
**Tanggal**: 6 Januari 2026
