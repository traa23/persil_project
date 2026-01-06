# Dokumentasi Controllers dan Seeder Integration

## Ringkasan Controllers

### 1. SuperAdminController.php

-   **Parent**: AdminController
-   **Role**: Super Admin dapat melihat dan mengelola semua data
-   **Dashboard**: Menampilkan total persil dan guest user yang ditangani

**Methods:**

-   `dashboard()`: Tampilan dashboard super admin

### 2. AdminController.php

-   **Role**: Admin dapat melihat dan mengelola data yang relevan dengan organisasinya
-   **Key Feature**: Filtering berdasarkan admin_id (untuk guest users yang ditangani)

**Methods:**

-   `dashboard()`: Menampilkan total persil dan guest user milik admin
-   `persilList()`: Menampilkan list persil dengan search/filter
-   Dan methods lainnya untuk CRUD persil

**Query yang digunakan:**

```php
// Ambil persil milik admin atau guest user yang ditangani admin
$recentPersil = Persil::where('pemilik_warga_id', $authId)
    ->orWhereHas('pemilik', function ($q) use ($authId) {
        $q->where('admin_id', $authId);
    })
    ->latest()
    ->take(5)
    ->get();
```

### 3. GuestController.php

-   **Role**: Guest user (warga) dapat melihat data milik mereka saja
-   Membatasi akses hanya ke persil yang dimiliki

### 4. PersilDetailController.php

-   **Role**: Menampilkan detail persil dengan semua relasi
-   Menampilkan dokumen, peta, foto, dan sengketa persil

## Data Flow dari Seeder ke Controller

### 1. User Creation Flow

```
UserSeeder.php
├── Membuat 3 user utama (admin, super_admin, user)
├── Membuat 97 user tambahan (role: user)
└── Controllers menggunakan auth()->id() untuk query

Penggunaan di Controller:
- SuperAdminController: Lihat semua persil
- AdminController: Lihat persil milik diri dan guest mereka
- GuestController: Lihat hanya persil milik sendiri
```

### 2. Persil Creation Flow

```
PersilSeeder.php
├── Ambil user_id dari users (role: user)
├── Ambil jenis_id dari jenis_penggunaan
└── Buat 20 persil dengan pemilik_warga_id

Controllers menerima data:
- pemilik_warga_id: Identifier pemilik persil (user_id)
- jenis_id: Jenis penggunaan tanah
- kode_persil: Kode unik untuk setiap persil

Query di Controller:
Persil::with('pemilik', 'jenisPenggunaan')->get();
```

### 3. Dokumen Creation Flow

```
DokumenPersilSeeder.php
├── Ambil persil_id dari persil
└── Buat dokumen untuk setiap persil

Controller menampilkan:
$persil->dokumenPersil()->get()
```

### 4. Foto Creation Flow

```
FotoPersilSeeder.php
├── Ambil persil_id dari persil
├── Buat 2-4 foto per persil
└── Simpan path file

Controller menampilkan:
$persil->fotoPersil()->get()
```

### 5. Peta Creation Flow

```
PetaPersilSeeder.php
├── Ambil persil_id dari persil
└── Generate GeoJSON untuk peta

Controller menggunakan:
$persil->petaPersil()->first()
```

### 6. Sengketa Creation Flow

```
SengketaPersilSeeder.php
├── Ambil persil_id dari persil
├── Ambil nama dari warga
└── Buat sengketa dengan status enum

Controller menampilkan:
$persil->sengketa()->get()
```

## Contoh Query yang Bekerja Dengan Seeder Data

### 1. Ambil persil dengan semua relasi

```php
$persil = Persil::with([
    'pemilik',           // User yang memiliki persil
    'jenisPenggunaan',   // Jenis penggunaan dari JenisPenggunaanSeeder
    'dokumenPersil',     // Dokumen dari DokumenPersilSeeder
    'petaPersil',        // Peta dari PetaPersilSeeder
    'fotoPersil',        // Foto dari FotoPersilSeeder
    'sengketa'           // Sengketa dari SengketaPersilSeeder
])->find(1);

// Akses data
echo $persil->kode_persil;                    // PSL-001
echo $persil->pemilik->name;                  // User Biasa
echo $persil->jenisPenggunaan->nama_penggunaan; // Perumahan
count($persil->dokumenPersil);                // ~5 dokumen
$geojson = $persil->petaPersil->geojson;     // GeoJSON polygon
count($persil->fotoPersil);                   // 2-4 foto
count($persil->sengketa);                     // 0-3 sengketa
```

### 2. Ambil persil berdasarkan admin

```php
$adminId = auth()->id();
$persil = Persil::where('pemilik_warga_id', $adminId)
    ->orWhereHas('pemilik', function ($q) use ($adminId) {
        $q->where('admin_id', $adminId);
    })
    ->get();
```

### 3. Ambil persil berdasarkan jenis penggunaan

```php
$jenis = JenisPenggunaan::find(1); // Perumahan
$persil = $jenis->persil()->get();
```

### 4. Ambil sengketa dengan status tertentu

```php
$sengketaProses = SengketaPersil::where('status', 'proses')->get();
$sengketaSelesai = SengketaPersil::where('status', 'selesai')->get();
// Status HARUS: 'baru', 'proses', 'selesai'
```

### 5. Hitung dokumen per jenis

```php
$dokumenCounts = DokumenPersil::select('jenis_dokumen')
    ->selectRaw('count(*) as count')
    ->groupBy('jenis_dokumen')
    ->get();
```

## Validasi Data Seeder di Controller

Sebelum menyimpan data, controller harus validate:

```php
// Validasi untuk create/update persil
$validated = $request->validate([
    'kode_persil' => 'required|unique:persil,kode_persil',
    'pemilik_warga_id' => 'required|exists:users,id',
    'jenis_id' => 'required|exists:jenis_penggunaan,jenis_id',
    'luas_m2' => 'required|numeric|min:0',
    'alamat_lahan' => 'required|string',
    'rt' => 'nullable|integer',
    'rw' => 'nullable|integer',
]);

// Data dari seeder sudah valid, tapi tetap validate user input
```

## Testing Integration

### 1. Setup Test Database

```bash
php artisan migrate:fresh --seed
```

### 2. Verify Seeder Data

```bash
php artisan tinker
```

```php
// Di tinker, coba query:
User::where('role', 'user')->count(); // Seharusnya 99
Persil::count(); // Seharusnya 20
DokumenPersil::count(); // Seharusnya ~100
FotoPersil::count(); // Seharusnya 40-80
SengketaPersil::count(); // Seharusnya 30

// Test relationships
$persil = Persil::first();
$persil->pemilik; // User yang memiliki
$persil->jenisPenggunaan; // Jenis penggunaan
$persil->dokumenPersil(); // Koleksi dokumen
```

### 3. Test Controller dengan Seeder Data

```bash
# Login sebagai admin
curl -X GET http://localhost:8000/admin/dashboard

# Seharusnya bisa lihat data dari seeder
```

## Catatan Penting

1. **Foreign Key Constraint**: Semua controller harus ensure bahwa foreign key ada sebelum insert
2. **Enum Values**: Status di sengketa hanya: 'baru', 'proses', 'selesai'
3. **Role-Based Access**: Controllers filter data berdasarkan role user
4. **Relationship Loading**: Gunakan eager loading (with()) untuk optimize query
5. **Data Consistency**: Seeder dan controller harus sinkron dalam hal field names dan types

---

**Dokumentasi dibuat**: 6 Januari 2026
