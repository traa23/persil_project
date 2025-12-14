@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Tambah Dokumen Persil</h1>
	@if($persil->isEmpty())
		<div class="alert alert-warning mb-3">
			Belum ada data Persil. Silakan <a href="{{ route('admin.persil.create') }}">tambah Persil</a> terlebih dahulu agar bisa memilih di sini.
		</div>
	@endif
	<form method="POST" action="{{ route('admin.dokumen-persil.store') }}" enctype="multipart/form-data">
		@csrf
		<div class="mb-3">
			<label class="form-label">Persil</label>
			<select name="persil_id" class="form-select" @if($persil->isEmpty()) disabled @endif>
				<option value="">- Pilih -</option>
				@foreach($persil as $p)
					<option value="{{ $p->persil_id }}">{{ $p->kode_persil }}</option>
				@endforeach
			</select>
			@error('persil_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Jenis Dokumen</label>
				<input name="jenis_dokumen" class="form-control" value="{{ old('jenis_dokumen') }}">
				@error('jenis_dokumen')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Nomor</label>
				<input name="nomor" class="form-control" value="{{ old('nomor') }}">
				@error('nomor')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
		</div>
		<div class="mb-3">
			<label class="form-label">Keterangan</label>
			<textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
		</div>
		<div class="mb-3">
			<label class="form-label">File</label>
			<input type="file" name="file" class="form-control">
			@error('file')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="d-flex gap-2">
			<a href="{{ route('admin.dokumen-persil.index') }}" class="btn btn-light">Batal</a>
			<button class="btn btn-primary" @if($persil->isEmpty()) disabled @endif>Simpan</button>
		</div>
	</form>
</div>
@endsection


