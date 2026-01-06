@extends('layouts.user')

@section('title', 'Dokumen Persil')
@section('page-title', 'Dokumen Persil Saya')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <!-- Search -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-file-alt text-green-600 mr-2"></i>
            Daftar Dokumen
        </h3>
        <form action="{{ route('user.dokumen.list') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari jenis, nomor, keterangan..."
                   class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 w-64">
            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if($dokumens->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode Persil</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Jenis Dokumen</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Nomor</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Keterangan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($dokumens as $index => $dok)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $dokumens->firstItem() + $index }}</td>
                    <td class="px-4 py-3 font-mono text-blue-600">
                        <a href="{{ route('user.persil.detail', $dok->persil_id) }}" class="hover:underline">
                            {{ $dok->persil->kode_persil ?? '-' }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ $dok->jenis_dokumen }}</span>
                    </td>
                    <td class="px-4 py-3 font-mono text-sm">{{ $dok->nomor }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ Str::limit($dok->keterangan, 40) ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $dok->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $dokumens->links() }}
    </div>
    @else
    <div class="text-center py-12 text-gray-500">
        <i class="fas fa-file-alt text-5xl mb-4"></i>
        <p class="text-lg">Belum ada dokumen persil.</p>
        @if($search)
        <p class="text-sm mt-2">Tidak ditemukan hasil untuk "{{ $search }}"</p>
        <a href="{{ route('user.dokumen.list') }}" class="text-teal-600 hover:underline mt-2 inline-block">
            <i class="fas fa-times mr-1"></i> Hapus filter
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
