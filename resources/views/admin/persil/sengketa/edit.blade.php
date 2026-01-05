@extends('layouts.admin')

@section('title', 'Edit Sengketa')
@section('page-title', 'Edit Sengketa Persil')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Persil: {{ $persil->kode_persil }}</h3>

    <form action="{{ route('admin.sengketa.update', $sengketa->sengketa_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pihak 1 -->
            <div>
                <label for="pihak_1" class="block text-sm font-medium text-gray-700 mb-2">
                    Pihak 1 <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="pihak_1"
                    name="pihak_1"
                    value="{{ old('pihak_1', $sengketa->pihak_1) }}"
                    class="w-full px-4 py-2 border @error('pihak_1') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
                @error('pihak_1')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pihak 2 -->
            <div>
                <label for="pihak_2" class="block text-sm font-medium text-gray-700 mb-2">
                    Pihak 2 <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="pihak_2"
                    name="pihak_2"
                    value="{{ old('pihak_2', $sengketa->pihak_2) }}"
                    class="w-full px-4 py-2 border @error('pihak_2') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
                @error('pihak_2')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Kronologi -->
        <div>
            <label for="kronologi" class="block text-sm font-medium text-gray-700 mb-2">
                Kronologi
            </label>
            <textarea
                id="kronologi"
                name="kronologi"
                rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
            >{{ old('kronologi', $sengketa->kronologi) }}</textarea>
            @error('kronologi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                Status <span class="text-red-500">*</span>
            </label>
            <select
                id="status"
                name="status"
                class="w-full px-4 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
                <option value="">-- Pilih Status --</option>
                <option value="baru" {{ old('status', $sengketa->status) == 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="proses" {{ old('status', $sengketa->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ old('status', $sengketa->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Penyelesaian -->
        <div>
            <label for="penyelesaian" class="block text-sm font-medium text-gray-700 mb-2">
                Penyelesaian
            </label>
            <textarea
                id="penyelesaian"
                name="penyelesaian"
                rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
            >{{ old('penyelesaian', $sengketa->penyelesaian) }}</textarea>
            @error('penyelesaian')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bukti -->
        <div>
            <label for="bukti_sengketa" class="block text-sm font-medium text-gray-700 mb-2">
                Bukti Sengketa
            </label>
            @if ($sengketa->bukti_sengketa)
                <div class="mb-3">
                    <a href="{{ asset('storage/' . $sengketa->bukti_sengketa) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-download mr-1"></i> Download File Lama
                    </a>
                </div>
            @endif
            <input
                type="file"
                id="bukti_sengketa"
                name="bukti_sengketa"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
            >
            <p class="text-gray-500 text-sm mt-1">Max: 5MB (Biarkan kosong jika tidak ingin mengubah)</p>
            @error('bukti_sengketa')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <button
                type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium"
            >
                Update
            </button>
            <form action="{{ route('admin.sengketa.delete', $sengketa->sengketa_id) }}" method="POST" class="inline-block" onclick="return confirm('Yakin ingin menghapus?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-medium">
                    Hapus
                </button>
            </form>
            <a href="javascript:history.back()" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
