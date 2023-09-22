<?php
namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function show(Hotel $hotel)
    {
        return view('rooms.show', compact('hotel'));
    }

    public function search(Request $request, Hotel $hotel)
    {
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        // Ваш запрос для поиска свободных комнат в отеле $hotel
        $availableRooms = Room::whereNotIn('id', function ($query) use ($checkIn, $checkOut) {
            $query->select('room_id')
                ->from('bookings')
                ->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<=', $checkOut)
                        ->where('check_out', '>=', $checkIn);
                });
        })->where('hotel_id', $hotel->id)->get();

        return response()->json(['availableRooms' => $availableRooms]);
    }


}
