<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    public function show()
    {
        $hotels = Hotel::with('rooms')->get();

        return view('main.show', compact('hotels'));
    }


}
