@extends('layouts.app')

@section('content')

    <div class="map-hotel-container">
       <div class ="search-map-container">
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

    <div id="mini-map" style="width: 300px; height: 300px;"></div>

    </div>


         <div class="hotel">

         <div class="hotel-name">
          <h1>{{ $hotel->name }}</h1>
         </div>

         <div class="hotel-photo">
          <img src="{{ asset('storage/' . $hotel->image_path) }}" alt="Изображение отеля">
         </div>

       </div>

    </div>

     <div class="hotel-details">

         <div class="hotel-description">
            <p>{{ $hotel->description }}</p>
         </div>
         <div class="hotel-amenities">
            <h3>Плюсы</h3>
            <ul>
                <li>{{ $hotel->amenities }}</li>
            </ul>
         </div>

     </div>





    <div id="available-rooms" class="room-list">
        <!-- Здесь будет отображаться список свободных комнат -->
    </div>
    <script>
        var map = L.map('mini-map').setView([39.4699, -0.3763], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

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
                            const roomList = document.createElement('ul'); // Создаем список
                            roomList.classList.add('room-list');

                            data.availableRooms.forEach(room => {
                                const listItem = document.createElement('li'); // Создаем элемент списка
                                listItem.classList.add('room');
                                listItem.innerHTML = `
                                <div class="room-header" onclick="toggleRoomInfo(this)">
                                    <h3>Комната №${room.id}</h3>
                                    <p>Цена: ${room.price}</p>
                                    <p>Класс: ${room.type}</p>

                                    <div class="room-price">
                                        <p>Стоимость за ${calculateStayDuration(checkIn, checkOut)} дней: ${calculateTotalPrice(room.price, calculateStayDuration(checkIn, checkOut))}</p>
                                    </div>
<button onclick="bookRoom(${room.id})">Забронировать</button>
                                </div>
                                <div class="room-info">
                                    "Фото комнаты" <!-- Изображение комнаты -->
                                    <p>Описание: ${room.description}</p>
                                    <p>Удобства: ${room.amenities}</p>
                                </div>

                            `;
                                roomList.appendChild(listItem); // Добавляем элемент списка в список комнат
                            });

                            availableRoomsDiv.appendChild(roomList); // Добавляем список комнат в контейнер
                        } else {
                            availableRoomsDiv.innerHTML = '<p>Нет доступных комнат для выбранных дат.</p>';
                        }
                    })
                    .catch(error => console.error('Ошибка:', error));
            });

            // Функция для вычисления количества дней между датами
            function calculateStayDuration(checkInDate, checkOutDate) {
                const checkIn = new Date(checkInDate);
                const checkOut = new Date(checkOutDate);
                const oneDay = 24 * 60 * 60 * 1000; // Один день в миллисекундах
                return Math.round(Math.abs((checkIn - checkOut) / oneDay));
            }

            // Функция для вычисления общей стоимости
            function calculateTotalPrice(pricePerNight, stayDuration) {
                return pricePerNight * stayDuration;
            }
        });

    </script>

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

    @push('styles')
        <link href="{{ asset('styles/styles.css') }}" rel="stylesheet">
        <link href="{{ asset('styles/rooms.css') }}" rel="stylesheet">
    @endpush

@endsection
