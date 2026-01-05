@extends('layouts.admin')

@section('title', 'Tambah Dokumen')
@section('page-title', 'Tambah Dokumen Persil')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Persil: {{ $persil->kode_persil }}</h3>

    <form action="{{ route('admin.dokumen.store', $persil->persil_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Jenis Dokumen -->
        <div>
            <label for="jenis_dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                Jenis Dokumen <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="jenis_dokumen"
                name="jenis_dokumen"
                value="{{ old('jenis_dokumen') }}"
                placeholder="Misal: Sertifikat, SPPT, etc"
                class="w-full px-4 py-2 border @error('jenis_dokumen') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >
            @error('jenis_dokumen')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nomor -->
        <div>
            <label for="nomor" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor
            </label>
            <input
                type="text"
                id="nomor"
                name="nomor"
                value="{{ old('nomor') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
            >
            @error('nomor')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Keterangan -->
        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                Keterangan
            </label>
            <textarea
                id="keterangan"
                name="keterangan"
                rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
            >{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- File -->
        <div>
            <label for="file_dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                File Dokumen (Multiple)
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 text-center cursor-pointer hover:border-purple-500 transition"
                 onclick="document.getElementById('file_dokumen').click()">
                <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">Drag & drop file di sini atau click untuk pilih</p>
                <p class="text-gray-500 text-sm mt-1">Format: PDF, Image, Doc, Excel (Max: 5MB per file)</p>
            </div>
            <input
                type="file"
                id="file_dokumen"
                name="file_dokumen[]"
                accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx,.xls,.xlsx"
                multiple
                class="hidden"
                onchange="previewFiles()"
            >
            <p class="text-gray-500 text-sm mt-2">Anda bisa memilih multiple file sekaligus</p>
            @error('file_dokumen')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('file_dokumen.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Preview Files -->
            <div id="filePreview" class="mt-4 space-y-2"></div>
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
    function previewFiles() {
        const fileInput = document.getElementById('file_dokumen');
        const previewContainer = document.getElementById('filePreview');
        previewContainer.innerHTML = '';

        if (fileInput.files && fileInput.files.length > 0) {
            const fileList = document.createElement('div');
            fileList.className = 'space-y-2';

            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center gap-3 p-3 bg-blue-50 rounded border border-blue-200';

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
                    <button type="button" onclick="removeFile(${i})" class="text-red-600 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                fileList.appendChild(fileItem);
            }

            previewContainer.appendChild(fileList);
        }
    }

    function removeFile(index) {
        const fileInput = document.getElementById('file_dokumen');
        const dataTransfer = new DataTransfer();

        for (let i = 0; i < fileInput.files.length; i++) {
            if (i !== index) {
                dataTransfer.items.add(fileInput.files[i]);
            }
        }

        fileInput.files = dataTransfer.files;
        previewFiles();
    }
</script>
@endsection
