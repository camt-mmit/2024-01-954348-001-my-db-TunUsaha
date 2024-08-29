@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">Category: Edit</h1>

        <form action="{{ route('categories.update', $category->code) }}" method="post" class="search-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" class="price-input" value="{{ $category->code }}" readonly>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="price-input" value="{{ $category->name }}"
                    required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" class="price-input" required>{{ $category->description }}</textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="primary-button">Update Category</button>
                <a href="{{ route('categories.view', $category->code) }}" class="secondary-button">Cancel</a>
            </div>
        </form>
    </div>
@endsection
