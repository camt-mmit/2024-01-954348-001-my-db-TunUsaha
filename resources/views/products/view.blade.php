@extends('layouts.main')

@section('title', $title)

@section('content')
    @if(isset($product))
        <div class="details">
            <h2>{{ $product->name }}</h2>
            <p><strong>Code :</strong> {{ $product->code }}</p>
            <p><strong>Price :</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Description :</strong> {{ $product->description }}</p>
        </div>
        <div class="button-container">
            <a href="{{ route('products.list') }}" class="button">Back to Products List</a>
        </div>
    @else
        <p>No Products Found</p>
        <div class="button-container">
            <a href="{{ route('products.list') }}" class="button">Back to Products List</a>
        </div>
    @endif
@endsection
