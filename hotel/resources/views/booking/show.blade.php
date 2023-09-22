
@extends('layouts.app')

@section('content')
    <h1>Бронирование комнаты №{{ $room->id }}</h1>
    <form action="{{ route('booking.store') }}" method="post">
        @csrf
        <div class="user-data">
            <h2>Данные пользователя</h2>
            <div class="form-group">
                <label for="user_id">ID пользователя:</label>
                <input type="text" name="user_id" id="user_id" value="{{ $user->id }}" readonly>
            </div>
            <div class="form-group">
                <label for="first_name">Имя:</label>
                <input type="text" name="first_name" id="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Фамилия:</label>
                <input type="text" name="last_name" id="last_name" required>
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона:</label>
                <input type="text" name="phone" id="phone" required>
            </div>
        </div>
        <div class="booking-info">
            <h2>Информация о бронировании</h2>
            <div class="form-group">
                <label for="check_in">Дата заезда:</label>
                <input type="date" name="check_in" id="check_in" required>
            </div>
            <div class="form-group">
                <label for="check_out">Дата выезда:</label>
                <input type="date" name="check_out" id="check_out" required>
            </div>
            <div class="form-group">
                <label for="hotel_id">ID отеля:</label>
                <input type="text" name="hotel_id" id="hotel_id" value="{{ $room->hotel_id }}" readonly>
            </div>
            <div class="form-group">
                <label for="room_number">Номер комнаты:</label>
                <input type="text" name="room_number" id="room_number" value="{{ $room->id ?? '' }}" readonly>
            </div>
        </div>
        <button type="submit">Забронировать</button>
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

@endsection
