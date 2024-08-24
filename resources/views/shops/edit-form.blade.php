@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1 class="page-title">Shop: Edit</h1>

        <form action="{{ route('shops.update', $shop->code) }}" method="post" class="search-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" class="price-input" value="{{ $shop->code }}" readonly>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="price-input" value="{{ $shop->name }}"
                    required>
            </div>

            <div class="form-group">
                <label for="owner">Owner</label>
                <input type="text" id="owner" name="owner" class="price-input" value="{{ $shop->owner }}"
                    required>
            </div>

            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="number" id="latitude" step="any" name="latitude" class="price-input"
                    value="{{ $shop->latitude }}" required>
            </div>

            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="number" id="longitude" step="any" name="longitude" class="price-input"
                    value="{{ $shop->longitude }}" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="5" class="price-input" required>{{ $shop->address }}</textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="primary-button">Update Shop</button>
                <a href="{{ route('shops.view', $shop->code) }}" class="secondary-button">Cancel</a>
            </div>
        </form>
    </div>
@endsection
