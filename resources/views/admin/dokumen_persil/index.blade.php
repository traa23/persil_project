@extends('layouts.sbadmin2')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dokumen Persil</h1>
    <a href="{{ route('admin.dokumen-persil.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Dokumen
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen Persil</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Persil</th>
                        <th>Jenis Dokumen</th>
                        <th>Nomor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="font-weight-bold">{{ optional($item->persil)->kode_persil }}</td>
                        <td>{{ $item->jenis_dokumen }}</td>
                        <td>{{ $item->nomor ?? '-' }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('admin.dokumen-persil.show', $item->dokumen_id) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-warning btn-sm" href="{{ route('admin.dokumen-persil.edit', $item->dokumen_id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form class="d-inline" method="POST" action="{{ route('admin.dokumen-persil.destroy', $item->dokumen_id) }}" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
