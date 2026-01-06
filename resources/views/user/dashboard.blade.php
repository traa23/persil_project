@extends('layouts.user')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Selamat Datang, {{ $warga->nama ?? auth()->user()->name }}!</h2>
                <p class="text-teal-100 mt-1">
                    @if($warga)
                        No. KTP: {{ $warga->no_ktp }}
                    @else
                        <span class="text-yellow-200">⚠️ Akun Anda belum terhubung dengan data warga. Hubungi admin.</span>
                    @endif
                </p>
            </div>
            <div class="text-5xl opacity-50">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </div>

    @if($warga)
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Persil</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['totalPersil'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-map text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Dokumen</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['totalDokumen'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Peta</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['totalPeta'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-map-marked-alt text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Sengketa</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['totalSengketa'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-balance-scale text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- My Persil List -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-map text-teal-600 mr-2"></i>
                Data Persil Saya
            </h3>
            <a href="{{ route('user.persil.list') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if($persils->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode Persil</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Penggunaan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Luas (m²)</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Alamat</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($persils as $persil)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono text-blue-600">{{ $persil->kode_persil }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-teal-100 text-teal-800 px-2 py-1 rounded text-xs">{{ $persil->penggunaan }}</span>
                        </td>
                        <td class="px-4 py-3">{{ number_format($persil->luas_m2, 2) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ Str::limit($persil->alamat_lahan, 40) }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('user.persil.detail', $persil->persil_id) }}" class="text-teal-600 hover:text-teal-800">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-3"></i>
            <p>Belum ada data persil.</p>
        </div>
        @endif
    </div>
    @else
    <!-- No linked warga -->
    <div class="bg-white rounded-xl shadow-md p-8 text-center">
        <div class="text-yellow-500 text-6xl mb-4">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Akun Belum Terhubung</h3>
        <p class="text-gray-600 mb-4">
            Akun Anda ({{ auth()->user()->email }}) belum terhubung dengan data warga.<br>
            Silakan hubungi admin untuk menghubungkan akun Anda dengan data warga.
        </p>
        <p class="text-sm text-gray-500">
            Email yang terdaftar harus sama dengan email di data warga.
        </p>
    </div>
    @endif
</div>
@endsection
