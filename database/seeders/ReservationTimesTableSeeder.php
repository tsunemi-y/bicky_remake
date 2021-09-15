<?php

namespace Database\Seeders;

use App\Models\ReservationTime;
use Illuminate\Database\Seeder;

class ReservationTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeList = [
            [
                'reservation_time_from' => '11:00',
                'reservation_time_to' => '12:00',
            ],
            [
                'reservation_time_from' => '13:00',
                'reservation_time_to' => '14:00',
            ],
            [
                'reservation_time_from' => '15:00',
                'reservation_time_to' => '16:00',
            ],
            [
                'reservation_time_from' => '17:00',
                'reservation_time_to' => '18:00',
            ],
            [
                'reservation_time_from' => '19:00',
                'reservation_time_to' => '20:00',
            ],
        ];

        foreach ($timeList as $time) {
            ReservationTime::create([
                'reservation_time_from' => $time['reservation_time_from'],
                'reservation_time_to' => $time['reservation_time_to'],
            ]);
        }
    }
}
