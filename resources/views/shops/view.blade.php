@extends('layouts.main')

@section('title', $title)

@section('content')
    <h1 class="page-title">Shop Details</h1>
    @if (isset($shop))
        <div class="product-actions">
            <a href="{{ route('shops.edit-form', $shop->code) }}" class="primary-button">Edit Shop</a>
            <form action="{{ route('shops.delete', $shop->code) }}" method="post"
                onsubmit="return confirm('Are you sure you want to delete this product?');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">Delete Shop</button>
            </form>
        </div>
        <div class="details-table">
            <div class="details-container">
                <div class="details">
                    <p class="text-3xl text-blue-600">{{ $shop->name }}</p>
                    <p><strong>Code :</strong> {{ $shop->code }}</p>
                    <p><strong>Owner :</strong> {{ $shop->owner }}</p>
                    <p><strong>Location :</strong> {{ number_format($shop->latitude, 7) }},
                        {{ number_format($shop->longitude, 7) }}</p>
                        <p><strong>Address :</strong> {!! nl2br(e($shop->address)) !!}</p>
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
