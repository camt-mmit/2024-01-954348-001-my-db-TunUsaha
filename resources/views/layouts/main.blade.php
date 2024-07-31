<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My - Controllers</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
</head>
<body>
        <center>
        <header id="app-cmp-main-header">
            <center><h1>@section('title-container')@yield('title')@show</h1></center>
        </header>
        <nav>
            <a href="{{ route('products.list') }}">Product</a> |
        </nav>
    <div id="app-cmp-main-content">
        @yield('content')
    </div>
    <br/>
        <footer id="app-cmp-main-content">
            Week-06: Tun Usaha, Controller
        </footer>
    </center>
</body>

</html>
