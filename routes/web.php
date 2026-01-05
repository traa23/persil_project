<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PersilDetailController;
use Illuminate\Support\Facades\Route;

// Welcome
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('guest.dashboard');
    }
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

    // Guest User Management
    Route::get('/guest', [AdminController::class, 'guestList'])->name('guest.list');
    Route::get('/guest/create', [AdminController::class, 'guestCreate'])->name('guest.create');
    Route::post('/guest', [AdminController::class, 'guestStore'])->name('guest.store');
    Route::get('/guest/{id}/edit', [AdminController::class, 'guestEdit'])->name('guest.edit');
    Route::put('/guest/{id}', [AdminController::class, 'guestUpdate'])->name('guest.update');
    Route::delete('/guest/{id}', [AdminController::class, 'guestDelete'])->name('guest.delete');

    // User Management (Admin + Guest)
    Route::get('/user/create', [AdminController::class, 'userCreate'])->name('user.create');
    Route::post('/user', [AdminController::class, 'userStore'])->name('user.store');
});

// Guest Routes
Route::middleware(['auth', 'role:guest'])->prefix('guest')->name('guest.')->group(function () {
    Route::get('/dashboard', [GuestController::class, 'dashboard'])->name('dashboard');
    Route::get('/persil/{id}', [GuestController::class, 'persilDetail'])->name('persil.detail');
});
