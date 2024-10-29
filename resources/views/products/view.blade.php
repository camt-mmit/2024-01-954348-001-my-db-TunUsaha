@extends('layouts.main')

@section('title', $title)

@section('content')
    <div class="container mx-auto p-8">
        @if (isset($product))
            <div class="product-header flex justify-between items-center mb-8">
                <h1 class="text-5xl font-bold text-gray-900">{{ $product->name }}</h1>
                <div class="product-actions flex items-center">
                    @can('update', \App\Models\Product::class)
                        <a href="{{ route('products.edit-form', $product->code) }}" class="primary-button ml-4">Edit Product</a>
                    @endcan
                    @can('delete', \App\Models\Product::class)
                        <form id="deleteForm" action="{{ route('products.delete', $product->code) }}" method="post" class="inline-block ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-button" onclick="showConfirmation()">Delete Product</button>
                        </form>
                    @endcan
                </div>
            </div>

            <!-- Confirmation Modal -->
            <div id="confirmationModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="modal-content bg-white rounded-lg p-6 text-center shadow-lg transition-transform transform scale-95 hover:scale-100">
                    <p class="mb-4 text-lg">Are you sure you want to delete this product?</p>
                    <button class="confirm-button bg-red-600 text-white px-6 py-2 rounded transition-colors duration-200" onclick="confirmDelete()">Yes, Delete</button>
                    <button class="cancel-button bg-gray-300 text-black px-6 py-2 rounded ml-2 transition-colors duration-200" onclick="closeModal()">Cancel</button>
                </div>
            </div>

            <!-- Image Gallery Section -->
            <div class="product-images-gallery grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @if($product->images && $product->images->isNotEmpty())
                    @foreach ($product->images as $image)
                        <img src="{{ $image->url }}" alt="{{ $product->name }}" class="product-image rounded-lg shadow-md transition-transform transform hover:scale-105 cursor-pointer">
                    @endforeach
                @else
                    <img src="{{ asset('images/products/1.jpeg') }}" alt="{{ $product->name }}" class="product-image rounded-lg shadow-md transition-transform transform hover:scale-105 cursor-pointer">
                @endif
            </div>

            <!-- Product Details Section -->
            <div class="details-table bg-white rounded-lg shadow p-6 mb-10">
                <div class="details-container">
                    <p class="text-lg font-medium text-gray-700"><strong>Code:</strong> {{ $product->code }}</p>
                    <p class="text-lg font-medium text-gray-700"><strong>Category:</strong> {{ $product->category->name }}</p>
                    <p class="text-lg font-medium text-gray-700"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p class="text-lg font-medium text-gray-700"><strong>Description:</strong> {!! nl2br(e($product->description)) !!}</p>
                </div>
            </div>

            <!-- Buy Button Section -->
            <div class="buy-section mb-10">
                <button type="submit" class="buy-button bg-green-600 text-white px-6 py-2 rounded-lg shadow-md transition-colors duration-200 hover:bg-green-500">Buy Now</button>
            </div>

            <!-- Back to Products List Button -->
            <div class="button-group">
                <a href="{{ route('products.list') }}" class="go-back-button bg-gray-800 text-white px-6 py-2 rounded-lg shadow-md transition-colors duration-200 hover:bg-gray-700">Back to Products List</a>
            </div>
        @else
            <p class="no-results text-center text-xl text-red-600">No Products Found</p>
            <div class="button-group">
                <a href="{{ session()->get('bookmark.products.view', route('products.list')) }}" class="go-back-button bg-gray-800 text-white px-6 py-2 rounded-lg shadow-md transition-colors duration-200 hover:bg-gray-700">Back to Products List</a>
            </div>
        @endif
    </div>

    <style>
        .product-image {
            width: 100%;
            height: auto;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .primary-button, .delete-button, .go-back-button, .buy-button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .primary-button {
            background-color: #007bff;
            color: white;
            border-radius: 8px; /* More rounded corners */
        }

        .primary-button:hover {
            background-color: #0056b3;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
            border-radius: 8px; /* More rounded corners */
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .go-back-button {
            background-color: #6c757d;
            color: white;
            border-radius: 8px; /* More rounded corners */
        }

        .go-back-button:hover {
            background-color: #5a6268;
        }

        .buy-button {
            background-color: #28a745; /* Green color */
            color: white;
            border-radius: 8px; /* More rounded corners */
        }

        .buy-button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            border-radius: 8px;
            margin: 15% auto;
            padding: 20px;
            width: 90%; 
            max-width: 500px; 
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        function showConfirmation() {
            const modal = document.getElementById('confirmationModal');
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('confirmationModal');
            modal.classList.add('hidden');
        }

        function confirmDelete() {
            document.getElementById('deleteForm').submit();
        }
    </script>
@endsection
