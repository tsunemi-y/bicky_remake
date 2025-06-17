<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\UserService;
use App\Consts\ConstUser;
use App\Models\User;
use App\Models\Child;
use Illuminate\Support\Collection;
use Mockery;
use App\Repositories\UserRepository;
use App\Repositories\ChildRepository;

class UserServiceTest extends TestCase
{
    public function test_get_use_time_by_fee_returns_long_use_time_for_sibling_fees()
    {
        $service = $this->getUserService();
        $this->assertEquals(ConstUser::LONG_USE_TIME, $service->getUseTimeByFee(ConstUser::FEE_ONE_SIBLING));
        $this->assertEquals(ConstUser::LONG_USE_TIME, $service->getUseTimeByFee(ConstUser::FEE_THREE_SIBLING));
    }

    // public function test_get_use_time_by_fee_returns_normal_use_time_for_other_fees()
    // {
    //     $service = $this->getUserService();
    //     $this->assertEquals(ConstUser::NORMAL_USE_TIME, $service->getUseTimeByFee('other_fee'));
    // }

    // public function test_calculate_age_and_months()
    // {
    //     $service = $this->getUserService();
    //     $birthDate = now()->subYears(3)->subMonths(5)->format('Y-m-d');
    //     $result = $service->calculateAgeAndMonths($birthDate);
    //     $this->assertStringContainsString('3歳', $result);
    //     $this->assertStringContainsString('5ヶ月', $result);
    // }

    // public function test_create_user_calls_repository()
    // {
    //     $userParams = ['name' => 'Test User', 'email' => 'test@example.com'];
    //     $mockUser = new User($userParams);
    //     $mockRepo = Mockery::mock(UserRepository::class);
    //     $mockRepo->shouldReceive('create')->with($userParams)->andReturn($mockUser);

    //     $service = $this->getUserService(['UserRepository' => $mockRepo]);
    //     $result = $service->createUser($userParams);
    //     $this->assertEquals($mockUser->name, $result->name);
    // }

    // public function test_get_children_by_user_id_calls_repository()
    // {
    //     $userId = 1;
    //     $mockChildren = new Collection([new Child(['name' => 'Child1'])]);
    //     $mockRepo = Mockery::mock(ChildRepository::class);
    //     $mockRepo->shouldReceive('getChildrenByUserId')->with($userId)->andReturn($mockChildren);

    //     $service = $this->getUserService(['ChildRepository' => $mockRepo]);
    //     $result = $service->getChildrenByUserId($userId);
    //     $this->assertCount(1, $result);
    // }

    protected function getUserService($mocks = [])
    {
        // 必要な依存をモックまたはnullで渡す
        $defaults = [
            'GoogleCalendarService' => null,
            'MailService' => null,
            'LineMessengerServices' => null,
            'AvailableReservationDatetimeService' => null,
            'AvailableReservationDatetimeRepository' => null,
        ];
        $deps = array_merge($defaults, $mocks);
        return new UserService(
            $deps['GoogleCalendarService'],
            $deps['MailService'],
            $deps['LineMessengerServices'],
            $deps['AvailableReservationDatetimeService'],
            $deps['AvailableReservationDatetimeRepository'],
        );
    }
} 