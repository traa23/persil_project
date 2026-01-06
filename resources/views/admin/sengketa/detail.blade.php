@extends('layouts.admin')

@section('title', 'Detail Sengketa')
@section('page-title', 'Detail Sengketa Persil')

@section('content')
<div class="mb-6">
    <a href="{{ getAdminRoute('sengketa.list') }}" class="text-purple-600 hover:text-purple-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Sengketa
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Sengketa</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="py-2 text-gray-600 w-1/3">Pihak 1</td>
                    <td class="py-2 font-medium">{{ $sengketa->pihak_1 ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Pihak 2</td>
                    <td class="py-2 font-medium">{{ $sengketa->pihak_2 ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Status</td>
                    <td class="py-2">
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
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Tanggal Mulai</td>
                    <td class="py-2">{{ $sengketa->tanggal_mulai ? date('d/m/Y', strtotime($sengketa->tanggal_mulai)) : '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Tanggal Selesai</td>
                    <td class="py-2">{{ $sengketa->tanggal_selesai ? date('d/m/Y', strtotime($sengketa->tanggal_selesai)) : '-' }}</td>
                </tr>
            </table>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Persil</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="py-2 text-gray-600 w-1/3">Kode Persil</td>
                    <td class="py-2">
                        <a href="{{ getAdminRoute('persil.detail', $sengketa->persil_id) }}" class="text-purple-600 hover:underline font-medium">
                            {{ $sengketa->persil->kode_persil ?? '-' }}
                        </a>
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Pemilik</td>
                    <td class="py-2 font-medium">{{ $sengketa->persil->pemilik->nama ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Alamat</td>
                    <td class="py-2">{{ $sengketa->persil->alamat_lahan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if($sengketa->kronologi)
    <div class="mt-6 pt-6 border-t">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kronologi</h3>
        <p class="text-gray-700 whitespace-pre-line">{{ $sengketa->kronologi }}</p>
    </div>
    @endif

    @if($sengketa->hasil_mediasi)
    <div class="mt-6 pt-6 border-t">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Hasil Mediasi</h3>
        <p class="text-gray-700 whitespace-pre-line">{{ $sengketa->hasil_mediasi }}</p>
    </div>
    @endif
</div>
@endsection
