@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Detail Dokumen Persil</h1>
	<div class="card"><div class="card-body">
		<dl class="row mb-0">
			<dt class="col-sm-3">Persil</dt><dd class="col-sm-9">{{ optional($dokumenPersil->persil)->kode_persil }}</dd>
			<dt class="col-sm-3">Jenis</dt><dd class="col-sm-9">{{ $dokumenPersil->jenis_dokumen }}</dd>
			<dt class="col-sm-3">Nomor</dt><dd class="col-sm-9">{{ $dokumenPersil->nomor }}</dd>
			<dt class="col-sm-3">Keterangan</dt><dd class="col-sm-9">{{ $dokumenPersil->keterangan }}</dd>
			<dt class="col-sm-3">File</dt><dd class="col-sm-9">@if($dokumenPersil->file_path)<a href="{{ asset('storage/'.$dokumenPersil->file_path) }}" target="_blank">Download</a>@endif</dd>
		</dl>
	</div></div>
	<div class="mt-3">
		<a href="{{ route('admin.dokumen-persil.index') }}" class="btn btn-light">Kembali</a>
		<a href="{{ route('admin.dokumen-persil.edit', $dokumenPersil->dokumen_id) }}" class="btn btn-primary">Edit</a>
	</div>
</div>
@endsection


