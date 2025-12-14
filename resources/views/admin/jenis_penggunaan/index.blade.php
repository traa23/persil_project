@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<h1 class="h3 mb-0">Jenis Penggunaan</h1>
		<a href="{{ route('admin.jenis-penggunaan.create') }}" class="btn btn-success">Tambah Jenis</a>
	</div>
	@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
	<div class="card border-0 shadow"><div class="card-body p-0">
		<table class="table align-items-center table-flush mb-0">
			<thead class="thead-light"><tr><th>Nama</th><th>Keterangan</th><th class="text-end">Aksi</th></tr></thead>
			<tbody>
			@forelse($items as $item)
				<tr>
					<td class="text-gray-900 fw-bold">{{ $item->nama_penggunaan }}</td>
					<td>{{ $item->keterangan }}</td>
					<td class="text-end">
						<a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.jenis-penggunaan.show', $item->jenis_id) }}">Detail</a>
						<a class="btn btn-sm btn-primary" href="{{ route('admin.jenis-penggunaan.edit', $item->jenis_id) }}">Edit</a>
						<form class="d-inline" method="POST" action="{{ route('admin.jenis-penggunaan.destroy', $item->jenis_id) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>
					</td>
				</tr>
			@empty
				<tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>
			@endforelse
			</tbody>
		</table>
	</div></div>
	<div class="mt-3">{{ $items->links() }}</div>
</div>
@endsection


