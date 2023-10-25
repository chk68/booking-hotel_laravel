<!DOCTYPE html>
<html lang="en">
<head>
    @stack('styles')
    <link href="{{ asset('styles/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
</head>
<body>
<header class="header">
    <div class="header-content">
        <h1 class="logo"><a href="{{ route('home') }}">Booking</a></h1>
        @guest
            <div class="auth-links">
                <a href="{{ route('register') }}" class="register-link">Регистрация</a>
                <a href="{{ route('login') }}" class="login-link">Вход</a>
            </div>
        @endguest
        @auth
            <a href="{{ route('profile.show') }}" class="user-link">{{ auth()->user()->name }}</a>
        @endauth
    </div>



    </div>
</header>
<main>
    @yield('content')
</main>
<footer class="footer">
    &copy; {{ date('Y') }} Hotel Booking
</footer>

</body>
</html>
