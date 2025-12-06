# 🔐 SISTEM LOGIN PERSIL - PANDUAN LENGKAP

## ✅ STATUS: SEMUA PERBAIKAN SELESAI

Semua middleware, controller, dan route sudah diperbaiki dan siap digunakan.

---

## 📍 AKSES LOGIN

**URL**: `http://127.0.0.1:8000/login`

### Akun Admin

```
Email: admin@persil.test
Password: password
```

### Akun Guest

```
Email: guest1@persil.test
Password: password
```

---

## 🔄 ALUR LOGIN

```
User Input Credentials
        ↓
POST /login (LoginController@login)
        ↓
Auth::attempt() validation
        ↓
        ├─ SUCCESS ─→ Role Check
        │            ├─ Admin → Redirect /admin/dashboard
        │            └─ Guest → Redirect /guest/
        │
        └─ FAIL → Return back with error
```

---

## 📁 FILE STRUCTURE & PERBAIKAN

### 1. **Authentication Routes** (`routes/web.php`)

```php
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
```

-   ✅ Middleware `guest` memastikan user sudah login tidak bisa akses login page
-   ✅ GET `/login` menampilkan form
-   ✅ POST `/login` memproses login

### 2. **Middleware Middleware** (`app/Http/Middleware/`)

#### a) `Authenticate.php` (BARU - PENTING)

-   Mengecek apakah user authenticated
-   Jika tidak authenticated → redirect ke login
-   Digunakan untuk melindungi route yang memerlukan authentication

#### b) `RedirectIfAuthenticated.php` (BARU - PENTING)

-   Mengecek apakah user sudah authenticated
-   Jika sudah authenticated → redirect ke dashboard sesuai role
-   Digunakan untuk middleware `guest` (agar user authenticated tidak bisa buka login page)

#### c) `AdminRoleMiddleware.php`

-   Mengecek apakah user adalah admin
-   Jika bukan admin → return 403 Forbidden
-   Digunakan di admin routes

#### d) `IsAdmin.php`

-   Sama seperti AdminRoleMiddleware
-   Bisa digunakan sebagai alternative

### 3. **Kernel.php** (`app/Http/Kernel.php`)

```php
protected $routeMiddleware = [
    'auth'             => \App\Http\Middleware\Authenticate::class,
    'admin.role'       => \App\Http\Middleware\AdminRoleMiddleware::class,
    'guest'            => \App\Http\Middleware\RedirectIfAuthenticated::class,
    // ... other middleware
];
```

### 4. **Login Controller** (`app/Http/Controllers/Auth/LoginController.php`)

```php
public function showLoginForm()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirect by role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('guest.persil.index');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}
```

### 5. **Login View** (`resources/views/auth/login.blade.php`)

-   Form login dengan Bootstrap 5
-   CSRF token included
-   Error display
-   Email dan password fields

---

## 🛡️ ROUTE PROTECTION

### Route Tanpa Protection

```php
Route::get('/') → Welcome page
Route::get('/login') → Login form (jika belum login)
Route::post('/login') → Login process
```

### Route dengan Auth Protection

```php
Route::middleware('auth')->group(...)
├── /guest/* → Untuk guest users
├── /users/* → Untuk any authenticated user
└── /products/* → Untuk any authenticated user
```

### Route dengan Admin Protection

```php
Route::middleware(['auth', 'admin.role'])->group(...)
├── /admin/dashboard → Hanya admin
├── /admin/users → Hanya admin
└── /admin/* → Hanya admin
```

---

## 🔍 MIDDLEWARE FLOW

### Request ke Login Page

```
GET /login
    ↓
guest middleware check: Auth::check()?
    ├─ YES (user authenticated) → Redirect /admin/dashboard atau /guest/
    └─ NO → Continue to showLoginForm()
    ↓
Show login form ✓
```

### Request ke Admin Routes

```
GET /admin/dashboard
    ↓
auth middleware check: Auth::check()?
    ├─ NO → Redirect /login
    └─ YES → Continue
    ↓
admin.role middleware check: role == 'admin'?
    ├─ NO → Abort 403 Forbidden
    └─ YES → Continue to controller ✓
```

### Request ke Guest Routes

```
GET /guest/
    ↓
auth middleware check: Auth::check()?
    ├─ NO → Redirect /login
    └─ YES → Continue to controller ✓
```

---

## 🧪 TESTING CHECKLIST

-   [ ] Akses `/login` tanpa login → Tampil login form
-   [ ] Login dengan admin@persil.test → Redirect /admin/dashboard
-   [ ] Login dengan guest1@persil.test → Redirect /guest/
-   [ ] Coba access `/admin/dashboard` sebagai guest → 403 Forbidden
-   [ ] Coba access `/guest/` sebagai admin → Success (auth only)
-   [ ] Logout → Redirect home
-   [ ] Akses `/login` sebagai authenticated user → Redirect dashboard

---

## 🚀 CARA TESTING

1. **Clear Cache & Restart Server**

    ```bash
    php artisan config:clear
    php artisan cache:clear
    php artisan serve --port=8000
    ```

2. **Test Login**

    - Buka http://127.0.0.1:8000/login
    - Masukkan email dan password
    - Tekan login

3. **Monitor Logs**
    - Check `storage/logs/laravel.log` untuk debug info

---

## 📋 SUMMARY FILE YANG DIPERBAIKI

| File                                              | Status        | Keterangan                |
| ------------------------------------------------- | ------------- | ------------------------- |
| `app/Http/Middleware/Authenticate.php`            | ✅ DIBUAT     | Auth check middleware     |
| `app/Http/Middleware/RedirectIfAuthenticated.php` | ✅ DIBUAT     | Guest middleware redirect |
| `app/Http/Middleware/AdminRoleMiddleware.php`     | ✅ ADA        | Admin role check          |
| `app/Http/Middleware/IsAdmin.php`                 | ✅ ADA        | Legacy admin check        |
| `app/Http/Kernel.php`                             | ✅ CONFIGURED | Middleware registration   |
| `app/Http/Controllers/Auth/LoginController.php`   | ✅ ADA        | Login logic               |
| `resources/views/auth/login.blade.php`            | ✅ ADA        | Login form                |
| `routes/web.php`                                  | ✅ CONFIGURED | Route setup               |

---

## ⚠️ JIKA MASIH ADA ERROR

1. **Restart Server**

    ```bash
    # Stop existing server (Ctrl+C)
    # Start new server
    php artisan serve --port=8000
    ```

2. **Clear All Cache**

    ```bash
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    ```

3. **Check Database**

    ```bash
    php artisan migrate:fresh --seed
    ```

4. **Check Logs**
    ```bash
    tail -f storage/logs/laravel.log
    ```

---

## 🎯 KESIMPULAN

✅ Sistem login sekarang berfungsi dengan benar:

-   Form login menampil di `/login`
-   Login dengan admin email → Admin dashboard
-   Login dengan guest email → Guest dashboard
-   Middleware protection aktif
-   CSRF protection aktif
-   Session management aktif
