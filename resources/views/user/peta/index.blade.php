@extends('layouts.user')

@section('title', 'Peta Persil')
@section('page-title', 'Peta Persil')
@section('page-subtitle', 'Semua peta dan ukuran persil Anda')

@section('content')
<div class="space-y-6">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 p-8 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-violet-400/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold tracking-wide">
                        <i class="fas fa-map-marked-alt mr-1"></i> PETA PERSIL
                    </span>
                </div>
                <h2 class="text-3xl font-bold mb-2">Daftar Peta</h2>
                <p class="text-violet-100 max-w-lg">
                    Lihat dan kelola semua peta persil beserta informasi ukuran dan koordinat geografis.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-center px-6 py-4 bg-white/10 rounded-2xl backdrop-blur">
                    <p class="text-4xl font-bold">{{ $petas->total() }}</p>
                    <p class="text-violet-200 text-sm">Total Peta</p>
                </div>
            </div>
        </div>
    </div>

    @if($petas->count() > 0)
    <!-- Peta Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($petas as $peta)
        <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden card-hover group">
            <!-- Image/Preview Section -->
            @if($peta->gambar)
            <div class="aspect-video bg-violet-100 relative overflow-hidden">
                <img src="{{ asset('storage/' . $peta->gambar) }}" alt="Peta"
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition">
                    <div class="absolute bottom-3 left-3 right-3">
                        <span class="px-3 py-1 bg-white/90 rounded-full text-xs font-semibold text-violet-700">
                            <i class="fas fa-expand mr-1"></i> Preview
                        </span>
                    </div>
                </div>
            </div>
            @else
            <div class="aspect-video bg-gradient-to-br from-violet-100 to-purple-100 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map text-violet-300 text-5xl mb-2"></i>
                    <p class="text-violet-400 text-sm">No Preview</p>
                </div>
            </div>
            @endif

            <!-- Card Body -->
            <div class="p-5 space-y-4">
                <div class="flex items-center justify-between">
                    <a href="{{ route('user.persil.detail', $peta->persil_id) }}"
                       class="font-bold text-blue-600 hover:text-blue-700 font-mono text-lg">
                        {{ $peta->persil->kode_persil ?? '-' }}
                    </a>
                    @if($peta->geojson)
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>GeoJSON
                    </span>
                    @endif
                </div>

                <!-- Dimensions -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-4 bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl text-center border border-violet-100">
                        <div class="w-10 h-10 mx-auto mb-2 bg-violet-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-arrows-alt-h text-white"></i>
                        </div>
                        <p class="text-2xl font-bold text-violet-700">{{ $peta->panjang_m ?? '-' }}</p>
                        <p class="text-gray-500 text-xs">Panjang (m)</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl text-center border border-purple-100">
                        <div class="w-10 h-10 mx-auto mb-2 bg-purple-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-arrows-alt-v text-white"></i>
                        </div>
                        <p class="text-2xl font-bold text-purple-700">{{ $peta->lebar_m ?? '-' }}</p>
                        <p class="text-gray-500 text-xs">Lebar (m)</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-gray-400 text-sm">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $peta->created_at->format('d M Y') }}
                    </span>
                    <a href="{{ route('user.persil.detail', $peta->persil_id) }}"
                       class="text-violet-600 hover:text-violet-700 font-medium text-sm flex items-center gap-1">
                        Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="glass rounded-2xl p-4 shadow-xl border border-white/50">
        {{ $petas->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="glass rounded-3xl p-12 shadow-xl border border-white/50 text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <i class="fas fa-map-marked-alt text-gray-400 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Peta</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            Anda belum memiliki peta persil yang terdaftar dalam sistem.
        </p>
    </div>
    @endif
</div>
@endsection
