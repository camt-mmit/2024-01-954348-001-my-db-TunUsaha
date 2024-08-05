@extends('layouts.main')

@section('title', $title)

@section('content')
<h1>Products List</h1>
<form action="{{ route('products.list') }}" method="get" class="search-form">
    <label class="app-inp-search">
        Search
        <input type="text" name="term" value="{{ $search['term'] }}" />
    </label>
    <br>
    <div class="form-group">
        <label for="app-inp-min-price">Min Price <span class="separator">::</span></label>
        <input id="app-inp-min-price" type="number" name="minPrice" value="{{ $search['minPrice'] ?? '' }}" />
    </div>
    <div class="form-group">
        <label for="app-inp-max-price">Max Price <span class="separator">::</span></label>
        <input id="app-inp-max-price" type="number" name="maxPrice" value="{{ $search['maxPrice'] ?? '' }}" />
    </div>
    <button type="submit" class="primary">Search</button>
    <a href="{{ route('products.list') }}">
        <button type="button" class="accent">Clear</button>
    </a>
    <div>
        <p><a href="{{ route('products.create-form') }}">New Product</a></p>
    </div>
</form>
@if(isset($products) && count($products) > 0)
<table>
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>
                <a href="{{ route('products.view', $product->code) }}">{{ $product->code }}</a>
            </td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $products->links() }}
@else
<p>No products found.</p>
@endif
@endsection
