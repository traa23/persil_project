@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Edit Sengketa Persil</h1>
	<form method="POST" action="{{ route('admin.sengketa-persil.update', $sengketaPersil->sengketa_id) }}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="mb-3">
			<label class="form-label">Persil</label>
			<select name="persil_id" class="form-select">
				@foreach($persil as $p)
					<option value="{{ $p->persil_id }}" @selected(old('persil_id', $sengketaPersil->persil_id)==$p->persil_id)>{{ $p->kode_persil }}</option>
				@endforeach
			</select>
			@error('persil_id')<div class="text-danger small">{{ $message }}</div>@enderror
		</div>
		<div class="row">
			<div class="col-md-6 mb-3"><label class="form-label">Pihak 1</label><input name="pihak_1" class="form-control" value="{{ old('pihak_1', $sengketaPersil->pihak_1) }}">@error('pihak_1')<div class="text-danger small">{{ $message }}</div>@enderror</div>
			<div class="col-md-6 mb-3"><label class="form-label">Pihak 2</label><input name="pihak_2" class="form-control" value="{{ old('pihak_2', $sengketaPersil->pihak_2) }}"></div>
		</div>
		<div class="mb-3"><label class="form-label">Kronologi</label><textarea name="kronologi" class="form-control">{{ old('kronologi', $sengketaPersil->kronologi) }}</textarea></div>
		<div class="row">
			<div class="col-md-6 mb-3"><label class="form-label">Status</label><input name="status" class="form-control" value="{{ old('status', $sengketaPersil->status) }}"></div>
			<div class="col-md-6 mb-3"><label class="form-label">Penyelesaian</label><input name="penyelesaian" class="form-control" value="{{ old('penyelesaian', $sengketaPersil->penyelesaian) }}"></div>
		</div>
		<div class="mb-3"><label class="form-label">Bukti (opsional)</label><input type="file" name="file" class="form-control">@error('file')<div class="text-danger small">{{ $message }}</div>@enderror</div>
		<div class="d-flex gap-2"><a href="{{ route('admin.sengketa-persil.index') }}" class="btn btn-light">Batal</a><button class="btn btn-primary">Update</button></div>
	</form>
</div>
@endsection


