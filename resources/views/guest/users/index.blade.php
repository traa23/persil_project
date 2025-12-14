@extends('layouts.guest')

@section('title', 'Daftar User - Sistem Informasi Persil')

@section('content')
<!-- Banner -->
<section class="banner full" style="height: 400px;">
    <article>
        <img src="{{ asset('guest-tamplate/images/slide01.jpg') }}" alt="" width="1440" height="961">
        <div class="inner">
            <header>
                <p>Manajemen Data</p>
                <h2>Daftar Pengguna</h2>
            </header>
        </div>
    </article>
</section>

<!-- Alert Messages -->
@if(session('success'))
<section class="wrapper style2" style="padding: 2em 0;">
    <div class="inner">
        <div style="background: #4CAF50; color: white; padding: 1em; border-radius: 5px; margin-bottom: 1em;">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    </div>
</section>
@endif

@if(session('error'))
<section class="wrapper style2" style="padding: 2em 0;">
    <div class="inner">
        <div style="background: #f44336; color: white; padding: 1em; border-radius: 5px; margin-bottom: 1em;">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    </div>
</section>
@endif

<!-- Main Content -->
<section id="one" class="wrapper style2">
    <div class="inner">
        <header class="align-center">
            <p>Manajemen Pengguna Sistem</p>
            <h2>Data Pengguna Terdaftar</h2>
        </header>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="{{ route('users.index') }}" method="GET" class="search-form">
                <div class="search-wrapper">
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari berdasarkan nama atau email..."
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="search-button">
                        <span class="search-icon">🔍</span>
                        Cari
                    </button>
                    @if(request('search'))
                    <a href="{{ route('users.index') }}" class="clear-button">
                        <span>✕</span>
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <div style="text-align: center; margin-top: 1.5em; margin-bottom: 1em; display: flex; gap: 1em; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('users.create') }}" class="button special">Tambah User Baru</a>
            <a href="{{ route('users.bulk-create') }}" class="button" style="background: #4CAF50; color: white; border: none;">📤 Tambah Multiple User</a>
        </div>

        @if(request('search'))
        <div class="search-result-info">
            <p>
                @if($users->total() > 0)
                    Menampilkan <strong>{{ $users->total() }}</strong> hasil untuk pencarian "<strong>{{ request('search') }}</strong>"
                @else
                    Tidak ada hasil untuk pencarian "<strong>{{ request('search') }}</strong>"
                @endif
            </p>
        </div>
        @endif

        @if($users->count() > 0)
        <div class="grid-style">
            @foreach($users as $user)
            <div class="user-card">
                <div class="card-header">
                    <div class="user-photo">
                        @if($user->photo_path)
                            <img src="{{ asset('storage/' . $user->photo_path) }}" alt="{{ $user->name }}">
                        @else
                            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        @endif
                    </div>
                    <h3>{{ $user->name }}</h3>
                </div>

                <div class="card-body">
                    <div class="info-item">
                        <span class="info-icon">📧</span>
                        <div class="info-content">
                            <small>Email</small>
                            <strong>{{ $user->email }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-icon">📅</span>
                        <div class="info-content">
                            <small>Terdaftar Sejak</small>
                            <strong>{{ $user->created_at->format('d M Y') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div style="margin-top: 2em; text-align: center;">
            {{ $users->links() }}
        </div>
        @endif
        @else
        <div class="align-center" style="padding: 3em 0;">
            <p style="font-size: 1.2em; color: #999;">Belum ada data user yang terdaftar.</p>
            <a href="{{ route('users.create') }}" class="button special">Tambah User Pertama</a>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Search Bar Styling */
    .search-container {
        margin: 2em auto;
        max-width: 800px;
    }

    .search-form {
        width: 100%;
    }

    .search-wrapper {
        display: flex;
        gap: 0.8em;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-input {
        flex: 1;
        min-width: 250px;
        padding: 0.9em 1.3em;
        font-size: 1em;
        border: 2px solid #d0d0d0;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .search-input:focus {
        outline: none;
        border-color: #2ebaae;
        box-shadow: 0 0 0 3px rgba(46, 186, 174, 0.1);
    }

    .search-button {
        padding: 0.9em 1.8em;
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5em;
        font-family: inherit;
    }

    .search-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 186, 174, 0.4);
    }

    .clear-button {
        padding: 0.9em 1.5em;
        background: #f44336;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-size: 1em;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5em;
    }

    .clear-button:hover {
        background: #d32f2f;
        transform: translateY(-2px);
    }

    /* Search Result Info */
    .search-result-info {
        text-align: center;
        margin: 1.5em auto;
        padding: 1em;
        background: #e8f5f4;
        border-left: 4px solid #2ebaae;
        border-radius: 8px;
        max-width: 800px;
    }

    .search-result-info strong {
        color: #2ebaae;
    }

    /* Grid Layout */
    .grid-style {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5em;
        margin-top: 2em;
    }

    /* User Card Styling */
    .user-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 2px solid #f0f0f0;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .user-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 8px 25px rgba(46, 186, 174, 0.2);
        border-color: #2ebaae;
    }

    /* Card Header with Photo */
    .user-card .card-header {
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        padding: 1.5em 1em;
        text-align: center;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1em;
    }

    .user-card .user-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-card .user-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-card .user-avatar {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5em;
        font-weight: 700;
        color: white;
        background: rgba(255, 255, 255, 0.2);
    }

    .user-card .card-header h3 {
        margin: 0;
        font-size: 1.3em;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    /* Card Body */
    .user-card .card-body {
        padding: 1em;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.8em;
    }

    .user-card .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.9em;
        padding: 0.8em 0.9em;
        background: #f8f9fa;
        border-radius: 8px;
        transition: background 0.2s ease;
    }

    .user-card .info-item:hover {
        background: #e9ecef;
    }

    .user-card .info-icon {
        font-size: 1.6em;
        min-width: 35px;
        text-align: center;
    }

    .user-card .info-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.3em;
    }

    .user-card .info-content small {
        font-size: 0.68em;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
    }

    .user-card .info-content strong {
        font-size: 0.95em;
        color: #212529;
        font-weight: 600;
        word-break: break-word;
    }

    /* Card Footer */
    .user-card .card-footer {
        padding: 1em;
        background: #ffffff;
        border-top: 2px solid #f0f0f0;
        display: flex;
        gap: 0.6em;
        justify-content: center;
    }

    .user-card .card-footer a,
    .user-card .card-footer button {
        flex: 1;
        padding: 0.7em 1em;
        text-align: center;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85em;
        text-decoration: none;
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid;
        cursor: pointer;
        font-family: inherit;
    }

    .user-card .btn-edit {
        background: #2ebaae;
        color: #ffffff;
        border-color: #2ebaae;
    }

    .user-card .btn-edit:hover {
        background: #1fa99c;
        border-color: #1fa99c;
        transform: scale(1.05);
    }

    .user-card .btn-delete {
        background: #ffffff;
        color: #f44336;
        border-color: #f44336;
    }

    .user-card .btn-delete:hover {
        background: #f44336;
        color: #ffffff;
        transform: scale(1.05);
    }

    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 2em 0;
        gap: 0.5em;
        flex-wrap: wrap;
    }

    .pagination .page-link {
        display: inline-block;
        padding: 0.75em 1.2em;
        background: #ffffff;
        color: #2ebaae;
        border: 2px solid #2ebaae;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95em;
        transition: all 0.3s ease;
        min-width: 45px;
        text-align: center;
    }

    .pagination .page-link:hover {
        background: #2ebaae;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 186, 174, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: #2ebaae;
        color: #ffffff;
        border-color: #2ebaae;
        cursor: default;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(46, 186, 174, 0.4);
    }

    .pagination .page-item.disabled .page-link {
        background: #f0f0f0;
        color: #999;
        border-color: #ddd;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .grid-style {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.2em;
        }

        .search-wrapper {
            flex-direction: column;
        }

        .search-input {
            width: 100%;
        }

        .search-button,
        .clear-button {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .grid-style {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
