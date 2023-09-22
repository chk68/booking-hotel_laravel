<!DOCTYPE html>
<html lang="en">
<head>
    @stack('styles')
    <link href="{{ asset('styles/styles.css') }}" rel="stylesheet">



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
</head>
<body>
<header>

    <header>
        <div class="header">
            <h1><a href="{{ route('home') }}">Booking</a></h1>
        </div>



    </header>


</header>
<main>
    @yield('content')
</main>
<footer>
    &copy; {{ date('Y') }} Hotel Booking
</footer>
</body>
</html>
