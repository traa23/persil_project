@extends('layouts.admin')

@section('title', 'Jenis Penggunaan')
@section('page-title', 'Jenis Penggunaan Lahan')

@section('content')
<div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
    <a href="{{ getAdminRoute('jenis-penggunaan.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium transition">
        <i class="fas fa-plus mr-2"></i>Tambah Jenis Penggunaan
    </a>

    <form method="GET" action="{{ getAdminRoute('jenis-penggunaan.list') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari jenis penggunaan..."
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium transition">
            <i class="fas fa-search"></i>
        </button>
        @if($search)
            <a href="{{ getAdminRoute('jenis-penggunaan.list') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    @if ($jenisList->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Nama Penggunaan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Keterangan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jenisList as $jenis)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium">{{ $jenis->nama_penggunaan }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $jenis->keterangan ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ getAdminRoute('jenis-penggunaan.detail', $jenis->jenis_id) }}" class="text-purple-600 hover:text-purple-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ getAdminRoute('jenis-penggunaan.edit', $jenis->jenis_id) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- OLD: onsubmit="return confirm('Yakin ingin menghapus?')" --}}
                                <form action="{{ getAdminRoute('jenis-penggunaan.delete', $jenis->jenis_id) }}" method="POST" class="inline" onsubmit="event.preventDefault(); confirmDelete('Yakin ingin menghapus jenis penggunaan {{ $jenis->nama_penggunaan }}?', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $jenisList->links() }}
        </div>
    @else
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-tags text-4xl mb-4"></i>
            <p>Belum ada data jenis penggunaan</p>
        </div>
    @endif
</div>
@endsection
