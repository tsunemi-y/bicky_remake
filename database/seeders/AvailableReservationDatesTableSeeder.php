<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvailableReservationDate;

class AvailableReservationDatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateList = [
            [
                'available_date' => '2021/11/30',
            ],
            [
                'available_date' => '2021/12/02',
            ],
            [
                'available_date' => '2021/12/11',
            ],
            [
                'available_date' => '2021/12/30',
            ],
        ];

        foreach ($dateList as $date) {
            AvailableReservationDate::create([
                'available_date' => $date['available_date'],
            ]);
        }
    }
}
