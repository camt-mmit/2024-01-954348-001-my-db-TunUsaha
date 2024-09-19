@extends('layouts.main')

@section('title', $title)

@section('content')
    <a href="{{ route('shops.view-products', ['shop' => $shop->code]) }}" class="back-button" aria-label="ย้อนกลับ">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36">
            <path
                d="M23.5587,16.916 C24.1447,17.4999987 24.1467,18.446 23.5647,19.034 L16.6077,26.056 C16.3147,26.352 15.9287,26.4999987 15.5427,26.4999987 C15.1607,26.4999987 14.7787,26.355 14.4867,26.065 C13.8977,25.482 13.8947,24.533 14.4777,23.944 L20.3818,17.984 L14.4408,12.062 C13.8548,11.478 13.8528,10.5279 14.4378,9.941 C15.0218,9.354 15.9738,9.353 16.5588,9.938 L23.5588,16.916 L23.5587,16.916 Z">
            </path>
        </svg>
    </a>
    <div class="content-wrapper">
        <h1 class="page-title">Products List</h1>
        <form action="{{ route('shops.add-products-form', ['shop' => $shop->code]) }}" method="get" class="search-form">
            <div class="search-container">
                <label class="app-inp-search">
                    Search
                    <input type="text" name="term" value="{{ $search['term'] ?? '' }}" class="search-input"
                        placeholder="Search by code or name" />
                </label>
            </div>
            <div class="price-filter">
                <div class="form-group">
                    <label for="app-inp-min-price">Min Price <span class="separator text-blue-600">::</span></label>
                    <input id="app-inp-min-price" type="number" name="minPrice" value="{{ $search['minPrice'] ?? '' }}"
                        class="price-input" placeholder="$" />
                </div>
                <div class="form-group">
                    <label for="app-inp-max-price">Max Price <span class="separator text-blue-600">::</span></label>
                    <input id="app-inp-max-price" type="number" name="maxPrice" value="{{ $search['maxPrice'] ?? '' }}"
                        class="price-input" placeholder="$" />
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="primary-button">Search</button>
                <a href="{{ route('shops.add-products-form', ['shop' => $shop->code]) }}" class="secondary-button">Clear</a>
            </div>
        </form>
        <form action="{{ route('shops.add-product', ['shop' => $shop->code]) }}" method="post" class="mt-6">
            @csrf
            @if (isset($products) && count($products) > 0)
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            session()->put('bookmark.products.view', url()->full());
                        @endphp
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('products.view', $product->code) }}">{{ $product->code }}</a>
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <a href="{{ $product->category ? route('categories.view', ['category' => $product->category->code]) : '#' }}">
                                        {{ $product->category ? $product->category->name : 'No Category' }}
                                    </a>
                                    </td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>
                                    <button type="submit" name="product" value="{{ $product->code }}" class="btn-icon">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-container">
                    {{ $products->links() }}
                </div>
            @else
                <p class="no-results">No products found in this shop.</p>
            @endif
        </form>

    </div>
@endsection
