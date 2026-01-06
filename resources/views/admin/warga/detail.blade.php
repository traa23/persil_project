@extends('layouts.admin')

@section('title', 'Detail Warga')
@section('page-title', 'Detail Data Warga')

@section('content')
<div class="mb-4">
    <a href="{{ getAdminRoute('warga.list') }}" class="text-purple-600 hover:text-purple-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Warga
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Data Warga -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                <i class="fas fa-user text-purple-600 mr-2"></i>Informasi Warga
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">No. KTP</p>
                    <p class="font-medium">{{ $warga->no_ktp }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                    <p class="font-medium">{{ $warga->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jenis Kelamin</p>
                    <p class="font-medium">{{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Agama</p>
                    <p class="font-medium">{{ $warga->agama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pekerjaan</p>
                    <p class="font-medium">{{ $warga->pekerjaan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">No. Telepon</p>
                    <p class="font-medium">{{ $warga->telp ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $warga->email ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t flex gap-3">
                <a href="{{ getAdminRoute('warga.edit', $warga->warga_id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                {{-- OLD: onsubmit="return confirm('Yakin ingin menghapus data warga ini?')" --}}
                <form action="{{ getAdminRoute('warga.delete', $warga->warga_id) }}" method="POST" onsubmit="event.preventDefault(); confirmDelete('Yakin ingin menghapus data warga {{ $warga->nama }}?', this);">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistik Warga -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                <i class="fas fa-chart-bar text-purple-600 mr-2"></i>Statistik Kepemilikan
            </h3>
            <div class="text-center py-4">
                <div class="text-4xl font-bold text-purple-600">{{ $warga->persil->count() }}</div>
                <p class="text-gray-500 mt-1">Total Persil Dimiliki</p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Persil yang Dimiliki -->
<div class="mt-6 bg-white rounded-lg shadow">
    <div class="p-4 border-b">
        <h3 class="text-lg font-semibold">
            <i class="fas fa-map-marked-alt text-purple-600 mr-2"></i>Daftar Persil yang Dimiliki
        </h3>
    </div>

    @if($warga->persil->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Kode Persil</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Alamat</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Luas (m²)</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Penggunaan</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warga->persil as $persil)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium">{{ $persil->kode_persil }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $persil->alamat_lahan }}</td>
                            <td class="px-4 py-3 text-sm">{{ number_format($persil->luas_m2, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $persil->penggunaan }}</td>
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
            <p>Warga ini belum memiliki persil</p>
        </div>
    @endif
</div>
@endsection
