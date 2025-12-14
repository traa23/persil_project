@extends('layouts.guest')

@section('title', 'Daftar Persil - Sistem Informasi Persil')

@section('content')
<!-- Banner -->
<section class="banner full" style="height: 400px;">
    <article>
        <img src="{{ asset('guest-tamplate/images/slide01.jpg') }}" alt="" width="1440" height="961">
        <div class="inner">
            <header>
                <p>Sistem Informasi Pengelolaan</p>
                <h2>Data Persil Pertanahan</h2>
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
            <p>Daftar Lengkap Data Persil</p>
            <h2>Data Persil Terdaftar</h2>
        </header>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="{{ route('guest.persil.index') }}" method="GET" class="search-form">
                <div class="search-wrapper">
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari berdasarkan kode, alamat, penggunaan, atau pemilik..."
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="search-button">
                        <span class="search-icon">🔍</span>
                        Cari
                    </button>
                    @if(request('search'))
                    <a href="{{ route('guest.persil.index') }}" class="clear-button">
                        <span>✕</span>
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <div style="text-align: center; margin-top: 1.5em; margin-bottom: 1em;">
            <a href="{{ route('guest.persil.create') }}" class="button special">Tambah Data Persil</a>
        </div>

        @if(request('search'))
        <div class="search-result-info">
            <p>
                @if($persils->total() > 0)
                    Menampilkan <strong>{{ $persils->total() }}</strong> hasil untuk pencarian "<strong>{{ request('search') }}</strong>"
                @else
                    Tidak ada hasil untuk pencarian "<strong>{{ request('search') }}</strong>"
                @endif
            </p>
        </div>
        @endif

        @if($persils->count() > 0)
        <div class="table-container">
            <table class="persil-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Persil</th>
                        <th>Luas Tanah</th>
                        <th>Lokasi</th>
                        <th>RT/RW</th>
                        <th>Pemilik</th>
                        <th>Penggunaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($persils as $index => $persil)
                    <tr>
                        <td class="text-center">{{ ($persils->currentPage() - 1) * $persils->perPage() + $loop->iteration }}</td>
                        <td class="text-center">
                            <strong>{{ $persil->kode_persil }}</strong>
                        </td>
                        <td class="text-center">
                            {{ $persil->luas_m2 ? number_format($persil->luas_m2, 2) . ' m²' : '-' }}
                        </td>
                        <td>{{ $persil->alamat_lahan ?? '-' }}</td>
                        <td class="text-center">{{ $persil->rt ?? '-' }} / {{ $persil->rw ?? '-' }}</td>
                        <td>
                            @if($persil->pemilik)
                            <div class="owner-info">
                                @if($persil->pemilik->photo_path)
                                    <img src="{{ asset('storage/' . $persil->pemilik->photo_path) }}" alt="{{ $persil->pemilik->name }}" class="owner-photo-table">
                                @else
                                    <div class="owner-avatar-table">{{ strtoupper(substr($persil->pemilik->name, 0, 1)) }}</div>
                                @endif
                                <span>{{ $persil->pemilik->name }}</span>
                            </div>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if($persil->penggunaan)
                                <span class="badge-table">{{ $persil->penggunaan }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('guest.persil.show', $persil->persil_id) }}" class="btn-detail-table" title="Detail">
                                    👁️ Detail
                                </a>
                                <a href="{{ route('guest.persil.edit', $persil->persil_id) }}" class="btn-edit-table" title="Edit">
                                    ✏️ Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($persils->hasPages())
        <div style="margin-top: 2em; text-align: center;">
            {{ $persils->links() }}
        </div>
        @endif
        @else
        <div class="align-center" style="padding: 3em 0;">
            <p style="font-size: 1.2em; color: #999;">Belum ada data persil yang terdaftar.</p>
            <a href="{{ route('guest.persil.create') }}" class="button special">Tambah Data Pertama</a>
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

    .search-input::placeholder {
        color: #999;
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

    .search-button:active {
        transform: translateY(0);
    }

    .search-icon {
        font-size: 1.1em;
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
        box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
    }

    .clear-button span {
        font-size: 1.2em;
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

    .search-result-info p {
        margin: 0;
        color: #333;
        font-size: 1em;
    }

    .search-result-info strong {
        color: #2ebaae;
    }

    /* Table Container */
    .table-container {
        margin-top: 2em;
        overflow-x: auto;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    }

    /* Table Styling */
    .persil-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }

    .persil-table thead {
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        color: white;
    }

    .persil-table thead th {
        padding: 1.2em 1em;
        text-align: left;
        font-weight: 700;
        font-size: 0.95em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        white-space: nowrap;
    }

    .persil-table tbody tr {
        border-bottom: 1px solid #e8e8e8;
        transition: all 0.3s ease;
    }

    .persil-table tbody tr:hover {
        background: #f0f8f7;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(46, 186, 174, 0.1);
    }

    .persil-table tbody tr:last-child {
        border-bottom: none;
    }

    .persil-table tbody td {
        padding: 1em;
        vertical-align: middle;
        font-size: 0.95em;
        color: #333;
    }

    .persil-table .text-center {
        text-align: center;
    }

    /* Owner Info in Table */
    .owner-info {
        display: flex;
        align-items: center;
        gap: 0.8em;
    }

    .owner-photo-table {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #2ebaae;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
    }

    .owner-avatar-table {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1em;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
    }

    .owner-info span {
        font-weight: 600;
        color: #212529;
    }

    /* Badge in Table */
    .badge-table {
        display: inline-block;
        padding: 0.4em 0.9em;
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        color: white;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5em;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-detail-table,
    .btn-edit-table {
        padding: 0.6em 1em;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85em;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3em;
        white-space: nowrap;
    }

    .btn-detail-table {
        background: #ffffff;
        color: #2ebaae;
        border: 2px solid #2ebaae;
    }

    .btn-detail-table:hover {
        background: #2ebaae;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 186, 174, 0.3);
    }

    .btn-edit-table {
        background: #2ebaae;
        color: #ffffff;
        border: 2px solid #2ebaae;
    }

    .btn-edit-table:hover {
        background: #1fa99c;
        border-color: #1fa99c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 169, 156, 0.3);
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        .table-container {
            border-radius: 8px;
        }

        .persil-table thead th {
            padding: 1em 0.7em;
            font-size: 0.85em;
        }

        .persil-table tbody td {
            padding: 0.8em 0.7em;
            font-size: 0.9em;
        }

        .owner-photo-table,
        .owner-avatar-table {
            width: 35px;
            height: 35px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.3em;
        }

        .btn-detail-table,
        .btn-edit-table {
            padding: 0.5em 0.8em;
            font-size: 0.8em;
        }
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

    .pagination li {
        display: inline-block;
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

    .pagination .page-item.disabled .page-link:hover {
        background: #f0f0f0;
        color: #999;
        transform: none;
        box-shadow: none;
    }

    /* Responsive Pagination */
    @media (max-width: 576px) {
        .pagination {
            gap: 0.3em;
        }

        .pagination .page-link {
            padding: 0.6em 0.9em;
            font-size: 0.85em;
            min-width: 40px;
        }
    }

    /* Responsive Search Bar */
    @media (max-width: 768px) {
        .search-wrapper {
            flex-direction: column;
        }

        .search-input {
            width: 100%;
            min-width: 100%;
        }

        .search-button,
        .clear-button {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

