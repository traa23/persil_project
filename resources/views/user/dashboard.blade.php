@extends('layouts.user')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data persil dan informasi Anda')

@section('content')
<div class="space-y-6">
    <!-- Welcome Hero Section -->
    <div class="relative overflow-hidden rounded-3xl gradient-primary p-8 text-white">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)"/>
            </svg>
        </div>

        <!-- Floating Shapes -->
        <div class="absolute top-4 right-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-4 left-1/2 w-48 h-48 bg-teal-400/20 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold tracking-wide">
                        <i class="fas fa-star mr-1"></i> USER PORTAL
                    </span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold mb-2">
                    Selamat Datang, {{ $warga->nama ?? auth()->user()->name }}! 👋
                </h2>
                <p class="text-teal-100 text-lg max-w-xl">
                    @if($warga)
                        Kelola dan pantau semua data persil Anda dengan mudah melalui dashboard ini.
                    @else
                        Akun Anda belum terhubung dengan data warga. Hubungi admin untuk verifikasi.
                    @endif
                </p>

                @if($warga)
                <div class="mt-4 flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-xl backdrop-blur">
                        <i class="fas fa-id-card"></i>
                        <span class="font-mono">{{ $warga->no_ktp }}</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-xl backdrop-blur">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $warga->alamat ?? 'Alamat belum diisi' }}</span>
                    </div>
                </div>
                @endif
            </div>

            <div class="hidden lg:block float-animation">
                <div class="w-32 h-32 bg-white/20 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/30 shadow-2xl">
                    <i class="fas fa-user-circle text-6xl opacity-80"></i>
                </div>
            </div>
        </div>
    </div>

    @if($warga)
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Persil -->
        <div class="glass rounded-2xl p-6 card-hover border border-white/50 shadow-xl">
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <i class="fas fa-map text-white text-xl"></i>
                </div>
                <div class="flex items-center gap-1 text-green-500 text-sm font-medium">
                    <i class="fas fa-check-circle"></i>
                    <span>Aktif</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm font-medium mb-1">Total Persil</p>
            <p class="text-4xl font-bold text-gray-800" data-count="{{ $stats['totalPersil'] }}">0</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('user.persil.list') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                    Lihat Detail <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Dokumen -->
        <div class="glass rounded-2xl p-6 card-hover border border-white/50 shadow-xl">
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <i class="fas fa-file-alt text-white text-xl"></i>
                </div>
                <div class="flex items-center gap-1 text-emerald-500 text-sm font-medium">
                    <i class="fas fa-folder"></i>
                    <span>Docs</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm font-medium mb-1">Total Dokumen</p>
            <p class="text-4xl font-bold text-gray-800" data-count="{{ $stats['totalDokumen'] }}">0</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('user.dokumen.list') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium flex items-center gap-1">
                    Lihat Detail <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Peta -->
        <div class="glass rounded-2xl p-6 card-hover border border-white/50 shadow-xl">
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center shadow-lg shadow-violet-500/30">
                    <i class="fas fa-map-marked-alt text-white text-xl"></i>
                </div>
                <div class="flex items-center gap-1 text-violet-500 text-sm font-medium">
                    <i class="fas fa-layer-group"></i>
                    <span>Maps</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm font-medium mb-1">Total Peta</p>
            <p class="text-4xl font-bold text-gray-800" data-count="{{ $stats['totalPeta'] }}">0</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('user.peta.list') }}" class="text-violet-600 hover:text-violet-700 text-sm font-medium flex items-center gap-1">
                    Lihat Detail <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Sengketa -->
        <div class="glass rounded-2xl p-6 card-hover border border-white/50 shadow-xl">
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/30">
                    <i class="fas fa-gavel text-white text-xl"></i>
                </div>
                @if($stats['totalSengketa'] > 0)
                <div class="flex items-center gap-1 text-amber-500 text-sm font-medium">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Perhatian</span>
                </div>
                @else
                <div class="flex items-center gap-1 text-green-500 text-sm font-medium">
                    <i class="fas fa-check-circle"></i>
                    <span>Aman</span>
                </div>
                @endif
            </div>
            <p class="text-gray-500 text-sm font-medium mb-1">Total Sengketa</p>
            <p class="text-4xl font-bold text-gray-800" data-count="{{ $stats['totalSengketa'] }}">0</p>
            <div class="mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('user.sengketa.list') }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium flex items-center gap-1">
                    Lihat Detail <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Persil List -->
        <div class="lg:col-span-2 glass rounded-2xl shadow-xl border border-white/50 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-map text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Data Persil Saya</h3>
                            <p class="text-gray-500 text-sm">Daftar persil yang Anda miliki</p>
                        </div>
                    </div>
                    <a href="{{ route('user.persil.list') }}" class="px-4 py-2 bg-teal-50 text-teal-600 rounded-xl hover:bg-teal-100 transition font-medium text-sm flex items-center gap-2">
                        <span>Lihat Semua</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            @if($persils->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-luxury">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-left text-gray-600">Kode Persil</th>
                            <th class="px-6 py-4 text-left text-gray-600">Penggunaan</th>
                            <th class="px-6 py-4 text-left text-gray-600">Luas</th>
                            <th class="px-6 py-4 text-left text-gray-600">Alamat</th>
                            <th class="px-6 py-4 text-center text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($persils as $persil)
                        <tr class="hover:bg-teal-50/50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono font-semibold text-teal-600 bg-teal-50 px-3 py-1 rounded-lg">
                                    {{ $persil->kode_persil }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-3 py-1.5 rounded-full">
                                    {{ $persil->penggunaan }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700 font-medium">{{ number_format($persil->luas_m2, 0, ',', '.') }}</span>
                                <span class="text-gray-400 text-sm">m²</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    {{ Str::limit($persil->alamat_lahan, 30) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('user.persil.detail', $persil->persil_id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition text-sm font-medium shadow-lg shadow-teal-500/30">
                                    <i class="fas fa-eye"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                </div>
                <h4 class="text-gray-600 font-semibold mb-2">Belum Ada Data Persil</h4>
                <p class="text-gray-400 text-sm">Anda belum memiliki data persil yang terdaftar.</p>
            </div>
            @endif
        </div>

        <!-- Quick Info Panel -->
        <div class="space-y-6">
            <!-- Profile Card -->
            <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden">
                <div class="h-24 gradient-primary relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                </div>
                <div class="p-6 -mt-12 relative">
                    <div class="w-24 h-24 rounded-2xl gradient-primary border-4 border-white shadow-xl flex items-center justify-center text-white text-3xl font-bold mx-auto">
                        {{ strtoupper(substr($warga->nama ?? auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="text-center mt-4">
                        <h4 class="text-xl font-bold text-gray-800">{{ $warga->nama ?? auth()->user()->name }}</h4>
                        <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                        <div class="mt-4 flex justify-center">
                            <span class="px-4 py-1.5 bg-teal-100 text-teal-700 rounded-full text-sm font-semibold">
                                <i class="fas fa-user-check mr-1"></i> Verified User
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">No. KTP</span>
                            <span class="font-mono font-medium text-gray-700">{{ $warga->no_ktp ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Jenis Kelamin</span>
                            <span class="font-medium text-gray-700">{{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Pekerjaan</span>
                            <span class="font-medium text-gray-700">{{ $warga->pekerjaan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass rounded-2xl p-6 shadow-xl border border-white/50">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-bolt text-amber-500"></i>
                    Akses Cepat
                </h4>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('user.persil.list') }}" class="p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition text-center group">
                        <div class="w-10 h-10 mx-auto mb-2 bg-blue-500 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition">
                            <i class="fas fa-map"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Persil</span>
                    </a>
                    <a href="{{ route('user.dokumen.list') }}" class="p-4 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition text-center group">
                        <div class="w-10 h-10 mx-auto mb-2 bg-emerald-500 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Dokumen</span>
                    </a>
                    <a href="{{ route('user.peta.list') }}" class="p-4 bg-violet-50 hover:bg-violet-100 rounded-xl transition text-center group">
                        <div class="w-10 h-10 mx-auto mb-2 bg-violet-500 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Peta</span>
                    </a>
                    <a href="{{ route('user.sengketa.list') }}" class="p-4 bg-amber-50 hover:bg-amber-100 rounded-xl transition text-center group">
                        <div class="w-10 h-10 mx-auto mb-2 bg-amber-500 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Sengketa</span>
                    </a>
                </div>
            </div>

            <!-- System Info -->
            <div class="glass rounded-2xl p-6 shadow-xl border border-white/50">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-500"></i>
                    Informasi
                </h4>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl">
                        <i class="fas fa-clock text-blue-500"></i>
                        <div>
                            <p class="text-gray-500">Terakhir Login</p>
                            <p class="font-medium text-gray-700">{{ now()->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl">
                        <i class="fas fa-shield-alt text-green-500"></i>
                        <div>
                            <p class="text-gray-500">Status Akun</p>
                            <p class="font-medium text-green-600">Aktif & Terverifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Not Connected Warning -->
    <div class="glass rounded-3xl p-12 shadow-xl border border-white/50 text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-amber-100 rounded-full flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-amber-500 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Akun Belum Terhubung</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            Akun Anda (<strong>{{ auth()->user()->email }}</strong>) belum terhubung dengan data warga.
            Silakan hubungi admin untuk menghubungkan akun Anda dengan data warga.
        </p>
        <div class="flex justify-center gap-4">
            <a href="#" class="px-6 py-3 bg-teal-600 text-white rounded-xl hover:bg-teal-700 transition font-medium shadow-lg shadow-teal-500/30">
                <i class="fas fa-headset mr-2"></i>
                Hubungi Admin
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
