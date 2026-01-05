@extends('layouts.admin')

@section('title', 'Kelola Peta Persil')
@section('page-title', 'Kelola Peta Persil')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Persil: {{ $persil->kode_persil }}</h3>

    <form action="{{ route('admin.peta.store', $persil->persil_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Panjang -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="panjang_m" class="block text-sm font-medium text-gray-700 mb-2">
                    Panjang (m)
                </label>
                <input
                    type="number"
                    id="panjang_m"
                    name="panjang_m"
                    value="{{ old('panjang_m', $peta?->panjang_m) }}"
                    step="0.01"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                @error('panjang_m')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lebar -->
            <div>
                <label for="lebar_m" class="block text-sm font-medium text-gray-700 mb-2">
                    Lebar (m)
                </label>
                <input
                    type="number"
                    id="lebar_m"
                    name="lebar_m"
                    value="{{ old('lebar_m', $peta?->lebar_m) }}"
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
            >{{ old('geojson', $peta?->geojson) }}</textarea>
            <p class="text-gray-500 text-sm mt-1">Format GeoJSON untuk koordinat peta</p>
            @error('geojson')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Peta -->
        <div>
            <label for="file_peta" class="block text-sm font-medium text-gray-700 mb-2">
                File Peta (Gambar/Scan) - Multiple
            </label>
            @if ($peta && $peta->file_peta)
                <div class="mb-3">
                    <p class="text-sm text-gray-600 mb-2">File Peta Saat Ini:</p>
                    <img src="{{ asset('storage/' . $peta->file_peta) }}" alt="Peta" class="w-32 h-32 object-cover rounded">
                </div>
            @endif
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 text-center cursor-pointer hover:border-purple-500 transition"
                 onclick="document.getElementById('file_peta').click()">
                <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">Drag & drop gambar peta di sini atau click untuk pilih</p>
                <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG (Max: 5MB per file)</p>
            </div>
            <input
                type="file"
                id="file_peta"
                name="file_peta[]"
                accept="image/*"
                multiple
                class="hidden"
                onchange="previewPetas()"
            >
            <p class="text-gray-500 text-sm mt-2">Anda bisa memilih multiple file sekaligus</p>
            @error('file_peta')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('file_peta.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Preview Peta -->
            <div id="petaPreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4"></div>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <button
                type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium"
            >
                {{ $peta ? 'Update' : 'Simpan' }}
            </button>
            <a href="javascript:history.back()" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    function previewPetas() {
        const fileInput = document.getElementById('file_peta');
        const previewContainer = document.getElementById('petaPreview');
        previewContainer.innerHTML = '';

        if (fileInput.files && fileInput.files.length > 0) {
            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative group rounded-lg overflow-hidden shadow hover:shadow-lg transition';
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="w-full h-40 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                            <button type="button" onclick="removePeta(${i})" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </div>
                    `;
                    previewContainer.appendChild(previewItem);
                };

                reader.readAsDataURL(file);
            }
        }
    }

    function removePeta(index) {
        const fileInput = document.getElementById('file_peta');
        const dataTransfer = new DataTransfer();

        for (let i = 0; i < fileInput.files.length; i++) {
            if (i !== index) {
                dataTransfer.items.add(fileInput.files[i]);
            }
        }

        fileInput.files = dataTransfer.files;
        previewPetas();
    }
</script>
@endsection
