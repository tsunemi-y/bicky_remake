<?php

namespace App\Repositories;

use DB;
use App\Models\Reservation;
use Illuminate\Support\Collection;
use App\Models\AvailableReservationDatetime;

class ReservationRepository
{
    public function getAvailableDatetimes($useTime)
    {
        $ajdustedUseTime = 0;
        if (!is_null($ajdustedUseTime)) {
            $ajdustedUseTime = $useTime - 1;
        }

        return AvailableReservationDatetime::query()
            ->select(DB::raw('
            available_date
            ,array_agg(available_time order by available_time) available_times
        '))
            ->whereNotExists(function($query) use($ajdustedUseTime) {
            $query->select(DB::raw(1))
                ->from('reservations')
                ->whereRaw('CAST(available_date AS DATE) = CAST(reservation_date AS DATE)')
                ->whereRaw("
                    (
                        CAST(available_time AS TIME) BETWEEN CAST(reservation_time AS TIME) AND CAST(end_time AS TIME) OR
                        CAST(available_time AS TIME) + CAST('$ajdustedUseTime minutes' as INTERVAL) BETWEEN CAST(reservation_time AS TIME) AND CAST(end_time AS TIME)
                    )
                ");
            })
            ->groupBy('available_date')
            ->get();
    }

    public function getReservations(): Collection
    {
        return Reservation::query()
            ->join('users', 'reservations.user_id', 'users.id')
            ->orderBy('reservation_date', 'asc')
            ->orderBy('reservation_time', 'asc')
            ->get(['parentName', 'reservation_date', 'reservation_time']);
    }

    public function getMonthlyFee(): int
    {
        // 今月分
        // feeをcount　→　user.feeから取ってくる
        return Reservation::query()
            ->join('users', 'reservations.user_id', '=', 'users.id')
            ->whereRaw("date_part('month', reservation_date) = date_part('month', now())")
            ->count();
    }
}