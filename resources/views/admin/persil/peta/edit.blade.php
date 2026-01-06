@extends('layouts.admin')

@section('title', 'Edit Peta Persil')
@section('page-title', 'Edit Peta Persil')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Persil: {{ $persil->kode_persil }}</h3>

    <form action="{{ getAdminRoute('peta.update', $peta->peta_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Panjang & Lebar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="panjang_m" class="block text-sm font-medium text-gray-700 mb-2">
                    Panjang (m)
                </label>
                <input
                    type="number"
                    id="panjang_m"
                    name="panjang_m"
                    value="{{ old('panjang_m', $peta->panjang_m) }}"
                    step="0.01"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                @error('panjang_m')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lebar_m" class="block text-sm font-medium text-gray-700 mb-2">
                    Lebar (m)
                </label>
                <input
                    type="number"
                    id="lebar_m"
                    name="lebar_m"
                    value="{{ old('lebar_m', $peta->lebar_m) }}"
                    step="0.01"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                @error('lebar_m')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- GeoJSON -->
        <div>
            <label for="geojson" class="block text-sm font-medium text-gray-700 mb-2">
                GeoJSON
            </label>
            <textarea
                id="geojson"
                name="geojson"
                rows="6"
                placeholder='{"type":"Feature","geometry":{"type":"Point","coordinates":[...]}}'
                class="w-full px-4 py-2 border border-gray-300 rounded-lg font-mono text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
            >{{ old('geojson', $peta->geojson) }}</textarea>
            <p class="text-gray-500 text-sm mt-1">Format GeoJSON untuk koordinat peta</p>
            @error('geojson')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current File -->
        @if ($peta->file_peta)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">File Peta Saat Ini</label>
            <div class="mb-3">
                <img src="{{ asset('storage/' . $peta->file_peta) }}" alt="Peta" class="w-48 h-48 object-cover rounded shadow">
            </div>
        </div>
        @endif

        <!-- New File -->
        <div>
            <label for="file_peta" class="block text-sm font-medium text-gray-700 mb-2">
                Upload File Peta Baru (Opsional)
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 text-center cursor-pointer hover:border-purple-500 transition"
                 onclick="document.getElementById('file_peta').click()">
                <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">Drag & drop gambar peta di sini atau click untuk pilih</p>
                <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG (Max: 5MB)</p>
            </div>
            <input
                type="file"
                id="file_peta"
                name="file_peta"
                accept="image/*"
                class="hidden"
                onchange="previewPeta()"
            >
            <p class="text-gray-500 text-sm mt-2">Kosongkan jika tidak ingin mengubah file</p>
            @error('file_peta')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Preview Peta -->
            <div id="petaPreview" class="mt-4"></div>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <button
                type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium"
            >
                Update
            </button>
            <a href="javascript:history.back()" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    function previewPeta() {
        const fileInput = document.getElementById('file_peta');
        const previewContainer = document.getElementById('petaPreview');
        previewContainer.innerHTML = '';

        if (fileInput.files && fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'relative inline-block rounded-lg overflow-hidden shadow';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="w-48 h-48 object-cover">
                    <button type="button" onclick="clearPeta()" class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                    <p class="text-xs text-green-600 font-medium mt-1">File baru akan diupload</p>
                `;
                previewContainer.appendChild(previewItem);
            };

            reader.readAsDataURL(file);
        }
    }

    function clearPeta() {
        document.getElementById('file_peta').value = '';
        document.getElementById('petaPreview').innerHTML = '';
    }
</script>
@endsection
