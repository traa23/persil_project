@extends('layouts.admin')

@section('title', 'Detail Persil')
@section('page-title', 'Detail Persil - ' . $persil->kode_persil)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Info Dasar -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $persil->kode_persil }}</h2>

            <!-- Gallery Foto -->
            @if ($persil->fotoPersil->count() > 0)
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        @foreach ($persil->fotoPersil as $foto)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $foto->file_path) }}" alt="Foto Persil" class="w-full h-64 object-cover rounded-lg shadow">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-lg transition flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                                    <form id="fotoDeleteForm-{{ $foto->id }}" action="{{ getAdminRoute('foto.delete', $foto->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showConfirm('Hapus foto ini?', document.getElementById('fotoDeleteForm-{{ $foto->id }}'))" class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium transition">
                                            <i class="fas fa-trash mr-2"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ getAdminRoute('persil.edit', $persil->persil_id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-plus"></i> Tambah Foto
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Alamat Lahan</p>
                    <p class="font-semibold">{{ $persil->alamat_lahan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Luas (m²)</p>
                    <p class="font-semibold">{{ number_format($persil->luas_m2, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jenis Penggunaan</p>
                    <p class="font-semibold">{{ $persil->jenisPenggunaan->nama_penggunaan ?? '-' }}</p>
                </div>
                @if ($persil->rt && $persil->rw)
                    <div>
                        <p class="text-sm text-gray-600">RT/RW</p>
                        <p class="font-semibold">{{ $persil->rt }}/{{ $persil->rw }}</p>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex gap-2">
                <a href="{{ getAdminRoute('persil.edit', $persil->persil_id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form id="deleteForm" action="{{ getAdminRoute('persil.delete', $persil->persil_id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="showConfirm('Apakah Anda yakin ingin menghapus persil ini beserta semua data terkait?', document.getElementById('deleteForm'))" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-medium transition">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Dokumen Persil -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                    Dokumen Persil
                </h3>
                <a href="{{ getAdminRoute('dokumen.create', $persil->persil_id) }}" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>

            @if ($persil->dokumenPersil->count() > 0)
                <!-- PREVIEW FOTO/GAMBAR - Ditampilkan terlebih dahulu jika ada -->
                @php
                    $imageDokumen = $persil->dokumenPersil->filter(function($d) {
                        $ext = strtolower(pathinfo($d->file_dokumen, PATHINFO_EXTENSION));
                        return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    });
                @endphp

                @if ($imageDokumen->count() > 0)
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 mb-3">Preview Foto Dokumen</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($imageDokumen as $dokumen)
                                <div class="relative group rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                                    <!-- Preview Foto -->
                                    <img src="{{ asset('storage/' . $dokumen->file_dokumen) }}"
                                         alt="{{ $dokumen->jenis_dokumen }}"
                                         class="w-full h-56 object-cover">

                                    <!-- Hover Overlay dengan Info -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-70 transition flex flex-col items-center justify-center gap-3 opacity-0 group-hover:opacity-100">
                                        <div class="text-white text-center px-3">
                                            <p class="font-semibold text-sm">{{ $dokumen->jenis_dokumen }}</p>
                                            @if ($dokumen->keterangan)
                                                <p class="text-xs">{{ Str::limit($dokumen->keterangan, 40) }}</p>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            <!-- Download Button -->
                                            <a href="{{ asset('storage/' . $dokumen->file_dokumen) }}"
                                               download
                                               class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700 transition">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </a>
                                            <!-- View Full Size -->
                                            <a href="{{ asset('storage/' . $dokumen->file_dokumen) }}"
                                               target="_blank"
                                               class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700 transition">
                                                <i class="fas fa-expand mr-1"></i>Perbesar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- TABEL DOKUMEN - Semua dokumen (termasuk yang bukan foto) -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold">Jenis Dokumen</th>
                                <th class="px-3 py-2 text-left font-semibold">Nomor</th>
                                <th class="px-3 py-2 text-left font-semibold">Keterangan</th>
                                <th class="px-3 py-2 text-left font-semibold">File</th>
                                <th class="px-3 py-2 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($persil->dokumenPersil as $dokumen)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $dokumen->jenis_dokumen }}</td>
                                    <td class="px-3 py-2">{{ $dokumen->nomor ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $dokumen->keterangan ?? '-' }}</td>
                                    <td class="px-3 py-2">
                                        @if ($dokumen->file_dokumen)
                                            @php
                                                $fileExt = strtolower(pathinfo($dokumen->file_dokumen, PATHINFO_EXTENSION));
                                                $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                            @endphp
                                            <div class="flex items-center gap-2">
                                                <!-- Icon type file -->
                                                @if ($isImage)
                                                    <i class="fas fa-image text-purple-600"></i>
                                                @else
                                                    <i class="fas fa-file text-gray-600"></i>
                                                @endif
                                                <!-- Download link -->
                                                <a href="{{ asset('storage/' . $dokumen->file_dokumen) }}"
                                                   target="_blank"
                                                   class="text-blue-600 hover:text-blue-700 text-xs font-medium">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <form action="{{ getAdminRoute('dokumen.delete', $dokumen->dokumen_id) }}" method="POST" class="inline-block" onclick="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">Belum ada dokumen</p>
            @endif
        </div>

        <!-- Peta Persil -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-map-marked-alt mr-2 text-green-600"></i>
                    Peta Persil
                </h3>
                <a href="{{ getAdminRoute('peta.create', $persil->persil_id) }}" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                    <i class="fas fa-plus"></i> Kelola
                </a>
            </div>

            @if ($persil->petaPersil)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if ($persil->petaPersil->panjang_m && $persil->petaPersil->lebar_m)
                        <div>
                            <p class="text-sm text-gray-600">Panjang (m)</p>
                            <p class="text-lg font-semibold">{{ $persil->petaPersil->panjang_m }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Lebar (m)</p>
                            <p class="text-lg font-semibold">{{ $persil->petaPersil->lebar_m }}</p>
                        </div>
                    @endif
                </div>

                @if ($persil->petaPersil->file_peta)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $persil->petaPersil->file_peta) }}" alt="Peta" class="w-full rounded mb-3 max-h-96 object-cover">
                        <a href="{{ asset('storage/' . $persil->petaPersil->file_peta) }}" target="_blank" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            <i class="fas fa-download mr-1"></i> Download Peta
                        </a>
                    </div>
                @endif

                @if ($persil->petaPersil->geojson)
                    <div class="mt-4 p-3 bg-gray-100 rounded text-sm">
                        <p class="font-semibold mb-2">GeoJSON:</p>
                        <pre class="whitespace-pre-wrap break-words text-xs">{{ $persil->petaPersil->geojson }}</pre>
                    </div>
                @endif
            @else
                <p class="text-gray-600">Belum ada data peta</p>
            @endif
        </div>

        <!-- Sengketa Persil -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
                    Sengketa Persil
                </h3>
                <a href="{{ getAdminRoute('sengketa.create', $persil->persil_id) }}" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>

            @if ($persil->sengketa->count() > 0)
                @foreach ($persil->sengketa as $sengketa)
                    <div class="mb-4 p-4 border border-gray-200 rounded">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-semibold">Sengketa #{{ $sengketa->sengketa_id }}</div>
                            <div class="flex gap-2">
                                <span class="px-3 py-1 rounded text-sm font-semibold
                                    @if ($sengketa->status == 'baru') bg-blue-100 text-blue-800
                                    @elseif ($sengketa->status == 'proses') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($sengketa->status) }}
                                </span>
                                <a href="{{ route('admin.sengketa.edit', $sengketa->sengketa_id) }}" class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <p class="text-sm text-gray-600">Pihak 1</p>
                                <p class="font-semibold">{{ $sengketa->pihak_1 }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pihak 2</p>
                                <p class="font-semibold">{{ $sengketa->pihak_2 }}</p>
                            </div>
                        </div>

                        @if ($sengketa->kronologi)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600">Kronologi</p>
                                <p class="text-sm">{{ $sengketa->kronologi }}</p>
                            </div>
                        @endif

                        @if ($sengketa->penyelesaian)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600">Penyelesaian</p>
                                <p class="text-sm">{{ $sengketa->penyelesaian }}</p>
                            </div>
                        @endif

                        @if ($sengketa->bukti_sengketa)
                            <a href="{{ asset('storage/' . $sengketa->bukti_sengketa) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">
                                <i class="fas fa-download mr-1"></i> Download Bukti
                            </a>
                        @endif
                    </div>
                @endforeach
            @else
                <p class="text-gray-600">Belum ada sengketa</p>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-purple-50 rounded-lg p-4">
            <h3 class="font-bold text-gray-800 mb-3">Informasi Pemilik</h3>
            <p class="text-sm mb-2">
                <span class="font-semibold">Nama:</span> {{ $persil->pemilik->name }}
            </p>
            <p class="text-sm mb-2">
                <span class="font-semibold">Email:</span> {{ $persil->pemilik->email }}
            </p>
            <p class="text-sm">
                <span class="font-semibold">Role:</span> {{ ucfirst($persil->pemilik->role) }}
            </p>
        </div>

        <div class="bg-purple-50 rounded-lg p-4">
            <h3 class="font-bold text-gray-800 mb-3">Statistik</h3>
            <div class="space-y-2 text-sm">
                <p>
                    <span class="font-semibold">Dokumen:</span> {{ $persil->dokumenPersil->count() }}
                </p>
                <p>
                    <span class="font-semibold">Sengketa:</span> {{ $persil->sengketa->count() }}
                </p>
                <p>
                    <span class="font-semibold">Dibuat:</span> {{ $persil->created_at->format('d-m-Y H:i') }}
                </p>
                <p>
                    <span class="font-semibold">Diubah:</span> {{ $persil->updated_at->format('d-m-Y H:i') }}
                </p>
            </div>
        </div>

        <a href="{{ route('admin.persil.list') }}" class="block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 text-center">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
