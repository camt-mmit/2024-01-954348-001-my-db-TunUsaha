@extends('layouts.main')

@section('title', $title)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/create-form.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="page-title">Create New Shop</h1>

        <form action="{{ route('shops.create') }}" method="post" class="create-form">
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
                <label for="owner">Owner</label>
                <input type="text" id="owner" name="owner" required>
            </div>

            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="number" id="latitude" name="latitude" step="any" required>
            </div>

            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="number" id="longitude" name="longitude" step="any" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="5" required class="price-input"></textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="primary-button">Create Shop</button>
                <a href="{{ route('shops.list') }}" class="delete-button">Cancel</a>
            </div>
        </form>
    </div>

@endsection
