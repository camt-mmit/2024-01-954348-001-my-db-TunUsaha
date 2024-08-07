@extends('layouts.main')

@section('title', $title)

@section('content')
@if(isset($shop))
<h1 class="page-title">Shop Details</h1>
<div class="search-form">
    <div class="container">
        <div class="details">
            <p class="text-3xl text-blue-600">{{ $shop->name }}</p>
            <p><strong>Code :</strong> {{ $shop->code }}</p>
            <p><strong>Owner :</strong> {{ $shop->owner }}</p>
            <p><strong>Location :</strong> {{ number_format($shop->latitude, 7) }}, {{ number_format($shop->longitude, 7) }}</p>
            <p><strong>Address :</strong> {{ $shop->address }}</p>
        </div>
    </div>
</div>
<div class="button-container">
    <a href="{{ route('shops.list') }}" class="new-product-button">Back to Shops List</a>
</div>
</div>
@else
<p class="no-products">No Shops Found</p>
<div class="button-container">
    <a href="{{ route('shops.list') }}" class="new-product-button">Back to Shops List</a>
</div>">Back to Shops List</a>

@endif
@endsection
