@extends('layouts.sbadmin2')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Persil</h1>
    <a href="{{ route('admin.persil.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<!-- Detail Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Persil</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="font-weight-bold">Kode Persil:</label>
                    <p class="form-control-plaintext">{{ $persil->kode_persil }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="font-weight-bold">Pemilik:</label>
                    <p class="form-control-plaintext">{{ optional($persil->pemilik)->name ?? '-' }}</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="font-weight-bold">Luas (m2):</label>
                    <p class="form-control-plaintext">{{ $persil->luas_m2 ?? '-' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="font-weight-bold">Penggunaan:</label>
                    <p class="form-control-plaintext">{{ $persil->penggunaan ?? '-' }}</p>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="font-weight-bold">Alamat Lahan:</label>
            <p class="form-control-plaintext">{{ $persil->alamat_lahan ?? '-' }}</p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="font-weight-bold">RT:</label>
                    <p class="form-control-plaintext">{{ $persil->rt ?? '-' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="font-weight-bold">RW:</label>
                    <p class="form-control-plaintext">{{ $persil->rw ?? '-' }}</p>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <a href="{{ route('admin.persil.edit', $persil->persil_id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.persil.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection


