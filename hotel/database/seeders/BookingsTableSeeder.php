<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booking::create([
            'room_id' => 3,
        'user_id' => 1	,
        'check_in'	=> '2023.08.08',
        'check_out' => '2023.09.09',
        ]);
    }

}
