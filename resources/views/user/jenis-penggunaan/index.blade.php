@extends('layouts.user')

@section('title', 'Jenis Penggunaan')
@section('page-title', 'Jenis Penggunaan')
@section('page-subtitle', 'Referensi jenis penggunaan lahan')

@section('content')
<div class="space-y-6">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-400/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold tracking-wide">
                        <i class="fas fa-tags mr-1"></i> REFERENSI
                    </span>
                </div>
                <h2 class="text-3xl font-bold mb-2">Jenis Penggunaan Lahan</h2>
                <p class="text-indigo-100 max-w-lg">
                    Daftar referensi kategori penggunaan lahan yang tersedia dalam sistem.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-center px-6 py-4 bg-white/10 rounded-2xl backdrop-blur">
                    <p class="text-4xl font-bold">{{ $jenisPenggunaan->count() }}</p>
                    <p class="text-indigo-200 text-sm">Total Kategori</p>
                </div>
            </div>
        </div>
    </div>

    @if($jenisPenggunaan->count() > 0)
    <!-- Category Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($jenisPenggunaan as $index => $jenis)
        @php
            $colors = [
                ['from-blue-500', 'to-cyan-500', 'bg-blue-100', 'text-blue-600'],
                ['from-emerald-500', 'to-teal-500', 'bg-emerald-100', 'text-emerald-600'],
                ['from-violet-500', 'to-purple-500', 'bg-violet-100', 'text-violet-600'],
                ['from-amber-500', 'to-orange-500', 'bg-amber-100', 'text-amber-600'],
                ['from-pink-500', 'to-rose-500', 'bg-pink-100', 'text-pink-600'],
                ['from-indigo-500', 'to-blue-500', 'bg-indigo-100', 'text-indigo-600'],
            ];
            $color = $colors[$index % count($colors)];
        @endphp
        <div class="glass rounded-2xl shadow-xl border border-white/50 overflow-hidden card-hover group">
            <div class="h-2 bg-gradient-to-r {{ $color[0] }} {{ $color[1] }}"></div>
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl {{ $color[2] }} flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition">
                        <i class="fas fa-layer-group {{ $color[3] }} text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $jenis->nama }}</h3>
                        @if($jenis->keterangan)
                        <p class="text-gray-500 text-sm line-clamp-2">{{ $jenis->keterangan }}</p>
                        @else
                        <p class="text-gray-400 text-sm italic">Tidak ada keterangan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="glass rounded-3xl p-12 shadow-xl border border-white/50 text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <i class="fas fa-tags text-gray-400 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            Belum ada kategori jenis penggunaan lahan yang terdaftar dalam sistem.
        </p>
    </div>
    @endif
</div>
@endsection
