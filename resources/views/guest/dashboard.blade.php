@extends('layouts.guest')

@section('title', 'Dashboard Guest')
@section('page-title', 'Dashboard')

@php
use App\Helpers\IconHelper;
@endphp

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">
        <i class="fas fa-map mr-2 text-blue-600"></i>
        Data Persil Saya
    </h2>

    @if ($persils->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($persils as $persil)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition p-4">
                    <div class="space-y-2">
                        <h3 class="font-semibold text-gray-800">{{ $persil->kode_persil }}</h3>
                        <p class="text-sm text-gray-600">{{ $persil->alamat_lahan }}</p>
                        <p class="text-sm">
                            <span class="font-medium">Luas:</span> {{ number_format($persil->luas_m2, 2) }} m²
                        </p>
                        <p class="text-sm">
                            <span class="font-medium">Penggunaan:</span> {{ $persil->jenisPenggunaan->nama_penggunaan ?? '-' }}
                        </p>
                        @if ($persil->rt && $persil->rw)
                            <p class="text-sm">
                                <span class="font-medium">RT/RW:</span> {{ $persil->rt }}/{{ $persil->rw }}
                            </p>
                        @endif
                    </div>

                    @php
                        // Filter dokumen yang berupa foto
                        $imageDokumen = collect();
                        if ($persil->dokumenPersil && $persil->dokumenPersil->count() > 0) {
                            $imageDokumen = $persil->dokumenPersil->filter(function($dokumen) {
                                $extension = strtolower(pathinfo($dokumen->file_dokumen, PATHINFO_EXTENSION));
                                return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            });
                        }

                        // Filter peta yang berupa gambar (petaPersil adalah hasOne, bukan collection)
                        $imagePeta = collect();
                        if ($persil->petaPersil) {
                            $extension = strtolower(pathinfo($persil->petaPersil->file_peta, PATHINFO_EXTENSION));
                            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                $imagePeta = collect([$persil->petaPersil]);
                            }
                        }

                        $allImages = $imageDokumen->concat($imagePeta);
                    @endphp

                    @if ($allImages && $allImages->count() > 0)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-images mr-1"></i>
                                Preview Foto ({{ $allImages->count() }})
                            </p>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach ($allImages->take(6) as $image)
                                    <div class="relative group overflow-hidden rounded-lg bg-gray-100" style="height: 80px;">
                                        <img src="{{ asset('storage/' . $image->file_dokumen ?? $image->file_peta) }}"
                                             alt="Foto"
                                             class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition flex items-center justify-center">
                                            <button type="button"
                                                    class="opacity-0 group-hover:opacity-100 transition text-white text-sm"
                                                    onclick="window.open('{{ asset('storage/' . ($image->file_dokumen ?? $image->file_peta)) }}', '_blank')">
                                                <i class="fas fa-search-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($allImages->count() > 6)
                                    <div class="relative overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center" style="height: 80px;">
                                        <div class="text-center">
                                            <p class="text-sm font-medium text-gray-700">+{{ $allImages->count() - 6 }}</p>
                                            <p class="text-xs text-gray-500">foto lagi</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('guest.persil.detail', $persil->persil_id) }}" class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                            <i class="fas fa-eye mr-1"></i>
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $persils->links() }}
        </div>
    @else
        <div class="p-8 text-center">
            <i class="fas fa-inbox text-gray-400 text-4xl mb-3 block"></i>
            <p class="text-gray-600">Belum ada data persil yang ditugaskan untuk Anda</p>
        </div>
    @endif
</div>
@endsection
