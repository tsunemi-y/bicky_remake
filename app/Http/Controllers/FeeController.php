<?php

namespace App\Http\Controllers;

use App\Models\ReservationTime;

class FeeController extends Controller
{

    public function index()
    {
        $reservationTimes = ReservationTime::all()->toArray();
        return view('pages.fee', compact('reservationTimes'));
    }
}
