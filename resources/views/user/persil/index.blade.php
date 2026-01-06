@extends('layouts.user')

@section('title', 'Data Persil')
@section('page-title', 'Data Persil')
@section('page-subtitle', 'Kelola dan pantau semua data persil Anda')

@section('content')
<div class="space-y-6">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl gradient-secondary p-8 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-400/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold tracking-wide">
                        <i class="fas fa-map mr-1"></i> DATA PERSIL
                    </span>
                </div>
                <h2 class="text-3xl font-bold mb-2">Daftar Persil Anda</h2>
                <p class="text-blue-100 max-w-lg">
                    Lihat dan kelola semua data persil yang terdaftar atas nama Anda.
                    Klik detail untuk informasi lengkap.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-center px-6 py-4 bg-white/10 rounded-2xl backdrop-blur">
                    <p class="text-4xl font-bold">{{ $persils->total() }}</p>
                    <p class="text-blue-200 text-sm">Total Persil</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="glass rounded-2xl p-6 shadow-xl border border-white/50">
        <form action="{{ route('user.persil.list') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Cari berdasarkan kode, alamat, atau penggunaan..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
            </div>
            <button type="submit" class="px-6 py-3 gradient-primary text-white rounded-xl hover:shadow-lg hover:shadow-teal-500/30 transition font-medium flex items-center gap-2">
                <i class="fas fa-search"></i>
                <span>Cari</span>
            </button>
            @if($search)
            <a href="{{ route('user.persil.list') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium flex items-center gap-2">
                <i class="fas fa-times"></i>
                <span>Reset</span>
            </a>
            @endif
        </form>
    </div>

    <!-- Persil Grid -->
    @if($persils->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($persils as $persil)
        <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden card-hover group">
            <!-- Card Header -->
            <div class="p-6 gradient-primary text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">
                            {{ $persil->penggunaan }}
                        </span>
                        <span class="text-teal-100 text-sm">
                            RT {{ $persil->rt }}/RW {{ $persil->rw }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold font-mono">{{ $persil->kode_persil }}</h3>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-ruler-combined text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Luas Tanah</p>
                        <p class="font-bold text-gray-800">{{ number_format($persil->luas_m2, 0, ',', '.') }} m²</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Alamat</p>
                        <p class="font-medium text-gray-700">{{ Str::limit($persil->alamat_lahan, 40) }}</p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-2 pt-4 border-t border-gray-100">
                    <div class="text-center p-2 bg-blue-50 rounded-lg">
                        <p class="text-lg font-bold text-blue-600">{{ $persil->dokumenPersil ? $persil->dokumenPersil->count() : 0 }}</p>
                        <p class="text-xs text-gray-500">Dokumen</p>
                    </div>
                    <div class="text-center p-2 bg-violet-50 rounded-lg">
                        <p class="text-lg font-bold text-violet-600">{{ $persil->petaPersil ? $persil->petaPersil->count() : 0 }}</p>
                        <p class="text-xs text-gray-500">Peta</p>
                    </div>
                    <div class="text-center p-2 bg-amber-50 rounded-lg">
                        <p class="text-lg font-bold text-amber-600">{{ $persil->sengketa ? $persil->sengketa->count() : 0 }}</p>
                        <p class="text-xs text-gray-500">Sengketa</p>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-6 pb-6">
                <a href="{{ route('user.persil.detail', $persil->persil_id) }}"
                   class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-teal-500 text-white rounded-xl hover:bg-teal-600 transition font-medium group-hover:shadow-lg group-hover:shadow-teal-500/30">
                    <i class="fas fa-eye"></i>
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="glass rounded-2xl p-4 shadow-xl border border-white/50">
        {{ $persils->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="glass rounded-3xl p-12 shadow-xl border border-white/50 text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <i class="fas fa-map text-gray-400 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data Persil</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            @if($search)
                Tidak ditemukan hasil untuk pencarian "<strong>{{ $search }}</strong>".
                Coba kata kunci lain atau hapus filter.
            @else
                Anda belum memiliki data persil yang terdaftar.
                Hubungi admin untuk mendaftarkan persil Anda.
            @endif
        </p>
        @if($search)
        <a href="{{ route('user.persil.list') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white rounded-xl hover:bg-teal-700 transition font-medium">
            <i class="fas fa-times"></i>
            <span>Hapus Filter</span>
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
