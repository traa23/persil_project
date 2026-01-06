@extends('layouts.admin')

@section('title', 'Dokumen Persil')
@section('page-title', 'Dokumen Persil')

@section('content')
<div class="mb-6">
    <form method="GET" action="{{ getAdminRoute('dokumen.list') }}" class="flex gap-2">
        <div class="flex-1 relative">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari jenis dokumen, nomor, atau kode persil..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>
        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium transition">
            <i class="fas fa-search mr-2"></i>Cari
        </button>
        @if($search)
            <a href="{{ getAdminRoute('dokumen.list') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    @if ($dokumens->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kode Persil</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Jenis Dokumen</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Nomor</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Terbit</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dokumens as $dokumen)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ getAdminRoute('persil.detail', $dokumen->persil_id) }}" class="text-purple-600 hover:underline font-medium">
                                {{ $dokumen->persil->kode_persil ?? '-' }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $dokumen->jenis_dokumen }}</td>
                        <td class="px-4 py-3 text-sm">{{ $dokumen->nomor ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $dokumen->tanggal_terbit ? date('d/m/Y', strtotime($dokumen->tanggal_terbit)) : '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ getAdminRoute('dokumen.detail', $dokumen->dokumen_id) }}" class="text-blue-600 hover:text-blue-800" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ getAdminRoute('dokumen.edit', $dokumen->dokumen_id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ getAdminRoute('dokumen.delete', $dokumen->dokumen_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
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
            {{ $dokumens->links() }}
        </div>
    @else
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-file-alt text-4xl mb-4"></i>
            <p>Belum ada data dokumen persil</p>
        </div>
    @endif
</div>
@endsection
