@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="content-wrapper">
        <h1 class="page-title">Products List</h1>
        <form action="{{ route('products.list') }}" method="get" class="search-form">
            <div class="search-container">
                <label class="app-inp-search">
                    <label>Search <span class="separator text-blue-600">::</span></label>
                    <input type="text" name="term" value="{{ $search['term'] ?? '' }}" class="search-input"
                        placeholder="Search by code, or name" />
                </label>
            </div>
            <div class="price-filter">
                <div class="form-group">
                    <label for="app-inp-min-price">Min Price <span class="separator text-blue-600">::</span></label>
                    <input id="app-inp-min-price" type="number" name="minPrice" value="{{ $search['minPrice'] ?? '' }}"
                        class="price-input" placeholder="-" />
                </div>
                <div class="form-group">
                    <label for="app-inp-max-price">Max Price <span class="separator text-blue-600">::</span></label>
                    <input id="app-inp-max-price" type="number" name="maxPrice" value="{{ $search['maxPrice'] ?? '' }}"
                        class="price-input" placeholder="-" />
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="primary-button">Search</button>
                <a href="{{ route('products.list') }}" class="secondary-button">Clear</a>
            </div>
        </form>

        <a href="{{ route('products.create-form') }}" class="new-product-button">New Product</a>

        @if (isset($products) && count($products) > 0)
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <a href="{{ route('products.view', $product->code) }}">{{ $product->code }}</a>
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $products->links() }}
            </div>
        @else
            <p class="no-products">No products found.</p>
        @endif
    </div>
@endsection
