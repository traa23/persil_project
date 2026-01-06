@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- DASHBOARD STATS CARDS - Improved Mobile View -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1: Total Persil -->
    <div class="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="bg-purple-100 rounded-full p-4 mr-6">
                <i class="fas fa-map text-purple-600 text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Persil</p>
                <p class="text-4xl font-bold text-gray-800 mt-1">{{ $totalPersil }}</p>
            </div>
        </div>
    </div>

    <!-- Card 2: Total User -->
    <div class="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="bg-blue-100 rounded-full p-4 mr-6">
                <i class="fas fa-users text-blue-600 text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-medium">Total User</p>
                <p class="text-4xl font-bold text-gray-800 mt-1">{{ $totalUser }}</p>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Warga -->
    <div class="bg-white rounded-lg shadow-md p-8 hover:shadow-lg transition">
        <div class="flex items-center">
            <div class="bg-green-100 rounded-full p-4 mr-6">
                <i class="fas fa-id-card text-green-600 text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Warga</p>
                <p class="text-4xl font-bold text-gray-800 mt-1">{{ $totalWarga }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <a href="{{ getAdminRoute('persil.create') }}" class="block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold text-center">
        <i class="fas fa-plus mr-2"></i> Tambah Persil
    </a>
    <a href="{{ getAdminRoute('warga.create') }}" class="block px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-center">
        <i class="fas fa-user-plus mr-2"></i> Tambah Warga
    </a>
</div>

<!-- Recent Persil Table -->
<div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-history mr-3 text-purple-600"></i>
        Persil Terbaru
    </h2>

    @if ($recentPersil->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b-2 border-gray-300">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800">Kode Persil</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800">Pemilik</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800">Alamat</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800">Luas (m²)</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-800">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentPersil as $persil)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-base font-semibold text-gray-800">{{ $persil->kode_persil }}</td>
                            <td class="px-6 py-4 text-base text-gray-700">{{ $persil->pemilik->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-base text-gray-700">{{ $persil->alamat_lahan }}</td>
                            <td class="px-6 py-4 text-base text-gray-700">{{ $persil->luas_m2 }}</td>
                            <td class="px-6 py-4 text-base text-gray-700">{{ $persil->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600 text-center py-12 text-lg">Belum ada data persil</p>
    @endif

    <div class="mt-6 pt-6 border-t">
        {{-- OLD: route('admin.persil.list') --}}
        <a href="{{ getAdminRoute('persil.list') }}" class="text-purple-600 hover:text-purple-800 font-bold text-base transition">
            Lihat semua data persil <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>

<!-- RESPONSIVE OPTIMIZATION STYLES -->
<style>
    @media (max-width: 768px) {
        /* Mobile optimization untuk dashboard cards */
        .grid {
            grid-template-columns: 1fr !important;
        }

        /* Ensure buttons are minimum 48px height for mobile touch */
        .block.px-6 {
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        /* Table responsiveness - stack columns di mobile */
        table {
            font-size: 14px;
        }

        /* Hide less important columns di mobile untuk readability */
        @media (max-width: 640px) {
            th:nth-child(3),
            td:nth-child(3) {
                display: none;
            }

            th:nth-child(4),
            td:nth-child(4) {
                display: none;
            }
        }
    }
</style>
@endsection
