<?php

namespace App\Services;

use App\Models\User;
use App\Consts\ConstUser;

use App\Services\MailService;
use App\Services\LineMessengerServices;

use App\Repositories\ReservationRepository;
use App\Repositories\AvailableReservationDatetimeRepository;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private GoogleCalendarService $googleCalendarService, 
        private MailService $mailService, 
        private LineMessengerServices $lineMessengerServices,
        private AvailableReservationDatetimeService $availableReservationDatetimeService,
        private ReservationRepository $reservationRepository,
        private AvailableReservationDatetimeRepository $availableReservationDatetimeRepository,
        private UserRepository $userRepository
    ) {
    }

    public function getUseTimeByFee($fee)
    { 
        if ($fee === ConstUser::FEE_ONE_SIBLING || $fee === ConstUser::FEE_TWO_SIBLING) {
            return ConstUser::LONG_USE_TIME;
        } else {
            return ConstUser::NORMAL_USE_TIME;
        }
    }

    public function putPDF($fee)
    { 
        if ($fee === ConstUser::FEE_ONE_SIBLING || $fee === ConstUser::FEE_TWO_SIBLING) {
            return ConstUser::LONG_USE_TIME;
        } else {
            return ConstUser::NORMAL_USE_TIME;
        }
    }

    public function getLoginUser(): User
    { 
        return $this->userRepository->getLoginUser(\Auth::id());
    }
}
