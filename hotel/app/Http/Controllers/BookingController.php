<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    public function show(Room $room)
    {
        $user = Auth::user(); // Получаем текущего пользователя

        // Передаем данные пользователя, отеля и номера комнаты в представление
        return view('booking.show', [
            'user' => $user,
            'room' => $room,
        ]);
    }

    public function make(Request $request)
    {
        // Проверяем, авторизован ли пользователь
        if (auth()->check()) {
            $user = auth()->user();

            // Получаем данные из строки запроса
            $roomId = $request->input('room_id'); // Обратите внимание, что это должно быть 'room_id', а не 'roomId' из строки запроса

            $checkIn = $request->input('check_in');
            $checkOut = $request->input('check_out');
            $hotelId = $request->input('hotel_id');

            // Создаем бронирование
            $booking = new Booking([
                'user_id' => $user->id,
                'room_id' => $roomId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'hotel_id' => $hotelId,
                // Другие атрибуты бронирования, если есть
            ]);

            $booking->save();

            return redirect()->route('rooms.show', ['room' => $roomId, 'hotel' => $hotelId])
                ->with('success', 'Комната успешно забронирована!');
        } else {
            // Если пользователь не авторизован, можно перенаправить на страницу авторизации
            return redirect()->route('login')->with('error', 'Для бронирования комнаты необходимо авторизоваться.');
        }
    }






}
