<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        session(['start_date' => $start_date, 'end_date' => $end_date]);

        // Выполните запрос к базе данных для поиска комнат
        $availableRooms = DB::table('rooms')
            ->whereNotExists(function ($query) use ($start_date, $end_date) {
                $query->select(DB::raw(1))
                    ->from('bookings')
                    ->where('room_id', '=', DB::raw('rooms.id'))
                    ->where(function ($query) use ($start_date, $end_date) {
                        $query->where(function ($query) use ($start_date, $end_date) {
                            $query->whereBetween('check_in', [$start_date, $end_date])
                                ->orWhereBetween('check_out', [$start_date, $end_date]);
                        })
                            ->orWhere('status', '=', 'cancelled');
                    });
            })
            ->get();

        // Получите список уникальных отелей, к которым относятся найденные комнаты
        $hotelIds = $availableRooms->pluck('hotel_id')->unique();
        $availableHotels = DB::table('hotels')
            ->whereIn('id', $hotelIds)
            ->get();

        return view('search.show', compact('availableHotels', 'start_date', 'end_date'));
    }
}
