@extends('layouts.admin')

@section('title', 'Detail Dokumen')
@section('page-title', 'Detail Dokumen Persil')

@section('content')
<div class="mb-6">
    <a href="{{ getAdminRoute('dokumen.list') }}" class="text-purple-600 hover:text-purple-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Dokumen
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dokumen</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="py-2 text-gray-600 w-1/3">Jenis Dokumen</td>
                    <td class="py-2 font-medium">{{ $dokumen->jenis_dokumen }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Nomor</td>
                    <td class="py-2 font-medium">{{ $dokumen->nomor ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Tanggal Terbit</td>
                    <td class="py-2 font-medium">{{ $dokumen->tanggal_terbit ? date('d/m/Y', strtotime($dokumen->tanggal_terbit)) : '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Keterangan</td>
                    <td class="py-2">{{ $dokumen->keterangan ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Persil</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="py-2 text-gray-600 w-1/3">Kode Persil</td>
                    <td class="py-2">
                        <a href="{{ getAdminRoute('persil.detail', $dokumen->persil_id) }}" class="text-purple-600 hover:underline font-medium">
                            {{ $dokumen->persil->kode_persil ?? '-' }}
                        </a>
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Pemilik</td>
                    <td class="py-2 font-medium">{{ $dokumen->persil->pemilik->nama ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Alamat</td>
                    <td class="py-2">{{ $dokumen->persil->alamat_lahan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
