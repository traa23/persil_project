@extends('layouts.user')

@section('title', 'Jenis Penggunaan')
@section('page-title', 'Jenis Penggunaan Lahan')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-6">
        <i class="fas fa-tags text-indigo-600 mr-2"></i>
        Referensi Jenis Penggunaan Lahan
    </h3>

    @if($jenisPenggunaan->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($jenisPenggunaan as $jenis)
        <div class="border rounded-lg p-4 hover:shadow-md transition">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-tag text-indigo-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $jenis->nama }}</p>
                    @if($jenis->keterangan)
                    <p class="text-sm text-gray-500">{{ $jenis->keterangan }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12 text-gray-500">
        <i class="fas fa-tags text-5xl mb-4"></i>
        <p class="text-lg">Belum ada data jenis penggunaan.</p>
    </div>
    @endif
</div>
@endsection
