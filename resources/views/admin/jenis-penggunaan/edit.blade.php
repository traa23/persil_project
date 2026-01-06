@extends('layouts.admin')

@section('title', 'Edit Jenis Penggunaan')
@section('page-title', 'Edit Jenis Penggunaan Lahan')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ getAdminRoute('jenis-penggunaan.update', $jenis->jenis_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_penggunaan" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Penggunaan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_penggunaan" id="nama_penggunaan" value="{{ old('nama_penggunaan', $jenis->nama_penggunaan) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('nama_penggunaan') border-red-500 @enderror"
                    placeholder="Masukkan nama penggunaan" required>
                @error('nama_penggunaan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">
                    Keterangan
                </label>
                <textarea name="keterangan" id="keterangan" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('keterangan') border-red-500 @enderror"
                    placeholder="Masukkan keterangan (opsional)">{{ old('keterangan', $jenis->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
                <a href="{{ getAdminRoute('jenis-penggunaan.list') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-medium transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
