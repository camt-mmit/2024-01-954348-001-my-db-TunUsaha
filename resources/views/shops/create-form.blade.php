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
                <input type="text" id="code" name="code" value="{{ old('code') }}" required>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="owner">Owner</label>
                <input type="text" id="owner" name="owner" value="{{ old('owner') }}" required>
            </div>

            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="number" id="latitude" name="latitude" step="any" value="{{ old('latitude') }}" required>
            </div>

            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="number" id="longitude" name="longitude" step="any" value="{{ old('longitude') }}" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="5" required class="price-input">{{ old('address') }}</textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="primary-button">Create Shop</button>
                <a href="{{ route('shops.list') }}" class="delete-button">Cancel</a>
            </div>
        </form>
    </div>

@endsection
