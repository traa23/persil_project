@extends('layouts.admin')

@section('title', 'Edit Dokumen')
@section('page-title', 'Edit Dokumen Persil')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Persil: {{ $persil->kode_persil }}</h3>

    <form action="{{ getAdminRoute('dokumen.update', $dokumen->dokumen_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Jenis Dokumen -->
        <div>
            <label for="jenis_dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                Jenis Dokumen <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="jenis_dokumen"
                name="jenis_dokumen"
                value="{{ old('jenis_dokumen', $dokumen->jenis_dokumen) }}"
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
                value="{{ old('nomor', $dokumen->nomor) }}"
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
            >{{ old('keterangan', $dokumen->keterangan) }}</textarea>
            @error('keterangan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current File -->
        @if ($dokumen->file_dokumen)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">File Saat Ini</label>
            <div class="flex items-center gap-3 p-3 bg-blue-50 rounded border border-blue-200">
                @php
                    $ext = pathinfo($dokumen->file_dokumen, PATHINFO_EXTENSION);
                    $icon = 'fa-file';
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $icon = 'fa-image text-purple-600';
                    } elseif ($ext === 'pdf') {
                        $icon = 'fa-file-pdf text-red-600';
                    } elseif (in_array($ext, ['doc', 'docx'])) {
                        $icon = 'fa-file-word text-blue-600';
                    } elseif (in_array($ext, ['xls', 'xlsx'])) {
                        $icon = 'fa-file-excel text-green-600';
                    }
                @endphp
                <i class="fas {{ $icon }} text-lg"></i>
                <div class="flex-1">
                    <a href="{{ asset('storage/' . $dokumen->file_dokumen) }}" target="_blank" class="text-sm font-medium text-blue-600 hover:underline">
                        {{ basename($dokumen->file_dokumen) }}
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- New File -->
        <div>
            <label for="file_dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                Upload File Baru (Opsional)
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 text-center cursor-pointer hover:border-purple-500 transition"
                 onclick="document.getElementById('file_dokumen').click()">
                <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">Drag & drop file di sini atau click untuk pilih</p>
                <p class="text-gray-500 text-sm mt-1">Format: PDF, Image, Doc, Excel (Max: 5MB)</p>
            </div>
            <input
                type="file"
                id="file_dokumen"
                name="file_dokumen"
                accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx,.xls,.xlsx"
                class="hidden"
                onchange="previewFile()"
            >
            <p class="text-gray-500 text-sm mt-2">Kosongkan jika tidak ingin mengubah file</p>
            @error('file_dokumen')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Preview File -->
            <div id="filePreview" class="mt-4"></div>
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
    function previewFile() {
        const fileInput = document.getElementById('file_dokumen');
        const previewContainer = document.getElementById('filePreview');
        previewContainer.innerHTML = '';

        if (fileInput.files && fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center gap-3 p-3 bg-green-50 rounded border border-green-200';

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
                    <p class="text-xs text-green-600 font-medium">File baru akan diupload</p>
                </div>
                <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            `;

            previewContainer.appendChild(fileItem);
        }
    }

    function clearFile() {
        document.getElementById('file_dokumen').value = '';
        document.getElementById('filePreview').innerHTML = '';
    }
</script>
@endsection
