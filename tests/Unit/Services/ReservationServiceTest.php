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
use App\Repositories\ChildRepository;
use App\Models\Reservation;
use App\Models\Child;
use Illuminate\Support\Collection;

class ReservationServiceTest extends TestCase
{
    protected function getService($mocks = [])
    {
        $defaults = [
            'GoogleCalendarService' => Mockery::mock(GoogleCalendarService::class),
            'AvailableReservationDatetimeService' => Mockery::mock(AvailableReservationDatetimeService::class),
            'UserService' => Mockery::mock(UserService::class),
            'AvailableReservationDatetimeRepository' => Mockery::mock(AvailableReservationDatetimeRepository::class),
            'ReservationRepository' => null,
            'ChildRepository' => null,
        ];
        $deps = array_merge($defaults, $mocks);
        return new ReservationService(
            $deps['GoogleCalendarService'],
            $deps['AvailableReservationDatetimeService'],
            $deps['UserService'],
            $deps['AvailableReservationDatetimeRepository'],
            $deps['ReservationRepository'],
            $deps['ChildRepository'],
        );
    }

    public function test_create_reservation_calls_repository()
    {
        $reservationData = ['user_id' => 1, 'reservation_date' => '2024-06-01', 'reservation_time' => '10:00:00'];
        $mockReservation = new Reservation($reservationData);
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('create')->with($reservationData)->andReturn($mockReservation);

        $service = $this->getService(['ReservationRepository' => $mockRepo]);
        $result = $service->createReservation($reservationData);
        $this->assertEquals($mockReservation->reservation_date, $result->reservation_date);
    }

    public function test_exists_duplicate_reservation_returns_true_if_exists()
    {
        $date = '2024-06-01';
        $time = '10:00:00';
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('query')->andReturnSelf();
        $mockRepo->shouldReceive('where')->with('reservation_date', $date)->andReturnSelf();
        $mockRepo->shouldReceive('where')->with('reservation_time', $time)->andReturnSelf();
        $mockRepo->shouldReceive('first')->andReturn(new Reservation(['reservation_date' => $date, 'reservation_time' => $time]));

        $service = $this->getService(['ReservationRepository' => $mockRepo]);
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
        $usetime = 30;
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('getAvailableDatetimes')->with($usetime)->andReturn([]);
        
        $service = $this->getService(['ReservationRepository' => $mockRepo]);
        $result = $service->getMappingAvailableDatesAndTimes($usetime);
        $this->assertArrayHasKey('avaDates', $result);
        $this->assertArrayHasKey('avaTimes', $result);
    }

    public function test_get_reservations_returns_array()
    {
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('getReservations')->andReturn(new Collection([]));
        
        $service = $this->getService(['ReservationRepository' => $mockRepo]);
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
        $mockAvailableRepo = Mockery::mock(AvailableReservationDatetimeRepository::class);
        $mockAvailableRepo->shouldReceive('bulkInsert')->with(Mockery::any())->once();
        
        $service = $this->getService([
            'AvailableReservationDatetimeRepository' => $mockAvailableRepo
        ]);
        $request = [
            'datetime' => '2033/1/1 10:00:00',
            'isBulkWeekend' => 1,
            'isBulkMonth' => 0,
            'isBulkDay' => 0,
        ];
        
        $service->saveAvailableDateTime($request);
        
        // モックの呼び出しが期待通りに行われたかはMockeryが自動検証
        $this->assertTrue(true);
    }

    public function test_attach_children_to_reservation()
    {
        $reservation = new Reservation(['id' => 1]);
        $childIds = [1,2,3];
        
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('attachChildrenToReservation')
                 ->once()
                 ->with($reservation, $childIds);
        
        $service = $this->getService(['ReservationRepository' => $mockRepo]);
        $service->attachChildrenToReservation($reservation, $childIds);
        
        // モックの呼び出しが期待通りに行われたかはMockeryが自動検証
        $this->assertTrue(true);
    }

    public function test_get_user_reservations()
    {
        $userId = 1;
        $expectedReservations = new Collection([
            new Reservation(['id' => 1, 'user_id' => $userId, 'reservation_date' => '2024-06-01']),
            new Reservation(['id' => 2, 'user_id' => $userId, 'reservation_date' => '2024-06-02'])
        ]);
        
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('getUserReservations')
                 ->once()
                 ->with($userId)
                 ->andReturn($expectedReservations);
        
        $service = $this->getService(['ReservationRepository' => $mockRepo]);
        $result = $service->getUserReservations($userId);
        
        $this->assertEquals($expectedReservations, $result);
        $this->assertCount(2, $result);
    }

    public function test_get_children_reservation_by_reservation_id()
    {
        $reservationId = 1;
        $expectedChildren = new Collection([
            new Child(['id' => 1, 'name' => 'Child1']),
            new Child(['id' => 2, 'name' => 'Child2'])
        ]);
        
        $mockRepo = Mockery::mock(ChildRepository::class);
        $mockRepo->shouldReceive('getChildrenByReservationId')
                 ->once()
                 ->with($reservationId)
                 ->andReturn($expectedChildren);
        
        $service = $this->getService(['ChildRepository' => $mockRepo]);
        $result = $service->getChildrenReservationByReservationId($reservationId);
        
        $this->assertEquals($expectedChildren, $result);
        $this->assertCount(2, $result);
    }

    public function test_delete_reservation()
    {
        $reservationId = 1;
        
        $mockRepo = Mockery::mock(ReservationRepository::class);
        $mockRepo->shouldReceive('delete')
                 ->once()
                 ->with($reservationId)
                 ->andReturn(true);
        
        $service = $this->getService(['ReservationRepository' => $mockRepo]);
        $result = $service->deleteReservation($reservationId);
        
        $this->assertTrue($result);
    }
}