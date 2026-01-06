@extends('layouts.user')

@section('title', 'Detail Persil')
@section('page-title', 'Detail Persil')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('user.persil.list') }}" class="text-teal-600 hover:text-teal-800">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Persil
        </a>
    </div>

    <!-- Persil Info Card -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-map text-teal-600 mr-2"></i>
                {{ $persil->kode_persil }}
            </h3>
            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-medium">
                {{ $persil->penggunaan }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-500">Pemilik</label>
                    <p class="font-semibold text-gray-800">{{ $persil->pemilik->nama ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">No. KTP Pemilik</label>
                    <p class="font-mono text-gray-800">{{ $persil->pemilik->no_ktp ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Luas Tanah</label>
                    <p class="font-semibold text-gray-800">{{ number_format($persil->luas_m2, 2) }} m²</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-500">Alamat Lahan</label>
                    <p class="text-gray-800">{{ $persil->alamat_lahan }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">RT / RW</label>
                    <p class="text-gray-800">{{ $persil->rt }} / {{ $persil->rw }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Tanggal Input</label>
                    <p class="text-gray-800">{{ $persil->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen Persil -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-file-alt text-green-600 mr-2"></i>
            Dokumen Persil ({{ $persil->dokumenPersil->count() }})
        </h3>

        @if($persil->dokumenPersil->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Jenis Dokumen</th>
                        <th class="px-4 py-2 text-left">Nomor</th>
                        <th class="px-4 py-2 text-left">Keterangan</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($persil->dokumenPersil as $dok)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium">{{ $dok->jenis_dokumen }}</td>
                        <td class="px-4 py-2 font-mono text-sm">{{ $dok->nomor }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $dok->keterangan ?? '-' }}</td>
                        <td class="px-4 py-2 text-gray-500">{{ $dok->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-4">Belum ada dokumen.</p>
        @endif
    </div>

    <!-- Peta Persil -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>
            Peta Persil ({{ $persil->petaPersil->count() }})
        </h3>

        @if($persil->petaPersil->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($persil->petaPersil as $peta)
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-sm text-gray-500">Peta ID: {{ $peta->peta_id }}</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-gray-500">Panjang:</span>
                        <span class="font-medium">{{ $peta->panjang_m ?? '-' }} m</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Lebar:</span>
                        <span class="font-medium">{{ $peta->lebar_m ?? '-' }} m</span>
                    </div>
                </div>
                @if($peta->geojson)
                <div class="mt-2">
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">GeoJSON Available</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-4">Belum ada peta.</p>
        @endif
    </div>

    <!-- Sengketa Persil -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-balance-scale text-red-600 mr-2"></i>
            Sengketa Persil ({{ $persil->sengketa->count() }})
        </h3>

        @if($persil->sengketa->count() > 0)
        <div class="space-y-4">
            @foreach($persil->sengketa as $sengketa)
            <div class="border rounded-lg p-4 {{ $sengketa->status == 'selesai' ? 'border-green-200 bg-green-50' : ($sengketa->status == 'proses' ? 'border-yellow-200 bg-yellow-50' : 'border-gray-200') }}">
                <div class="flex justify-between items-start mb-2">
                    <div class="font-medium">
                        {{ $sengketa->pihak_1 }} <span class="text-gray-400">vs</span> {{ $sengketa->pihak_2 }}
                    </div>
                    <span class="px-2 py-1 rounded text-xs font-medium
                        @if($sengketa->status == 'selesai') bg-green-200 text-green-800
                        @elseif($sengketa->status == 'proses') bg-yellow-200 text-yellow-800
                        @else bg-gray-200 text-gray-800
                        @endif">
                        {{ ucfirst($sengketa->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-600 mb-2">{{ $sengketa->kronologi }}</p>
                @if($sengketa->penyelesaian)
                <div class="mt-2 p-2 bg-white rounded text-sm">
                    <span class="text-gray-500">Penyelesaian:</span>
                    <p class="text-gray-700">{{ $sengketa->penyelesaian }}</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-4">Tidak ada sengketa.</p>
        @endif
    </div>

    <!-- Foto Persil -->
    @if($persil->fotoPersil && $persil->fotoPersil->count() > 0)
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-images text-blue-600 mr-2"></i>
            Foto Persil ({{ $persil->fotoPersil->count() }})
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($persil->fotoPersil as $foto)
            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $foto->file_path) }}" alt="Foto Persil" class="w-full h-full object-cover">
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
