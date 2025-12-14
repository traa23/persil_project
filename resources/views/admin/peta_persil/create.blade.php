@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Tambah Peta Persil</h1>
	@if($persil->isEmpty())
		<div class="alert alert-warning">Belum ada data Persil. Tambahkan dulu di menu Persil agar bisa memilih.</div>
	@endif
	<form method="POST" action="{{ route('admin.peta-persil.store') }}" enctype="multipart/form-data">
		@csrf
		<div class="mb-3">
			<label class="form-label">Persil</label>
			<select name="persil_id" class="form-select">
				<option value="">- Pilih -</option>
				@foreach($persil as $p)
					<option value="{{ $p->persil_id }}">{{ $p->kode_persil }}</option>
				@endforeach
			</select>
			@error('persil_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Panjang (m)</label>
				<input name="panjang_m" class="form-control" value="{{ old('panjang_m') }}">
				@error('panjang_m')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Lebar (m)</label>
				<input name="lebar_m" class="form-control" value="{{ old('lebar_m') }}">
				@error('lebar_m')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
		</div>
		<div class="mb-3">
			<label class="form-label">GeoJSON</label>
			<textarea name="geojson" rows="6" class="form-control">{{ old('geojson') }}</textarea>
		</div>
		<div class="mb-3">
			<label class="form-label">Lampiran Scan (opsional)</label>
			<input type="file" name="file" class="form-control">
			@error('file')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="d-flex gap-2">
			<a href="{{ route('admin.peta-persil.index') }}" class="btn btn-light">Batal</a>
			<button class="btn btn-primary">Simpan</button>
		</div>
	</form>
</div>
@endsection


