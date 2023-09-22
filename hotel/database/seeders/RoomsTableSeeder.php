<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Room::create([
            'hotel_id' => 1,
            'price' => 250.00,
            // Другие поля комнаты
        ]);

        Room::create([
            'hotel_id' => 2,
            'price' => 150.00,
            // Другие поля комнаты
        ]);

        Room::create([
            'hotel_id' => 2,
            'price' => 2350.00,
            // Другие поля комнаты
        ]);

        Room::create([
            'hotel_id' => 1,
            'price' => 2550.00,
            // Другие поля комнаты
        ]);

        Room::create([
            'hotel_id' => 2,
            'price' => 450.00,
            // Другие поля комнаты
        ]);

        Room::create([
            'hotel_id' => 2,
            'price' => 350.00,
            // Другие поля комнаты
        ]);
        // Добавьте другие комнаты
    }

}
