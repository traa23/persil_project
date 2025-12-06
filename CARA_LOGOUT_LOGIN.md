# 🚀 CARA AKSES FORM LOGIN - LANGKAH DEMI LANGKAH

## ✅ JIKA ANDA SUDAH LOGIN SEBELUMNYA

Jika form login tidak muncul saat akses `/login`, itu berarti **Anda masih login**. Ikuti langkah di bawah untuk logout terlebih dahulu:

### Langkah 1: Buka Home Page

```
Buka: http://127.0.0.1:8000
atau
Buka: http://127.0.0.1:8000/
```

### Langkah 2: Klik Tombol "Logout"

Di halaman home (kanan atas), Anda akan melihat tombol **"Logout"**

-   Klik tombol Logout

### Langkah 3: Kembali ke Home

Setelah logout, Anda akan kembali ke home page

-   Sekarang Anda akan melihat tombol **"Log in"** (bukan Logout)

### Langkah 4: Klik "Log in" atau Buka `/login`

-   Klik tombol "Log in" di halaman home, ATAU
-   Ketik di URL: `http://127.0.0.1:8000/login`

### Langkah 5: ✅ Form Login Muncul

Sekarang form login akan muncul dengan fields:

-   Email
-   Password
-   Tombol Login

---

## 📋 FLOW DIAGRAM

```
┌─────────────────────┐
│ Home Page (/)       │
│ - Tombol Logout     │
└────────┬────────────┘
         │
         │ Klik Logout
         ▼
┌─────────────────────┐
│ Auto Redirect Home  │
│ - Tombol Log in     │
└────────┬────────────┘
         │
         │ Klik "Log in" atau Buka /login
         ▼
┌─────────────────────┐
│ Form Login ✅       │
│ - Email field       │
│ - Password field    │
│ - Login button      │
└────────┬────────────┘
         │
         │ Masukkan credentials & klik Login
         ▼
┌─────────────────────┐
│ Persil Dashboard    │
│ - Daftar persil     │
│ - CRUD buttons      │
│ - Logout button     │
└─────────────────────┘
```

---

## 🔐 AKUN UNTUK LOGIN

```
Email:    guest1@persil.test
Password: password
```

---

## ❓ TROUBLESHOOTING

### Q: Saya di home page, tapi tidak ada tombol logout?

**A**: Kemungkinan:

1. Browser belum di-refresh
2. Session sudah expired
3. Coba refresh page (F5 atau Ctrl+R)

### Q: Saya klik logout tapi tetap login?

**A**:

1. Buka Developer Tools (F12)
2. Buka Console
3. Ketik: `localStorage.clear()` dan Enter
4. Refresh page

### Q: Form login masih tidak muncul?

**A**:

1. Clear browser cache (Ctrl+Shift+Delete)
2. Clear Laravel cache: `php artisan optimize:clear`
3. Restart server
4. Coba lagi

---

## ✨ FLOW YANG BENAR

✅ **Jika Logout**: Akses `/login` → Form login muncul
✅ **Jika Login**: Akses `/login` → Auto redirect ke dashboard
✅ **Dari Home**: Klik "Log in" → Form login muncul
✅ **Dari Dashboard**: Klik "Logout" → Home page dengan login button

---

**SEKARANG COBA IKUTI LANGKAH DI ATAS! 🎊**
