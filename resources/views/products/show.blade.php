@extends('adminlte::page')

@section('title', 'Detail Product')

@section('content_header')
    <h1>Detail Product</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Price:</strong> {{ $product->price }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Image:</strong> @if($product->image)<br><img src="{{ asset('storage/' . $product->image) }}" width="120">@endif</p>
            
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@stop