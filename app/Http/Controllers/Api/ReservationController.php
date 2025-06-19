<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;

class ReservationController extends Controller
{
    public function getTodayReservations()
    {
        $repository = new ReservationRepository(\App\Models\Reservation::class);
        $reservations = $repository->getTodayReservations();
        return response()->json($reservations);
    }
}