<!DOCTYPE html>
<html lang="en">
<style>.cart-icon {
    position: relative;
    margin-left: 15px;
    cursor: pointer;
}

.cart-icon a {
    color: #333;
    text-decoration: none;
}

.cart-count {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: #ff0000;
    color: white;
    border-radius: 50%;
    padding: 2px 5px;
    font-size: 12px;
}
    </style>
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

        function toggleDropdown() {
    document.getElementById("userDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.user-icon')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
    </script>
</head>

<body>
    <header>
        <div class="container">
        <div class="header-container">
            <div class="Logo">
            <img src="{{ asset('images/product-1.jpg') }}"  >
            </div>
            <h1>
                <!-- @section('title-container')@yield('title')@show -->
                </h1>
                <nav>
                    <ul>
                    <li><a href="{{ route('products.list') }}" class="nav-link">Store</a></li>
                    <li class="dropdown">
                        <a href="{{ route('welcome') }}" class="nav-link">Mac</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Macpine Air</a></li>
                            <li><a href="#">Macpine Pro</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('welcome') }}" class="nav-link">Pinepad</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Pinepad</a></li>
                            <li><a href="#">Pinepad Mini</a></li>
                            <li><a href="#">Pinepad Pro</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link">Watch</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Pineapple Watch</a></li>
                            <li><a href="#">Pineapple Watch SE</a></li>
                            <li><a href="#">Pineapple Watch Ultra</a></li>
                            
                        </ul>
                    </li>
                    <li><a href="{{ route('welcome') }}" class="nav-link">Contact</a></li>
                        <li>
                        <li> <input type="text" class="input"> <span> Search </span></li>
                            <div class="user-icon" onclick="toggleDropdown()">
                                <i class="fas fa-user"></i> {{ Auth::user()->role }}
                            </div>
                            <div class="dropdown-content" id="userDropdown">
                                @if(Auth::check())
                                <p>Logged in as: {{ Auth::user()->name }}</p>
                                @if(Auth::user()->role === 'ADMIN')
                                    <a href="{{ route('users.list') }}">Manage Users</a>
                                @else
                                    <a href="{{ route('users.self', Auth::user()->id) }}">Account</a>
                                @endif
                                <a href="{{ route('logout') }}">Logout</a>
                                @else
                                    <p>You are not logged in.</p>
                                    <a href="{{ route('login') }}">Login</a>
                                @endif
                            </div>
                            
<div class="cart-icon">
    <a href="{{ route('cart.show') }}">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
    </a>
</div>
                        </li>

                    </ul>

                </nav>
</div>
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
            &#xA9; Copyright: Project 954348 Web Programming.
        </div>
    </footer>

    </html>
