@extends('layouts.main')

@section('title', $title)

@section('content')
<main class="p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
            <thead class="bg-gray-50 border-b border-gray-300">
                <tr>
                    <th class="py-4 px-6 text-left text-gray-800 font-medium">Code</th>
                    <th class="py-4 px-6 text-left text-gray-800 font-medium">Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-300">
                    <td class="py-3 px-6">
                        <a href="{{ route('products.view', $product->code) }}" class="text-gray-700 hover:text-blue-600 font-semibold">{{ $product->code }}</a>
                    </td>
                    <td class="py-3 px-6 text-gray-700">{{ $product->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
