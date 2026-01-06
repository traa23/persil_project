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

    // === DATA MASTER ===
    // Warga Management
    Route::get('/warga', [AdminController::class, 'wargaList'])->name('warga.list');
    Route::get('/warga/create', [AdminController::class, 'wargaCreate'])->name('warga.create');
    Route::post('/warga', [AdminController::class, 'wargaStore'])->name('warga.store');
    Route::get('/warga/{id}', [AdminController::class, 'wargaDetail'])->name('warga.detail');
    Route::get('/warga/{id}/edit', [AdminController::class, 'wargaEdit'])->name('warga.edit');
    Route::put('/warga/{id}', [AdminController::class, 'wargaUpdate'])->name('warga.update');
    Route::delete('/warga/{id}', [AdminController::class, 'wargaDelete'])->name('warga.delete');

    // Persil Management
    Route::get('/persil', [AdminController::class, 'persilList'])->name('persil.list');
    Route::get('/persil/create', [AdminController::class, 'persilCreate'])->name('persil.create');
    Route::post('/persil', [AdminController::class, 'persilStore'])->name('persil.store');
    Route::get('/persil/{id}', [AdminController::class, 'persilDetail'])->name('persil.detail');
    Route::get('/persil/{id}/edit', [AdminController::class, 'persilEdit'])->name('persil.edit');
    Route::put('/persil/{id}', [AdminController::class, 'persilUpdate'])->name('persil.update');
    Route::delete('/persil/{id}', [AdminController::class, 'persilDelete'])->name('persil.delete');

    // Foto Persil
    Route::delete('/foto/{id}', [AdminController::class, 'fotoPersilDelete'])->name('foto.delete');

    // === PERTANAHAN ===
    // Dokumen Persil
    Route::get('/dokumen', [AdminController::class, 'dokumenList'])->name('dokumen.list');
    Route::get('/dokumen/{id}', [AdminController::class, 'dokumenDetail'])->name('dokumen.detail');
    Route::get('/persil/{persilId}/dokumen/create', [PersilDetailController::class, 'dokumenAdd'])->name('dokumen.create');
    Route::post('/persil/{persilId}/dokumen', [PersilDetailController::class, 'dokumenStore'])->name('dokumen.store');
    Route::get('/dokumen/{dokumenId}/edit', [PersilDetailController::class, 'dokumenEdit'])->name('dokumen.edit');
    Route::put('/dokumen/{dokumenId}', [PersilDetailController::class, 'dokumenUpdate'])->name('dokumen.update');
    Route::delete('/dokumen/{dokumenId}', [PersilDetailController::class, 'dokumenDelete'])->name('dokumen.delete');

    // Peta Persil
    Route::get('/peta', [AdminController::class, 'petaList'])->name('peta.list');
    Route::get('/peta/{id}', [AdminController::class, 'petaDetail'])->name('peta.detail');
    Route::get('/persil/{persilId}/peta/create', [PersilDetailController::class, 'petaAdd'])->name('peta.create');
    Route::post('/persil/{persilId}/peta', [PersilDetailController::class, 'petaStore'])->name('peta.store');
    Route::get('/peta/{petaId}/edit', [PersilDetailController::class, 'petaEdit'])->name('peta.edit');
    Route::put('/peta/{petaId}', [PersilDetailController::class, 'petaUpdate'])->name('peta.update');
    Route::delete('/peta/{petaId}', [PersilDetailController::class, 'petaDelete'])->name('peta.delete');

    // Sengketa Persil
    Route::get('/sengketa', [AdminController::class, 'sengketaList'])->name('sengketa.list');
    Route::get('/sengketa/{id}', [AdminController::class, 'sengketaDetail'])->name('sengketa.detail');
    Route::get('/persil/{persilId}/sengketa/create', [PersilDetailController::class, 'sengketaAdd'])->name('sengketa.create');
    Route::post('/persil/{persilId}/sengketa', [PersilDetailController::class, 'sengketaStore'])->name('sengketa.store');
    Route::get('/sengketa/{sengketaId}/edit', [PersilDetailController::class, 'sengketaEdit'])->name('sengketa.edit');
    Route::put('/sengketa/{sengketaId}', [PersilDetailController::class, 'sengketaUpdate'])->name('sengketa.update');
    Route::delete('/sengketa/{sengketaId}', [PersilDetailController::class, 'sengketaDelete'])->name('sengketa.delete');

    // Jenis Penggunaan
    Route::get('/jenis-penggunaan', [AdminController::class, 'jenisPenggunaanList'])->name('jenis-penggunaan.list');
    Route::get('/jenis-penggunaan/create', [AdminController::class, 'jenisPenggunaanCreate'])->name('jenis-penggunaan.create');
    Route::post('/jenis-penggunaan', [AdminController::class, 'jenisPenggunaanStore'])->name('jenis-penggunaan.store');
    Route::get('/jenis-penggunaan/{id}', [AdminController::class, 'jenisPenggunaanDetail'])->name('jenis-penggunaan.detail');
    Route::get('/jenis-penggunaan/{id}/edit', [AdminController::class, 'jenisPenggunaanEdit'])->name('jenis-penggunaan.edit');
    Route::put('/jenis-penggunaan/{id}', [AdminController::class, 'jenisPenggunaanUpdate'])->name('jenis-penggunaan.update');
    Route::delete('/jenis-penggunaan/{id}', [AdminController::class, 'jenisPenggunaanDelete'])->name('jenis-penggunaan.delete');

    // === USER MANAGEMENT ===
    Route::get('/user', [AdminController::class, 'userList'])->name('user.list');
    Route::get('/user/create', [AdminController::class, 'userCreate'])->name('user.create');
    Route::post('/user', [AdminController::class, 'userStore'])->name('user.store');
    Route::get('/user/{id}/edit', [AdminController::class, 'userEdit'])->name('user.edit');
    Route::put('/user/{id}', [AdminController::class, 'userUpdate'])->name('user.update');
    Route::delete('/user/{id}', [AdminController::class, 'userDelete'])->name('user.delete');

    // === TAMBAH DATA API (for User Management) ===
    Route::post('/user/get-or-create-warga', [AdminController::class, 'getOrCreateWargaForUser'])->name('user.get-or-create-warga');
    Route::get('/user/get-persil-by-warga', [AdminController::class, 'getPersilByWarga'])->name('user.get-persil-by-warga');
});

// Super Admin Routes (same features as Admin)
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // === DATA MASTER ===
    // Warga Management
    Route::get('/warga', [AdminController::class, 'wargaList'])->name('warga.list');
    Route::get('/warga/create', [AdminController::class, 'wargaCreate'])->name('warga.create');
    Route::post('/warga', [AdminController::class, 'wargaStore'])->name('warga.store');
    Route::get('/warga/{id}', [AdminController::class, 'wargaDetail'])->name('warga.detail');
    Route::get('/warga/{id}/edit', [AdminController::class, 'wargaEdit'])->name('warga.edit');
    Route::put('/warga/{id}', [AdminController::class, 'wargaUpdate'])->name('warga.update');
    Route::delete('/warga/{id}', [AdminController::class, 'wargaDelete'])->name('warga.delete');

    // Persil Management
    Route::get('/persil', [AdminController::class, 'persilList'])->name('persil.list');
    Route::get('/persil/create', [AdminController::class, 'persilCreate'])->name('persil.create');
    Route::post('/persil', [AdminController::class, 'persilStore'])->name('persil.store');
    Route::get('/persil/{id}', [AdminController::class, 'persilDetail'])->name('persil.detail');
    Route::get('/persil/{id}/edit', [AdminController::class, 'persilEdit'])->name('persil.edit');
    Route::put('/persil/{id}', [AdminController::class, 'persilUpdate'])->name('persil.update');
    Route::delete('/persil/{id}', [AdminController::class, 'persilDelete'])->name('persil.delete');

    // Foto Persil
    Route::delete('/foto/{id}', [AdminController::class, 'fotoPersilDelete'])->name('foto.delete');

    // === PERTANAHAN ===
    // Dokumen Persil
    Route::get('/dokumen', [AdminController::class, 'dokumenList'])->name('dokumen.list');
    Route::get('/dokumen/{id}', [AdminController::class, 'dokumenDetail'])->name('dokumen.detail');
    Route::get('/persil/{persilId}/dokumen/create', [PersilDetailController::class, 'dokumenAdd'])->name('dokumen.create');
    Route::post('/persil/{persilId}/dokumen', [PersilDetailController::class, 'dokumenStore'])->name('dokumen.store');
    Route::get('/dokumen/{dokumenId}/edit', [PersilDetailController::class, 'dokumenEdit'])->name('dokumen.edit');
    Route::put('/dokumen/{dokumenId}', [PersilDetailController::class, 'dokumenUpdate'])->name('dokumen.update');
    Route::delete('/dokumen/{dokumenId}', [PersilDetailController::class, 'dokumenDelete'])->name('dokumen.delete');

    // Peta Persil
    Route::get('/peta', [AdminController::class, 'petaList'])->name('peta.list');
    Route::get('/peta/{id}', [AdminController::class, 'petaDetail'])->name('peta.detail');
    Route::get('/persil/{persilId}/peta/create', [PersilDetailController::class, 'petaAdd'])->name('peta.create');
    Route::post('/persil/{persilId}/peta', [PersilDetailController::class, 'petaStore'])->name('peta.store');
    Route::get('/peta/{petaId}/edit', [PersilDetailController::class, 'petaEdit'])->name('peta.edit');
    Route::put('/peta/{petaId}', [PersilDetailController::class, 'petaUpdate'])->name('peta.update');
    Route::delete('/peta/{petaId}', [PersilDetailController::class, 'petaDelete'])->name('peta.delete');

    // Sengketa Persil
    Route::get('/sengketa', [AdminController::class, 'sengketaList'])->name('sengketa.list');
    Route::get('/sengketa/{id}', [AdminController::class, 'sengketaDetail'])->name('sengketa.detail');
    Route::get('/persil/{persilId}/sengketa/create', [PersilDetailController::class, 'sengketaAdd'])->name('sengketa.create');
    Route::post('/persil/{persilId}/sengketa', [PersilDetailController::class, 'sengketaStore'])->name('sengketa.store');
    Route::get('/sengketa/{sengketaId}/edit', [PersilDetailController::class, 'sengketaEdit'])->name('sengketa.edit');
    Route::put('/sengketa/{sengketaId}', [PersilDetailController::class, 'sengketaUpdate'])->name('sengketa.update');
    Route::delete('/sengketa/{sengketaId}', [PersilDetailController::class, 'sengketaDelete'])->name('sengketa.delete');

    // Jenis Penggunaan
    Route::get('/jenis-penggunaan', [AdminController::class, 'jenisPenggunaanList'])->name('jenis-penggunaan.list');
    Route::get('/jenis-penggunaan/create', [AdminController::class, 'jenisPenggunaanCreate'])->name('jenis-penggunaan.create');
    Route::post('/jenis-penggunaan', [AdminController::class, 'jenisPenggunaanStore'])->name('jenis-penggunaan.store');
    Route::get('/jenis-penggunaan/{id}', [AdminController::class, 'jenisPenggunaanDetail'])->name('jenis-penggunaan.detail');
    Route::get('/jenis-penggunaan/{id}/edit', [AdminController::class, 'jenisPenggunaanEdit'])->name('jenis-penggunaan.edit');
    Route::put('/jenis-penggunaan/{id}', [AdminController::class, 'jenisPenggunaanUpdate'])->name('jenis-penggunaan.update');
    Route::delete('/jenis-penggunaan/{id}', [AdminController::class, 'jenisPenggunaanDelete'])->name('jenis-penggunaan.delete');

    // === USER MANAGEMENT ===
    Route::get('/user', [AdminController::class, 'userList'])->name('user.list');
    Route::get('/user/create', [AdminController::class, 'userCreate'])->name('user.create');
    Route::post('/user', [AdminController::class, 'userStore'])->name('user.store');
    Route::get('/user/{id}/edit', [AdminController::class, 'userEdit'])->name('user.edit');
    Route::put('/user/{id}', [AdminController::class, 'userUpdate'])->name('user.update');
    Route::delete('/user/{id}', [AdminController::class, 'userDelete'])->name('user.delete');

    // === TAMBAH DATA API (for User Management) ===
    Route::post('/user/get-or-create-warga', [AdminController::class, 'getOrCreateWargaForUser'])->name('user.get-or-create-warga');
    Route::get('/user/get-persil-by-warga', [AdminController::class, 'getPersilByWarga'])->name('user.get-persil-by-warga');
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
