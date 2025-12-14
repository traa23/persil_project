@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<h1 class="h3 mb-3">Edit Jenis Penggunaan</h1>
	<form method="POST" action="{{ route('admin.jenis-penggunaan.update', $jenisPenggunaan->jenis_id) }}">
		@csrf
		@method('PUT')
		<div class="mb-3"><label class="form-label">Nama</label><input name="nama_penggunaan" class="form-control" value="{{ old('nama_penggunaan', $jenisPenggunaan->nama_penggunaan) }}">@error('nama_penggunaan')<div class="text-danger small">{{ $message }}</div>@enderror</div>
		<div class="mb-3"><label class="form-label">Keterangan</label><textarea name="keterangan" class="form-control">{{ old('keterangan', $jenisPenggunaan->keterangan) }}</textarea></div>
		<div class="d-flex gap-2"><a href="{{ route('admin.jenis-penggunaan.index') }}" class="btn btn-light">Batal</a><button class="btn btn-primary">Update</button></div>
	</form>
</div>
@endsection


