@extends('layouts.main')

@section('title', $title)

@section('content')
<div class="content-wrapper">
    
    @can('create', \App\Models\Product::class)
        <div class="header">
            <a href="{{ route('products.create-form') }}" class="new-product-button">Add New Product</a>
        </div>
    @endcan

    @if (isset($products) && count($products) > 0)
        <div class="product-grid">
            @php
                session()->put('bookmark.products.view', url()->full());
            @endphp

            @foreach ($products as $product)
                <div class="product-card">
                    <a href="{{ route('products.view', $product->code) }}">
                        <div class="product-image">
                            {{-- Debugging: Uncomment the next line to see the URL being generated --}}
                            {{-- {{ dd($product->image_url ?? asset('images/products/1.jpeg')) }} --}}

                           <img src="{{ $product->image_url ?: asset('images/products/1.jpeg') }}" alt="{{ $product->name }}">

                          
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-category">
                                <a href="{{ $product->category ? route('categories.view', ['category' => $product->category->code]) : '#' }}">
                                    {{ $product->category ? $product->category->name : 'No Category' }}
                                </a>
                            </p>
                            <p class="product-price">${{ number_format($product->price, 2) }}</p>
                            <p class="product-shops">Available in {{ $product->shops_count }} shops</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="pagination-container">
            {{ $products->links() }}
        </div>
    @else
        <p class="no-results">No products found.</p>
    @endif
</div>
@endsection
