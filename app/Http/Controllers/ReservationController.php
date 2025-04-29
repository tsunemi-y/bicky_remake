<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationFormRequest;
use App\Http\Services\MailService;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.reservation');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail(ReservationFormRequest $request)
    {
        $mailService = new MailService();
        $mailService->sendMail($request);
        return view('pages.reservation');
    }
}
