<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ReservationService;
use Mockery;
use App\Services\GoogleCalendarService;
use App\Services\AvailableReservationDatetimeService;
use App\Services\UserService;
use App\Repositories\AvailableReservationDatetimeRepository;
use App\Repositories\ReservationRepository;
use App\Models\Reservation;
use App\Models\AvailableReservationDatetime;
use App\Models\Child;
use App\Repositories\ChildRepository;
use App\Consts\ConstReservation;

class ReservationServiceTest extends TestCase
{
    protected function getService($mocks = [])
    {
        $defaults = [
            'GoogleCalendarService' => Mockery::mock(GoogleCalendarService::class),
            'AvailableReservationDatetimeService' => Mockery::mock(AvailableReservationDatetimeService::class),
            'UserService' => Mockery::mock(UserService::class),
            'AvailableReservationDatetimeRepository' => Mockery::mock(AvailableReservationDatetimeRepository::class),
        ];
        $deps = array_merge($defaults, $mocks);
        return new ReservationService(
            $deps['GoogleCalendarService'],
            $deps['AvailableReservationDatetimeService'],
            $deps['UserService'],
            $deps['AvailableReservationDatetimeRepository'],
        );
    }

    public function test_create_reservation_calls_repository()
    {
        $reservationData = ['user_id' => 1, 'reservation_date' => '2024-06-01', 'reservation_time' => '10:00:00'];
        $mockReservation = new Reservation($reservationData);
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('create')->with($reservationData)->andReturn($mockReservation);

        $service = $this->getService();
        // Repositoryの差し替えはDI設計次第で調整
        // ここでは雛形として記載
        $result = $mockRepo->create($reservationData);
        $this->assertEquals($mockReservation->reservation_date, $result->reservation_date);
    }

    public function test_exists_duplicate_reservation_returns_true_if_exists()
    {
        $date = '2024-06-01';
        $time = '10:00:00';
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('query')->andReturnSelf();
        $mockRepo->shouldReceive('where')->andReturnSelf();
        $mockRepo->shouldReceive('first')->andReturn(new Reservation(['reservation_date' => $date, 'reservation_time' => $time]));

        $service = $this->getService();
        $result = $service->existsDuplicateReservation($date, $time);
        $this->assertTrue($result);
    }

    public function test_calculate_reservation_end_time()
    {
        $service = $this->getService();
        $time = '10:00:00';
        $useTime = 30;
        $expected = date('H:i:s', strtotime("{$time} +{$useTime} minute -1 second"));
        $result = $service->calculateReservationEndTime($time, $useTime);
        $this->assertEquals($expected, $result);
    }

    public function test_get_mapping_available_dates_and_times()
    {
        $service = $this->getService();
        $usetime = 30;
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('getAvailableDatetimes')->with($usetime)->andReturn([]);
        // 雛形なので空配列でOK
        $result = $service->getMappingAvailableDatesAndTimes($usetime);
        $this->assertArrayHasKey('avaDates', $result);
        $this->assertArrayHasKey('avaTimes', $result);
    }

    public function test_get_reservations_returns_array()
    {
        $service = $this->getService();
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('getReservations')->andReturn([]);
        $result = $service->getReservations();
        $this->assertIsArray($result);
    }

    public function test_get_holidays_returns_array()
    {
        $service = $this->getService();
        $result = $service->getHolidays();
        $this->assertIsArray($result);
    }

    public function test_save_available_datetime_bulk_weekend()
    {
        $service = $this->getService();
        $request = [
            'datetime' => '2033/1/1 10:00:00',
            'isBulkWeekend' => 1,
            'isBulkMonth' => 0,
            'isBulkDay' => 0,
        ];
        $this->markTestIncomplete('saveAvailableDatetimeの週末一括登録テストを実装してください');
    }

    public function test_attach_children_to_reservation()
    {
        $service = $this->getService();
        $reservation = new Reservation(['id' => 1]);
        $childIds = [1,2,3];
        $this->markTestIncomplete('attachChildrenToReservationのテストを実装してください');
    }

    public function test_get_user_reservations()
    {
        $service = $this->getService();
        $userId = 1;
        $this->markTestIncomplete('getUserReservationsのテストを実装してください');
    }

    public function test_get_children_reservation_by_reservation_id()
    {
        $service = $this->getService();
        $reservationId = 1;
        $this->markTestIncomplete('getChildrenReservationByReservationIdのテストを実装してください');
    }

    public function test_delete_reservation()
    {
        $service = $this->getService();
        $reservationId = 1;
        $this->markTestIncomplete('deleteReservationのテストを実装してください');
    }
}