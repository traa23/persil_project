@extends('layouts.user')

@section('title', 'Peta Persil')
@section('page-title', 'Peta Persil Saya')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-6">
        <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>
        Daftar Peta Persil
    </h3>

    @if($petas->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($petas as $peta)
        <div class="border rounded-lg p-4 hover:shadow-md transition">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <a href="{{ route('user.persil.detail', $peta->persil_id) }}" class="font-mono text-blue-600 hover:underline font-semibold">
                        {{ $peta->persil->kode_persil ?? '-' }}
                    </a>
                    <p class="text-sm text-gray-500">Peta ID: {{ $peta->peta_id }}</p>
                </div>
                @if($peta->geojson)
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">GeoJSON</span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                <div class="bg-gray-50 p-2 rounded">
                    <span class="text-gray-500 block text-xs">Panjang</span>
                    <span class="font-semibold">{{ $peta->panjang_m ?? '-' }} m</span>
                </div>
                <div class="bg-gray-50 p-2 rounded">
                    <span class="text-gray-500 block text-xs">Lebar</span>
                    <span class="font-semibold">{{ $peta->lebar_m ?? '-' }} m</span>
                </div>
            </div>

            <div class="text-xs text-gray-500">
                <i class="fas fa-calendar mr-1"></i>
                {{ $peta->created_at->format('d M Y') }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $petas->links() }}
    </div>
    @else
    <div class="text-center py-12 text-gray-500">
        <i class="fas fa-map-marked-alt text-5xl mb-4"></i>
        <p class="text-lg">Belum ada peta persil.</p>
    </div>
    @endif
</div>
@endsection
