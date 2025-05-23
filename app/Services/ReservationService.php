<?php

namespace App\Services;

use \Yasumi\Yasumi;
use App\Models\User;
use App\Models\Reservation;
use App\Services\UserService;
use App\Consts\ConstReservation;
use App\Repositories\ReservationRepository;
use App\Models\AvailableReservationDatetime;
use App\Repositories\AvailableReservationDatetimeRepository;


class ReservationService
{
    public function __construct(
        private GoogleCalendarService $googleCalendarService, 
        private AvailableReservationDatetimeService $availableReservationDatetimeService,
        private UserService $userService,
        private AvailableReservationDatetimeRepository $availableReservationDatetimeRepository
    ) {
    }

    public function createReservation($reservationData)
    {
        $repository = new ReservationRepository(Reservation::class);
        $reservation = $repository->create($reservationData);

        return $reservation;
    }

    public function existsDuplicateReservation($date, $time)
    {
        $reservedDateTime = Reservation::query()
            ->where('reservation_date', $date)
            ->where('reservation_time', $time)
            ->first();

        return !empty($reservedDateTime);
    }

    public function calculateReservationEndTime($time, $useTime)
    {
        return date('H:i:s', strtotime("{$time} +{$useTime} minute -1 second"));
    }

    public function getMappingAvailableDatesAndTimes($usetime)
    {
        $reservationRepository = new ReservationRepository(Reservation::class);
        $avaDatetimes = $reservationRepository->getAvailableDatetimes($usetime);

        $avaDates = [];
        $avaTimes = [];
        foreach ($avaDatetimes as $datetime) {
            $avaDates[] = $datetime->available_date;

            $tmpAvaTimes = toArrayFromArrayColumn($datetime->available_times);
            $avaTimes[$datetime->available_date] = $tmpAvaTimes;
        }

        return compact('avaDates', 'avaTimes');
    }

    public function getReservations()
    {
        $reservationRepository = new ReservationRepository(Reservation::class);
        $tmpReservations = $reservationRepository->getReservations();

        $reservations = [];
        foreach ($tmpReservations as $tr) {
            $reservations[$tr->reservation_date][] = [
                'reservationName' => $tr->parentName,
                'reservationTime' => $tr->reservation_time
            ];
        }

        return $reservations;
    }

    public function getHolidays()
    {
        $holidays = Yasumi::create('Japan', date('Y'), 'ja_JP');
        return array_values($holidays->getHolidayDates());
    }

    public function saveAvailableDatetime($request)
    {
        $datetime = $request['datetime'];
        $date = substr($datetime, 0, 10);
        $time = substr($datetime, 11, 15);
        $monthCount = date('t', strtotime($date));
        $nonDayDate = substr($date, 0, 8); // 例）2022/05/

        if ($request['isBulkWeekend']) {
            $targetInsertWeeks = [6, 0];
            $this->bulkInsert($monthCount, $nonDayDate, $targetInsertWeeks);
        } elseif ($request['isBulkMonth']) {
            $targetInsertWeeks = [0, 1, 2, 3, 4, 5, 6];
            $this->bulkInsert($monthCount, $nonDayDate, $targetInsertWeeks);
        } elseif ($request['isBulkDay']) {
            $insertDatetimes = $this->availableReservationDatetimeService->getInsertDatetimes($date);
            $this->availableReservationDatetimeRepository->bulkInsert($insertDatetimes);
        } else {
            $avaRsvDatetimeModel = new AvailableReservationDatetime();
            $avaRsvDatetimeModel->create([
                'available_date' => $date,
                'available_time' => $time,
            ]);
        }
    }

    public function attachChildrenToReservation($reservation, $childIds)
    {
        $reservationRepository = new ReservationRepository(Reservation::class);
        $reservationRepository->attachChildrenToReservation($reservation, $childIds);
    }

    private function bulkInsert($monthCount, $nonDayDate, $targetInsertWeeks)
    {
        $holidays = Yasumi::create('Japan', date('Y'), 'ja_JP');

        $insertDatetimes = [];
        for ($i = 1; $i <= $monthCount; $i++) {
            $week = (int)date('w', strtotime($nonDayDate. $i));
            if (!(in_array($week, $targetInsertWeeks, true))) continue;
            if ($holidays->isHoliday(new \DateTime($nonDayDate . $i))) continue;
            foreach (ConstReservation::AVAILABLE_TIME_LIST as $time) {
                $insertDatetimes[] = [
                    'available_date' => $nonDayDate. $i,
                    'available_time' => $time,
                ];
            }
        }
        
        $this->availableReservationDatetimeRepository->bulkInsert($insertDatetimes);
    }
}
