<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvailableReservationTime;

class AvailableReservationTimesTableSeeder extends Seeder
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
                'available_time' => '10:00',
                'available_reservation_date_id' => 1
            ],
            [
                'available_time' => '11:00',
                'available_reservation_date_id' => 1
            ],
            [
                'available_time' => '13:00',
                'available_reservation_date_id' => 1
            ],
            [
                'available_time' => '14:00',
                'available_reservation_date_id' => 2
            ],
        ];

        foreach ($timeList as $time) {
            AvailableReservationTime::create([
                'available_time' => $time['available_time'],
                'available_reservation_date_id' => $time['available_reservation_date_id'],
            ]);
        }
    }
}
