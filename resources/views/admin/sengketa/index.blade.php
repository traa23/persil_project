@extends('layouts.admin')

@section('title', 'Sengketa Persil')
@section('page-title', 'Sengketa Persil')

@section('content')
<div class="mb-6">
    <form method="GET" action="{{ getAdminRoute('sengketa.list') }}" class="flex flex-wrap gap-2">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pihak atau kode persil..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="">Semua Status</option>
            <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="proses" {{ ($status ?? '') == 'proses' ? 'selected' : '' }}>Proses</option>
            <option value="selesai" {{ ($status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium transition">
            <i class="fas fa-search mr-2"></i>Filter
        </button>
        @if($search || $status)
            <a href="{{ getAdminRoute('sengketa.list') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    @if ($sengketas->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Kode Persil</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Pihak 1</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Pihak 2</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sengketas as $sengketa)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ getAdminRoute('persil.detail', $sengketa->persil_id) }}" class="text-purple-600 hover:underline font-medium">
                                {{ $sengketa->persil->kode_persil ?? '-' }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $sengketa->pihak_1 ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $sengketa->pihak_2 ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'proses' => 'bg-blue-100 text-blue-800',
                                    'selesai' => 'bg-green-100 text-green-800',
                                ];
                                $color = $statusColors[$sengketa->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                                {{ ucfirst($sengketa->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $sengketa->created_at ? $sengketa->created_at->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ getAdminRoute('sengketa.detail', $sengketa->sengketa_id) }}" class="text-blue-600 hover:text-blue-800" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ getAdminRoute('sengketa.edit', $sengketa->sengketa_id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ getAdminRoute('sengketa.delete', $sengketa->sengketa_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data sengketa ini?')">
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
            {{ $sengketas->links() }}
        </div>
    @else
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-gavel text-4xl mb-4"></i>
            <p>Belum ada data sengketa persil</p>
        </div>
    @endif
</div>
@endsection
