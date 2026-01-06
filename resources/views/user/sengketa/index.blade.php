@extends('layouts.user')

@section('title', 'Sengketa Persil')
@section('page-title', 'Sengketa Persil')
@section('page-subtitle', 'Daftar sengketa dan status penyelesaian')

@section('content')
<div class="space-y-6">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 p-8 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-400/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold tracking-wide">
                        <i class="fas fa-gavel mr-1"></i> SENGKETA PERSIL
                    </span>
                </div>
                <h2 class="text-3xl font-bold mb-2">Daftar Sengketa</h2>
                <p class="text-amber-100 max-w-lg">
                    Pantau status sengketa dan perkembangan penyelesaian untuk persil Anda.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-center px-6 py-4 bg-white/10 rounded-2xl backdrop-blur">
                    <p class="text-4xl font-bold">{{ $sengketas->total() }}</p>
                    <p class="text-amber-200 text-sm">Total Sengketa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="glass rounded-2xl p-6 shadow-xl border border-white/50">
        <form action="{{ route('user.sengketa.list') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Cari berdasarkan pihak, status, atau keterangan..."
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl hover:shadow-lg hover:shadow-amber-500/30 transition font-medium flex items-center gap-2">
                <i class="fas fa-search"></i>
                <span>Cari</span>
            </button>
            @if($search)
            <a href="{{ route('user.sengketa.list') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium flex items-center gap-2">
                <i class="fas fa-times"></i>
                <span>Reset</span>
            </a>
            @endif
        </form>
    </div>

    @if($sengketas->count() > 0)
    <!-- Sengketa Cards -->
    <div class="space-y-6">
        @foreach($sengketas as $sengketa)
        <div class="glass rounded-2xl shadow-xl border-2 overflow-hidden card-hover
            @if($sengketa->status == 'selesai') border-green-200
            @elseif($sengketa->status == 'proses') border-amber-200
            @else border-gray-200
            @endif">

            <!-- Status Banner -->
            <div class="px-6 py-3
                @if($sengketa->status == 'selesai') bg-gradient-to-r from-green-500 to-emerald-500
                @elseif($sengketa->status == 'proses') bg-gradient-to-r from-amber-500 to-orange-500
                @else bg-gradient-to-r from-gray-500 to-slate-500
                @endif text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                        @if($sengketa->status == 'selesai')
                            <i class="fas fa-check"></i>
                        @elseif($sengketa->status == 'proses')
                            <i class="fas fa-clock"></i>
                        @else
                            <i class="fas fa-pause"></i>
                        @endif
                    </div>
                    <span class="font-semibold text-lg">{{ ucfirst($sengketa->status) }}</span>
                </div>
                <span class="text-sm opacity-80">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ $sengketa->created_at->format('d M Y') }}
                </span>
            </div>

            <div class="p-6">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Main Info -->
                    <div class="flex-1 space-y-4">
                        <!-- Kode Persil -->
                        <div class="flex items-center gap-3 mb-4">
                            <a href="{{ route('user.persil.detail', $sengketa->persil_id) }}"
                               class="px-4 py-2 bg-blue-50 rounded-xl font-mono font-bold text-blue-600 hover:bg-blue-100 transition">
                                <i class="fas fa-map mr-2"></i>{{ $sengketa->persil->kode_persil ?? '-' }}
                            </a>
                        </div>

                        <!-- Parties Involved -->
                        <div class="flex flex-col md:flex-row items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            <div class="flex-1 text-center p-4 bg-white rounded-xl shadow-sm">
                                <div class="w-12 h-12 mx-auto mb-2 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <p class="text-xs text-gray-400 mb-1">Pihak 1</p>
                                <p class="font-bold text-gray-800">{{ $sengketa->pihak_1 }}</p>
                            </div>

                            <div class="text-3xl text-gray-300">
                                <i class="fas fa-arrows-alt-h"></i>
                            </div>

                            <div class="flex-1 text-center p-4 bg-white rounded-xl shadow-sm">
                                <div class="w-12 h-12 mx-auto mb-2 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-red-600"></i>
                                </div>
                                <p class="text-xs text-gray-400 mb-1">Pihak 2</p>
                                <p class="font-bold text-gray-800">{{ $sengketa->pihak_2 }}</p>
                            </div>
                        </div>

                        <!-- Kronologi -->
                        <div class="p-4 bg-amber-50 rounded-xl border border-amber-100">
                            <h4 class="font-semibold text-amber-800 mb-2 flex items-center gap-2">
                                <i class="fas fa-history"></i> Kronologi
                            </h4>
                            <p class="text-gray-700">{{ $sengketa->kronologi }}</p>
                        </div>

                        <!-- Penyelesaian -->
                        @if($sengketa->penyelesaian)
                        <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                            <h4 class="font-semibold text-green-800 mb-2 flex items-center gap-2">
                                <i class="fas fa-check-circle"></i> Penyelesaian
                            </h4>
                            <p class="text-gray-700">{{ $sengketa->penyelesaian }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="glass rounded-2xl p-4 shadow-xl border border-white/50">
        {{ $sengketas->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="glass rounded-3xl p-12 shadow-xl border border-white/50 text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
            <i class="fas fa-check-double text-green-500 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Sengketa</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            @if($search)
                Tidak ditemukan hasil untuk pencarian "<strong>{{ $search }}</strong>".
            @else
                Selamat! Anda tidak memiliki sengketa persil yang tercatat dalam sistem.
            @endif
        </p>
        @if($search)
        <a href="{{ route('user.sengketa.list') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 text-white rounded-xl hover:bg-amber-700 transition font-medium">
            <i class="fas fa-times"></i>
            <span>Hapus Filter</span>
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
