<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class AvailableReservationDatetimeRepository
{
    public function bulkInsert($insertDatetimes)
    {
        DB::table('available_reservation_datetimes')->insert($insertDatetimes);
    }
}