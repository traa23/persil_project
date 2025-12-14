@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<section id="banner" class="style2">
    <div class="inner">
        <header class="major">
            <h1><i class="fas fa-edit"></i> Edit User</h1>
        </header>
        <div class="content">
            <p>Ubah informasi pengguna: <strong>{{ $user->name }}</strong></p>
        </div>
    </div>
</section>

<!-- Form Edit User -->
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
                <h2 style="margin-top: 0;"><i class="fas fa-file-alt"></i> Edit Informasi Pengguna</h2>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div style="margin-bottom: 20px;">
                        <label for="name" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                            <i class="fas fa-user"></i> Nama Lengkap *
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
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
                            value="{{ old('email', $user->email) }}"
                            placeholder="nama@example.com"
                            required
                        >
                        @error('email')
                            <small style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password Field (Optional) -->
                    <div style="margin-bottom: 20px;">
                        <label for="password" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                            <i class="fas fa-lock"></i> Password Baru (Kosongkan jika tidak ingin mengubah)
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password baru (min. 8 karakter)"
                        >
                        @error('password')
                            <small style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password Confirmation Field -->
                    @if(request('password'))
                        <div style="margin-bottom: 20px;">
                            <label for="password_confirmation" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                                <i class="fas fa-lock"></i> Konfirmasi Password Baru
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password baru"
                            >
                        </div>
                    @endif

                    <!-- Role Field -->
                    <div style="margin-bottom: 30px;">
                        <label for="role" style="display: block; font-weight: bold; margin-bottom: 8px; color: #2c3e50;">
                            <i class="fas fa-key"></i> Role *
                        </label>
                        @if(auth()->user()->id === $user->id)
                            <!-- Cannot change own role -->
                            <select
                                id="role"
                                name="role"
                                disabled
                            >
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>👑 Admin (Akses Penuh)</option>
                                <option value="guest" {{ $user->role === 'guest' ? 'selected' : '' }}>👤 Guest (Akses Terbatas)</option>
                            </select>
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <small style="color: #f39c12;"><i class="fas fa-info-circle"></i> Anda tidak bisa mengubah role akun Anda sendiri</small>
                        @else
                            <!-- Can change other user's role -->
                            <select id="role" name="role" required>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>👑 Admin (Akses Penuh)</option>
                                <option value="guest" {{ old('role', $user->role) === 'guest' ? 'selected' : '' }}>👤 Guest (Akses Terbatas)</option>
                            </select>
                        @endif
                        @error('role')
                            <small style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <!-- User Info -->
                    <div style="margin: 20px 0; padding: 15px; background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(41, 128, 185, 0.1) 100%); border-left: 4px solid #3498db; border-radius: 4px;">
                        <small style="color: #2c3e50;">
                            <strong><i class="fas fa-info-circle"></i> Informasi User:</strong><br>
                            📧 Email: {{ $user->email }}<br>
                            📅 Bergabung: {{ $user->created_at->format('d M Y H:i') }}
                        </small>
                    </div>

                    <!-- Form Actions -->
                    <div style="display: flex; gap: 12px;">
                        <button type="submit" class="btn-primary" style="flex: 1; cursor: pointer;">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="flex: 1; text-align: center; text-decoration: none;">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Delete Section -->
            @if(auth()->user()->id !== $user->id)
                <div class="card" style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.05) 0%, rgba(192, 57, 43, 0.05) 100%); border-left: 5px solid #e74c3c; margin-top: 20px;">
                    <h3 style="margin-top: 0; color: #c0392b;"><i class="fas fa-exclamation-triangle"></i> Zona Berbahaya</h3>
                    <p style="color: #7f8c8d; margin: 10px 0;">Hapus akun pengguna secara permanen:</p>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }} secara permanen? Tindakan ini tidak dapat dibatalkan.');style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">
                            <i class="fas fa-trash"></i> Hapus User Selamanya
                        </button>
                    </form>
                </div>
            @endif

            <!-- Back Link -->
            <div style="margin-top: 20px; text-align: center;">
                <a href="{{ route('admin.users.index') }}" style="color: #3498db; text-decoration: none; font-weight: 500;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Users
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
