@extends('layouts.sbadmin2')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Persil</h1>
    <a href="{{ route('admin.persil.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Persil
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

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Terjadi kesalahan input. Periksa kembali form Anda.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Persil</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode Persil</th>
                        <th>Pemilik</th>
                        <th>Luas (m2)</th>
                        <th>Penggunaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="font-weight-bold">{{ $item->kode_persil }}</td>
                        <td>{{ optional($item->pemilik)->name }}</td>
                        <td>{{ $item->luas_m2 }}</td>
                        <td>{{ $item->penggunaan }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('admin.persil.show', $item->persil_id) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-warning btn-sm" href="{{ route('admin.persil.edit', $item->persil_id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form class="d-inline" method="POST" action="{{ route('admin.persil.destroy', $item->persil_id) }}" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
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


