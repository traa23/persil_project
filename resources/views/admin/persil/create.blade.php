@extends('layouts.sbadmin2')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Persil</h1>
    <a href="{{ route('admin.persil.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<!-- Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Persil</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.persil.store') }}">
            @csrf
            <div class="form-group">
                <label for="kode_persil">Kode Persil <span class="text-danger">*</span></label>
                <input type="text" name="kode_persil" class="form-control @error('kode_persil') is-invalid @enderror" value="{{ old('kode_persil') }}" required>
                @error('kode_persil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pemilik_warga_id">Pemilik (User)</label>
                        <select name="pemilik_warga_id" class="form-control @error('pemilik_warga_id') is-invalid @enderror">
                            <option value="">- Opsional -</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" @selected(old('pemilik_warga_id')==$u->id)>{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                        @error('pemilik_warga_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="luas_m2">Luas (m2)</label>
                        <input type="number" step="0.01" name="luas_m2" class="form-control @error('luas_m2') is-invalid @enderror" value="{{ old('luas_m2') }}">
                        @error('luas_m2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="penggunaan">Penggunaan</label>
                        <input type="text" name="penggunaan" class="form-control @error('penggunaan') is-invalid @enderror" value="{{ old('penggunaan') }}">
                        @error('penggunaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="alamat_lahan">Alamat Lahan</label>
                <textarea name="alamat_lahan" class="form-control @error('alamat_lahan') is-invalid @enderror" rows="3">{{ old('alamat_lahan') }}</textarea>
                @error('alamat_lahan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="rt">RT</label>
                        <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt') }}">
                        @error('rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="rw">RW</label>
                        <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw') }}">
                        @error('rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.persil.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


