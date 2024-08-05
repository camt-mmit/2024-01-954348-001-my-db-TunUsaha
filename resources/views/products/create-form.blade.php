@extends('layouts.main')

@section('title', $title)

@section('content')
<div class="container">
    <h1 class="page-title">Create New Product</h1>

    <form action="{{ route('products.create-form') }}" method="post" class="search-form">
        @csrf

        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" id="code" name="code" class="price-input" required>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="price-input" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" step="any" name="price" class="price-input" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" class="price-input" required></textarea>
        </div>

        <div class="button-group">
            <button type="submit" class="primary-button">Create Product</button>
            <a href="{{ route('products.list') }}" class="secondary-button">Cancel</a>
        </div>
    </form>
</div>
@endsection
