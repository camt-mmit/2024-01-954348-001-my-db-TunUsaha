@extends('layouts.main')

@section('title', $title)

@section('content')
    <h1 class="page-title">Category Details</h1>
    @if (isset($category))
        <div class="product-actions">
            <a href="{{ route('categories.view-products', ['category' => $category->code]) }}" class="primary-button">Show
                Products</a>
            @can('update', \App\Models\category::class)
            <a href="{{ route('categories.edit-form', $category->code) }}" class="primary-button">Edit Category</a>
            @endcan
            <form id="deleteForm" action="{{ route('categories.delete', $category->code) }}" method="post" style="display: inline;">
                @csrf
                @method('DELETE')
                @can('delete', $category)
                <button type="button" class="delete-button" onclick="showConfirmation()">Delete Category</button>
                @endcan
            </form>
            <div id="confirmationModal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to delete this Category?</p>
                    <button onclick="confirmDelete()">Yes, Delete</button>
                    <button onclick="closeModal()">Cancel</button>
                </div>
            </div>
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
            <a href="{{ route('categories.list') }}" class="go-back-button">Back to Categories List</a>
        </div>
    @else
        <p class="no-results">No Category Found</p>
        <div class="button-container">
            <a href="{{ session('bookmark.categories.view', route('categories.list')) }}" class="go-back-button">Back to Category List</a>
        </div>
    @endif
@endsection
