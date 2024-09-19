<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('icon/logo.svg') }}" type="image/svg+xml">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <script>
        function showConfirmation() {
            document.getElementById('confirmationModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirmationModal').style.display = 'none';
        }

        function confirmDelete() {
            document.getElementById('deleteForm').submit();
        }
    </script>
</head>

<body>
    <header>
        <div class="container">
            <h1>
                @section('title-container')@yield('title')@show
                </h1>
                <nav>
                    <ul>
                        <li><a href="{{ route('products.list') }}">Product</a></li>
                        <li><a href="{{ route('shops.list') }}">Shop</a></li>
                        <li><a href="{{ route('categories.list') }}">Category</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        @session('status')
            <div class="status_session">
                <span class="app-cl-info">{{ $value }}</span>
            </div>
        @endsession

        <main>
            <div class="container ">
                @yield('content')
            </div>
        </main>


    </body>
    <footer>
        <div class="container">
            &#xA9; Copyright: Tun Usaha 954348 Web Programming.
        </div>
    </footer>

    </html>
