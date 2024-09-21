@extends('layouts.main')

@section('title', $title)

@section('content')
    <h1 class="page-title">Shop Details</h1>
    @if (isset($shop))
        <div class="product-actions">
            <a href="{{ route('shops.view-products', ['shop' => $shop->code]) }}" class="primary-button">Show Products</a>
            @can('update', \App\Models\Shop::class)
            <a href="{{ route('shops.edit-form', $shop->code) }}" class="primary-button">Edit Shop</a>
            @endcan
            @can('delete', \App\Models\Shop::class)
            <form id="deleteForm" action="{{ route('shops.delete', $shop->code) }}" method="post" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="delete-button" onclick="showConfirmation()">Delete Shop</button>
            </form>
            <div id="confirmationModal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to delete this Shop?</p>
                    <button onclick="confirmDelete()">Yes, Delete</button>
                    <button onclick="closeModal()">Cancel</button>
                </div>
            </div>
            @endcan
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
                <a href="{{ route('shops.list') }}" class="go-back-button">Back to Shops List</a>
            </div>
        </div>
    @else
        <p class="no-results">No Shops Found</p>
        <div class="button-container">
            <a href="{{ session('bookmark.shops.view', route('shops.list')) }}" class="go-back-button">Back to Shops List</a>
        </div>

    @endif
@endsection
