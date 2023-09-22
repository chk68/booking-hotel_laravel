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


    public function make(Request $request, $roomId)
    {
        // Проверяем, авторизован ли пользователь
        if (auth()->check()) {
            $user = auth()->user();

            // Создаем бронирование
            $booking = new Booking([
                'user_id' => $user->id,
                'room_id' => $roomId,
                'check_in' => $request->input('check_in'),
                'check_out' => $request->input('check_out'),
                // Другие атрибуты бронирования
            ]);

            $booking->save();

            return redirect()->route('rooms.show', ['room' => $roomId])
                ->with('success', 'Комната успешно забронирована!');

        } else {
            // Если пользователь не авторизован, можно перенаправить на страницу авторизации
            return redirect()->route('login')->with('error', 'Для бронирования комнаты необходимо авторизоваться.');
        }
    }

    public function store(Request $request)
    {
        // Проверяем, авторизован ли пользователь
        if (auth()->check()) {
            // Получаем данные из формы
            $userId = auth()->user()->id;
            $roomId = $request->input('room_id');
            $checkIn = $request->input('check_in');
            $checkOut = $request->input('check_out');
            $hotelId = $request->input('hotel_id');

            // Создаем запись в таблице "bookings"
            $booking = new Booking([
                'user_id' => $userId,
                'room_id' => $roomId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'hotel_id' => $hotelId,
                // Другие атрибуты бронирования, если есть
            ]);

            $booking->save();

            return redirect()->route('rooms.show', ['hotel' => $hotelId, 'room' => $roomId])
                ->with('success', 'Комната успешно забронирована!');
        } else {
            // Если пользователь не авторизован, можно перенаправить на страницу авторизации
            return redirect()->route('login')->with('error', 'Для бронирования комнаты необходимо авторизоваться.');
        }
    }
}
