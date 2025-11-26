@extends('layouts.guest')

@section('title', 'Edit User - Sistem Informasi Persil')

@section('content')
<section class="wrapper style2">
    <div class="inner">
        <header class="align-center">
            <p>Manajemen Data Pengguna</p>
            <h2>Edit Data User</h2>
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

        <div class="form-container">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="user-form">
                @csrf
                @method('PUT')

                <!-- Current Photo Display -->
                @if($user->photo_path)
                <div class="current-photo">
                    <label>Foto Profil Saat Ini</label>
                    <div class="current-photo-wrapper">
                        <img src="{{ asset('storage/' . $user->photo_path) }}" alt="{{ $user->name }}">
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        placeholder="Masukkan nama lengkap"
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        placeholder="contoh@email.com"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Kosongkan jika tidak ingin mengubah password"
                    >
                    <small style="color: #666; font-size: 0.85em;">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah.</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password baru"
                    >
                </div>

                <div class="form-group">
                    <label for="photo">Ubah Foto Profil</label>
                    <div class="file-upload-wrapper">
                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            accept="image/*"
                            onchange="previewImage(this)"
                        >
                        <div class="file-upload-info">
                            <span class="file-icon">📷</span>
                            <span class="file-text">{{ $user->photo_path ? 'Ubah foto profil' : 'Pilih foto profil' }}</span>
                            <span class="file-subtext">Format: JPG, PNG, GIF. Maksimal 2MB</span>
                        </div>
                    </div>
                    <div id="image-preview" class="image-preview" style="display: none;">
                        <img id="preview-img" src="" alt="Preview">
                        <button type="button" onclick="removeImage()" class="remove-preview">✕ Hapus</button>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button special">Update Data</button>
                    <a href="{{ route('users.index') }}" class="button">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const fileInfo = input.parentElement.querySelector('.file-upload-info');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            fileInfo.querySelector('.file-text').textContent = input.files[0].name;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.getElementById('photo');
    const preview = document.getElementById('image-preview');
    const fileInfo = document.querySelector('.file-upload-info');
    const hasCurrentPhoto = {{ $user->photo_path ? 'true' : 'false' }};

    input.value = '';
    preview.style.display = 'none';
    fileInfo.querySelector('.file-text').textContent = hasCurrentPhoto ? 'Ubah foto profil' : 'Pilih foto profil';
}
</script>
@endsection

@push('styles')
<style>
    .form-container {
        max-width: 700px;
        margin: 2em auto;
        background: #ffffff;
        padding: 2.5em;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    /* Current Photo Display */
    .current-photo {
        margin-bottom: 2em;
        text-align: center;
    }

    .current-photo label {
        display: block;
        font-weight: 700;
        color: #333;
        margin-bottom: 1em;
        font-size: 0.95em;
    }

    .current-photo-wrapper {
        display: inline-block;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #2ebaae;
        box-shadow: 0 4px 15px rgba(46, 186, 174, 0.2);
    }

    .current-photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-form {
        display: flex;
        flex-direction: column;
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

    /* File Upload Styling */
    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        border: 2px dashed #d0d0d0;
        border-radius: 8px;
        padding: 1.5em;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .file-upload-wrapper:hover {
        border-color: #2ebaae;
        background: #e8f5f4;
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5em;
        pointer-events: none;
    }

    .file-icon {
        font-size: 2.5em;
    }

    .file-text {
        font-weight: 600;
        color: #2ebaae;
    }

    .file-subtext {
        font-size: 0.85em;
        color: #666;
    }

    /* Image Preview */
    .image-preview {
        margin-top: 1em;
        text-align: center;
    }

    .image-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 10px;
        border: 3px solid #2ebaae;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .remove-preview {
        display: block;
        margin: 1em auto 0;
        padding: 0.6em 1.2em;
        background: #f44336;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .remove-preview:hover {
        background: #d32f2f;
        transform: scale(1.05);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1em;
        margin-top: 1em;
        justify-content: center;
    }

    .form-actions .button {
        flex: 1;
        max-width: 200px;
        text-align: center;
        padding: 0.9em 2em;
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

    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 1.5em;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .button {
            max-width: 100%;
        }
    }
</style>
@endpush
