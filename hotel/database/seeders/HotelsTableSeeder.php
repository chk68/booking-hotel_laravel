<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hotel::create([
            'name' => 'Hotel A',
            // Другие поля отеля
        ]);

        Hotel::create([
            'name' => 'Hotel B',
            // Другие поля отеля
        ]);

        // Добавьте другие отели
    }

}
