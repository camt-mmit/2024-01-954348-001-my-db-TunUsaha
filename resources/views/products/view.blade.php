@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">Product Details</h1>

        @if (isset($product))
            <div class="product-actions">
                <a href="{{ route('products.edit-form', $product->code) }}" class="primary-button">Edit Product</a>
                <form action="{{ route('products.delete', $product->code) }}" method="post"
                    onsubmit="return confirm('Are you sure you want to delete this product?');" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-button">Delete Product</button>
                </form>
            </div>

            <div class="search-form">
                <div class="details">
                    <p class="text-3xl text-blue-600">{{ $product->name }}</p>
                    <p><strong>Code:</strong> {{ $product->code }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p><strong>Description:</strong> {{ $product->description }}</p>
                </div>
            </div>

            <div class="button-group" style="margin-top: 20px;">
                <a href="{{ route('products.list') }}" class="secondary-button">Back to Products List</a>
            </div>
        @else
            <p class="no-products">No Products Found</p>
            <div class="button-group">
                <a href="{{ route('products.list') }}" class="secondary-button">Back to Products List</a>
            </div>
        @endif
    </div>
@endsection
