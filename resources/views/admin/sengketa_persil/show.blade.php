@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Detail Sengketa Persil</h1>
	<div class="card"><div class="card-body">
		<dl class="row mb-0">
			<dt class="col-sm-3">Persil</dt><dd class="col-sm-9">{{ optional($sengketaPersil->persil)->kode_persil }}</dd>
			<dt class="col-sm-3">Pihak 1</dt><dd class="col-sm-9">{{ $sengketaPersil->pihak_1 }}</dd>
			<dt class="col-sm-3">Pihak 2</dt><dd class="col-sm-9">{{ $sengketaPersil->pihak_2 }}</dd>
			<dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ $sengketaPersil->status }}</dd>
			<dt class="col-sm-3">Penyelesaian</dt><dd class="col-sm-9">{{ $sengketaPersil->penyelesaian }}</dd>
			<dt class="col-sm-3">Bukti</dt><dd class="col-sm-9">@if($sengketaPersil->file_path)<a href="{{ asset('storage/'.$sengketaPersil->file_path) }}" target="_blank">Lihat</a>@endif</dd>
		</dl>
	</div></div>
	<div class="mt-3"><a href="{{ route('admin.sengketa-persil.index') }}" class="btn btn-light">Kembali</a><a href="{{ route('admin.sengketa-persil.edit', $sengketaPersil->sengketa_id) }}" class="btn btn-primary ms-2">Edit</a></div>
</div>
@endsection


