<?php

namespace App\Services;

use App\Models\User;
use App\Models\Child;
use App\Consts\ConstUser;

use App\Services\MailService;
use App\Services\LineMessengerServices;

use App\Repositories\Repository;
use App\Repositories\ReservationRepository;
use App\Repositories\AvailableReservationDatetimeRepository;
use App\Repositories\UserRepository;
use App\Repositories\ChildRepository;

class UserService
{
    public function __construct(
        private GoogleCalendarService $googleCalendarService, 
        private MailService $mailService, 
        private LineMessengerServices $lineMessengerServices,
        private AvailableReservationDatetimeService $availableReservationDatetimeService,

        private ReservationRepository $reservationRepository,
        private AvailableReservationDatetimeRepository $availableReservationDatetimeRepository,
        private UserRepository $userRepository,
        private ChildRepository $childRepository
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

    public function createUser($userParams)
    {
        $repository = new Repository(User::class);
        return $repository->create($userParams);
    }

    public function getLoginUser(): User | null
    { 
        return auth('api')->user();
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

    public function getChildren($userId)
    {
        return $this->ChildRepository->getChildren($userId);
    }

    public function createChild($childParams)
    {
        $repository = new Repository(Child::class);
        return $repository->create($childParams);
    }

    public function getChildrenByChildIds(array $childIds): Collection
    {
        return $this->ChildRepository->getChildrenByChildIds($childIds);
    }
}
