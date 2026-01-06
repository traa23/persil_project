@extends('layouts.user')

@section('title', 'Sengketa Persil')
@section('page-title', 'Sengketa Persil Saya')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <!-- Search -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-balance-scale text-red-600 mr-2"></i>
            Daftar Sengketa
        </h3>
        <form action="{{ route('user.sengketa.list') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pihak, status..."
                   class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 w-64">
            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if($sengketas->count() > 0)
    <div class="space-y-4">
        @foreach($sengketas as $sengketa)
        <div class="border rounded-lg p-4 {{ $sengketa->status == 'selesai' ? 'border-green-200 bg-green-50' : ($sengketa->status == 'proses' ? 'border-yellow-200 bg-yellow-50' : 'border-gray-200 bg-gray-50') }}">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <a href="{{ route('user.persil.detail', $sengketa->persil_id) }}" class="font-mono text-blue-600 hover:underline font-semibold">
                            {{ $sengketa->persil->kode_persil ?? '-' }}
                        </a>
                        <span class="px-2 py-1 rounded text-xs font-medium
                            @if($sengketa->status == 'selesai') bg-green-200 text-green-800
                            @elseif($sengketa->status == 'proses') bg-yellow-200 text-yellow-800
                            @else bg-gray-200 text-gray-800
                            @endif">
                            @if($sengketa->status == 'selesai')
                                <i class="fas fa-check-circle mr-1"></i>
                            @elseif($sengketa->status == 'proses')
                                <i class="fas fa-sync-alt mr-1"></i>
                            @else
                                <i class="fas fa-clock mr-1"></i>
                            @endif
                            {{ ucfirst($sengketa->status) }}
                        </span>
                    </div>

                    <div class="text-lg font-medium text-gray-800 mb-2">
                        {{ $sengketa->pihak_1 }}
                        <span class="text-gray-400 mx-2">vs</span>
                        {{ $sengketa->pihak_2 }}
                    </div>

                    <p class="text-gray-600 text-sm mb-3">{{ $sengketa->kronologi }}</p>

                    @if($sengketa->penyelesaian)
                    <div class="p-3 bg-white rounded border border-green-200">
                        <span class="text-xs text-gray-500 block mb-1">Penyelesaian:</span>
                        <p class="text-sm text-gray-700">{{ $sengketa->penyelesaian }}</p>
                    </div>
                    @endif
                </div>

                <div class="text-xs text-gray-500">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ $sengketa->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $sengketas->links() }}
    </div>
    @else
    <div class="text-center py-12 text-gray-500">
        <i class="fas fa-balance-scale text-5xl mb-4"></i>
        <p class="text-lg">Tidak ada sengketa persil.</p>
        @if($search)
        <p class="text-sm mt-2">Tidak ditemukan hasil untuk "{{ $search }}"</p>
        <a href="{{ route('user.sengketa.list') }}" class="text-teal-600 hover:underline mt-2 inline-block">
            <i class="fas fa-times mr-1"></i> Hapus filter
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
