@extends('layouts.app')
@push('styles')
    <link href="{{ asset('styles/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('styles/rooms.css') }}" rel="stylesheet">
    <link href="{{ asset('styles/booking.css') }}" rel="stylesheet">
@endpush
@section('content')
    <h1>Бронирование комнаты №{{ $room->id }}</h1>
    <form action="{{ route('booking.make') }}" method="post">
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
            <!-- Добавленные поля -->
            <div class="form-group">
                <label for="last_name">Фамилия:</label>
                <input type="text" name="last_name" id="last_name" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Номер телефона:</label>
                <input type="text" name="phone_number" id="phone_number" required>
            </div>
        </div>


        <div class="booking-info">
            <h2>Информация о бронировании</h2>
            <div class="form-group">
                <label for="room_id">ID комнаты:</label>
                <input type="text" name="room_id" value="{{ $room->id }}" readonly>
            </div>
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
                <input type="text" name="hotel_id" value="{{ $room->hotel_id }}" readonly>
            </div>
            <!-- Добавленный блок для стоимости -->
            <div class="form-group">
                <label for="total_price">Стоимость:</label>
                <input type="text" name="total_price" id="total_price" readonly>
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
            const roomIDInput = document.getElementById('room_id');

            const savedCheckIn = localStorage.getItem('check_in');
            const savedCheckOut = localStorage.getItem('check_out');

            if (savedCheckIn) {
                checkInInput.value = savedCheckIn;
            }

            if (savedCheckOut) {
                checkOutInput.value = savedCheckOut;
            }

            // Функция для вычисления стоимости на основе цены за ночь и срока пребывания
            function calculateTotalPrice(pricePerNight, stayDuration) {
                return pricePerNight * stayDuration;
            }

            // Обновление стоимости при изменении дат заезда или выезда
            function updateTotalPrice() {
                const checkIn = document.getElementById('check_in').value;
                const checkOut = document.getElementById('check_out').value;
                const pricePerNight = parseFloat('{{ $room->price }}'); // Преобразуйте цену в число

                const stayDuration = calculateStayDuration(checkIn, checkOut);
                const totalPrice = calculateTotalPrice(pricePerNight, stayDuration);

                // Отображение стоимости
                const totalPriceInput = document.getElementById('total_price');
                totalPriceInput.value = totalPrice.toFixed(2); // Форматируем стоимость с двумя знаками после запятой
            }

            // Обработчики событий для обновления стоимости при изменении дат заезда или выезда
            document.getElementById('check_in').addEventListener('input', updateTotalPrice);
            document.getElementById('check_out').addEventListener('input', updateTotalPrice);

            // Вызов функции для инициализации стоимости при загрузке страницы
            updateTotalPrice();
        });
    </script>





@endsection
