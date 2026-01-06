@extends('layouts.user')

@section('title', 'Dokumen Persil')
@section('page-title', 'Dokumen Persil')
@section('page-subtitle', 'Semua dokumen terkait persil Anda')

@section('content')
<div class="space-y-6">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-8 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-emerald-400/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold tracking-wide">
                        <i class="fas fa-file-alt mr-1"></i> DOKUMEN PERSIL
                    </span>
                </div>
                <h2 class="text-3xl font-bold mb-2">Daftar Dokumen</h2>
                <p class="text-emerald-100 max-w-lg">
                    Lihat dan kelola semua dokumen persil yang terdaftar.
                    Termasuk sertifikat, akta jual beli, dan dokumen lainnya.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-center px-6 py-4 bg-white/10 rounded-2xl backdrop-blur">
                    <p class="text-4xl font-bold">{{ $dokumens->total() }}</p>
                    <p class="text-emerald-200 text-sm">Total Dokumen</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="glass rounded-2xl p-6 shadow-xl border border-white/50">
        <form action="{{ route('user.dokumen.list') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Cari berdasarkan jenis, nomor, atau keterangan..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition font-medium flex items-center gap-2">
                <i class="fas fa-search"></i>
                <span>Cari</span>
            </button>
            @if($search)
            <a href="{{ route('user.dokumen.list') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium flex items-center gap-2">
                <i class="fas fa-times"></i>
                <span>Reset</span>
            </a>
            @endif
        </form>
    </div>

    @if($dokumens->count() > 0)
    <!-- Dokumen Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($dokumens as $dok)
        <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden card-hover group">
            <!-- Card Header -->
            <div class="p-5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white">
                <div class="flex items-center justify-between mb-2">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">
                        {{ $dok->jenis_dokumen }}
                    </span>
                    <i class="fas fa-file-contract text-2xl opacity-50"></i>
                </div>
                <h3 class="text-lg font-bold font-mono truncate">{{ $dok->nomor }}</h3>
            </div>

            <!-- Card Body -->
            <div class="p-5 space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Kode Persil</p>
                        <a href="{{ route('user.persil.detail', $dok->persil_id) }}"
                           class="font-bold text-blue-600 hover:text-blue-700 font-mono">
                            {{ $dok->persil->kode_persil ?? '-' }}
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Keterangan</p>
                        <p class="font-medium text-gray-700">{{ Str::limit($dok->keterangan, 50) ?? 'Tidak ada keterangan' }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-sm">
                    <span class="text-gray-400">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $dok->created_at->format('d M Y') }}
                    </span>
                    <a href="{{ route('user.persil.detail', $dok->persil_id) }}"
                       class="text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1">
                        Lihat Persil <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="glass rounded-2xl p-4 shadow-xl border border-white/50">
        {{ $dokumens->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="glass rounded-3xl p-12 shadow-xl border border-white/50 text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <i class="fas fa-file-alt text-gray-400 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Dokumen</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            @if($search)
                Tidak ditemukan hasil untuk pencarian "<strong>{{ $search }}</strong>".
            @else
                Anda belum memiliki dokumen persil yang terdaftar.
            @endif
        </p>
        @if($search)
        <a href="{{ route('user.dokumen.list') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition font-medium">
            <i class="fas fa-times"></i>
            <span>Hapus Filter</span>
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
