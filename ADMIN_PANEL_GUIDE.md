# 🛡️ ADMIN PANEL - PANDUAN LENGKAP

## 📋 Daftar Isi

1. [Akses Admin Panel](#akses-admin-panel)
2. [Dashboard Admin](#dashboard-admin)
3. [User Management](#user-management)
4. [Fitur-Fitur](#fitur-fitur)
5. [Role dan Permission](#role-dan-permission)

---

## 🔐 Akses Admin Panel

### URL Admin Panel

```
http://127.0.0.1:8000/admin/dashboard
```

### Akun Admin Default

```
Email: admin@persil.test
Password: password
```

### Cara Login sebagai Admin

1. Buka `http://127.0.0.1:8000/login`
2. Masukkan email: `admin@persil.test`
3. Masukkan password: `password`
4. Klik **Login**
5. Otomatis redirect ke `/admin/dashboard`

---

## 📊 Dashboard Admin

### Tampilan Dashboard

Dashboard menampilkan statistik penting:

```
┌─────────────────────────────────────────────────────────┐
│            ADMIN DASHBOARD                              │
├─────────────────────────────────────────────────────────┤
│ Total Users: 5     │ Total Admins: 2    │ Total Guests: 3
│ Total Persil: 12   │
├─────────────────────────────────────────────────────────┤
│ Recent Users (5 terakhir)                               │
├─────────────────────────────────────────────────────────┤
│ Recent Persil (5 terakhir)                              │
├─────────────────────────────────────────────────────────┤
│ Quick Actions:                                          │
│ • Create New User   • Manage Users                      │
└─────────────────────────────────────────────────────────┘
```

### Statistik yang Ditampilkan

-   **Total Users**: Jumlah semua pengguna di sistem
-   **Total Admins**: Jumlah pengguna dengan role admin
-   **Total Guests**: Jumlah pengguna dengan role guest
-   **Total Persil**: Jumlah data persil di sistem

---

## 👥 User Management

### 1. Lihat Daftar Pengguna

**URL**: `/admin/users`

**Fitur**:

-   ✅ Tabel daftar semua pengguna
-   ✅ Pagination (10 pengguna per halaman)
-   ✅ Informasi: No, Nama, Email, Role, Tanggal Bergabung
-   ✅ Tombol aksi: Detail, Edit, Hapus

**Contoh Tabel**:

```
No  Nama           Email                    Role    Bergabung
1   Admin Persil   admin@persil.test       Admin   20 Des 2025
2   Guest 1        guest1@persil.test      Guest   20 Des 2025
3   Guest 2        guest2@persil.test      Guest   20 Des 2025
```

---

### 2. Membuat Pengguna Baru

**URL**: `/admin/users/create`

**Langkah-Langkah**:

#### Step 1: Buka Halaman Create

-   Klik tombol **+ Tambah User Baru** di halaman User Management
-   Atau langsung buka `/admin/users/create`

#### Step 2: Isi Form

```
Nama *
├─ Contoh: "John Doe"
├─ Tipe: Text (max 255 karakter)
└─ Wajib diisi

Email *
├─ Contoh: "john@example.com"
├─ Tipe: Email (harus valid dan unik)
└─ Wajib diisi

Password *
├─ Minimal: 8 karakter
├─ Harus mengandung huruf dan angka
└─ Wajib diisi

Konfirmasi Password *
├─ Harus sama dengan Password
└─ Wajib diisi

Role *
├─ Pilihan: Admin / Guest
├─ Admin: Akses penuh ke admin panel
└─ Guest: Hanya akses ke CRUD persil
```

#### Step 3: Submit Form

-   Klik tombol **Buat User**
-   Akan redirect ke halaman User Management dengan notifikasi sukses
-   Jika error, akan menampilkan pesan error di atas form

---

### 3. Melihat Detail Pengguna

**URL**: `/admin/users/{id}`

**Cara Akses**:

-   Dari tabel User Management, klik tombol **Detail**

**Informasi yang Ditampilkan**:

```
BASIC INFORMATION:
├─ Full Name
├─ Email
└─ Role (Badge warna: Admin=Purple, Guest=Blue)

SYSTEM INFORMATION:
├─ User ID
├─ Joined Date
└─ Last Updated
```

**Tombol Aksi**:

-   ✏️ **Edit User**: Buka halaman edit
-   🗑️ **Hapus User**: Hapus pengguna (untuk pengguna lain)
-   ← **Kembali ke List**: Kembali ke halaman user list

---

### 4. Edit Pengguna

**URL**: `/admin/users/{id}/edit`

**Cara Akses**:

-   Dari tabel User Management, klik tombol **Edit**
-   Atau dari halaman Detail, klik **Edit User**

**Form yang Dapat Diubah**:

```
Nama *
├─ Isi ulang nama pengguna
└─ Max 255 karakter

Email *
├─ Isi ulang email
├─ Harus unik (tidak boleh sama dengan email lain)
└─ Harus valid

Password (Opsional)
├─ Kosongkan jika tidak ingin mengubah password
├─ Isi jika ingin ubah password
└─ Minimal 8 karakter

Konfirmasi Password
├─ Isi jika mengubah password
└─ Harus sama dengan Password baru

Role *
├─ Ubah role pengguna
├─ Pilihan: Admin / Guest
└─ Wajib dipilih
```

**Contoh Perubahan**:

```
Sebelum: Guest dengan email guest1@persil.test
Sesudah: Admin dengan email guest1@persil.test
```

**Tombol Aksi**:

-   ✅ **Simpan Perubahan**: Simpan perubahan
-   ❌ **Batal**: Kembali tanpa menyimpan

---

### 5. Hapus Pengguna

**Cara Hapus**:

#### Opsi 1: Dari Tabel User Management

1. Cari pengguna yang ingin dihapus
2. Klik tombol **Hapus** di kolom Aksi
3. Konfirmasi dengan klik **OK** di dialog

#### Opsi 2: Dari Halaman Detail

1. Buka detail pengguna
2. Klik tombol **🗑️ Hapus User**
3. Konfirmasi dengan klik **OK** di dialog

**Keamanan**:

-   ✅ Tidak bisa menghapus akun sendiri
-   ✅ Ada konfirmasi sebelum hapus
-   ✅ Data persil pengguna juga akan dihapus (cascade delete)

**Peringatan**:

```
⚠️ PERHATIAN!
Menghapus pengguna akan juga menghapus:
- Semua data persil milik pengguna
- Semua dokumen persil
- Semua data terkait
Tindakan ini TIDAK BISA DIBATALKAN!
```

---

## 🎯 Fitur-Fitur

### 1. Role Assignment (Penetapan Role)

**Apa itu Role?**

```
Admin:
├─ Akses ke Admin Panel
├─ Bisa membuat/edit/hapus pengguna
├─ Bisa mengubah role pengguna
└─ Full access ke semua fitur

Guest:
├─ Hanya bisa akses User Dashboard
├─ Bisa CRUD persil milik sendiri
├─ Tidak bisa akses Admin Panel
└─ Tidak bisa melihat data pengguna lain
```

**Cara Ubah Role**:

1. Buka halaman Edit Pengguna
2. Pilih Role: Admin atau Guest
3. Klik **Simpan Perubahan**

**Contoh Skenario**:

```
Skenario 1: Promote Guest ke Admin
└─ Edit guest1@persil.test
└─ Ubah role: Guest → Admin
└─ Sekarang guest1@persil.test bisa akses Admin Panel

Skenario 2: Demote Admin ke Guest
└─ Edit admin2@persil.test
└─ Ubah role: Admin → Guest
└─ Sekarang admin2@persil.test hanya bisa akses User Dashboard
```

**Keamanan**:

-   ✅ Admin tidak bisa mengubah role mereka sendiri menjadi Guest
-   ✅ Hanya Admin yang bisa mengubah role

---

### 2. Password Management

**Fitur Password**:

```
Create User:
├─ Password wajib diisi
├─ Minimal 8 karakter
├─ Harus dikonfirmasi
└─ Langsung di-hash dengan bcrypt

Edit User:
├─ Password bersifat opsional
├─ Kosongkan jika tidak ingin ubah
├─ Minimal 8 karakter jika diisi
└─ Harus dikonfirmasi jika diubah
```

**Keamanan Password**:

-   🔐 Password di-hash dengan bcrypt (BCRYPT_ROUNDS=12)
-   🔐 Password tidak pernah disimpan dalam bentuk plain text
-   🔐 Minimal 8 karakter untuk keamanan
-   🔐 Harus dikonfirmasi untuk menghindari typo

---

### 3. Email Validation

**Validasi Email**:

```
Create User:
└─ Email harus unik (tidak boleh duplikat)

Edit User:
└─ Email harus unik (kecuali miliknya sendiri)
```

**Contoh Error**:

```
Skenario: Mencoba buat user dengan email yang sudah ada
Email: admin@persil.test (sudah terdaftar)
Error: Email sudah terdaftar
```

---

## 🔑 Role dan Permission

### Admin Role Permissions

```
✅ Dashboard Access
   └─ Lihat dashboard dengan statistik

✅ User Management
   ├─ List semua pengguna
   ├─ Create pengguna baru
   ├─ View detail pengguna
   ├─ Edit pengguna
   └─ Hapus pengguna

✅ Role Management
   └─ Ubah role pengguna (Admin ↔ Guest)

✅ System Access
   └─ Full akses ke semua fitur Admin Panel
```

### Guest Role Permissions

```
❌ Admin Panel Access
   └─ Tidak bisa akses /admin/*

❌ User Management
   └─ Tidak bisa lihat daftar pengguna

❌ Role Management
   └─ Tidak bisa ubah role

✅ User Dashboard
   ├─ CRUD persil milik sendiri
   ├─ Upload dokumen
   ├─ View statistik persil pribadi
   └─ Logout
```

---

## 🚀 Alur Kerja Admin

### Workflow 1: Onboarding Pengguna Baru

```
1. Admin login ke /admin/users
2. Klik "+ Tambah User Baru"
3. Isi form:
   ├─ Nama: "Rina Wijaya"
   ├─ Email: "rina@example.com"
   ├─ Password: "SecurePass123"
   ├─ Konfirmasi: "SecurePass123"
   └─ Role: "Guest"
4. Klik "Buat User"
5. Notifikasi: "Pengguna berhasil ditambahkan"
6. User baru bisa login dengan email: rina@example.com
```

### Workflow 2: Mengubah Role

```
1. Admin buka /admin/users
2. Cari pengguna: "rina@example.com"
3. Klik "Edit"
4. Ubah role: Guest → Admin
5. Klik "Simpan Perubahan"
6. Notifikasi: "Pengguna berhasil diperbarui"
7. Rina sekarang bisa akses Admin Panel
```

### Workflow 3: Menghapus Pengguna

```
1. Admin buka /admin/users
2. Cari pengguna yang ingin dihapus
3. Klik tombol "Hapus"
4. Confirm dialog muncul
5. Klik "OK" untuk confirm
6. Notifikasi: "Pengguna berhasil dihapus"
7. Semua data pengguna terhapus (cascade)
```

---

## 📊 Statistik dan Monitoring

### Dashboard Stats

```
Total Users Card:
└─ Menampilkan total pengguna: 5

Total Admins Card:
└─ Menampilkan total admin: 2

Total Guests Card:
└─ Menampilkan total guest: 3

Total Persil Card:
└─ Menampilkan total data persil: 12
```

### Recent Activity

```
Recent Users (Tabel):
├─ Nama pengguna
├─ Role (Badge)
└─ Tanggal bergabung

Recent Persil (Tabel):
├─ Kode persil
├─ Pemilik (nama)
└─ Tanggal buat
```

---

## ⚠️ Keamanan dan Best Practice

### ✅ DO (Lakukan)

```
✅ Ganti password admin default setelah setup
✅ Gunakan password yang kuat (8+ karakter)
✅ Jangan share akun admin dengan orang lain
✅ Confirm sebelum hapus pengguna
✅ Monitor aktivitas di dashboard secara berkala
✅ Update data pengguna jika ada perubahan
```

### ❌ DON'T (Jangan Lakukan)

```
❌ Jangan bagikan password admin
❌ Jangan gunakan password yang mudah ditebak
❌ Jangan hapus pengguna tanpa double-check
❌ Jangan lupa logout dari Admin Panel
❌ Jangan klik "Hapus" untuk pengguna yang masih aktif
❌ Jangan ubah role ke Guest jika masih diperlukan akses admin
```

---

## 🆘 Troubleshooting

### Problem: "Tidak bisa akses /admin/dashboard"

```
Solusi:
1. Pastikan sudah login dengan akun admin
2. Cek apakah role adalah "admin"
3. Coba logout dan login kembali
4. Cek URL benar: http://127.0.0.1:8000/admin/dashboard
```

### Problem: "Email sudah terdaftar"

```
Solusi:
1. Gunakan email yang berbeda
2. Jika ingin gunakan email yang sama, edit pengguna lama dulu
3. Periksa pengguna dengan email tersebut sudah ada atau tidak
```

### Problem: "Password tidak cocok"

```
Solusi:
1. Pastikan konfirmasi password sama dengan password
2. Perhatikan kapital dan karakter khusus
3. Gunakan password minimal 8 karakter
```

### Problem: "Pengguna tidak bisa dihapus"

```
Solusi:
1. Mungkin sedang login (coba logout pengguna dulu)
2. Jika akun sendiri, tidak bisa dihapus
3. Refresh halaman dan coba lagi
```

---

## 📞 Kontak Support

Jika ada masalah atau pertanyaan:

```
Admin Panel: /admin/dashboard
User Management: /admin/users
Default Admin: admin@persil.test
```

---

**Last Updated**: December 5, 2025
**Version**: 1.0.0
