@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Banner Section -->
<section id="banner">
    <div class="inner">
        <div class="major">
            <h1><i class="fas fa-chart-bar"></i> Dashboard</h1>
        </div>
        <div class="content">
            <p>Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>! Pantau sistem dari sini.</p>
        </div>
    </div>
</section>

<!-- Statistics Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">

    <!-- Total Users Card -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h3 style="margin: 0 0 8px 0; color: #90A4AE; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Total Users</h3>
                <p style="margin: 0; font-size: 32px; font-weight: 800; color: var(--primary);">{{ $stats['total_users'] }}</p>
                <p style="margin: 8px 0 0 0; color: #90A4AE; font-size: 13px;">Pengguna terdaftar di sistem</p>
            </div>
            <div style="font-size: 40px; color: rgba(21, 101, 192, 0.2);">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Admin Users Card -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h3 style="margin: 0 0 8px 0; color: #90A4AE; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Admin Users</h3>
                <p style="margin: 0; font-size: 32px; font-weight: 800; color: #7C4DFF;">{{ $stats['total_admins'] }}</p>
                <p style="margin: 8px 0 0 0; color: #90A4AE; font-size: 13px;">Akun administrator</p>
            </div>
            <div style="font-size: 40px; color: rgba(124, 77, 255, 0.2);">
                <i class="fas fa-crown"></i>
            </div>
        </div>
    </div>

    <!-- Guest Users Card -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h3 style="margin: 0 0 8px 0; color: #90A4AE; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Guest Users</h3>
                <p style="margin: 0; font-size: 32px; font-weight: 800; color: #00BCD4;">{{ $stats['total_guests'] }}</p>
                <p style="margin: 8px 0 0 0; color: #90A4AE; font-size: 13px;">Akun pengguna reguler</p>
            </div>
            <div style="font-size: 40px; color: rgba(0, 188, 212, 0.2);">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </div>

    <!-- Total Persil Card -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h3 style="margin: 0 0 8px 0; color: #90A4AE; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Total Persil</h3>
                <p style="margin: 0; font-size: 32px; font-weight: 800; color: #26A69A;">{{ $stats['total_persil'] }}</p>
                <p style="margin: 8px 0 0 0; color: #90A4AE; font-size: 13px;">Data persil terdaftar</p>
            </div>
            <div style="font-size: 40px; color: rgba(38, 166, 154, 0.2);">
                <i class="fas fa-map-marker-alt"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <h2>Quick Actions</h2>
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <a href="{{ route('admin.users.index') }}" class="btn-primary">
            <i class="fas fa-users"></i> Lihat Semua Users
        </a>
        <a href="{{ route('admin.users.create') }}" class="btn-success">
            <i class="fas fa-user-plus"></i> Tambah User Baru
        </a>
    </div>
</div>

<!-- Recent Users Table -->
@if($recent_users->count() > 0)
<div class="card">
    <h2>Recent Users</h2>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-guest' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn-primary btn-small">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Recent Persil Table -->
@if($recent_persil->count() > 0)
<div class="card">
    <h2>Recent Persil</h2>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Alamat</th>
                    <th>Luas (m²)</th>
                    <th>Penggunaan</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_persil as $persil)
                <tr>
                    <td><strong>{{ $persil->kode_persil }}</strong></td>
                    <td>{{ $persil->alamat_lahan }}</td>
                    <td>{{ number_format($persil->luas_m2, 2) }}</td>
                    <td>{{ $persil->penggunaan }}</td>
                    <td>{{ $persil->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
