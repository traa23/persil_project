<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\PersilDetailController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Debug Database Route (tanpa auth)
Route::get('/debug/database', [DebugController::class, 'database'])->name('debug.database');

// Welcome - Default route
Route::get('/', function () {
    // Jika sudah login, arahkan sesuai role
    if (auth()->check()) {
        $role = auth()->user()->role;
        return match ($role) {
            'admin'       => redirect()->route('admin.dashboard'),
            'super_admin' => redirect()->route('super-admin.dashboard'),
            'user'        => redirect()->route('user.dashboard'),
            default       => redirect()->route('login'),
        };
    }
    // Jika belum login, arahkan ke form login
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Persil Management
    Route::get('/persil', [AdminController::class, 'persilList'])->name('persil.list');
    Route::get('/persil/create', [AdminController::class, 'persilCreate'])->name('persil.create');
    Route::post('/persil', [AdminController::class, 'persilStore'])->name('persil.store');
    Route::get('/persil/{id}', [AdminController::class, 'persilDetail'])->name('persil.detail');
    Route::get('/persil/{id}/edit', [AdminController::class, 'persilEdit'])->name('persil.edit');
    Route::put('/persil/{id}', [AdminController::class, 'persilUpdate'])->name('persil.update');
    Route::delete('/persil/{id}', [AdminController::class, 'persilDelete'])->name('persil.delete');

    // Foto Persil
    Route::delete('/foto/{id}', [AdminController::class, 'fotoPersílDelete'])->name('foto.delete');

    // Dokumen Persil
    Route::get('/persil/{persilId}/dokumen/create', [PersilDetailController::class, 'dokumenAdd'])->name('dokumen.create');
    Route::post('/persil/{persilId}/dokumen', [PersilDetailController::class, 'dokumenStore'])->name('dokumen.store');
    Route::delete('/dokumen/{dokumenId}', [PersilDetailController::class, 'dokumenDelete'])->name('dokumen.delete');

    // Peta Persil
    Route::get('/persil/{persilId}/peta/create', [PersilDetailController::class, 'petaAdd'])->name('peta.create');
    Route::post('/persil/{persilId}/peta', [PersilDetailController::class, 'petaStore'])->name('peta.store');

    // Sengketa Persil
    Route::get('/persil/{persilId}/sengketa/create', [PersilDetailController::class, 'sengketaAdd'])->name('sengketa.create');
    Route::post('/persil/{persilId}/sengketa', [PersilDetailController::class, 'sengketaStore'])->name('sengketa.store');
    Route::get('/sengketa/{sengketaId}/edit', [PersilDetailController::class, 'sengketaEdit'])->name('sengketa.edit');
    Route::put('/sengketa/{sengketaId}', [PersilDetailController::class, 'sengketaUpdate'])->name('sengketa.update');
    Route::delete('/sengketa/{sengketaId}', [PersilDetailController::class, 'sengketaDelete'])->name('sengketa.delete');

    // Warga Management
    Route::get('/warga', [AdminController::class, 'wargaList'])->name('warga.list');
    Route::get('/warga/create', [AdminController::class, 'wargaCreate'])->name('warga.create');
    Route::post('/warga', [AdminController::class, 'wargaStore'])->name('warga.store');
    Route::get('/warga/{id}/edit', [AdminController::class, 'wargaEdit'])->name('warga.edit');
    Route::put('/warga/{id}', [AdminController::class, 'wargaUpdate'])->name('warga.update');
    Route::delete('/warga/{id}', [AdminController::class, 'wargaDelete'])->name('warga.delete');

    // User Management (Admin + User)
    Route::get('/user/create', [AdminController::class, 'userCreate'])->name('user.create');
    Route::post('/user', [AdminController::class, 'userStore'])->name('user.store');
});

// Super Admin Routes (same as Admin)
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // Persil Management
    Route::get('/persil', [AdminController::class, 'persilList'])->name('persil.list');
    Route::get('/persil/create', [AdminController::class, 'persilCreate'])->name('persil.create');
    Route::post('/persil', [AdminController::class, 'persilStore'])->name('persil.store');
    Route::get('/persil/{id}', [AdminController::class, 'persilDetail'])->name('persil.detail');
    Route::get('/persil/{id}/edit', [AdminController::class, 'persilEdit'])->name('persil.edit');
    Route::put('/persil/{id}', [AdminController::class, 'persilUpdate'])->name('persil.update');
    Route::delete('/persil/{id}', [AdminController::class, 'persilDelete'])->name('persil.delete');

    // Foto Persil
    Route::delete('/foto/{id}', [AdminController::class, 'fotoPersílDelete'])->name('foto.delete');

    // Dokumen Persil
    Route::get('/persil/{persilId}/dokumen/create', [PersilDetailController::class, 'dokumenAdd'])->name('dokumen.create');
    Route::post('/persil/{persilId}/dokumen', [PersilDetailController::class, 'dokumenStore'])->name('dokumen.store');
    Route::delete('/dokumen/{dokumenId}', [PersilDetailController::class, 'dokumenDelete'])->name('dokumen.delete');

    // Peta Persil
    Route::get('/persil/{persilId}/peta/create', [PersilDetailController::class, 'petaAdd'])->name('peta.create');
    Route::post('/persil/{persilId}/peta', [PersilDetailController::class, 'petaStore'])->name('peta.store');

    // Sengketa Persil
    Route::get('/persil/{persilId}/sengketa/create', [PersilDetailController::class, 'sengketaAdd'])->name('sengketa.create');
    Route::post('/persil/{persilId}/sengketa', [PersilDetailController::class, 'sengketaStore'])->name('sengketa.store');
    Route::get('/sengketa/{sengketaId}/edit', [PersilDetailController::class, 'sengketaEdit'])->name('sengketa.edit');
    Route::put('/sengketa/{sengketaId}', [PersilDetailController::class, 'sengketaUpdate'])->name('sengketa.update');
    Route::delete('/sengketa/{sengketaId}', [PersilDetailController::class, 'sengketaDelete'])->name('sengketa.delete');

    // Warga Management
    Route::get('/warga', [AdminController::class, 'wargaList'])->name('warga.list');
    Route::get('/warga/create', [AdminController::class, 'wargaCreate'])->name('warga.create');
    Route::post('/warga', [AdminController::class, 'wargaStore'])->name('warga.store');
    Route::get('/warga/{id}/edit', [AdminController::class, 'wargaEdit'])->name('warga.edit');
    Route::put('/warga/{id}', [AdminController::class, 'wargaUpdate'])->name('warga.update');
    Route::delete('/warga/{id}', [AdminController::class, 'wargaDelete'])->name('warga.delete');

    // User Management (Admin + User)
    Route::get('/user/create', [AdminController::class, 'userCreate'])->name('user.create');
    Route::post('/user', [AdminController::class, 'userStore'])->name('user.store');
});

// User Routes (view-only access to their own data)
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Persil (read-only)
    Route::get('/persil', [UserController::class, 'persilList'])->name('persil.list');
    Route::get('/persil/{id}', [UserController::class, 'persilDetail'])->name('persil.detail');

    // Dokumen Persil (read-only)
    Route::get('/dokumen', [UserController::class, 'dokumenList'])->name('dokumen.list');
    Route::get('/dokumen/{id}', [UserController::class, 'dokumenDetail'])->name('dokumen.detail');

    // Peta Persil (read-only)
    Route::get('/peta', [UserController::class, 'petaList'])->name('peta.list');
    Route::get('/peta/{id}', [UserController::class, 'petaDetail'])->name('peta.detail');

    // Sengketa Persil (read-only)
    Route::get('/sengketa', [UserController::class, 'sengketaList'])->name('sengketa.list');
    Route::get('/sengketa/{id}', [UserController::class, 'sengketaDetail'])->name('sengketa.detail');

    // Jenis Penggunaan (read-only reference)
    Route::get('/jenis-penggunaan', [UserController::class, 'jenisPenggunaanList'])->name('jenis-penggunaan.list');
});
