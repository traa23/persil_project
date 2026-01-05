@extends('layouts.guest')

@section('title', 'Detail Persil')
@section('page-title', 'Detail Persil - ' . $persil->kode_persil)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Info Dasar -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $persil->kode_persil }}</h2>

            <!-- Gallery Foto -->
            @if ($persil->fotoPersil->count() > 0)
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($persil->fotoPersil as $index => $foto)
                            <div class="relative group overflow-hidden rounded-lg shadow cursor-pointer hover:shadow-lg transition"
                                 onclick="openLightbox({{ $index }})">
                                <img src="{{ asset('storage/' . $foto->file_path) }}" alt="Foto Persil" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-3xl opacity-0 group-hover:opacity-100 transition"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mb-6 bg-gray-100 rounded-lg h-64 flex items-center justify-center">
                    <p class="text-gray-500">
                        <i class="fas fa-image mr-2"></i>
                        Belum ada foto
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Alamat Lahan</p>
                    <p class="font-semibold">{{ $persil->alamat_lahan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Luas (m²)</p>
                    <p class="font-semibold">{{ number_format($persil->luas_m2, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jenis Penggunaan</p>
                    <p class="font-semibold">{{ $persil->jenisPenggunaan->nama_penggunaan ?? '-' }}</p>
                </div>
                @if ($persil->rt && $persil->rw)
                    <div>
                        <p class="text-sm text-gray-600">RT/RW</p>
                        <p class="font-semibold">{{ $persil->rt }}/{{ $persil->rw }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Dokumen Persil -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                Dokumen Persil
            </h3>

            @if ($persil->dokumenPersil->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold">Jenis Dokumen</th>
                                <th class="px-3 py-2 text-left font-semibold">Nomor</th>
                                <th class="px-3 py-2 text-left font-semibold">Keterangan</th>
                                <th class="px-3 py-2 text-left font-semibold">File</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($persil->dokumenPersil as $dokumen)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $dokumen->jenis_dokumen }}</td>
                                    <td class="px-3 py-2">{{ $dokumen->nomor ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $dokumen->keterangan ?? '-' }}</td>
                                    <td class="px-3 py-2">
                                        @if ($dokumen->file_dokumen)
                                            <a href="{{ asset('storage/' . $dokumen->file_dokumen) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">Belum ada dokumen</p>
            @endif
        </div>

        <!-- Peta Persil -->
        @if ($persil->petaPersil)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-map-marked-alt mr-2 text-green-600"></i>
                    Peta Persil
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if ($persil->petaPersil->panjang_m && $persil->petaPersil->lebar_m)
                        <div>
                            <p class="text-sm text-gray-600">Panjang (m)</p>
                            <p class="text-lg font-semibold">{{ $persil->petaPersil->panjang_m }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Lebar (m)</p>
                            <p class="text-lg font-semibold">{{ $persil->petaPersil->lebar_m }}</p>
                        </div>
                    @endif
                </div>

                @if ($persil->petaPersil->file_peta)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $persil->petaPersil->file_peta) }}" target="_blank" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            <i class="fas fa-download mr-1"></i> Download Peta
                        </a>
                    </div>
                @endif

                @if ($persil->petaPersil->geojson)
                    <div class="mt-4 p-3 bg-gray-100 rounded text-sm">
                        <p class="font-semibold mb-2">GeoJSON:</p>
                        <pre class="whitespace-pre-wrap break-words text-xs">{{ $persil->petaPersil->geojson }}</pre>
                    </div>
                @endif
            </div>
        @endif

        <!-- Sengketa Persil -->
        @if ($persil->sengketa->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
                    Sengketa Persil
                </h3>

                @foreach ($persil->sengketa as $sengketa)
                    <div class="mb-4 p-4 border border-gray-200 rounded">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-semibold">Sengketa #{{ $sengketa->sengketa_id }}</div>
                            <span class="px-3 py-1 rounded text-sm font-semibold
                                @if ($sengketa->status == 'baru') bg-blue-100 text-blue-800
                                @elseif ($sengketa->status == 'proses') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($sengketa->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <p class="text-sm text-gray-600">Pihak 1</p>
                                <p class="font-semibold">{{ $sengketa->pihak_1 }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pihak 2</p>
                                <p class="font-semibold">{{ $sengketa->pihak_2 }}</p>
                            </div>
                        </div>

                        @if ($sengketa->kronologi)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600">Kronologi</p>
                                <p class="text-sm">{{ $sengketa->kronologi }}</p>
                            </div>
                        @endif

                        @if ($sengketa->penyelesaian)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600">Penyelesaian</p>
                                <p class="text-sm">{{ $sengketa->penyelesaian }}</p>
                            </div>
                        @endif

                        @if ($sengketa->bukti_sengketa)
                            <a href="{{ asset('storage/' . $sengketa->bukti_sengketa) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">
                                <i class="fas fa-download mr-1"></i> Download Bukti
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-blue-50 rounded-lg p-4">
            <h3 class="font-bold text-gray-800 mb-3">Informasi Pemilik</h3>
            <p class="text-sm mb-2">
                <span class="font-semibold">Nama:</span> {{ $persil->pemilik->name }}
            </p>
            <p class="text-sm">
                <span class="font-semibold">Email:</span> {{ $persil->pemilik->email }}
            </p>
        </div>

        <div class="bg-blue-50 rounded-lg p-4">
            <h3 class="font-bold text-gray-800 mb-3">Statistik</h3>
            <div class="space-y-2 text-sm">
                <p>
                    <span class="font-semibold">Dokumen:</span> {{ $persil->dokumenPersil->count() }}
                </p>
                <p>
                    <span class="font-semibold">Sengketa:</span> {{ $persil->sengketa->count() }}
                </p>
                <p>
                    <span class="font-semibold">Dibuat:</span> {{ $persil->created_at->format('d-m-Y H:i') }}
                </p>
                <p>
                    <span class="font-semibold">Diubah:</span> {{ $persil->updated_at->format('d-m-Y H:i') }}
                </p>
            </div>
        </div>

        <a href="{{ route('guest.dashboard') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4">
    <!-- Main Container -->
    <div class="relative w-full h-full flex flex-col items-center justify-center">
        <!-- Close Button -->
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 transition z-10">
            <i class="fas fa-times"></i>
        </button>

        <!-- Image Container -->
        <div class="flex-1 flex items-center justify-center relative max-w-5xl w-full">
            <img id="lightboxImage" src="" alt="Foto" class="max-h-[85vh] max-w-full object-contain rounded-lg shadow-2xl">
        </div>

        <!-- Navigation -->
        <div class="mt-6 flex items-center gap-4 justify-center">
            <!-- Previous Button -->
            <button onclick="previousPhoto()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>

            <!-- Counter -->
            <div class="text-white font-semibold min-w-[100px] text-center">
                <span id="photoCounter">0/0</span>
            </div>

            <!-- Next Button -->
            <button onclick="nextPhoto()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center gap-2">
                Selanjutnya <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Download Button -->
            <button onclick="downloadPhoto()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition flex items-center gap-2">
                <i class="fas fa-download"></i> Download
            </button>
        </div>

        <!-- Thumbnail Strip -->
        <div class="mt-6 flex gap-2 overflow-x-auto justify-center max-w-full">
            @foreach ($persil->fotoPersil as $index => $foto)
                <img src="{{ asset('storage/' . $foto->file_path) }}"
                     alt="Thumbnail {{ $index }}"
                     class="h-16 w-16 object-cover rounded cursor-pointer opacity-50 hover:opacity-100 transition border-2 border-transparent hover:border-white"
                     onclick="goToPhoto({{ $index }})">
            @endforeach
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    @php
        $fotoArray = $persil->fotoPersil->map(function($foto) {
            return asset('storage/' . $foto->file_path);
        })->toArray();
    @endphp

    const photos = @json($fotoArray);
    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        document.getElementById('lightboxModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightboxModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function updateLightbox() {
        document.getElementById('lightboxImage').src = photos[currentIndex];
        document.getElementById('photoCounter').textContent = (currentIndex + 1) + '/' + photos.length;

        // Update thumbnail highlight
        document.querySelectorAll('#lightboxModal img[alt^="Thumbnail"]').forEach((img, idx) => {
            if (idx === currentIndex) {
                img.classList.remove('opacity-50');
                img.classList.add('opacity-100', 'border-white');
            } else {
                img.classList.add('opacity-50');
                img.classList.remove('opacity-100', 'border-white');
            }
        });
    }

    function nextPhoto() {
        if (currentIndex < photos.length - 1) {
            currentIndex++;
            updateLightbox();
        }
    }

    function previousPhoto() {
        if (currentIndex > 0) {
            currentIndex--;
            updateLightbox();
        }
    }

    function goToPhoto(index) {
        currentIndex = index;
        updateLightbox();
    }

    function downloadPhoto() {
        const link = document.createElement('a');
        link.href = photos[currentIndex];
        link.download = 'foto-persil-' + (currentIndex + 1) + '.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(event) {
        if (document.getElementById('lightboxModal').classList.contains('hidden')) return;

        if (event.key === 'ArrowRight') nextPhoto();
        if (event.key === 'ArrowLeft') previousPhoto();
        if (event.key === 'Escape') closeLightbox();
    });

    // Close lightbox saat click di luar image
    document.getElementById('lightboxModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
</script>
@endsection
