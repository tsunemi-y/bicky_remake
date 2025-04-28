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
        if ($fee === ConstUser::FEE_ONE_SIBLING || $fee === ConstUser::FEE_THREE_SIBLING) {
            return ConstUser::LONG_USE_TIME;
        } else {
            return ConstUser::NORMAL_USE_TIME;
        }
    }

    public function getLoginUser(): User | null
    { 
        return $this->userRepository->getLoginUser(\Auth::id());
    }

    /**
     * Calculate age in years and months from birth date.
     *
     * @param string $birthDate The birth date string
     * @return string A formatted age string like "3歳5ヶ月"
     */
    public function calculateAgeAndMonths(string $birthDate): string
    {
        $dob = new \DateTime($birthDate);
        $now = new \DateTime();
        $diff = $dob->diff($now);
        return sprintf('%d歳%dヶ月', $diff->y, $diff->m);
    }
}
