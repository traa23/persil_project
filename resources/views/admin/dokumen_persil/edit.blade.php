@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Edit Dokumen Persil</h1>
	<form method="POST" action="{{ route('admin.dokumen-persil.update', $dokumenPersil->dokumen_id) }}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="mb-3">
			<label class="form-label">Persil</label>
			<select name="persil_id" class="form-select">
				@foreach($persil as $p)
					<option value="{{ $p->persil_id }}" @selected(old('persil_id', $dokumenPersil->persil_id)==$p->persil_id)>{{ $p->kode_persil }}</option>
				@endforeach
			</select>
			@error('persil_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="row">
			<div class="col-md-6 mb-3">
				<label class="form-label">Jenis Dokumen</label>
				<input name="jenis_dokumen" class="form-control" value="{{ old('jenis_dokumen', $dokumenPersil->jenis_dokumen) }}">
				@error('jenis_dokumen')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
			<div class="col-md-6 mb-3">
				<label class="form-label">Nomor</label>
				<input name="nomor" class="form-control" value="{{ old('nomor', $dokumenPersil->nomor) }}">
				@error('nomor')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
		</div>
		<div class="mb-3">
			<label class="form-label">Keterangan</label>
			<textarea name="keterangan" class="form-control">{{ old('keterangan', $dokumenPersil->keterangan) }}</textarea>
		</div>
		<div class="mb-3">
			<label class="form-label">File (opsional)</label>
			<input type="file" name="file" class="form-control">
			@error('file')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="d-flex gap-2">
			<a href="{{ route('admin.dokumen-persil.index') }}" class="btn btn-light">Batal</a>
			<button class="btn btn-primary">Update</button>
		</div>
	</form>
</div>
@endsection


