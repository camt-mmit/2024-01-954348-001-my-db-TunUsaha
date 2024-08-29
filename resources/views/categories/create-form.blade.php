@extends('layouts.main')

@section('title', $title)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/create-form.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="page-title">Create New Category</h1>

        <form action="{{ route('categories.create-form') }}" method="post" class="create-form">
            @csrf

            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" required>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" required class="price-input"></textarea>
            </div>
            <div class="button-group">
                <button type="submit" class="primary-button ">Create Category</button>
                <a href="{{ route('categories.list') }}" class="delete-button ">Cancel</a>
            </div>
        </form>
    </div>

@endsection
