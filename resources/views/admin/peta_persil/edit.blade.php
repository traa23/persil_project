@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Edit Peta Persil</h1>
	<form method="POST" action="{{ route('admin.peta-persil.update', $petaPersil->peta_id) }}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="mb-3">
			<label class="form-label">Persil</label>
			<select name="persil_id" class="form-select">
				@foreach($persil as $p)
					<option value="{{ $p->persil_id }}" @selected(old('persil_id', $petaPersil->persil_id)==$p->persil_id)>{{ $p->kode_persil }}</option>
				@endforeach
			</select>
			@error('persil_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Panjang (m)</label>
				<input name="panjang_m" class="form-control" value="{{ old('panjang_m', $petaPersil->panjang_m) }}">
				@error('panjang_m')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Lebar (m)</label>
				<input name="lebar_m" class="form-control" value="{{ old('lebar_m', $petaPersil->lebar_m) }}">
				@error('lebar_m')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
		</div>
		<div class="mb-3">
			<label class="form-label">GeoJSON</label>
			<textarea name="geojson" rows="6" class="form-control">{{ old('geojson', $petaPersil->geojson) }}</textarea>
		</div>
		<div class="mb-3">
			<label class="form-label">Lampiran Scan (opsional)</label>
			<input type="file" name="file" class="form-control">
			@error('file')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="d-flex gap-2">
			<a href="{{ route('admin.peta-persil.index') }}" class="btn btn-light">Batal</a>
			<button class="btn btn-primary">Update</button>
		</div>
	</form>
</div>
@endsection


