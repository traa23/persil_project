@extends('layouts.admin')

@section('title', 'Data Persil')
@section('page-title', 'Data Persil')

@section('content')
<div class="mb-6">
    <div class="flex gap-4 items-center">
        <a href="{{ getAdminRoute('persil.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium transition">
            <i class="fas fa-plus mr-2"></i>Tambah Data Persil
        </a>

        <!-- Search Form -->
        <form method="GET" action="{{ getAdminRoute('persil.list') }}" class="flex-1 flex gap-2">
            <div class="flex-1 relative">
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari kode, alamat, pemilik, atau jenis..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            @if($search)
                <a href="{{ getAdminRoute('persil.list') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            @endif
        </form>
    </div>

    @if($search)
        <p class="text-gray-600 text-sm mt-2">
            <i class="fas fa-info-circle mr-1"></i>
            Hasil pencarian untuk: <strong>"{{ $search }}"</strong>
        </p>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    @if ($persils->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kode Persil</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Pemilik</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Alamat</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Luas (m²)</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Penggunaan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($persils as $persil)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium">{{ $persil->kode_persil }}</td>
                        <td class="px-4 py-3 text-sm">{{ $persil->pemilik->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $persil->alamat_lahan }}</td>
                        <td class="px-4 py-3 text-sm">{{ number_format($persil->luas_m2, 2) }}</td>
                        <td class="px-4 py-3 text-sm">{{ $persil->jenisPenggunaan->nama_penggunaan ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm space-x-2 flex items-center">
                            <a href="{{ getAdminRoute('persil.detail', $persil->persil_id) }}" class="text-green-600 hover:text-green-700 hover:scale-110 transition" title="Lihat Detail">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                            <a href="{{ getAdminRoute('persil.edit', $persil->persil_id) }}" class="text-blue-600 hover:text-blue-700 hover:scale-110 transition" title="Edit">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <form id="deleteForm-{{ $persil->persil_id }}" action="{{ getAdminRoute('persil.delete', $persil->persil_id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showConfirm('Hapus persil {{ $persil->kode_persil }}?', document.getElementById('deleteForm-{{ $persil->persil_id }}'))" class="text-red-600 hover:text-red-700 hover:scale-110 transition" title="Hapus">
                                    <i class="fas fa-trash text-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-4 py-4">
            {{ $persils->links() }}
        </div>
    @else
        <div class="p-8 text-center">
            <p class="text-gray-600">Belum ada data persil</p>
        </div>
    @endif
</div>
@endsection
