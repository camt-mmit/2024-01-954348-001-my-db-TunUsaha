@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="content-wrapper">
        <h1 class="page-title">Shops List</h1>
        <form action="{{ route('shops.list') }}" method="get" class="search-form">
            <div class="search-container">
                <label class="app-inp-search">
                    Search
                    <input type="text" name="term" value="{{ $search['term'] ?? '' }}" class="search-input"placeholder="Search by code, name, or owner" />
                </label>
            </div>
            <div class="button-group">
                <button type="submit" class="primary-button">Search</button>
                <a href="{{ route('shops.list') }}" class="secondary-button">Clear</a>
            </div>
        </form>
        @can('create', \App\Models\Shop::class)
        <a href="{{ route('shops.create-form') }}" class="new-product-button">New Shop</a>
        @endcan
        @if (isset($shops) && count($shops) > 0)
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>No. Of Products</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shops as $shop)
                        <tr>
                            <td>
                                <a href="{{ route('shops.view', $shop->code) }}">{{ $shop->code }}</a>
                            </td>
                            <td>{{ $shop->name }}</td>
                            <td>{{ $shop->owner }}</td>
                            <td>{{ $shop->products_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $shops->links() }}
            </div>
        @else
            <p class="no-results">No shops found.</p>
        @endif
    </div>
@endsection
