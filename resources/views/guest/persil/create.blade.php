@extends('layouts.guest')

@section('title', 'Tambah Data Persil')

@section('content')
<!-- Banner -->
<section class="banner full" style="height: 300px;">
    <article>
        <img src="{{ asset('guest-tamplate/images/slide03.jpg') }}" alt="" width="1440" height="961">
        <div class="inner">
            <header>
                <p>Tambah Data Baru</p>
                <h2>Persil Pertanahan</h2>
            </header>
        </div>
    </article>
</section>

<!-- Form Content -->
<section id="one" class="wrapper style2">
    <div class="inner">
        <div style="margin-bottom: 2em;">
            <a href="{{ route('guest.persil.index') }}" class="button">Kembali</a>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div style="background: #f44336; color: white; padding: 1em; border-radius: 5px; margin-bottom: 2em;">
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin: 0.5em 0 0 1.5em;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div style="background: #f44336; color: white; padding: 1em; border-radius: 5px; margin-bottom: 2em;">
            <strong>Error!</strong> {{ session('error') }}
        </div>
        @endif

        <div class="form-container">
            <form action="{{ route('guest.persil.store') }}" method="POST" enctype="multipart/form-data" id="create-persil-form">
                @csrf

                <h3 style="margin-bottom: 1.5em; color: #2ebaae; border-bottom: 2px solid #2ebaae; padding-bottom: 0.5em;">📋 Data Persil</h3>

                <div class="form-group">
                    <label for="kode_persil">Kode Persil <span style="color: red;">*</span></label>
                    <input type="text" id="kode_persil" name="kode_persil" value="{{ old('kode_persil') }}" required>
                </div>

                <div class="form-group">
                    <label for="luas_m2">Luas (m²)</label>
                    <input type="number" id="luas_m2" name="luas_m2" step="0.01" min="0" value="{{ old('luas_m2') }}">
                </div>

                <div class="form-group">
                    <label for="penggunaan">Penggunaan Lahan</label>
                    <input type="text" id="penggunaan" name="penggunaan" value="{{ old('penggunaan') }}" placeholder="Contoh: Pertanian, Perumahan, dll">
                </div>

                <div class="form-group">
                    <label for="alamat_lahan">Alamat Lahan</label>
                    <textarea id="alamat_lahan" name="alamat_lahan" rows="3">{{ old('alamat_lahan') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rt">RT</label>
                        <input type="text" id="rt" name="rt" value="{{ old('rt') }}" maxlength="5" placeholder="001">
                    </div>

                    <div class="form-group">
                        <label for="rw">RW</label>
                        <input type="text" id="rw" name="rw" value="{{ old('rw') }}" maxlength="5" placeholder="001">
                    </div>
                </div>

                <!-- Multi Upload Dokumen Section -->
                <h3 style="margin: 2em 0 1.5em 0; color: #2ebaae; border-bottom: 2px solid #2ebaae; padding-bottom: 0.5em;">📁 Upload Dokumen (Opsional)</h3>

                <div class="upload-section">
                    <div class="file-drop-zone" id="dropZoneCreate">
                        <input type="file" name="files[]" id="filesCreate" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="display: none;">
                        <div class="drop-zone-content">
                            <span class="upload-icon">📁</span>
                            <h4>Drag & Drop files atau klik untuk memilih</h4>
                            <p>Format: PDF, DOC, DOCX, JPG, PNG (Max 5MB per file)</p>
                            <button type="button" class="button special" onclick="document.getElementById('filesCreate').click()">Pilih File</button>
                        </div>
                    </div>

                    <div id="files-preview-create" class="files-preview" style="display: none;">
                        <!-- File items will be added here dynamically -->
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button special">Simpan</button>
                    <a href="{{ route('guest.persil.index') }}" class="button">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
// Multi File Upload for Create Form
const fileInputCreate = document.getElementById('filesCreate');
const dropZoneCreate = document.getElementById('dropZoneCreate');
const filesPreviewCreate = document.getElementById('files-preview-create');
let selectedFilesCreate = [];

fileInputCreate.addEventListener('change', handleFilesCreate);

dropZoneCreate.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZoneCreate.classList.add('drag-over');
});

dropZoneCreate.addEventListener('dragleave', () => {
    dropZoneCreate.classList.remove('drag-over');
});

dropZoneCreate.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZoneCreate.classList.remove('drag-over');
    const files = e.dataTransfer.files;
    fileInputCreate.files = files;
    handleFilesCreate();
});

function handleFilesCreate() {
    selectedFilesCreate = Array.from(fileInputCreate.files);
    displayFilesCreate();
}

function displayFilesCreate() {
    if (selectedFilesCreate.length === 0) {
        filesPreviewCreate.style.display = 'none';
        return;
    }

    filesPreviewCreate.style.display = 'block';
    filesPreviewCreate.innerHTML = '';

    selectedFilesCreate.forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.className = 'file-preview-item';
        fileItem.innerHTML = `
            <span class="file-preview-icon">${getFileIconCreate(file.name)}</span>
            <div class="file-preview-info">
                <strong>${file.name}</strong>
                <small>${formatFileSizeCreate(file.size)}</small>
            </div>
            <div class="file-preview-input">
                <input type="text" name="jenis_dokumen[]" placeholder="Jenis Dokumen" required>
            </div>
            <button type="button" class="file-preview-remove" onclick="removeFileCreate(${index})">✕</button>
        `;
        filesPreviewCreate.appendChild(fileItem);
    });
}

function getFileIconCreate(filename) {
    const ext = filename.split('.').pop().toLowerCase();
    const icons = {
        'pdf': '📄',
        'doc': '📝',
        'docx': '📝',
        'jpg': '🖼️',
        'jpeg': '🖼️',
        'png': '🖼️'
    };
    return icons[ext] || '📎';
}

function formatFileSizeCreate(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

function removeFileCreate(index) {
    selectedFilesCreate.splice(index, 1);

    const dataTransfer = new DataTransfer();
    selectedFilesCreate.forEach(file => dataTransfer.items.add(file));
    fileInputCreate.files = dataTransfer.files;

    displayFilesCreate();
}
</script>
@endsection

@push('styles')
<style>
    .form-container {
        max-width: 1000px;
        margin: 0 auto;
        background: #fff;
        padding: 2em;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 1.5em;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5em;
        font-weight: 700;
        color: #333;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.9em 1.2em;
        border: 2px solid #d0d0d0;
        border-radius: 8px;
        font-size: 1em;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #2ebaae;
        box-shadow: 0 0 0 3px rgba(46, 186, 174, 0.1);
    }

    .form-group select {
        cursor: pointer;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1em;
    }

    /* Upload Section Styles */
    .upload-section {
        margin: 2em 0;
    }

    .file-drop-zone {
        border: 3px dashed #d0d0d0;
        border-radius: 12px;
        padding: 3em 2em;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-drop-zone:hover, .file-drop-zone.drag-over {
        border-color: #2ebaae;
        background: #e8f5f4;
    }

    .drop-zone-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1em;
    }

    .upload-icon {
        font-size: 4em;
    }

    .drop-zone-content h4 {
        margin: 0;
        color: #333;
        font-size: 1.2em;
    }

    .drop-zone-content p {
        margin: 0;
        color: #666;
        font-size: 0.9em;
    }

    /* Files Preview */
    .files-preview {
        margin-top: 1.5em;
        border: 2px solid #2ebaae;
        border-radius: 12px;
        padding: 1.5em;
        background: #ffffff;
    }

    .file-preview-item {
        display: flex;
        align-items: center;
        gap: 1em;
        padding: 1em;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 0.8em;
        transition: all 0.2s ease;
    }

    .file-preview-item:hover {
        background: #e9ecef;
    }

    .file-preview-item:last-child {
        margin-bottom: 0;
    }

    .file-preview-icon {
        font-size: 2em;
        min-width: 50px;
        text-align: center;
    }

    .file-preview-info {
        flex: 1;
    }

    .file-preview-info strong {
        display: block;
        color: #333;
        margin-bottom: 0.3em;
    }

    .file-preview-info small {
        color: #666;
    }

    .file-preview-input {
        flex: 1;
        max-width: 300px;
    }

    .file-preview-input input {
        width: 100%;
        padding: 0.7em;
        border: 1px solid #d0d0d0;
        border-radius: 6px;
        font-size: 0.9em;
    }

    .file-preview-remove {
        background: #f44336;
        color: white;
        border: none;
        padding: 0.6em 1em;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .file-preview-remove:hover {
        background: #d32f2f;
        transform: scale(1.05);
    }

    /* Owner Photo Preview Styling */
    .owner-preview {
        margin-top: 1em;
        padding: 1.2em;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        border: 2px solid #2ebaae;
        animation: fadeIn 0.3s ease;
    }

    .preview-container {
        display: flex;
        align-items: center;
        gap: 1.2em;
    }

    .preview-photo {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #2ebaae;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .preview-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8em;
        font-weight: 700;
        border: 3px solid #2ebaae;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .preview-info {
        flex: 1;
    }

    .preview-info small {
        display: block;
        font-size: 0.75em;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        margin-bottom: 0.3em;
    }

    .preview-info strong {
        display: block;
        font-size: 1.1em;
        color: #212529;
        font-weight: 600;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Owner Photo Upload Styling */
    .owner-photo-upload {
        margin-top: 1em;
        padding: 1.2em;
        background: #ffffff;
        border-radius: 12px;
        border: 2px dashed #2ebaae;
    }

    .owner-photo-upload label {
        display: block;
        margin-bottom: 0.8em;
        font-weight: 700;
        color: #2ebaae;
    }

    .owner-photo-upload input[type="file"] {
        width: 100%;
        padding: 0.8em;
        border: 2px solid #d0d0d0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .owner-photo-upload input[type="file"]:hover {
        border-color: #2ebaae;
        background: #f8f9fa;
    }

    .form-actions {
        margin-top: 2em;
        padding-top: 2em;
        border-top: 2px solid #e9ecef;
        text-align: center;
    }

    .form-actions button,
    .form-actions a {
        margin: 0 0.5em;
        min-width: 150px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-container {
            padding: 1.5em;
        }
    }
</style>
@endpush
