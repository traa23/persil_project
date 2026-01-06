@extends('layouts.user')

@section('title', 'Detail Persil')
@section('page-title', 'Detail Persil')
@section('page-subtitle', 'Informasi lengkap persil {{ $persil->kode_persil }}')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('user.persil.list') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-xl shadow-md hover:shadow-lg transition text-gray-700 font-medium">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Persil Hero Card -->
    <div class="relative overflow-hidden rounded-3xl gradient-primary p-8 text-white shadow-xl">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-400/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-4 py-1.5 bg-white/20 rounded-full text-sm font-semibold backdrop-blur">
                            <i class="fas fa-map mr-2"></i>{{ $persil->penggunaan }}
                        </span>
                        <span class="px-4 py-1.5 bg-white/20 rounded-full text-sm font-semibold backdrop-blur">
                            RT {{ $persil->rt }} / RW {{ $persil->rw }}
                        </span>
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-bold mb-3 font-mono tracking-wide">{{ $persil->kode_persil }}</h1>
                    <p class="text-teal-100 text-lg flex items-center gap-2">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $persil->alamat_lahan }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-4">
                    <div class="text-center px-8 py-6 bg-white/10 rounded-2xl backdrop-blur border border-white/20">
                        <p class="text-5xl font-bold">{{ number_format($persil->luas_m2, 0, ',', '.') }}</p>
                        <p class="text-teal-200 text-sm mt-1">Luas (m²)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pemilik Info -->
        <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Informasi Pemilik</h3>
                        <p class="text-gray-500 text-sm">Data pemilik persil</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        {{ strtoupper(substr($persil->pemilik->nama ?? 'N', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-lg">{{ $persil->pemilik->nama ?? '-' }}</p>
                        <p class="text-gray-500 font-mono text-sm">{{ $persil->pemilik->no_ktp ?? '-' }}</p>
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-100 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Tanggal Input</span>
                        <span class="font-medium text-gray-700">{{ $persil->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Update Terakhir</span>
                        <span class="font-medium text-gray-700">{{ $persil->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="glass rounded-2xl p-6 shadow-xl border border-white/50 card-hover">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 mb-4">
                    <i class="fas fa-file-alt text-white text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $persil->dokumenPersil ? $persil->dokumenPersil->count() : 0 }}</p>
                <p class="text-gray-500 text-sm">Dokumen</p>
            </div>
            <div class="glass rounded-2xl p-6 shadow-xl border border-white/50 card-hover">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center shadow-lg shadow-violet-500/30 mb-4">
                    <i class="fas fa-map-marked-alt text-white text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $persil->petaPersil ? $persil->petaPersil->count() : 0 }}</p>
                <p class="text-gray-500 text-sm">Peta</p>
            </div>
            <div class="glass rounded-2xl p-6 shadow-xl border border-white/50 card-hover">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/30 mb-4">
                    <i class="fas fa-gavel text-white text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $persil->sengketa ? $persil->sengketa->count() : 0 }}</p>
                <p class="text-gray-500 text-sm">Sengketa</p>
            </div>
            <div class="glass rounded-2xl p-6 shadow-xl border border-white/50 card-hover">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-lg shadow-pink-500/30 mb-4">
                    <i class="fas fa-images text-white text-xl"></i>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $persil->fotoPersil ? $persil->fotoPersil->count() : 0 }}</p>
                <p class="text-gray-500 text-sm">Foto</p>
            </div>
        </div>
    </div>

    <!-- Dokumen Persil -->
    <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Dokumen Persil</h3>
                        <p class="text-gray-500 text-sm">{{ $persil->dokumenPersil ? $persil->dokumenPersil->count() : 0 }} dokumen terdaftar</p>
                    </div>
                </div>
            </div>
        </div>

        @if($persil->dokumenPersil && $persil->dokumenPersil->count() > 0)
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($persil->dokumenPersil as $dok)
                <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-100 hover:shadow-lg transition">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-white flex-shrink-0">
                            <i class="fas fa-file-contract text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-800 mb-1">{{ $dok->jenis_dokumen }}</h4>
                            <p class="text-emerald-600 font-mono text-sm mb-2">{{ $dok->nomor }}</p>
                            <p class="text-gray-500 text-sm truncate">{{ $dok->keterangan ?? 'Tidak ada keterangan' }}</p>
                            <div class="flex items-center gap-4 mt-3 text-xs text-gray-400">
                                <span><i class="fas fa-calendar mr-1"></i>{{ $dok->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-500">Belum ada dokumen terdaftar</p>
        </div>
        @endif
    </div>

    <!-- Peta Persil -->
    <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-map-marked-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Peta Persil</h3>
                        <p class="text-gray-500 text-sm">{{ $persil->petaPersil ? $persil->petaPersil->count() : 0 }} peta terdaftar</p>
                    </div>
                </div>
            </div>
        </div>

        @if($persil->petaPersil && $persil->petaPersil->count() > 0)
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($persil->petaPersil as $peta)
                <div class="p-5 bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl border border-violet-100 hover:shadow-lg transition group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-violet-100 text-violet-700 rounded-full text-xs font-semibold">
                            Peta #{{ $peta->peta_id }}
                        </span>
                        @if($peta->geojson)
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>GeoJSON
                        </span>
                        @endif
                    </div>

                    @if($peta->gambar)
                    <div class="mb-4 rounded-xl overflow-hidden bg-violet-100 aspect-video">
                        <img src="{{ asset('storage/' . $peta->gambar) }}" alt="Peta" class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    @else
                    <div class="mb-4 rounded-xl bg-violet-100 aspect-video flex items-center justify-center">
                        <i class="fas fa-map text-violet-300 text-4xl"></i>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-white rounded-lg text-center">
                            <p class="text-2xl font-bold text-violet-600">{{ $peta->panjang_m ?? '-' }}</p>
                            <p class="text-gray-500 text-xs">Panjang (m)</p>
                        </div>
                        <div class="p-3 bg-white rounded-lg text-center">
                            <p class="text-2xl font-bold text-violet-600">{{ $peta->lebar_m ?? '-' }}</p>
                            <p class="text-gray-500 text-xs">Lebar (m)</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-map-marked-alt text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-500">Belum ada peta terdaftar</p>
        </div>
        @endif
    </div>

    <!-- Sengketa Persil -->
    <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg">
                        <i class="fas fa-gavel text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Sengketa Persil</h3>
                        <p class="text-gray-500 text-sm">{{ $persil->sengketa ? $persil->sengketa->count() : 0 }} sengketa tercatat</p>
                    </div>
                </div>
            </div>
        </div>

        @if($persil->sengketa && $persil->sengketa->count() > 0)
        <div class="p-6 space-y-4">
            @foreach($persil->sengketa as $sengketa)
            <div class="rounded-xl border-2 overflow-hidden
                @if($sengketa->status == 'selesai') border-green-200 bg-gradient-to-r from-green-50 to-emerald-50
                @elseif($sengketa->status == 'proses') border-amber-200 bg-gradient-to-r from-amber-50 to-yellow-50
                @else border-gray-200 bg-gradient-to-r from-gray-50 to-slate-50
                @endif">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full
                                @if($sengketa->status == 'selesai') bg-green-500
                                @elseif($sengketa->status == 'proses') bg-amber-500
                                @else bg-gray-500
                                @endif flex items-center justify-center text-white">
                                @if($sengketa->status == 'selesai')
                                    <i class="fas fa-check"></i>
                                @elseif($sengketa->status == 'proses')
                                    <i class="fas fa-clock"></i>
                                @else
                                    <i class="fas fa-pause"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">
                                    {{ $sengketa->pihak_1 }}
                                    <span class="text-gray-400 font-normal">vs</span>
                                    {{ $sengketa->pihak_2 }}
                                </h4>
                                <p class="text-sm text-gray-500">Sengketa #{{ $sengketa->sengketa_id }}</p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 rounded-full text-sm font-semibold
                            @if($sengketa->status == 'selesai') bg-green-100 text-green-700
                            @elseif($sengketa->status == 'proses') bg-amber-100 text-amber-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($sengketa->status) }}
                        </span>
                    </div>

                    <div class="bg-white/50 rounded-xl p-4 mb-4">
                        <h5 class="text-sm font-semibold text-gray-600 mb-2">Kronologi</h5>
                        <p class="text-gray-700">{{ $sengketa->kronologi }}</p>
                    </div>

                    @if($sengketa->penyelesaian)
                    <div class="bg-green-100/50 rounded-xl p-4">
                        <h5 class="text-sm font-semibold text-green-700 mb-2">
                            <i class="fas fa-check-circle mr-1"></i>Penyelesaian
                        </h5>
                        <p class="text-gray-700">{{ $sengketa->penyelesaian }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
            </div>
            <h4 class="font-semibold text-gray-700 mb-1">Tidak Ada Sengketa</h4>
            <p class="text-gray-500 text-sm">Persil ini tidak memiliki catatan sengketa</p>
        </div>
        @endif
    </div>

    <!-- Foto Persil -->
    @if($persil->fotoPersil && $persil->fotoPersil->count() > 0)
    <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-images text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Foto Persil</h3>
                    <p class="text-gray-500 text-sm">{{ $persil->fotoPersil->count() }} foto dokumentasi</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($persil->fotoPersil as $foto)
                <div class="group relative aspect-square bg-gray-100 rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $foto->file_path) }}" alt="Foto Persil"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition flex items-end justify-center pb-4">
                        <a href="{{ asset('storage/' . $foto->file_path) }}" target="_blank"
                           class="px-4 py-2 bg-white/90 rounded-full text-sm font-medium text-gray-800 hover:bg-white transition">
                            <i class="fas fa-expand mr-1"></i> Perbesar
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
