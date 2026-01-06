# Dokumentasi Relasi Database dan Seeder

## Struktur Tabel dan Relationships

### 1. **users** (Pengguna Sistem)

-   Pemilik: Super Admin, Admin, Guest, User
-   Primary Key: `id`
-   Fields Utama: name, email, password, role, admin_id, parent_admin_id

**Relationships:**

```php
- guestUsers() -> users (hasMany)
- admin() -> users (belongsTo) - admin yang membuat user ini
- parentAdmin() -> users (belongsTo) - parent admin user
- childAdmins() -> users (hasMany) - admin yang dibuat user ini
- persil() -> persil (hasMany) - via pemilik_warga_id
```

### 2. **warga** (Data Warga Masyarakat)

-   Primary Key: `id`
-   Fields: no_ktp, nama, jenis_kelamin, agama, pekerjaan, telp, email
-   **CATATAN**: Tabel ini berbeda dengan users. Ini menyimpan data demografi warga.

**Relationships:**

```php
- persil() -> persil (hasMany) - via user relationship
```

### 3. **jenis_penggunaan** (Jenis Penggunaan Tanah)

-   Primary Key: `jenis_id`
-   Fields: nama_penggunaan, keterangan, created_at, updated_at
-   Data: Perumahan, Pertanian, Perkebunan, Peternakan, Industri, dll

**Relationships:**

```php
- persil() -> persil (hasMany)
```

### 4. **persil** (Data Persil/Bidang Tanah)

-   Primary Key: `persil_id`
-   Foreign Keys:
    -   `pemilik_warga_id` -> `users.id`
    -   `jenis_id` -> `jenis_penggunaan.jenis_id`
-   Fields: kode_persil, luas_m2, alamat_lahan, rt, rw, foto_persil

**Relationships:**

```php
- pemilik() -> users (belongsTo)
- jenisPenggunaan() -> jenis_penggunaan (belongsTo)
- dokumenPersil() -> dokumen_persil (hasMany)
- petaPersil() -> peta_persil (hasOne)
- sengketa() -> sengketa_persil (hasMany)
- fotoPersil() -> foto_persil (hasMany)
```

### 5. **dokumen_persil** (Dokumen Kepemilikan Persil)

-   Primary Key: `dokumen_id`
-   Foreign Key: `persil_id` -> `persil.persil_id`
-   Fields: jenis_dokumen, nomor, keterangan, file_dokumen

**Relationships:**

```php
- persil() -> persil (belongsTo)
```

### 6. **peta_persil** (Peta/GeoJSON Persil)

-   Primary Key: `peta_id`
-   Foreign Key: `persil_id` -> `persil.persil_id`
-   Fields: geojson, panjang_m, lebar_m, file_peta

**Relationships:**

```php
- persil() -> persil (belongsTo)
```

### 7. **foto_persil** (Foto Persil)

-   Primary Key: `id`
-   Foreign Key: `persil_id` -> `persil.persil_id`
-   Fields: file_path, original_name, file_size

**Relationships:**

```php
- persil() -> persil (belongsTo)
```

### 8. **sengketa_persil** (Data Sengketa Persil)

-   Primary Key: `sengketa_id`
-   Foreign Key: `persil_id` -> `persil.persil_id`
-   Fields: pihak_1, pihak_2, kronologi, status (enum: baru/proses/selesai), penyelesaian, bukti_sengketa

**Relationships:**

```php
- persil() -> persil (belongsTo)
```

## Urutan Seeding yang Benar

```
1. UserSeeder
   ├── Membuat 3 user utama (admin, super_admin, user)
   └── Membuat 97 user tambahan

2. WargaSeeder
   └── Membuat 100 data warga dengan info KTP, nama, agama, pekerjaan, dll

3. JenisPenggunaanSeeder
   └── Membuat 10 jenis penggunaan tanah (Perumahan, Pertanian, dll)

4. PersilSeeder (depends: users, jenis_penggunaan)
   ├── Mengambil user_id dari users (role='user')
   ├── Mengambil jenis_id dari jenis_penggunaan
   └── Membuat 20 persil

5. DokumenPersilSeeder (depends: persil)
   ├── Mengambil persil_id dari persil
   └── Membuat 100 dokumen persil

6. PetaPersilSeeder (depends: persil)
   ├── Mengambil persil_id dari persil
   └── Membuat peta GeoJSON untuk setiap persil

7. FotoPersilSeeder (depends: persil)
   ├── Mengambil persil_id dari persil
   └── Membuat 2-4 foto untuk setiap persil

8. SengketaPersilSeeder (depends: persil, warga)
   ├── Mengambil persil_id dari persil
   ├── Mengambil nama dari warga
   └── Membuat 30 data sengketa
```

## Penting!

1. **Persil membutuhkan Users, bukan Warga**: Kolom `pemilik_warga_id` di tabel `persil` adalah foreign key ke `users.id`, BUKAN ke `warga.id`

2. **Warga adalah tabel terpisah**: Digunakan untuk menyimpan data demografi masyarakat, BUKAN untuk kepemilikan persil

3. **Order Seeding Penting**: Jangan mengubah urutan seeder karena ada dependency antar tabel

4. **Foreign Key Constraints**: Semua seeder harus mengikuti foreign key constraints yang didefinisikan di migration

5. **Enum Values Harus Sesuai**: Untuk `sengketa_persil.status`, hanya gunakan: 'baru', 'proses', 'selesai'

## Query Contoh

### Ambil semua persil milik user tertentu

```php
$user = User::find(1);
$persilUser = $user->persil; // Menggunakan relationship
```

### Ambil semua persil dengan jenis tertentu

```php
$jenis = JenisPenggunaan::find(1);
$persilJenis = $jenis->persil;
```

### Ambil detail persil lengkap

```php
$persil = Persil::with([
    'pemilik',
    'jenisPenggunaan',
    'dokumenPersil',
    'petaPersil',
    'fotoPersil',
    'sengketa'
])->find(1);
```
