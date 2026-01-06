@extends('layouts.admin')

@section('title', 'Detail Jenis Penggunaan')
@section('page-title', 'Detail Jenis Penggunaan Lahan')

@section('content')
<div class="mb-4">
    <a href="{{ getAdminRoute('jenis-penggunaan.list') }}" class="text-purple-600 hover:text-purple-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Jenis Penggunaan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Data Jenis Penggunaan -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                <i class="fas fa-tags text-purple-600 mr-2"></i>Informasi Jenis Penggunaan
            </h3>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Penggunaan</p>
                    <p class="font-medium text-lg">{{ $jenis->nama_penggunaan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Keterangan</p>
                    <p class="font-medium">{{ $jenis->keterangan ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t flex gap-3">
                <a href="{{ getAdminRoute('jenis-penggunaan.edit', $jenis->jenis_id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                {{-- OLD: onsubmit="return confirm('Yakin ingin menghapus jenis penggunaan ini?')" --}}
                <form action="{{ getAdminRoute('jenis-penggunaan.delete', $jenis->jenis_id) }}" method="POST" onsubmit="event.preventDefault(); confirmDelete('Yakin ingin menghapus jenis penggunaan {{ $jenis->nama_penggunaan }}?', this);">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistik Penggunaan -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                <i class="fas fa-chart-pie text-purple-600 mr-2"></i>Statistik
            </h3>
            <div class="text-center py-4">
                <div class="text-4xl font-bold text-purple-600">{{ $jenis->persil->count() }}</div>
                <p class="text-gray-500 mt-1">Total Persil dengan Jenis Ini</p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Persil dengan Jenis Penggunaan Ini -->
<div class="mt-6 bg-white rounded-lg shadow">
    <div class="p-4 border-b">
        <h3 class="text-lg font-semibold">
            <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>Daftar Persil dengan Jenis Penggunaan "{{ $jenis->nama_penggunaan }}"
        </h3>
    </div>

    @if($jenis->persil->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Kode Persil</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Pemilik</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Alamat</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Luas (m²)</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenis->persil as $persil)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium">{{ $persil->kode_persil }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $persil->pemilik->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $persil->alamat_lahan }}</td>
                            <td class="px-4 py-3 text-sm">{{ number_format($persil->luas_m2, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ getAdminRoute('persil.detail', $persil->persil_id) }}" class="text-purple-600 hover:text-purple-800">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-map text-4xl mb-4"></i>
            <p>Belum ada persil dengan jenis penggunaan ini</p>
        </div>
    @endif
</div>
@endsection
