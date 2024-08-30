@extends('layouts.main')

@section('title', $title)

@section('content')
    <h1 class="page-title">Category Details</h1>
    @if (isset($category))
    <div class="product-actions">
        <a href="{{ route('categories.view-products', ['category' => $category->code]) }}" class="primary-button">Show Products</a>
        <a href="{{ route('categories.edit-form', $category->code) }}" class="primary-button">Edit Category</a>
        <form action="{{ route('categories.delete', $category->code) }}" method="post"
            onsubmit="return confirm('Are you sure you want to delete this category?');" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button">Delete Category</button>
        </form>
    </div>
        <div class="details-table">
            <div class="details-container">
                <div class="details">
                    <p class="text-3xl text-blue-600">{{ $category->name }}</p>
                    <p><strong>Code :</strong> {{ $category->code }}</p>
                    <p><strong>Description :</strong> {!! nl2br(e($category->description)) !!}</p>
                    <p><strong>Number of Products:</strong> {{ $category->products_count }}</p>
                </div>
            </div>
        </div>
        <div class="button-container">
            <a href="{{ route('categories.list') }}" class="new-product-button">Back to Categories List</a>
        </div>
    @else
        <p class="no-products">No Category Found</p>
        <div class="button-container">
            <a href="{{ route('categories.list') }}" class="new-product-button">Back to Categories List</a>
        </div>
    @endif
@endsection