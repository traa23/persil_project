@extends('layouts.sbadmin2')

@section('content')
<div class="container">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<h1 class="h3 mb-0">Sengketa Persil</h1>
		<a href="{{ route('admin.sengketa-persil.create') }}" class="btn btn-success">Tambah Sengketa</a>
	</div>
	@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
	<div class="card border-0 shadow"><div class="card-body p-0">
		<div class="table-responsive">
			<table class="table align-items-center table-flush mb-0">
				<thead class="thead-light"><tr><th>Persil</th><th>Pihak 1</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
				<tbody>
				@forelse($items as $item)
					<tr>
						<td>{{ optional($item->persil)->kode_persil }}</td>
						<td>{{ $item->pihak_1 }}</td>
						<td>{{ $item->status }}</td>
						<td class="text-end">
							<a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.sengketa-persil.show', $item->sengketa_id) }}">Detail</a>
							<a class="btn btn-sm btn-primary" href="{{ route('admin.sengketa-persil.edit', $item->sengketa_id) }}">Edit</a>
							<form class="d-inline" method="POST" action="{{ route('admin.sengketa-persil.destroy', $item->sengketa_id) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form>
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


