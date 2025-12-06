@extends('layouts.guest')

@section('title', 'Edit Data Persil - ' . $persil->kode_persil)

@section('content')
<!-- Banner -->
<section class="banner full" style="height: 300px;">
    <article>
        <img src="{{ asset('guest-tamplate/images/slide04.jpg') }}" alt="" width="1440" height="961">
        <div class="inner">
            <header>
                <p>Edit Data</p>
                <h2>{{ $persil->kode_persil }}</h2>
            </header>
        </div>
    </article>
</section>

<!-- Form Content -->
<section id="one" class="wrapper style2">
    <div class="inner">
        <div style="margin-bottom: 2em;">
            <a href="{{ route('guest.persil.show', $persil->persil_id) }}" class="button">Kembali</a>
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
            <form action="{{ route('guest.persil.update', $persil->persil_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="kode_persil">Kode Persil <span style="color: red;">*</span></label>
                    <input type="text" id="kode_persil" name="kode_persil" value="{{ old('kode_persil', $persil->kode_persil) }}" required>
                    <div class="custom-validation-message" id="kode_persil-error"></div>
                    @error('kode_persil')
                    <div class="validation-error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" fill="#ff9800"/>
                            <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pemilik_warga_id">Pemilik Persil</label>
                    <div style="padding: 10px; background: #f5f5f5; border-radius: 5px; display: flex; align-items: center; gap: 15px;">
                        @if($persil->pemilik)
                            @if($persil->pemilik->photo_path)
                                <img src="{{ asset('storage/' . $persil->pemilik->photo_path) }}" alt="{{ $persil->pemilik->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: #2ebaae; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    {{ strtoupper(substr($persil->pemilik->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <strong>{{ $persil->pemilik->name }}</strong><br>
                                <small style="color: #666;">{{ $persil->pemilik->email }}</small>
                            </div>
                        @else
                            <em style="color: #999;">Belum ada pemilik yang ditentukan</em>
                        @endif
                    </div>
                    <small style="color: #666; display: block; margin-top: 0.5em;">Pemilik tidak dapat diubah (sesuai dengan akun yang membuat)</small>
                </div>

                <div class="form-group">
                    <label for="luas_m2">Luas (m²)</label>
                    <input type="number" id="luas_m2" name="luas_m2" step="0.01" min="0" value="{{ old('luas_m2', $persil->luas_m2) }}">
                    @error('luas_m2')
                    <div class="validation-error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" fill="#ff9800"/>
                            <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="penggunaan">Penggunaan Lahan</label>
                    <input type="text" id="penggunaan" name="penggunaan" value="{{ old('penggunaan', $persil->penggunaan) }}" placeholder="Contoh: Pertanian, Perumahan, dll">
                    @error('penggunaan')
                    <div class="validation-error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" fill="#ff9800"/>
                            <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat_lahan">Alamat Lahan</label>
                    <textarea id="alamat_lahan" name="alamat_lahan" rows="3">{{ old('alamat_lahan', $persil->alamat_lahan) }}</textarea>
                    @error('alamat_lahan')
                    <div class="validation-error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" fill="#ff9800"/>
                            <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rt">RT</label>
                        <input type="text" id="rt" name="rt" value="{{ old('rt', $persil->rt) }}" maxlength="5" placeholder="001">
                        @error('rt')
                        <div class="validation-error">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" fill="#ff9800"/>
                                <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rw">RW</label>
                        <input type="text" id="rw" name="rw" value="{{ old('rw', $persil->rw) }}" maxlength="5" placeholder="001">
                        @error('rw')
                        <div class="validation-error">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" fill="#ff9800"/>
                                <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button special">Update</button>
                    <a href="{{ route('guest.persil.show', $persil->persil_id) }}" class="button">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        padding: 2em;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 1.5em;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5em;
        font-weight: bold;
        color: #333;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.8em;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1em;
        font-family: inherit;
        background-color: #fff;
        color: #333;
    }

    .form-group select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232ebaae' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.8em center;
        background-size: 1.2em;
        padding-right: 2.5em;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #2ebaae;
        box-shadow: 0 0 5px rgba(46, 186, 174, 0.3);
        background-color: #fff;
    }

    .form-group select option {
        padding: 0.5em;
        background-color: #fff;
        color: #333;
    }

    .form-group select option:first-child {
        color: #999;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1em;
    }

    .form-actions {
        margin-top: 2em;
        text-align: center;
    }

    .form-actions button,
    .form-actions a {
        margin: 0 0.5em;
    }

    small {
        display: block;
        margin-top: 0.3em;
    }

    /* Custom Validation Message Styling */
    .custom-validation-message {
        display: none;
        margin-top: 0.5em;
        padding: 0.75em 1em;
        background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        color: white;
        border-radius: 8px;
        font-size: 0.9em;
        box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
        animation: slideDown 0.3s ease;
        position: relative;
        padding-left: 2.5em;
    }

    .custom-validation-message::before {
        content: '';
        position: absolute;
        left: 0.75em;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-validation-message::after {
        content: '!';
        position: absolute;
        left: 0.75em;
        top: 50%;
        transform: translateY(-50%);
        color: #ff9800;
        font-weight: 700;
        font-size: 0.9em;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-validation-message.show {
        display: block;
    }

    .validation-error {
        display: flex;
        align-items: center;
        gap: 0.5em;
        margin-top: 0.5em;
        padding: 0.75em 1em;
        background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        color: white;
        border-radius: 8px;
        font-size: 0.9em;
        box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
        animation: slideDown 0.3s ease;
    }

    .validation-error svg {
        flex-shrink: 0;
    }

    .form-group input:invalid:not(:placeholder-shown),
    .form-group input:invalid:focus {
        border-color: #ff9800;
        box-shadow: 0 0 8px rgba(255, 152, 0, 0.4);
    }

    .form-group input:valid:not(:placeholder-shown) {
        border-color: #4caf50;
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

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .custom-validation-message,
        .validation-error {
            font-size: 0.85em;
            padding: 0.65em 0.85em;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Owner Photo Preview Handler
    document.addEventListener('DOMContentLoaded', function() {
        const ownerSelect = document.getElementById('pemilik_warga_id');
        const ownerPreview = document.getElementById('owner-photo-preview');
        const previewPhoto = document.getElementById('preview-photo');
        const previewAvatar = document.getElementById('preview-avatar');
        const previewName = document.getElementById('preview-name');
        const ownerPhotoUpload = document.getElementById('owner-photo-upload');
        const ownerPhotoInput = document.getElementById('owner_photo');
        const newPhotoPreview = document.getElementById('new-photo-preview');
        const newPhotoImg = document.getElementById('new-photo-img');

        if (ownerSelect) {
            ownerSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const photoUrl = selectedOption.getAttribute('data-photo');
                const ownerName = selectedOption.getAttribute('data-name');

                if (this.value && ownerName) {
                    ownerPreview.style.display = 'flex';
                    ownerPhotoUpload.style.display = 'block';
                    previewName.textContent = ownerName;

                    if (photoUrl) {
                        previewPhoto.src = photoUrl;
                        previewPhoto.alt = ownerName;
                        previewPhoto.style.display = 'block';
                        previewAvatar.style.display = 'none';
                    } else {
                        previewPhoto.style.display = 'none';
                        previewAvatar.style.display = 'flex';
                        previewAvatar.textContent = ownerName.charAt(0).toUpperCase();
                    }
                } else {
                    ownerPreview.style.display = 'none';
                    ownerPhotoUpload.style.display = 'none';
                    newPhotoPreview.style.display = 'none';
                    ownerPhotoInput.value = '';
                }
            });
        }

        // Handle new photo upload preview
        if (ownerPhotoInput) {
            ownerPhotoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 2MB');
                        this.value = '';
                        newPhotoPreview.style.display = 'none';
                        return;
                    }

                    // Validate file type
                    if (!file.type.match('image/(jpeg|jpg|png)')) {
                        alert('Format file tidak didukung! Gunakan JPG atau PNG');
                        this.value = '';
                        newPhotoPreview.style.display = 'none';
                        return;
                    }

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        newPhotoImg.src = e.target.result;
                        newPhotoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    newPhotoPreview.style.display = 'none';
                }
            });
        }
    });

    // Custom validation message untuk HTML5 required fields
    document.addEventListener('DOMContentLoaded', function() {
        const requiredInputs = document.querySelectorAll('input[required], textarea[required], select[required]');

        requiredInputs.forEach(input => {
            const errorDiv = document.getElementById(input.id + '-error');

            // Custom message untuk setiap field
            const fieldLabels = {
                'kode_persil': 'Kode Persil wajib diisi',
                'pemilik_warga_id': 'Pemilik Persil wajib dipilih',
                'luas_m2': 'Luas wajib diisi',
                'penggunaan': 'Penggunaan Lahan wajib diisi',
                'alamat_lahan': 'Alamat Lahan wajib diisi',
                'rt': 'RT wajib diisi',
                'rw': 'RW wajib diisi'
            };

            // Set custom validation message
            input.setCustomValidity('');

            // Handle invalid event
            input.addEventListener('invalid', function(e) {
                e.preventDefault();
                const message = fieldLabels[input.id] || 'Field ini wajib diisi';

                if (errorDiv) {
                    errorDiv.textContent = message;
                    errorDiv.classList.add('show');
                }

                // Tambahkan class error ke input
                input.classList.add('input-error');

                // Highlight input
                input.style.borderColor = '#ff9800';
                input.style.boxShadow = '0 0 8px rgba(255, 152, 0, 0.4)';
            });

            // Handle input event untuk hide error
            input.addEventListener('input', function() {
                if (input.validity.valid) {
                    if (errorDiv) {
                        errorDiv.classList.remove('show');
                    }
                    input.classList.remove('input-error');
                    input.style.borderColor = '';
                    input.style.boxShadow = '';
                }
            });

            // Handle blur event
            input.addEventListener('blur', function() {
                if (!input.validity.valid && input.value === '') {
                    const message = fieldLabels[input.id] || 'Field ini wajib diisi';
                    if (errorDiv) {
                        errorDiv.textContent = message;
                        errorDiv.classList.add('show');
                    }
                }
            });
        });

        // Handle form submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                let isValid = true;

                requiredInputs.forEach(input => {
                    if (!input.validity.valid) {
                        isValid = false;
                        const errorDiv = document.getElementById(input.id + '-error');
                        const fieldLabels = {
                            'kode_persil': 'Kode Persil wajib diisi',
                            'pemilik_warga_id': 'Pemilik Persil wajib dipilih',
                            'luas_m2': 'Luas wajib diisi',
                            'penggunaan': 'Penggunaan Lahan wajib diisi',
                            'alamat_lahan': 'Alamat Lahan wajib diisi',
                            'rt': 'RT wajib diisi',
                            'rw': 'RW wajib diisi'
                        };

                        if (errorDiv) {
                            const message = fieldLabels[input.id] || 'Field ini wajib diisi';
                            errorDiv.textContent = message;
                            errorDiv.classList.add('show');
                        }

                        input.classList.add('input-error');
                        input.style.borderColor = '#ff9800';
                        input.style.boxShadow = '0 0 8px rgba(255, 152, 0, 0.4)';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Scroll ke field pertama yang error
                    const firstError = document.querySelector('.input-error');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }
            });
        }
    });
</script>
@endpush
