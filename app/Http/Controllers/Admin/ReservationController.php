<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AvailableReservationDatetime;
use App\Http\Requests\CreateAvailableFormRequest;

use App\Services\ReservationService;
use App\Services\UserService;

class ReservationController extends Controller
{
    public function __construct(
        private ReservationService $reservationService,
        private UserService $userService,

    ) {
    }

    public function index()
    {
        $user = $this->userService->getLoginUser();

        $avaDatetimes = $this->reservationService->getMappingAvailableDatesAndTimes($user->use_time);
        $avaTimes = $avaDatetimes['avaTimes'];

        $reservations = $this->reservationService->getReservations();
        
        $holidays = $this->reservationService->getHolidays();

        return compact('avaTimes', 'reservations', 'holidays');
    }

    public function store(CreateAvailableFormRequest $request)
    {
        $this->reservationService->saveAvailableDatetime($request);
    }

    public function destroy(Request $request)
    {
        $time = date('H:i:s', strtotime(str_replace(['時', '分'], [':', ''], $request['time']))); // フロントから送られる形式は〇〇時〇〇分なので変換

        $avaDateId = AvailableReservationDatetime::where('available_date', $request['date'])
            ->where('available_time', $time)
            ->get('id')
            ->toArray()[0]['id'];

        AvailableReservationDatetime::where('id', $avaDateId)->delete();
    }
}
