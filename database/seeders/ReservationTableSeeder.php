<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reservation::create([
            'user_id'          => 1,
            'reservation_date' => '2021/9/21',
            'reservation_time' => '11:00:00',
        ]);
    }
}
