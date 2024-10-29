@extends('layouts.main')

@section('title', 'Welcome to Pineapple')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pineapple Store</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <!-- Top Banner Section -->




    <!-- Hero Section  Logo -->
    <div class="hero flex items-center justify-center bg-light-gray py-32" style="background-image: url('{{ asset('images/product-1.jpg') }}'); background-size: cover; background-position: center;">
        <div class="text-center bg-white bg-opacity-80 py-12 px-6 rounded-lg shadow-lg animate-fadeIn">
            <h1 class="text-6xl font-extrabold text-gray-900 mb-4">Welcome to Pineapple</h1>
            <p class="text-xl text-gray-700 mb-8">Your trusted partner for premium products and services.</p>
            <a href="{{ route('welcome') }}" class="cta-button bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-10 py-4 rounded-full hover:from-indigo-600 hover:to-blue-600 transition duration-300 shadow-lg transform hover:scale-105">Explore Our Products</a>
        </div>
    </div>

    <!-- Product Showcase Section -->
    <div class="product-showcase py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <!-- Product 1 -->
            <div class="product-item flex flex-col md:flex-row items-center py-12 animate-slideInLeft">
                <div class="product-image md:w-1/2 w-full mb-6 md:mb-0">
                    <img src="{{ asset('images/product-1.jpg') }}" alt="Macpine" class="rounded-lg shadow-lg w-full">
                </div>
                <div class="product-info md:w-1/2 w-full text-center md:text-left md:pl-10">
                    <h2 class="text-5xl font-bold text-gray-900 mb-4">Macpine</h2>
                    <p class="text-lg text-gray-600 mb-6">The ultimate experience of power and performance. Perfect for those who need to work and create on the go.</p>
                    <a href="#" class="cta-button bg-black text-white px-8 py-3 rounded-full hover:bg-gray-800 transition duration-300 shadow-lg transform hover:scale-105">Learn More</a>
                </div>
            </div>
            <!-- Repeat Product Structure for Other Products -->
        </div>
    </div>

    <!-- Call-to-Action Section -->
    <div class="cta-section bg-gradient-to-r from-gray-900 to-gray-700 py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-5xl font-bold text-white mb-8">Discover Our Latest Products</h2>
            <a href="{{ route('welcome') }}" class="cta-button bg-white text-black px-10 py-4 rounded-full hover:bg-gray-200 transition duration-300 shadow-lg transform hover:scale-105">Shop Now</a>
        </div>
    </div>
   
    <!-- Footer Section -->

    <script>
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileNav = document.getElementById('mobile-nav');

        hamburgerBtn.addEventListener('click', function () {
            mobileNav.classList.toggle('show');
            document.body.classList.toggle('menu-open');
        });

        document.addEventListener('click', function (e) {
            if (!mobileNav.contains(e.target) && !hamburgerBtn.contains(e.target)) {
                if (mobileNav.classList.contains('show')) {
                    mobileNav.classList.remove('show');
                    document.body.classList.remove('menu-open');
                }
            }
        });
    </script>

    
</body>
@endsection
