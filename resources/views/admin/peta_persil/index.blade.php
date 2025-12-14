@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<div>
			<nav aria-label="breadcrumb"><ol class="breadcrumb mb-1"><li class="breadcrumb-item"><a href="{{ url('/admin/peta-persil') }}">Peta Persil</a></li><li class="breadcrumb-item active">List</li></ol></nav>
			<h1 class="h3 mb-0">Peta Persil</h1>
		</div>
		<a href="{{ route('admin.peta-persil.create') }}" class="btn btn-success">Tambah Peta</a>
	</div>
	@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
	<div class="card border-0 shadow"><div class="card-body p-0">
		<div class="table-responsive">
			<table class="table align-items-center table-flush mb-0">
				<thead class="thead-light"><tr><th>Persil</th><th>Panjang (m)</th><th>Lebar (m)</th><th class="text-end">Aksi</th></tr></thead>
				<tbody>
				@forelse($items as $item)
					<tr>
						<td>{{ optional($item->persil)->kode_persil }}</td>
						<td>{{ $item->panjang_m }}</td>
						<td>{{ $item->lebar_m }}</td>
						<td class="text-end">
							<a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.peta-persil.show', $item->peta_id) }}">Detail</a>
							<a class="btn btn-sm btn-primary" href="{{ route('admin.peta-persil.edit', $item->peta_id) }}">Edit</a>
							<form class="d-inline" method="POST" action="{{ route('admin.peta-persil.destroy', $item->peta_id) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>
						</td>
					</tr>
				@empty
					<tr><td colspan="4" class="text-center text-muted">Belum ada data</td></tr>
				@endforelse
				</tbody>
			</table>
		</div>
	</div></div>
	<div class="mt-3">{{ $items->links() }}</div>
</div>
@endsection


