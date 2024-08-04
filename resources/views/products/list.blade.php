@extends('layouts.main')

@section('title', $title)

@section('content')
    <table class="app-cmp-data-list">
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
                <td>{{ number_format($product->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection