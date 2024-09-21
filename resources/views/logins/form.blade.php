<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('icon/logo.svg') }}" type="image/svg+xml">

    <script>
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
                    <li>
                        <div class="user-icon" onclick="toggleDropdown()">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="dropdown-content" id="userDropdown">
                            @if(Auth::check())
                                <p>Logged in as: {{ Auth::user()->name }}</p>
                                <a href="{{ route('logout') }}">Logout</a>
                            @else
                                <p>You are not logged in.</p>
                                <a href="{{ route('login') }}">Login</a>
                            @endif
                        </div>
                    </li>
                </ul>
            </nav>

        </div>
    </header>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2 class="login-title">Sign In</h2>
            <form action="{{ route('authenticate') }}" method="post">
                @csrf
                <div class="login-group">
                    <label class="login-label" for="email">Email</label>
                    <input type="text" name="email" id="email" required class="input-email" placeholder="Email " />
                </div>
                <div class="login-group">
                    <label class="login-label" for="password">Password</label>
                    <input type="password" name="password" id="password" required class="input-password" placeholder="Password " />
                </div>
                <button type="submit" class="login-button">Sign In</button>
                @error('credentials')
                    <div class="warn">{{ $message }}</div>
                @enderror
                <a href="#" class="forgot-password">Forgot Apple ID or password?</a>
            </form>
            <div class="social-login ">
                <a href="/login/google" class="social-button google">
                    <i class="fab fa-google mx-auto"></i>
                </a>
                <a href="/login/facebook" class="social-button facebook">
                    <i class="fab fa-facebook" ></i>
                </a>
                <a href="/login/github" class="social-button github">
                    <i class="fab fa-github"></i>
                </a>
            </div>


        </div>
    </div>
</body>

<footer>
    <div class="container">
        &#xA9; Copyright: Tun Usaha 954348 Web Programming.
    </div>
</footer>
</html>
