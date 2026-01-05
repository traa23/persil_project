@extends('layouts.admin')

@section('title', 'Tambah Sengketa')
@section('page-title', 'Tambah Sengketa Persil')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Persil: {{ $persil->kode_persil }}</h3>

    <form action="{{ route('admin.sengketa.store', $persil->persil_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

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
                    value="{{ old('pihak_1') }}"
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
                    value="{{ old('pihak_2') }}"
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
            >{{ old('kronologi') }}</textarea>
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
                <option value="baru" {{ old('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
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
            >{{ old('penyelesaian') }}</textarea>
            @error('penyelesaian')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bukti -->
        <div>
            <label for="bukti_sengketa" class="block text-sm font-medium text-gray-700 mb-2">
                Bukti Sengketa (Multiple)
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 text-center cursor-pointer hover:border-purple-500 transition"
                 onclick="document.getElementById('bukti_sengketa').click()">
                <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">Drag & drop file bukti di sini atau click untuk pilih</p>
                <p class="text-gray-500 text-sm mt-1">Format: PDF, Image, Doc, Excel (Max: 5MB per file)</p>
            </div>
            <input
                type="file"
                id="bukti_sengketa"
                name="bukti_sengketa[]"
                accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx,.xls,.xlsx"
                multiple
                class="hidden"
                onchange="previewBukti()"
            >
            <p class="text-gray-500 text-sm mt-2">Anda bisa memilih multiple file sekaligus</p>
            @error('bukti_sengketa')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('bukti_sengketa.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Preview Files -->
            <div id="buktiPreview" class="mt-4 space-y-2"></div>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <button
                type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium"
            >
                Simpan
            </button>
            <a href="javascript:history.back()" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    function previewBukti() {
        const fileInput = document.getElementById('bukti_sengketa');
        const previewContainer = document.getElementById('buktiPreview');
        previewContainer.innerHTML = '';

        if (fileInput.files && fileInput.files.length > 0) {
            const fileList = document.createElement('div');
            fileList.className = 'space-y-2';

            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center gap-3 p-3 bg-red-50 rounded border border-red-200';

                let icon = 'fa-file';
                const ext = file.name.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    icon = 'fa-image text-purple-600';
                } else if (['pdf'].includes(ext)) {
                    icon = 'fa-file-pdf text-red-600';
                } else if (['doc', 'docx'].includes(ext)) {
                    icon = 'fa-file-word text-blue-600';
                } else if (['xls', 'xlsx'].includes(ext)) {
                    icon = 'fa-file-excel text-green-600';
                }

                fileItem.innerHTML = `
                    <i class="fas ${icon} text-lg"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">${file.name}</p>
                        <p class="text-xs text-gray-600">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                    </div>
                    <button type="button" onclick="removeBukti(${i})" class="text-red-600 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                fileList.appendChild(fileItem);
            }

            previewContainer.appendChild(fileList);
        }
    }

    function removeBukti(index) {
        const fileInput = document.getElementById('bukti_sengketa');
        const dataTransfer = new DataTransfer();

        for (let i = 0; i < fileInput.files.length; i++) {
            if (i !== index) {
                dataTransfer.items.add(fileInput.files[i]);
            }
        }

        fileInput.files = dataTransfer.files;
        previewBukti();
    }
</script>
@endsection
