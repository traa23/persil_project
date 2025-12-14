@extends('layouts.guest')

@section('title', 'Detail Persil - ' . $persil->kode_persil)

@section('content')
<!-- Banner -->
<section class="banner full" style="height: 300px;">
    <article>
        <img src="{{ asset('guest-tamplate/images/slide02.jpg') }}" alt="" width="1440" height="961">
        <div class="inner">
            <header>
                <p>Detail Informasi</p>
                <h2>{{ $persil->kode_persil }}</h2>
            </header>
        </div>
    </article>
</section>

<!-- Alert Messages -->
@if(session('success'))
<section class="wrapper style2" style="padding: 2em 0;">
    <div class="inner">
        <div style="background: #4CAF50; color: white; padding: 1em; border-radius: 5px; margin-bottom: 1em;">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    </div>
</section>
@endif

@if(session('error'))
<section class="wrapper style2" style="padding: 2em 0;">
    <div class="inner">
        <div style="background: #f44336; color: white; padding: 1em; border-radius: 5px; margin-bottom: 1em;">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    </div>
</section>
@endif

<!-- Detail Content -->
<section id="one" class="wrapper style2">
    <div class="inner">
        <div style="margin-bottom: 2em;">
            <a href="{{ route('guest.persil.index') }}" class="button">Kembali</a>
            <a href="{{ route('guest.persil.edit', $persil->persil_id) }}" class="button special">Edit</a>
            <button onclick="confirmDelete()" class="button" style="background: #f44336;">Hapus</button>
        </div>

        <div class="grid-style-detail">
            <!-- Main Info -->
            <div class="detail-card">
                <h3>Informasi Utama</h3>
                <div class="card-content">
                <table class="detail-table">
                    <tr>
                        <td><strong>Kode Persil</strong></td>
                        <td>{{ $persil->kode_persil }}</td>
                    </tr>
                    <tr>
                        <td><strong>Luas (m²)</strong></td>
                        <td>{{ $persil->luas_m2 ? number_format($persil->luas_m2, 2) : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Penggunaan</strong></td>
                        <td>{{ $persil->penggunaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat Lahan</strong></td>
                        <td>{{ $persil->alamat_lahan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>RT / RW</strong></td>
                        <td>{{ $persil->rt ?? '-' }} / {{ $persil->rw ?? '-' }}</td>
                    </tr>
                    @if($persil->pemilik)
                    <tr>
                        <td><strong>Pemilik</strong></td>
                        <td>{{ $persil->pemilik->name }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Dibuat</strong></td>
                        <td>{{ $persil->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Diupdate</strong></td>
                        <td>{{ $persil->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
                </div>
            </div>

            <!-- Upload Multiple Dokumen -->
            <div class="detail-card full-width">
                <h3>📤 Upload Dokumen Persil (Multiple Files)</h3>
                <div class="card-content">
                    <form action="{{ route('guest.dokumen-persil.store-multiple') }}" method="POST" enctype="multipart/form-data" id="multiple-upload-form">
                        @csrf
                        <input type="hidden" name="persil_id" value="{{ $persil->persil_id }}">

                        <div class="upload-section">
                            <div class="file-drop-zone" id="dropZone">
                                <input type="file" name="files[]" id="files" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="display: none;">
                                <div class="drop-zone-content">
                                    <span class="upload-icon">📁</span>
                                    <h4>Drag & Drop files atau klik untuk memilih</h4>
                                    <p>Format: PDF, DOC, DOCX, JPG, PNG (Max 5MB per file)</p>
                                    <button type="button" class="button special" onclick="document.getElementById('files').click()">Pilih File</button>
                                </div>
                            </div>

                            <div id="files-preview" class="files-preview" style="display: none;">
                                <!-- File items will be added here dynamically -->
                            </div>

                            <div class="upload-actions" id="uploadActions" style="display: none;">
                                <button type="submit" class="button special">Upload Semua Dokumen</button>
                                <button type="button" class="button" onclick="clearAllFiles()">Batalkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Dokumen Terkait -->
            <div class="detail-card full-width">
                <h3>📄 Dokumen Terkait ({{ $persil->dokumen->count() }})</h3>
                <div class="card-content">
                    @if($persil->dokumen->count() > 0)
                    <div class="dokumen-grid">
                        @foreach($persil->dokumen as $dokumen)
                        <div class="dokumen-item">
                            <div class="dokumen-icon">
                                @if($dokumen->file_path && in_array(pathinfo($dokumen->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                    <img src="{{ asset('storage/' . $dokumen->file_path) }}" alt="{{ $dokumen->jenis_dokumen }}">
                                @else
                                    <span class="file-type-icon">📄</span>
                                @endif
                            </div>
                            <div class="dokumen-info">
                                <strong>{{ $dokumen->jenis_dokumen }}</strong>
                                @if($dokumen->nomor)
                                <small>No: {{ $dokumen->nomor }}</small>
                                @endif
                                @if($dokumen->keterangan)
                                <small>{{ Str::limit($dokumen->keterangan, 50) }}</small>
                                @endif
                            </div>
                            <div class="dokumen-actions">
                                @if($dokumen->file_path)
                                <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn-view" title="Lihat">👁️</a>
                                <a href="{{ asset('storage/' . $dokumen->file_path) }}" download class="btn-download" title="Download">⬇️</a>
                                @endif
                                <form action="{{ route('guest.dokumen-persil.destroy', $dokumen->dokumen_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-dok" onclick="return confirm('Hapus dokumen ini?')" title="Hapus">🗑️</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p style="text-align: center; color: #999; padding: 2em 0;">Belum ada dokumen yang diupload.</p>
                    @endif
                </div>
            </div>

            <!-- Peta -->
            @if($persil->peta->count() > 0)
            <div class="detail-card">
                <h3>Peta Persil</h3>
                <div class="card-content">
                <p>Tersedia {{ $persil->peta->count() }} data peta</p>
                </div>
            </div>
            @endif

            <!-- Sengketa -->
            @if($persil->sengketa->count() > 0)
            <div class="detail-card">
                <h3>Riwayat Sengketa</h3>
                <div class="card-content">
                <ul>
                    @foreach($persil->sengketa as $sengketa)
                    <li style="border-left-color: #ffc107;">
                        <strong>{{ $sengketa->tanggal_sengketa->format('d M Y') }}</strong>
                        <small>Status: {{ $sengketa->status }}</small>
                        <small>{{ Str::limit($sengketa->deskripsi, 100) }}</small>
                    </li>
                    @endforeach
                </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Delete Form -->
<form id="delete-form" action="{{ route('guest.persil.destroy', $persil->persil_id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Custom Delete Confirmation Modal -->
<div id="delete-modal" class="delete-modal">
    <div class="delete-modal-content">
        <div class="delete-modal-icon-wrapper">
            <div class="delete-modal-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" fill="#f44336"/>
                    <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
        <h3 class="delete-modal-title">Konfirmasi Hapus</h3>
        <p class="delete-modal-message">Apakah Anda yakin ingin menghapus data persil ini?</p>
        <p class="delete-modal-submessage">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="delete-modal-buttons">
            <button onclick="closeDeleteModal()" class="delete-modal-btn delete-modal-btn-cancel">Batal</button>
            <button onclick="submitDelete()" class="delete-modal-btn delete-modal-btn-confirm">Hapus</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .full-width {
        grid-column: 1 / -1;
    }

    .grid-style-detail {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5em;
        margin-top: 2em;
        align-items: start;
    }

    .detail-card {
        background: #fff;
        padding: 0;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .detail-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(46, 186, 174, 0.15);
        border-color: #2ebaae;
    }

    .detail-card h3 {
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        color: #ffffff;
        margin: 0;
        padding: 1.2em 1.5em;
        font-size: 1.3em;
        font-weight: 700;
        border-bottom: none;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        letter-spacing: 0.3px;
    }

    .detail-card .card-content {
        padding: 1.5em;
        flex: 1;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .detail-table tr {
        transition: background 0.2s ease;
    }

    .detail-table tr:hover {
        background: #f8f9fa;
    }

    .detail-table td {
        padding: 1em 0.5em;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: top;
    }

    .detail-table td:first-child {
        width: 38%;
        color: #666;
        font-weight: 600;
        font-size: 0.9em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-table td:last-child {
        color: #212529;
        font-weight: 500;
    }

    .detail-table tr:last-child td {
        border-bottom: none;
    }

    /* Upload Section Styles */
    .upload-section {
        margin-top: 1em;
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
        padding: 0.6em;
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
    }

    .file-preview-remove:hover {
        background: #d32f2f;
        transform: scale(1.05);
    }

    .upload-actions {
        margin-top: 1.5em;
        display: flex;
        gap: 1em;
        justify-content: center;
    }

    .upload-actions .button {
        min-width: 200px;
    }

    /* Dokumen Grid */
    .dokumen-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1em;
    }

    .dokumen-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1em;
        display: flex;
        gap: 1em;
        align-items: center;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }

    .dokumen-item:hover {
        background: #e9ecef;
        border-color: #2ebaae;
        transform: translateY(-2px);
    }

    .dokumen-icon {
        min-width: 60px;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
    }

    .dokumen-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-type-icon {
        font-size: 2.5em;
    }

    .dokumen-info {
        flex: 1;
        min-width: 0;
    }

    .dokumen-info strong {
        display: block;
        color: #333;
        font-size: 0.95em;
        margin-bottom: 0.3em;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dokumen-info small {
        display: block;
        color: #666;
        font-size: 0.85em;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dokumen-actions {
        display: flex;
        gap: 0.5em;
    }

    .dokumen-actions a,
    .dokumen-actions button {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1.2em;
    }

    .btn-view {
        background: #2196F3;
    }

    .btn-view:hover {
        background: #1976D2;
        transform: scale(1.1);
    }

    .btn-download {
        background: #4CAF50;
    }

    .btn-download:hover {
        background: #388E3C;
        transform: scale(1.1);
    }

    .btn-delete-dok {
        background: #f44336;
    }

    .btn-delete-dok:hover {
        background: #d32f2f;
        transform: scale(1.1);
    }

    /* Styling untuk list items dalam card */
    .detail-card ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .detail-card ul li {
        padding: 1em;
        background: #f8f9fa;
        margin-bottom: 0.75em;
        border-radius: 8px;
        border-left: 3px solid #2ebaae;
        transition: all 0.2s ease;
    }

    .detail-card ul li:hover {
        background: #e9ecef;
        transform: translateX(3px);
    }

    .detail-card ul li:last-child {
        margin-bottom: 0;
    }

    .detail-card ul li strong {
        display: block;
        color: #212529;
        margin-bottom: 0.3em;
        font-size: 0.95em;
    }

    .detail-card ul li small {
        color: #6c757d;
        font-size: 0.85em;
        display: block;
        line-height: 1.5;
    }

    .detail-card p {
        margin: 0;
        color: #6c757d;
        font-size: 0.95em;
        padding: 0.5em 0;
    }

    /* Delete Modal Styles */
    .delete-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(6px);
        opacity: 0;
        transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .delete-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
    }

    .delete-modal-content {
        background-color: #ffffff;
        border-radius: 20px;
        padding: 3em 2.5em;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        text-align: center;
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .delete-modal.show .delete-modal-content {
        transform: scale(1);
        opacity: 1;
    }

    .delete-modal-icon-wrapper {
        margin-bottom: 1.5em;
    }

    .delete-modal-icon svg {
        filter: drop-shadow(0 4px 12px rgba(244, 67, 54, 0.4));
    }

    .delete-modal-title {
        color: #f44336;
        font-size: 1.75em;
        font-weight: 700;
        margin: 0 0 0.75em 0;
    }

    .delete-modal-message {
        color: #4a4a4a;
        font-size: 1.05em;
        margin: 0 0 0.5em 0;
    }

    .delete-modal-submessage {
        color: #888;
        font-size: 0.95em;
        margin: 0 0 2em 0;
    }

    .delete-modal-buttons {
        display: flex;
        gap: 1em;
        justify-content: center;
        margin-top: 2em;
    }

    .delete-modal-btn {
        padding: 0.9em 2em;
        border: none;
        border-radius: 10px;
        font-size: 0.9em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        min-width: 140px;
        font-family: inherit;
    }

    .delete-modal-btn-cancel {
        background-color: #f5f5f5;
        color: #333;
    }

    .delete-modal-btn-cancel:hover {
        background-color: #e8e8e8;
        transform: translateY(-2px);
    }

    .delete-modal-btn-confirm {
        background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(244, 67, 54, 0.3);
    }

    .delete-modal-btn-confirm:hover {
        background: linear-gradient(135deg, #d32f2f 0%, #c62828 100%);
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .grid-style-detail {
            grid-template-columns: 1fr;
        }

        .dokumen-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Multiple File Upload Handling
    const fileInput = document.getElementById('files');
    const dropZone = document.getElementById('dropZone');
    const filesPreview = document.getElementById('files-preview');
    const uploadActions = document.getElementById('uploadActions');
    let selectedFiles = [];

    // Click to select files
    fileInput.addEventListener('change', handleFiles);

    // Drag & Drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('drag-over');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        fileInput.files = files;
        handleFiles();
    });

    function handleFiles() {
        selectedFiles = Array.from(fileInput.files);
        displayFiles();
    }

    function displayFiles() {
        if (selectedFiles.length === 0) {
            filesPreview.style.display = 'none';
            uploadActions.style.display = 'none';
            return;
        }

        filesPreview.style.display = 'block';
        uploadActions.style.display = 'flex';
        filesPreview.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-preview-item';
            fileItem.innerHTML = `
                <span class="file-preview-icon">${getFileIcon(file.name)}</span>
                <div class="file-preview-info">
                    <strong>${file.name}</strong>
                    <small>${formatFileSize(file.size)}</small>
                </div>
                <div class="file-preview-input">
                    <input type="text" name="jenis_dokumen[]" placeholder="Jenis Dokumen" required>
                </div>
                <button type="button" class="file-preview-remove" onclick="removeFile(${index})">✕</button>
            `;
            filesPreview.appendChild(fileItem);
        });
    }

    function getFileIcon(filename) {
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

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);

        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;

        displayFiles();
    }

    function clearAllFiles() {
        selectedFiles = [];
        fileInput.value = '';
        displayFiles();
    }

    // Delete Modal Functions
    function confirmDelete() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('show');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('show');
    }

    function submitDelete() {
        document.getElementById('delete-form').submit();
    }

    // Close modal when clicking outside
    document.getElementById('delete-modal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush
