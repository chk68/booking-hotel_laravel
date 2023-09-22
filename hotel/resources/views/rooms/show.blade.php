@extends('layouts.app')
@push('styles')
    <link href="{{ asset('styles/styles.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="room-details">
        <h1>{{ $hotel->name }}</h1>
        <div class="search-form">
            <form id="search-form">
                @csrf
                <label for="check_in">Дата заезда:</label>
                <input type="date" name="check_in" id="check_in" required>
                <label for="check_out">Дата выезда:</label>
                <input type="date" name="check_out" id="check_out" required>
                <button type="submit">Поиск свободных комнат</button>
            </form>
        </div>
    </div>

        <div id="available-rooms">
            <!-- Здесь будет отображаться список свободных комнат -->
        </div>

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

    <script>
        function bookRoom(roomId) {
            // Выполняем переход на страницу бронирования с использованием roomId
            window.location.href = `/booking/show/${roomId}`;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchForm = document.getElementById('search-form');
            const availableRoomsDiv = document.getElementById('available-rooms');

            searchForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const checkIn = document.getElementById('check_in').value;
                const checkOut = document.getElementById('check_out').value;

                fetch("{{ route('rooms.search', ['hotel' => $hotel]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ check_in: checkIn, check_out: checkOut })
                })
                    .then(response => response.json())
                    .then(data => {
                        // Обновляем список свободных комнат на странице
                        availableRoomsDiv.innerHTML = '';

                        if (data.availableRooms.length > 0) {
                            data.availableRooms.forEach(room => {
                                const roomDiv = document.createElement('div');
                                roomDiv.classList.add('room');
                                roomDiv.innerHTML = `
                                    <div class="room-header" onclick="toggleRoomInfo(this)">
                                        <h3>Комната №${room.id}</h3>
                                        <p>Цена: ${room.price}</p>
                                        <p>Класс: ${room.class}</p>
                                        <button onclick="bookRoom(${room.id})">Забронировать</button>
                                    </div>
                                    <div class="room-info">
                                        <p>Описание: ${room.description}</p>
                                        <p>Удобства: ${room.amenities}</p>
                                    </div>
                                `;
                                availableRoomsDiv.appendChild(roomDiv);
                            });
                        } else {
                            availableRoomsDiv.innerHTML = '<p>Нет доступных комнат для выбранных дат.</p>';
                        }
                    })
                    .catch(error => console.error('Ошибка:', error));
            });
        });

    </script>
@endsection
