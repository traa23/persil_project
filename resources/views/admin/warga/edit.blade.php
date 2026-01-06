@extends('layouts.admin')

@section('title', 'Edit Warga')
@section('page-title', 'Edit Data Warga')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ getAdminRoute('warga.update', $warga->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- No KTP -->
            <div>
                <label for="no_ktp" class="block text-sm font-medium text-gray-700 mb-2">No. KTP <span class="text-red-500">*</span></label>
                <input type="text" name="no_ktp" id="no_ktp" value="{{ old('no_ktp', $warga->no_ktp) }}" maxlength="16" pattern="[0-9]{16}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('no_ktp') border-red-500 @enderror"
                       placeholder="16 digit NIK" required>
                @error('no_ktp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $warga->nama) }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('nama') border-red-500 @enderror"
                       placeholder="Nama lengkap sesuai KTP" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('jenis_kelamin') border-red-500 @enderror" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Agama -->
            <div>
                <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">Agama <span class="text-red-500">*</span></label>
                <select name="agama" id="agama"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('agama') border-red-500 @enderror" required>
                    <option value="">-- Pilih --</option>
                    <option value="Islam" {{ old('agama', $warga->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama', $warga->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama', $warga->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama', $warga->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama', $warga->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ old('agama', $warga->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
                @error('agama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pekerjaan -->
            <div>
                <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('pekerjaan') border-red-500 @enderror"
                       placeholder="Pekerjaan" required>
                @error('pekerjaan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Telepon -->
            <div>
                <label for="telp" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                <input type="text" name="telp" id="telp" value="{{ old('telp', $warga->telp) }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('telp') border-red-500 @enderror"
                       placeholder="08xxxxxxxxxx">
                @error('telp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="md:col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $warga->email) }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror"
                       placeholder="email@example.com">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-4 border-t">
            <a href="{{ getAdminRoute('warga.list') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium">
                <i class="fas fa-save mr-2"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection
