@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<section id="banner" class="style2">
    <div class="inner">
        <header class="major">
            <h1><i class="fas fa-user-circle"></i> Detail User</h1>
        </header>
        <div class="content">
            <p>Informasi lengkap pengguna: <strong>{{ $user->name }}</strong></p>
        </div>
    </div>
</section>

<!-- User Detail -->
<section id="three">
    <div class="inner container">
        <div style="max-width: 600px; margin: 0 auto;">
            <!-- User Card -->
            <div class="card">
                <!-- Profile Header -->
                <div style="text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #ecf0f1;">
                    @if($user->photo_path && \Storage::disk('public')->exists($user->photo_path))
                        <div style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                            <img src="{{ asset('storage/' . $user->photo_path) }}" alt="Profile Photo" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @else
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, {{ $user->role === 'admin' ? '#9b59b6' : '#3498db' }} 0%, {{ $user->role === 'admin' ? '#8e44ad' : '#2980b9' }} 100%); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                            <span style="color: white; font-size: 40px; font-weight: bold;"><i class="fas fa-user"></i></span>
                        </div>
                    @endif
                    <h2 style="margin: 10px 0; color: #2c3e50; font-size: 24px;">{{ $user->name }}</h2>
                    <p style="margin: 8px 0; color: #7f8c8d; font-size: 14px;">{{ $user->email }}</p>
                    <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-guest' }}" style="margin-top: 10px;">
                        {{ strtoupper($user->role) }}
                    </span>
                </div>

                <!-- User Information -->
                <div style="margin-bottom: 30px;">
                    <h3 style="color: #2c3e50; border-bottom: 2px solid #ecf0f1; padding-bottom: 10px; margin-top: 0;">
                        <i class="fas fa-info-circle"></i> Informasi Akun
                    </h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                        <!-- Email -->
                        <div style="padding: 12px; background: #f8f9fa; border-radius: 6px;">
                            <label style="display: block; font-size: 12px; color: #7f8c8d; text-transform: uppercase; margin-bottom: 8px;">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <p style="margin: 0; color: #2c3e50; font-weight: 500;">{{ $user->email }}</p>
                        </div>

                        <!-- Role -->
                        <div style="padding: 12px; background: #f8f9fa; border-radius: 6px;">
                            <label style="display: block; font-size: 12px; color: #7f8c8d; text-transform: uppercase; margin-bottom: 8px;">
                                <i class="fas fa-key"></i> Role
                            </label>
                            <p style="margin: 0; color: #2c3e50; font-weight: 500;">
                                @if($user->role === 'admin')
                                    <span class="badge badge-admin" style="font-size: 11px;">Admin</span>
                                @else
                                    <span class="badge badge-guest" style="font-size: 11px;">Guest</span>
                                @endif
                            </p>
                        </div>

                        <!-- Bergabung -->
                        <div style="padding: 12px; background: #f8f9fa; border-radius: 6px;">
                            <label style="display: block; font-size: 12px; color: #7f8c8d; text-transform: uppercase; margin-bottom: 8px;">
                                <i class="fas fa-calendar"></i> Bergabung
                            </label>
                            <p style="margin: 0; color: #2c3e50; font-weight: 500;">{{ $user->created_at->format('d M Y') }}</p>
                            <small style="color: #95a5a6; display: block; margin-top: 3px;">{{ $user->created_at->format('H:i:s') }}</small>
                        </div>

                        <!-- Diubah -->
                        <div style="padding: 12px; background: #f8f9fa; border-radius: 6px;">
                            <label style="display: block; font-size: 12px; color: #7f8c8d; text-transform: uppercase; margin-bottom: 8px;">
                                <i class="fas fa-edit"></i> Diubah
                            </label>
                            <p style="margin: 0; color: #2c3e50; font-weight: 500;">{{ $user->updated_at->format('d M Y') }}</p>
                            <small style="color: #95a5a6; display: block; margin-top: 3px;">{{ $user->updated_at->format('H:i:s') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 12px; margin-top: 30px;">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-primary" style="flex: 1; text-align: center; text-decoration: none;">
                        <i class="fas fa-edit"></i> Edit User
                    </a>

                    @if(auth()->user()->id !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="width: 100%;">
                                <i class="fas fa-trash"></i> Hapus User
                            </button>
                        </form>
                    @else
                        <div class="btn-secondary" style="flex: 1; text-align: center; cursor: not-allowed; opacity: 0.6;">
                            <i class="fas fa-ban"></i> Tidak bisa hapus akun sendiri
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Info Section -->
            @if($user->role === 'admin')
                <div class="card" style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.1) 0%, rgba(188, 110, 212, 0.1) 100%); border-left: 5px solid #9b59b6; margin-top: 20px;">
                    <h3 style="margin-top: 0; color: #663399;"><i class="fas fa-lock"></i> Akun Administrator</h3>
                    <p style="margin: 0; color: #663399; font-size: 14px;">
                        👑 Akun ini memiliki akses penuh untuk mengelola pengguna, sistem, dan semua data aplikasi.
                    </p>
                </div>
            @else
                <div class="card" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(41, 128, 185, 0.1) 100%); border-left: 5px solid #3498db; margin-top: 20px;">
                    <h3 style="margin-top: 0; color: #1565c0;"><i class="fas fa-user"></i> Pengguna Tamu</h3>
                    <p style="margin: 0; color: #1565c0; font-size: 14px;">
                        👤 Akun ini hanya memiliki akses terbatas dan hanya bisa menggunakan fitur dasar aplikasi.
                    </p>
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
