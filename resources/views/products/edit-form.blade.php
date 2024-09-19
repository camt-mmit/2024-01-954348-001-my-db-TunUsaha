@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">Product: Edit</h1>

        <form action="{{ route('products.update', $product->code) }}" method="post" class="search-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" class="price-input" value="{{ $product->code }}" readonly>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="price-input" value="{{ $product->name }}"
                    required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category_id">
                    <option value="">-- Please select a category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            [{{ $category->code }}] {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" step="any" name="price" class="price-input"
                    value="{{ $product->price }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" class="price-input" required>{{ $product->description }}</textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="primary-button">Update Product</button>
                <a href="{{ route('products.view', $product->code) }}" class="secondary-button">Cancel</a>
            </div>
        </form>
    </div>
@endsection
