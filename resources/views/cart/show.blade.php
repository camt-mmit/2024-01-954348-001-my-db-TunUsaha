@extends('layouts.main')

@section('title', 'Your Cart')

@section('content')
<div class="container cart-page">
    <h1>Your Cart</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($cart) > 0)
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $productId => $product)
                    <tr>
                        <td>{{ $product['name'] }}</td>
                        <td>${{ number_format($product['price'], 2) }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>${{ number_format($product['price'] * $product['quantity'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                @csrf
                                <button type="submit" class="remove-button">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button type="submit" class="clear-button">Clear Cart</button>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif

    <!-- Continue Shopping Button -->
    <a href="{{ route('products.list') }}" class="continue-shopping-button">Continue Shopping</a>
</div>

<style>
    .cart-page {
        max-width: 800px;
        margin: 0 auto;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .cart-table th, .cart-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .cart-table th {
        background-color: #f4f4f4;
    }

    .remove-button, .clear-button {
        padding: 5px 10px;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .remove-button {
        background-color: #ff4d4d; /* Red color for remove button */
    }

    .remove-button:hover {
        background-color: #e63946; /* Darker red on hover */
    }

    .clear-button {
        margin-top: 20px;
        background-color: #333; /* Dark background for clear button */
    }

    .clear-button:hover {
        background-color: #555; /* Darker gray on hover */
    }

    .continue-shopping-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #28a745; /* Green color for continue shopping button */
        color: white;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .continue-shopping-button:hover {
        background-color: #218838; /* Darker green on hover */
    }

    .alert-success {
        color: green;
    }
</style>
@endsection
