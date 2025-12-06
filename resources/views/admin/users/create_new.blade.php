@extends('layouts.admin')

@section('title', 'Tambah User Baru')

@section('content')
<section id="banner" class="style2">
    <div class="inner">
        <header class="major">
            <h1><i class="fas fa-user-plus"></i> Tambah User Baru</h1>
        </header>
        <div class="content">
            <p>Buat akun pengguna baru untuk sistem</p>
        </div>
    </div>
</section>

<!-- Form Create User -->
<section id="three">
    <div class="inner container">
        <div style="max-width: 600px; margin: 0 auto;">
            @if($errors->any())
                <div class="alert-error">
                    <i class="fas fa-times-circle"></i>
                    <div>
                        <strong>Terdapat Kesalahan:</strong>
                        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="card">
                <h2 style="margin-top: 0;"><i class="fas fa-file-alt"></i> Informasi Pengguna</h2>

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <!-- Name Field -->
                    <div style="margin-bottom: 20px;">
                        <label for="name" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                            <i class="fas fa-user"></i> Nama Lengkap *
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >
                        @error('name')
                            <small style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div style="margin-bottom: 20px;">
                        <label for="email" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                            <i class="fas fa-envelope"></i> Email *
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@example.com"
                            required
                        >
                        @error('email')
                            <small style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div style="margin-bottom: 20px;">
                        <label for="password" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                            <i class="fas fa-lock"></i> Password (min. 8 karakter) *
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >
                        @error('password')
                            <small style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password Confirmation Field -->
                    <div style="margin-bottom: 20px;">
                        <label for="password_confirmation" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                            <i class="fas fa-lock"></i> Konfirmasi Password *
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                        >
                    </div>

                    <!-- Role Field -->
                    <div style="margin-bottom: 30px;">
                        <label for="role" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                            <i class="fas fa-key"></i> Role *
                        </label>
                        <select id="role" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                👑 Admin (Akses Penuh)
                            </option>
                            <option value="guest" {{ old('role') === 'guest' ? 'selected' : '' }}>
                                👤 Guest (Akses Terbatas)
                            </option>
                        </select>
                        @error('role')
                            <small style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div style="display: flex; gap: 12px;">
                        <button type="submit" class="btn-success" style="flex: 1; cursor: pointer;">
                            <i class="fas fa-check"></i> Buat User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="flex: 1; text-align: center; text-decoration: none;">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Help Text -->
            <div class="card" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.05) 0%, rgba(41, 128, 185, 0.05) 100%); margin-top: 20px;">
                <h3 style="margin-top: 0; color: #2c3e50;"><i class="fas fa-info-circle"></i> Informasi Penting</h3>
                <ul style="margin: 0; padding-left: 20px; color: #7f8c8d; font-size: 14px;">
                    <li>Password harus minimal 8 karakter</li>
                    <li>Email harus unik dan belum terdaftar</li>
                    <li><strong>Admin:</strong> Dapat mengelola pengguna dan sistem</li>
                    <li><strong>Guest:</strong> Hanya dapat mengakses fitur dasar</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
