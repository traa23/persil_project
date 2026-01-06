@extends('layouts.admin')

@section('title', 'Kelola Warga')
@section('page-title', 'Kelola Warga')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <a href="{{ getAdminRoute('warga.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium transition">
            <i class="fas fa-plus mr-2"></i> Tambah Warga
        </a>
    </div>
    <div class="flex-1 md:max-w-md">
        <form method="GET" action="{{ getAdminRoute('warga.list') }}" class="flex-1 flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, NIK, email..."
                   class="flex-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium transition">
                <i class="fas fa-search"></i>
            </button>
            @if ($search)
                <a href="{{ getAdminRoute('warga.list') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">No. KTP</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">JK</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Pekerjaan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Telp</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($wargaList as $warga)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono text-sm">{{ $warga->no_ktp }}</td>
                        <td class="px-4 py-3 font-medium">{{ $warga->nama }}</td>
                        <td class="px-4 py-3">{{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-4 py-3">{{ $warga->pekerjaan }}</td>
                        <td class="px-4 py-3">{{ $warga->telp ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ getAdminRoute('warga.edit', $warga->warga_id) }}" class="text-blue-600 hover:text-blue-700 hover:scale-110 transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="wargaDeleteForm-{{ $warga->warga_id }}" action="{{ getAdminRoute('warga.delete', $warga->warga_id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDeleteWarga({{ $warga->warga_id }})" class="text-red-600 hover:text-red-700 hover:scale-110 transition ml-2" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-2 block"></i>
                            Tidak ada data warga
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($wargaList->hasPages())
        <div class="px-4 py-3 border-t">
            {{ $wargaList->links() }}
        </div>
    @endif
</div>

<script>
function confirmDeleteWarga(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data warga ini?')) {
        document.getElementById('wargaDeleteForm-' + id).submit();
    }
}
</script>
@endsection
