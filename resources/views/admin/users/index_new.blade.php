@extends('layouts.admin')

@section('title', 'Kelola Users')

@section('content')
<section id="banner" class="style2">
    <div class="inner">
        <header class="major">
            <h1><i class="fas fa-users"></i> Kelola Users</h1>
        </header>
        <div class="content">
            <p>Manajemen pengguna sistem - Buat, Edit, dan Hapus akun pengguna</p>
        </div>
    </div>
</section>

<!-- Alert Messages -->
@if(session('success'))
    <section style="max-width: 1200px; margin: 0 auto;">
        <div class="alert-success" style="margin: 20px;">
            <i class="fas fa-check-circle"></i> <strong>{{ session('success') }}</strong>
        </div>
    </section>
@endif

@if(session('error'))
    <section style="max-width: 1200px; margin: 0 auto;">
        <div class="alert-error" style="margin: 20px;">
            <i class="fas fa-exclamation-circle"></i> <strong>{{ session('error') }}</strong>
        </div>
    </section>
@endif

<!-- Users Table -->
<section id="three">
    <div class="inner">
        <header class="major">
            <h2>Daftar Users</h2>
        </header>

        <div style="margin-bottom: 20px;">
            <a href="{{ route('admin.users.create') }}" class="button primary">+ Tambah User Baru</a>
        </div>

        @if($users->count() > 0)
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span style="padding: 6px 12px; border-radius: 4px; font-size: 12px; color: white; font-weight: bold; {{ $user->role === 'admin' ? 'background-color: #9C27B0;' : 'background-color: #2196F3;' }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="button small">Detail</a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="button small">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin hapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button small" style="background-color: #f44336; color: white;">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 30px; text-align: center;">
                {{ $users->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 40px; background: #f5f5f5; border-radius: 8px;">
                <p>Tidak ada pengguna. <a href="{{ route('admin.users.create') }}">Buat user baru</a></p>
            </div>
        @endif
    </div>
</section>

<style>
    .table-wrapper table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    .table-wrapper table thead {
        background: #f4f4f4;
    }
    .table-wrapper table thead th {
        padding: 15px;
        text-align: left;
        font-weight: bold;
        border-bottom: 2px solid #ddd;
    }
    .table-wrapper table tbody td {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }
    .table-wrapper table tbody tr:hover {
        background-color: #f9f9f9;
    }
    .button.small {
        padding: 8px 15px;
        font-size: 12px;
        margin-right: 5px;
        display: inline-block;
    }
    .button.primary {
        background-color: #2196F3;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-weight: bold;
    }
    .button.primary:hover {
        background-color: #1976D2;
    }
</style>
@endsection
