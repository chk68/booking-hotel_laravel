@extends('layouts.app')

@section('content')

    <div class="search-hotels">
        <h1>Общий поиск бронирования</h1>

        <form action="{{ route('hotels.search') }}" method="post" id="search-form">
            @csrf
            <label for="check_in">Дата заезда:</label>
            <input type="date" name="check_in" required id="check_in" value="{{ old('check_in') }}">

            <label for="check_out">Дата выезда:</label>
            <input type="date" name="check_out" required id="check_out" value="{{ old('check_out') }}">

            <button type="submit">Поиск</button>
        </form>

        <script>
            // Сохраняем введенные даты в локальное хранилище при вводе
            document.addEventListener('input', function(e) {
                if (e.target.id === 'check_in' || e.target.id === 'check_out') {
                    localStorage.setItem('check_in', document.getElementById('check_in').value);
                    localStorage.setItem('check_out', document.getElementById('check_out').value);
                }
            });

            // При загрузке страницы восстанавливаем введенные даты из локального хранилища
            document.addEventListener('DOMContentLoaded', function() {
                const checkInInput = document.getElementById('check_in');
                const checkOutInput = document.getElementById('check_out');

                const savedCheckIn = localStorage.getItem('check_in');
                const savedCheckOut = localStorage.getItem('check_out');

                if (savedCheckIn) {
                    checkInInput.value = savedCheckIn;
                }

                if (savedCheckOut) {
                    checkOutInput.value = savedCheckOut;
                }
            });
        </script>

    </div>



    <div class="hotels-info">
        @foreach($hotels as $hotel)
            <div class="hotel">
                <div class="hotel-details">
                    <h2><a href="{{ route('rooms.show', ['hotel' => $hotel]) }}">{{ $hotel->name }}</a></h2>
                </div>
                <div class="hotel-price">
                    @if($hotel->rooms->count() > 0)
                        <p>Цена: {{ $hotel->rooms->min('price') }} - {{ $hotel->rooms->max('price') }}</p>
                    @else
                        <p>Нет доступных комнат</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @push('styles')
        <link href="{{ asset('styles/styles.css') }}" rel="stylesheet">
    @endpush

@endsection
