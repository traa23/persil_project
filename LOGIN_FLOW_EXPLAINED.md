# 📍 FLOW LOGIN YANG BENAR

## ✅ TAHAP 1: FORM LOGIN

### Ketika User Belum Login

1. **Buka URL**: `http://127.0.0.1:8000/login`
2. **Muncul**: Form login dengan fields email & password
3. **Masukkan**:
    - Email: `guest1@persil.test`
    - Password: `password`
4. **Klik**: Tombol Login

---

## ✅ TAHAP 2: REDIRECT KE GUEST DASHBOARD

Setelah login berhasil:

1. **Sistem Cek Role**

    - Jika role = 'admin' → redirect ke `/admin/dashboard`
    - Jika role = 'guest' → redirect ke `/guest/` ✅

2. **Otomatis Masuk Ke**:

    ```
    http://127.0.0.1:8000/guest/
    ```

3. **Muncul**: Halaman Daftar Persil dengan:
    - Tabel persil lengkap
    - Search bar
    - Pagination
    - Tombol Create, Edit, Detail, Delete
    - **Logout button** di menu (kanan atas)

---

## 🔄 FLOW LENGKAP

```
┌──────────────────────────┐
│ Akses /login             │
│ (Belum login)            │
└───────────┬──────────────┘
            │
            ▼
┌──────────────────────────┐
│ Muncul Form Login        │
│ - Email field            │
│ - Password field         │
│ - Submit button          │
└───────────┬──────────────┘
            │
            ├─ Input email & password
            ▼
┌──────────────────────────┐
│ Submit Form (POST)       │
│ Validasi di server       │
└───────────┬──────────────┘
            │
            ├─ Valid?
            │  ├─ YES → Create session
            │  └─ NO → Show error & stay at /login
            │
            ▼
┌──────────────────────────┐
│ Check Role               │
│ dari database            │
└───────────┬──────────────┘
            │
            ├─ role == 'guest'?
            │  └─ YES
            ▼
┌──────────────────────────┐
│ Redirect ke /guest/      │
│ (Guest Dashboard)        │
└───────────┬──────────────┘
            │
            ▼
┌──────────────────────────┐
│ Muncul Halaman Persil    │
│ - Daftar persil         │
│ - Search bar            │
│ - CRUD buttons          │
│ - Logout button         │
└──────────────────────────┘
```

---

## 🚀 CARA TESTING FLOW LENGKAP

### Test 1: Akses Login Page Tanpa Login

```
1. Buka http://127.0.0.1:8000/login
2. ✅ Muncul form login
```

### Test 2: Login Process

```
1. Masukkan email: guest1@persil.test
2. Masukkan password: password
3. Klik Login
4. ✅ Redirect ke http://127.0.0.1:8000/guest/
```

### Test 3: Akses Login Page Setelah Sudah Login

```
1. Ketika sudah login, buka http://127.0.0.1:8000/login
2. ✅ Auto-redirect ke /guest/ (karena middleware guest)
3. ❌ Form login TIDAK muncul (user sudah authenticated)
```

### Test 4: Logout

```
1. Di halaman guest, klik "Logout (nama-user)"
2. ✅ Kembali ke home page
3. Buka http://127.0.0.1:8000/login
4. ✅ Form login muncul lagi (sudah logout)
```

---

## 💡 PENTING DIPAHAMI

### Apa itu Middleware `guest`?

Middleware `guest` pada route `/login` artinya:

-   **Hanya user yang BELUM login** bisa akses form login
-   **User yang sudah login** otomatis redirect ke dashboard

Ini adalah behavior yang **BENAR** dan **AMAN**.

### Contoh Skenario:

**Skenario 1: User Belum Login**

```
GET /login
→ Middleware guest: Auth::check() = FALSE
→ Lanjut ke controller
→ Tampil form login ✅
```

**Skenario 2: User Sudah Login**

```
GET /login
→ Middleware guest: Auth::check() = TRUE
→ Redirect ke dashboard ✅
→ Form login TIDAK ditampilkan (user sudah login)
```

---

## 🔐 SECURITY BENEFIT

Dengan middleware `guest` di login route:

✅ User yang sudah login tidak bisa "login lagi"
✅ User tidak perlu logout manual sebelum login dengan akun lain
✅ Mencegah session hijacking
✅ Best practice Laravel security

---

## 📋 CHECKLIST

-   [ ] Akses `/login` tanpa login → Form login muncul
-   [ ] Login dengan guest account → Redirect ke `/guest/`
-   [ ] Lihat halaman persil dengan data
-   [ ] Klik logout → Kembali ke home
-   [ ] Akses `/login` lagi → Form login muncul

---

## 🎯 KESIMPULAN

Flow login sudah BENAR:

1. ✅ Form login di `/login` (untuk user belum login)
2. ✅ Redirect ke guest dashboard (setelah login sukses)
3. ✅ Logout button tersedia di halaman guest
4. ✅ Tidak bisa akses form login ketika sudah login

**SISTEM SUDAH SESUAI BEST PRACTICE! 🎉**
