<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use App\Booking;
class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booking::create([
            'title' => 'Meeting',
            'start' => '2024-11-28 10:00:00',
            'end' => '2024-11-28 12:00:00',
        ]);

        Booking::create([
            'title' => 'Conference',
            'start' => '2024-11-29 13:00:00',
            'end' => '2024-11-29 15:00:00',
        ]);
    }
}
