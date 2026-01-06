@extends('layouts.admin')

@section('title', 'Tambah Persil')
@section('page-title', 'Tambah Data Persil')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    {{-- OLD: route('admin.persil.store') --}}
    <form action="{{ getAdminRoute('persil.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kode Persil -->
            <div>
                <label for="kode_persil" class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Persil <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="kode_persil"
                    name="kode_persil"
                    value="{{ old('kode_persil') }}"
                    class="w-full px-4 py-2 border @error('kode_persil') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
                @error('kode_persil')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pemilik -->
            <div>
                <label for="pemilik_warga_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pemilik/Warga <span class="text-red-500">*</span>
                </label>
                <select
                    id="pemilik_warga_id"
                    name="pemilik_warga_id"
                    class="w-full px-4 py-2 border @error('pemilik_warga_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
                    <option value="">-- Pilih Warga --</option>
                    @foreach ($wargaList as $warga)
                        <option value="{{ $warga->warga_id }}" {{ (old('pemilik_warga_id') == $warga->warga_id || request('warga_id') == $warga->warga_id) ? 'selected' : '' }}>
                            {{ $warga->nama }} {{ $warga->email ? '(' . $warga->email . ')' : '' }}
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-500 text-xs mt-1">
                    <i class="fas fa-info-circle mr-1"></i>
                    Pilih warga yang memiliki email untuk menghubungkan dengan akun user.
                </p>
                @error('pemilik_warga_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Luas -->
            <div>
                <label for="luas_m2" class="block text-sm font-medium text-gray-700 mb-2">
                    Luas (m²) <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    id="luas_m2"
                    name="luas_m2"
                    value="{{ old('luas_m2') }}"
                    step="0.01"
                    class="w-full px-4 py-2 border @error('luas_m2') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required
                >
                @error('luas_m2')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Penggunaan -->
            <div>
                <label for="jenis_penggunaan_input" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Penggunaan <span class="text-red-500">*</span>
                </label>
                <div class="relative" id="jenisPenggunaanContainer">
                    <!-- Input Field -->
                    <input
                        type="text"
                        id="jenis_penggunaan_input"
                        name="jenis_penggunaan_custom"
                        value="{{ old('jenis_penggunaan_custom') }}"
                        placeholder="Cari atau ketik jenis penggunaan"
                        class="w-full px-4 py-2 border @error('jenis_penggunaan_custom') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        autocomplete="off"
                        required
                    >
                    <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>

                    <!-- Custom Dropdown -->
                    <div id="jenisPenggunaanDropdown" class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 hidden max-h-64 overflow-y-auto">
                        <!-- Search Input di Dropdown -->
                        <div class="sticky top-0 p-2 bg-gray-50 border-b">
                            <input
                                type="text"
                                id="jenisPenggunaanSearch"
                                placeholder="Cari jenis..."
                                class="w-full px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                            >
                        </div>

                        <!-- Dropdown Items -->
                        <div id="jenisPenggunaanItems" class="py-1">
                            @foreach ($jenisPenggunaan as $jenis)
                                <div class="jenis-option p-3 hover:bg-purple-50 cursor-pointer border-l-4 border-l-transparent hover:border-l-purple-500 transition"
                                     data-value="{{ $jenis->nama_penggunaan }}"
                                     data-icon="fas fa-leaf">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-leaf text-green-600"></i>
                                        <span class="font-medium text-gray-800">{{ $jenis->nama_penggunaan }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Custom Option -->
                        <div class="border-t p-3 bg-gradient-to-r from-purple-50 to-blue-50">
                            <div class="flex items-center gap-2 text-purple-600 font-medium">
                                <i class="fas fa-plus-circle"></i>
                                <span class="text-sm">Gunakan value yang diketik</span>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-gray-500 text-xs mt-1">💡 Ketik untuk mencari atau pilih dari daftar yang tersedia</p>
                @error('jenis_penggunaan_custom')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const input = document.getElementById('jenis_penggunaan_input');
                    const dropdown = document.getElementById('jenisPenggunaanDropdown');
                    const searchInput = document.getElementById('jenisPenggunaanSearch');
                    const itemsContainer = document.getElementById('jenisPenggunaanItems');
                    const options = Array.from(document.querySelectorAll('.jenis-option'));

                    // Tampilkan dropdown saat input di-focus (pertama kali atau saat di-click)
                    input.addEventListener('focus', function() {
                        dropdown.classList.remove('hidden');
                        // Reset search saat focus
                        searchInput.value = '';
                        options.forEach(option => {
                            option.style.display = 'block';
                        });
                        // Focus ke search input agar user bisa langsung ketik
                        setTimeout(() => searchInput.focus(), 100);
                    });

                    // Sembunyikan dropdown saat click di luar
                    document.addEventListener('click', function(e) {
                        const container = document.getElementById('jenisPenggunaanContainer');
                        if (!container.contains(e.target)) {
                            dropdown.classList.add('hidden');
                        }
                    });

                    // Filter dropdown saat mengetik di search input (di dalam dropdown)
                    searchInput.addEventListener('input', function() {
                        const searchValue = this.value.toLowerCase();
                        let visibleCount = 0;

                        options.forEach(option => {
                            const text = option.textContent.toLowerCase();
                            if (text.includes(searchValue)) {
                                option.style.display = 'block';
                                visibleCount++;
                            } else {
                                option.style.display = 'none';
                            }
                        });

                        // Sinkronisasi nilai ke main input
                        if (searchValue.length > 0) {
                            input.value = searchValue;
                        }
                    });

                    // Filter dropdown saat mengetik di main input
                    input.addEventListener('input', function() {
                        const searchValue = this.value.toLowerCase();

                        options.forEach(option => {
                            const text = option.textContent.toLowerCase();
                            const matches = text.includes(searchValue);
                            option.style.display = matches ? 'block' : 'none';
                        });

                        // Tampilkan dropdown saat mengetik
                        if (searchValue.length > 0) {
                            dropdown.classList.remove('hidden');
                            searchInput.value = searchValue;
                        }
                    });

                    // Pilih item dari dropdown
                    options.forEach(option => {
                        option.addEventListener('click', function() {
                            const value = this.dataset.value;
                            input.value = value;
                            input.focus(); // Tetap fokus di input
                            dropdown.classList.add('hidden');
                        });

                        // Hover effect untuk keyboard navigation
                        option.addEventListener('mouseenter', function() {
                            options.forEach(opt => opt.classList.remove('bg-purple-100'));
                            this.classList.add('bg-purple-100');
                        });
                    });

                    // Keyboard navigation
                    input.addEventListener('keydown', function(e) {
                        const visibleOptions = options.filter(opt => opt.style.display !== 'none');
                        const selectedIndex = Array.from(visibleOptions).findIndex(opt => opt.classList.contains('bg-purple-100'));

                        if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            dropdown.classList.remove('hidden');
                            if (selectedIndex < visibleOptions.length - 1) {
                                visibleOptions.forEach(opt => opt.classList.remove('bg-purple-100'));
                                visibleOptions[selectedIndex + 1].classList.add('bg-purple-100');
                                visibleOptions[selectedIndex + 1].scrollIntoView({ block: 'nearest' });
                            }
                        } else if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            if (selectedIndex > 0) {
                                visibleOptions.forEach(opt => opt.classList.remove('bg-purple-100'));
                                visibleOptions[selectedIndex - 1].classList.add('bg-purple-100');
                                visibleOptions[selectedIndex - 1].scrollIntoView({ block: 'nearest' });
                            }
                        } else if (e.key === 'Enter') {
                            e.preventDefault();
                            if (selectedIndex >= 0) {
                                visibleOptions[selectedIndex].click();
                            } else {
                                // Jika tidak ada pilihan, submit form atau tutup dropdown
                                dropdown.classList.add('hidden');
                            }
                        } else if (e.key === 'Escape') {
                            dropdown.classList.add('hidden');
                        }
                    });
                });
            </script>

            <!-- RT -->
            <div>
                <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">
                    RT
                </label>
                <input
                    type="number"
                    id="rt"
                    name="rt"
                    value="{{ old('rt') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                @error('rt')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- RW -->
            <div>
                <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">
                    RW
                </label>
                <input
                    type="number"
                    id="rw"
                    name="rw"
                    value="{{ old('rw') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                @error('rw')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Alamat Lahan -->
        <div>
            <label for="alamat_lahan" class="block text-sm font-medium text-gray-700 mb-2">
                Alamat Lahan <span class="text-red-500">*</span>
            </label>
            <textarea
                id="alamat_lahan"
                name="alamat_lahan"
                rows="3"
                class="w-full px-4 py-2 border @error('alamat_lahan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
            >{{ old('alamat_lahan') }}</textarea>
            @error('alamat_lahan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Foto Persil (Multiple) -->
        <div>
            <label for="foto_persil" class="block text-sm font-medium text-gray-700 mb-2">
                Foto Persil (Bisa Multiple)
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 text-center cursor-pointer hover:border-purple-500 transition"
                 onclick="document.getElementById('foto_persil').click()">
                <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-600">Drag & drop foto di sini atau click untuk pilih</p>
                <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG (Max: 2MB per file)</p>
            </div>
            <input
                type="file"
                id="foto_persil"
                name="foto_persil[]"
                accept="image/*"
                multiple
                class="hidden"
                onchange="previewFotos()"
            >
            @error('foto_persil')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('foto_persil.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Preview -->
            <div id="preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 hidden">
                <!-- Preview akan ditampilkan di sini -->
            </div>
        </div>

        <style>
            #preview-container.hidden {
                display: none;
            }
            #preview-container:not(.hidden) {
                display: grid;
            }
        </style>

        <script>
            function previewFotos() {
                const input = document.getElementById('foto_persil');
                const container = document.getElementById('preview-container');
                container.innerHTML = '';

                if (input.files.length > 0) {
                    container.classList.remove('hidden');
                    Array.from(input.files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.createElement('div');
                            preview.className = 'relative';
                            preview.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-40 object-cover rounded-lg">
                                <p class="text-gray-600 text-sm mt-1 truncate">${file.name}</p>
                            `;
                            container.appendChild(preview);
                        };
                        reader.readAsDataURL(file);
                    });
                } else {
                    container.classList.add('hidden');
                }
            }
        </script>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <button
                type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 font-medium"
            >
                Simpan
            </button>
            {{-- OLD: route('admin.persil.list') --}}
            <a href="{{ getAdminRoute('persil.list') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
