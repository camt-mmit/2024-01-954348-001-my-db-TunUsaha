@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="details">
        <h2>{{ $shop->name }}</h2>
        <p><strong>Code:</strong> {{ $shop->code }}</p>
        <p><strong>Owner:</strong> {{ $shop->owner }}</p>
        <p><strong>Location:</strong> {{ number_format($shop->latitude, 7) }}, {{ number_format($shop->longitude, 7) }}</p>
        <p><strong>Address:</strong> {{ $shop->address }}</p>
    </div>
    <div class="button-container">
        <a href="{{ route('shops.list') }}" class="button">Back to Shops List</a>
    </div>
@endsection