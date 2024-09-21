@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">Product Details</h1>

        @if (isset($product))
            <div class="product-actions">
                <a href="{{ route('products.view-shops', ['product' => $product->code]) }}" class="primary-button">Show
                    Shops</a>
                @can('update', \App\Models\Product::class)
                    <a href="{{ route('products.edit-form', $product->code) }}" class="primary-button">Edit Product</a>
                @endcan
                @can('delete', \App\Models\Product::class)
                    <form id="deleteForm" action="{{ route('products.delete', $product->code) }}" method="post"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="delete-button" onclick="showConfirmation()">Delete Product</button>
                    </form>
                @endcan
            </div>
            <div id="confirmationModal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to delete this product?</p>
                    <button onclick="confirmDelete()">Yes, Delete</button>
                    <button onclick="closeModal()">Cancel</button>
                </div>
            </div>

            <div class="details-table">
                <div class="details-container">
                    <p class="text-3xl text-blue-600">{{ $product->name }}</p>
                    <p><strong>Code:</strong> {{ $product->code }}</p>
                    <p><strong>Category:</strong> {{ $product->category->name }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p><strong>Description:</strong> {!! nl2br(e($product->description)) !!}</p>
                </div>
            </div>

            <div class="button-group" style="margin-top: 20px;">
                <a href="{{ route('products.list') }}" class="go-back-button">Back to Products List</a>
            </div>
        @else
            <p class="no-results">No Products Found</p>
            <div class="button-group">
                <a href="{{ session()->get('bookmark.products.view', route('products.list')) }}" class="go-back-button">Back
                    to Products List</a>
            </div>
        @endif
    </div>
@endsection
