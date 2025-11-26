@extends('layouts.guest')

@section('title', 'Tambah Multiple User - Sistem Informasi Persil')

@section('content')
<section class="wrapper style2">
    <div class="inner">
        <header class="align-center">
            <p>Manajemen Data Pengguna</p>
            <h2>Tambah Multiple User Sekaligus</h2>
        </header>

        @if(session('error'))
        <div style="background: #f44336; color: white; padding: 1em; border-radius: 5px; margin-bottom: 1em;">
            <strong>Error!</strong> {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div style="background: #ff9800; color: white; padding: 1em; border-radius: 5px; margin-bottom: 1em;">
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin: 0.5em 0 0 1.5em;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-container-bulk">
            <form action="{{ route('users.bulk-store') }}" method="POST" enctype="multipart/form-data" id="bulk-user-form">
                @csrf

                <div id="users-container">
                    <!-- User entries will be added here -->
                </div>

                <div class="bulk-actions">
                    <button type="button" class="button" onclick="addUserRow()">+ Tambah User Baru</button>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button special">Simpan Semua User</button>
                    <a href="{{ route('users.index') }}" class="button">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
let userIndex = 0;

function addUserRow() {
    const container = document.getElementById('users-container');
    const userRow = document.createElement('div');
    userRow.className = 'user-row';
    userRow.id = `user-row-${userIndex}`;

    userRow.innerHTML = `
        <div class="user-row-header">
            <h3>User ${userIndex + 1}</h3>
            <button type="button" class="remove-user-btn" onclick="removeUserRow(${userIndex})">✕ Hapus</button>
        </div>

        <div class="user-row-content">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="users[${userIndex}][name]" required placeholder="Masukkan nama lengkap">
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="users[${userIndex}][email]" required placeholder="contoh@email.com">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password <span class="required">*</span></label>
                    <input type="password" name="users[${userIndex}][password]" required placeholder="Minimal 8 karakter">
                </div>

                <div class="form-group">
                    <label>Foto Profil</label>
                    <div class="file-upload-compact">
                        <input type="file" name="photos[${userIndex}]" id="photo-${userIndex}" accept="image/*" onchange="previewPhoto(${userIndex})">
                        <label for="photo-${userIndex}" class="file-label">
                            <span class="file-icon">📷</span>
                            <span class="file-text">Pilih Foto</span>
                        </label>
                        <div id="preview-${userIndex}" class="photo-preview" style="display: none;">
                            <img id="preview-img-${userIndex}" src="" alt="Preview">
                            <button type="button" onclick="removePhoto(${userIndex})" class="remove-photo-btn">✕</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.appendChild(userRow);
    userIndex++;

    // Auto-add first row if this is the first one
    if (userIndex === 1) {
        updateUserNumbers();
    }
}

function removeUserRow(index) {
    const row = document.getElementById(`user-row-${index}`);
    if (row) {
        row.remove();
        updateUserNumbers();
    }
}

function updateUserNumbers() {
    const rows = document.querySelectorAll('.user-row');
    rows.forEach((row, index) => {
        const header = row.querySelector('.user-row-header h3');
        if (header) {
            header.textContent = `User ${index + 1}`;
        }
    });
}

function previewPhoto(index) {
    const input = document.getElementById(`photo-${index}`);
    const preview = document.getElementById(`preview-${index}`);
    const previewImg = document.getElementById(`preview-img-${index}`);

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removePhoto(index) {
    const input = document.getElementById(`photo-${index}`);
    const preview = document.getElementById(`preview-${index}`);

    input.value = '';
    preview.style.display = 'none';
}

// Add first user row on page load
document.addEventListener('DOMContentLoaded', function() {
    addUserRow();
});
</script>
@endsection

@push('styles')
<style>
    .form-container-bulk {
        max-width: 1200px;
        margin: 2em auto;
        background: #ffffff;
        padding: 2.5em;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    #users-container {
        display: flex;
        flex-direction: column;
        gap: 2em;
    }

    .user-row {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5em;
        transition: all 0.3s ease;
    }

    .user-row:hover {
        border-color: #2ebaae;
        box-shadow: 0 4px 15px rgba(46, 186, 174, 0.1);
    }

    .user-row-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5em;
        padding-bottom: 1em;
        border-bottom: 2px solid #e9ecef;
    }

    .user-row-header h3 {
        margin: 0;
        color: #2ebaae;
        font-size: 1.3em;
    }

    .remove-user-btn {
        background: #f44336;
        color: white;
        border: none;
        padding: 0.6em 1.2em;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .remove-user-btn:hover {
        background: #d32f2f;
        transform: scale(1.05);
    }

    .user-row-content {
        display: flex;
        flex-direction: column;
        gap: 1.5em;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5em;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5em;
    }

    .form-group label {
        font-weight: 700;
        color: #333;
        font-size: 0.95em;
    }

    .required {
        color: #f44336;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"] {
        padding: 0.9em 1.2em;
        border: 2px solid #d0d0d0;
        border-radius: 8px;
        font-size: 1em;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus {
        outline: none;
        border-color: #2ebaae;
        box-shadow: 0 0 0 3px rgba(46, 186, 174, 0.1);
    }

    /* File Upload Compact */
    .file-upload-compact {
        position: relative;
    }

    .file-upload-compact input[type="file"] {
        display: none;
    }

    .file-label {
        display: inline-flex;
        align-items: center;
        gap: 0.8em;
        padding: 0.9em 1.5em;
        background: #2ebaae;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .file-label:hover {
        background: #1fa99c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 186, 174, 0.3);
    }

    .file-icon {
        font-size: 1.3em;
    }

    .photo-preview {
        margin-top: 1em;
        position: relative;
        display: inline-block;
    }

    .photo-preview img {
        max-width: 120px;
        max-height: 120px;
        border-radius: 8px;
        border: 3px solid #2ebaae;
    }

    .remove-photo-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #f44336;
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .remove-photo-btn:hover {
        background: #d32f2f;
        transform: scale(1.1);
    }

    .bulk-actions {
        margin: 2em 0;
        text-align: center;
    }

    .bulk-actions .button {
        background: #ffffff;
        color: #2ebaae;
        border: 2px solid #2ebaae;
        padding: 1em 2em;
        font-weight: 600;
    }

    .bulk-actions .button:hover {
        background: #2ebaae;
        color: #ffffff;
    }

    .form-actions {
        display: flex;
        gap: 1em;
        margin-top: 2em;
        justify-content: center;
        padding-top: 2em;
        border-top: 2px solid #e9ecef;
    }

    .form-actions .button {
        flex: 0 0 auto;
        min-width: 200px;
        text-align: center;
        padding: 1em 2em;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-actions .button.special {
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        color: white;
        border: none;
    }

    .form-actions .button.special:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(46, 186, 174, 0.4);
    }

    .form-actions .button:not(.special) {
        background: #ffffff;
        color: #666;
        border: 2px solid #d0d0d0;
    }

    .form-actions .button:not(.special):hover {
        border-color: #999;
        color: #333;
    }

    @media (max-width: 768px) {
        .form-container-bulk {
            padding: 1.5em;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .button {
            width: 100%;
        }
    }
</style>
@endpush
