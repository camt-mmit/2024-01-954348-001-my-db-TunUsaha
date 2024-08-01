<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-6">
        <header class="bg-white border-b border-gray-300 shadow-sm py-4 mb-8 rounded-lg">
            <h1 class="text-16xl font-semibold text-gray-900 text-center">@section('title-container')@yield('title')@show</h1>
        </header>
        <nav class="mb-8">
            <ul class="flex justify-center space-x-6">
                <li><a href="{{ route('products.list') }}" class="text-blue-500 hover:text-blue-700 font-medium transition-colors duration-300">Product</a></li>
                <li><a href="{{ route('shops.list') }}" class="text-blue-500 hover:text-blue-700 font-medium transition-colors duration-300">Shop</a></li>
            </ul>
        </nav>
        <div class="bg-white shadow-md rounded-lg px-6 py-6 mb-8">
            @yield('content')
        </div>
        <footer class="text-center text-gray-500 text-sm mt-8 py-4 border-t border-gray-300">
            © Copyright Week-07: Tun Usaha, Database
        </footer>
    </div>
</body>
</html>
