@extends('layouts.user')

@section('title', 'Data Persil')
@section('page-title', 'Data Persil Saya')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <!-- Search -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-map text-teal-600 mr-2"></i>
            Daftar Persil
        </h3>
        <form action="{{ route('user.persil.list') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari kode, alamat, penggunaan..."
                   class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 w-64">
            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if($persils->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode Persil</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Penggunaan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Luas (m²)</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Alamat</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">RT/RW</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($persils as $index => $persil)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $persils->firstItem() + $index }}</td>
                    <td class="px-4 py-3 font-mono text-blue-600 font-semibold">{{ $persil->kode_persil }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-teal-100 text-teal-800 px-2 py-1 rounded text-xs">{{ $persil->penggunaan }}</span>
                    </td>
                    <td class="px-4 py-3">{{ number_format($persil->luas_m2, 2) }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ Str::limit($persil->alamat_lahan, 30) }}</td>
                    <td class="px-4 py-3">{{ $persil->rt }}/{{ $persil->rw }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('user.persil.detail', $persil->persil_id) }}"
                           class="bg-teal-500 text-white px-3 py-1 rounded hover:bg-teal-600 text-sm">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $persils->links() }}
    </div>
    @else
    <div class="text-center py-12 text-gray-500">
        <i class="fas fa-inbox text-5xl mb-4"></i>
        <p class="text-lg">Belum ada data persil.</p>
        @if($search)
        <p class="text-sm mt-2">Tidak ditemukan hasil untuk "{{ $search }}"</p>
        <a href="{{ route('user.persil.list') }}" class="text-teal-600 hover:underline mt-2 inline-block">
            <i class="fas fa-times mr-1"></i> Hapus filter
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
