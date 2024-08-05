@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">Product Details</h1>

        @if(isset($product))
            <div class="search-form">
                <div class="details">
                    <h2>{{ $product->name }}</h2>
                    <p><strong>Code:</strong> {{ $product->code }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p><strong>Description:</strong> {{ $product->description }}</p>
                </div>
            </div>
            <div class="button-group">
                <a href="{{ route('products.list') }}" class="new-product-button">Back to Products List</a>
            </div>
        @else
            <p class="no-products">No Products Found</p>
            <div class="button-group">
                <a href="{{ route('products.list') }}" class="new-product-button">Back to Products List</a>
            </div>
        @endif
    </div>
@endsection
