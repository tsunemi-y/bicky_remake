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
                'reservation_time_from' => '10:00',
                'reservation_time_to' => '10:50',
            ],
            [
                'reservation_time_from' => '11:00',
                'reservation_time_to' => '11:50',
            ],
            [
                'reservation_time_from' => '13:00',
                'reservation_time_to' => '13:50',
            ],
            [
                'reservation_time_from' => '14:00',
                'reservation_time_to' => '14:50',
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
