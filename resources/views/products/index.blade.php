@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
    <h1>Products</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Create</a>
        </div>
        <div class="card-body table-responsive">
            <table id="crudTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($products as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>@if($item->image)<img src="{{ asset('storage/' . $item->image) }}" alt="" width="60">@endif</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <a href="{{ route('products.show', $item) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('products.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('products.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{-- pagination server side --}}
            {{ $products->links() }}
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            // aktifkan datatable, tapi biarkan pagination Laravel tetap tampil
            $('#crudTable').DataTable({
                "paging": false, // kita matikan paging datatables karena sudah pakai pagination Laravel
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering":  true,
                "info": false,
                "searching": true
            });
        });
    </script>
@stop