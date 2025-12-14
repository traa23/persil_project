@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Detail Peta Persil</h1>
	<div class="card"><div class="card-body">
		<dl class="row mb-0">
			<dt class="col-sm-3">Persil</dt><dd class="col-sm-9">{{ optional($petaPersil->persil)->kode_persil }}</dd>
			<dt class="col-sm-3">Panjang (m)</dt><dd class="col-sm-9">{{ $petaPersil->panjang_m }}</dd>
			<dt class="col-sm-3">Lebar (m)</dt><dd class="col-sm-9">{{ $petaPersil->lebar_m }}</dd>
			<dt class="col-sm-3">GeoJSON</dt><dd class="col-sm-9"><pre class="mb-0">{{ Str::limit($petaPersil->geojson, 1000) }}</pre></dd>
			<dt class="col-sm-3">Lampiran</dt><dd class="col-sm-9">@if($petaPersil->file_path)<a href="{{ asset('storage/'.$petaPersil->file_path) }}" target="_blank">Lihat</a>@endif</dd>
		</dl>
	</div></div>
	<div class="mt-3">
		<a href="{{ route('admin.peta-persil.index') }}" class="btn btn-light">Kembali</a>
		<a href="{{ route('admin.peta-persil.edit', $petaPersil->peta_id) }}" class="btn btn-primary">Edit</a>
	</div>
</div>
@endsection


