# 🎯 CARA MENGGUNAKAN SISTEM PERSIL

## TAHAP 1️⃣: AKSES FORM LOGIN

### Jika Anda Belum Login Sebelumnya:

1. **Buka browser**
2. **Ketik URL**: `http://127.0.0.1:8000/login`
3. ✅ **Muncul**: Form login dengan 2 field
    - Email
    - Password

---

## TAHAP 2️⃣: LOGIN

1. **Masukkan Email**:

    ```
    guest1@persil.test
    ```

2. **Masukkan Password**:

    ```
    password
    ```

3. **Klik Tombol**: "Login"

---

## TAHAP 3️⃣: OTOMATIS MASUK KE GUEST DASHBOARD

Setelah klik login, sistem otomatis membawa Anda ke:

```
http://127.0.0.1:8000/guest/
```

Di halaman ini Anda bisa:

-   ✅ Lihat daftar persil
-   ✅ Search persil
-   ✅ Create persil baru
-   ✅ Edit persil
-   ✅ Lihat detail persil
-   ✅ Delete persil
-   ✅ Logout (tombol di menu kanan atas)

---

## 📝 AKUN LOGIN YANG TERSEDIA

### Untuk Test CRUD Persil:

```
Email:    guest1@persil.test
Password: password
```

### Untuk Test Admin Dashboard:

```
Email:    admin@persil.test
Password: password
```

---

## ❓ PERTANYAAN UMUM

### Q: Kenapa ketika login langsung ke halaman guest, tidak di form login?

**A**: Itu BENAR! Setelah login sukses, sistem otomatis membawa Anda ke dashboard sesuai role Anda:

-   Admin → `/admin/dashboard`
-   Guest → `/guest/` (halaman persil)

---

### Q: Bagaimana cara kembali ke form login?

**A**:

1. Cari tombol **"Logout"** di halaman guest (menu atas)
2. Klik logout
3. Kembali ke home page
4. Buka `/login` lagi
5. Form login muncul

---

### Q: Form login tidak muncul padahal buka `/login`?

**A**: Itu berarti Anda sudah login!

-   Sistem otomatis redirect ke dashboard
-   Klik logout terlebih dahulu
-   Baru buka `/login` lagi

---

## 🚀 QUICK START (RINGKAS)

```
1. Buka: http://127.0.0.1:8000/login
2. Masukkan: guest1@persil.test / password
3. Klik: Login
4. ✅ Masuk ke halaman persil
5. Gunakan: CRUD sesuai kebutuhan
6. Logout: Klik tombol Logout di menu
```

---

## ✨ FITUR YANG SUDAH SIAP

✅ Form Login
✅ Login Validation
✅ Role-Based Dashboard
✅ Guest CRUD (Create, Read, Update, Delete)
✅ Search Persil
✅ Pagination
✅ File Upload
✅ Logout Function

---

**SEKARANG MULAI TEST! 🎊**
