@extends('layouts.admin')

@section('title', 'Detail Peta')
@section('page-title', 'Detail Peta Persil')

@section('content')
<div class="mb-6">
    <a href="{{ getAdminRoute('peta.list') }}" class="text-purple-600 hover:text-purple-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Peta
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Peta</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="py-2 text-gray-600 w-1/3">Tanggal Survey</td>
                    <td class="py-2 font-medium">{{ $peta->tanggal_survey ? date('d/m/Y', strtotime($peta->tanggal_survey)) : '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Surveyor</td>
                    <td class="py-2 font-medium">{{ $peta->surveyor ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Koordinat</td>
                    <td class="py-2 font-medium">{{ $peta->koordinat ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Keterangan</td>
                    <td class="py-2">{{ $peta->keterangan ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Persil</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="py-2 text-gray-600 w-1/3">Kode Persil</td>
                    <td class="py-2">
                        <a href="{{ getAdminRoute('persil.detail', $peta->persil_id) }}" class="text-purple-600 hover:underline font-medium">
                            {{ $peta->persil->kode_persil ?? '-' }}
                        </a>
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Pemilik</td>
                    <td class="py-2 font-medium">{{ $peta->persil->pemilik->nama ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Alamat</td>
                    <td class="py-2">{{ $peta->persil->alamat_lahan ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Luas</td>
                    <td class="py-2">{{ $peta->persil->luas_m2 ?? '-' }} m²</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
