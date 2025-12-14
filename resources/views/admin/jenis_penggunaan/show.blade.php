@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Detail Jenis Penggunaan</h1>
	<div class="card"><div class="card-body">
		<dl class="row mb-0">
			<dt class="col-sm-3">Nama</dt><dd class="col-sm-9">{{ $jenisPenggunaan->nama_penggunaan }}</dd>
			<dt class="col-sm-3">Keterangan</dt><dd class="col-sm-9">{{ $jenisPenggunaan->keterangan }}</dd>
		</dl>
	</div></div>
	<div class="mt-3"><a href="{{ route('admin.jenis-penggunaan.index') }}" class="btn btn-light">Kembali</a><a href="{{ route('admin.jenis-penggunaan.edit', $jenisPenggunaan->jenis_id) }}" class="btn btn-primary ms-2">Edit</a></div>
</div>
@endsection


