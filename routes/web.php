<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuestPersilController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Default Laravel welcome page
Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', 'admin.role'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserManagementController::class);
});

// Guest resource routes (protected by auth)
Route::middleware('auth')->prefix('guest')->name('guest.')->group(function () {
    // Persil routes
    Route::get('/', [GuestPersilController::class, 'index'])->name('persil.index');
    Route::prefix('persil')->name('persil.')->group(function () {
        Route::get('/create', [GuestPersilController::class, 'create'])->name('create');
        Route::post('/', [GuestPersilController::class, 'store'])->name('store');
        Route::get('/{id}', [GuestPersilController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [GuestPersilController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GuestPersilController::class, 'update'])->name('update');
        Route::delete('/{id}', [GuestPersilController::class, 'destroy'])->name('destroy');
    });

    // Other guest resources
    Route::resource('dokumen-persil', \App\Http\Controllers\DokumenPersilController::class);
    Route::post('dokumen-persil/store-multiple', [\App\Http\Controllers\DokumenPersilController::class, 'storeMultiple'])->name('dokumen-persil.store-multiple');
    Route::resource('peta-persil', \App\Http\Controllers\PetaPersilController::class);
    Route::resource('sengketa-persil', \App\Http\Controllers\SengketaPersilController::class);
    Route::resource('jenis-penggunaan', \App\Http\Controllers\JenisPenggunaanController::class);
});

Route::get('/ketua', function () {
    return view('ketua');
});
Route::get('/anggota', function () {
    return view('anggota');
});

Route::get('/anggota2', function () {
    return view('anggota2');
});

Route::resource('products', \App\Http\Controllers\ProductController::class);

// User Management
Route::middleware('auth')->group(function () {
    Route::get('users/bulk-create', [\App\Http\Controllers\BulkUserController::class, 'create'])->name('users.bulk-create');
    Route::post('users/bulk-store', [\App\Http\Controllers\BulkUserController::class, 'store'])->name('users.bulk-store');
    Route::resource('users', \App\Http\Controllers\UserController::class);
});
