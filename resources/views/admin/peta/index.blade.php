@extends('layouts.admin')

@section('title', 'Peta Persil')
@section('page-title', 'Peta Persil')

@section('content')
<div class="mb-6">
    <form method="GET" action="{{ getAdminRoute('peta.list') }}" class="flex gap-2">
        <div class="flex-1 relative">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari kode persil atau alamat..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>
        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium transition">
            <i class="fas fa-search mr-2"></i>Cari
        </button>
        @if($search)
            <a href="{{ getAdminRoute('peta.list') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    @if ($petas->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kode Persil</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Pemilik</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal Survey</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Surveyor</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($petas as $peta)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ getAdminRoute('persil.detail', $peta->persil_id) }}" class="text-purple-600 hover:underline font-medium">
                                {{ $peta->persil->kode_persil ?? '-' }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $peta->persil->pemilik->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $peta->tanggal_survey ? date('d/m/Y', strtotime($peta->tanggal_survey)) : '-' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $peta->surveyor ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ getAdminRoute('peta.detail', $peta->peta_id) }}" class="text-blue-600 hover:text-blue-800" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ getAdminRoute('peta.edit', $peta->peta_id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ getAdminRoute('peta.delete', $peta->peta_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus peta ini?')">
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
            {{ $petas->links() }}
        </div>
    @else
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-map text-4xl mb-4"></i>
            <p>Belum ada data peta persil</p>
        </div>
    @endif
</div>
@endsection
