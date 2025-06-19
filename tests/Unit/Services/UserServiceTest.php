<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\UserService;
use App\Models\User;
use App\Models\Child;
use App\Repositories\UserRepository;
use App\Repositories\ChildRepository;
use App\Consts\ConstUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Mockery;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_use_time_by_fee_returns_long_use_time_for_sibling_fees()
    {
        $service = $this->getUserService();
        $this->assertEquals(ConstUser::LONG_USE_TIME, $service->getUseTimeByFee(ConstUser::FEE_ONE_SIBLING));
        $this->assertEquals(ConstUser::LONG_USE_TIME, $service->getUseTimeByFee(ConstUser::FEE_THREE_SIBLING));
    }

    public function test_get_login_user_returns_authenticated_user()
    {
        $user = User::create([
            'parentName' => 'テストユーザー',
            'email' => 'test@example.com',
            'tel' => '090-1234-5678',
            'password' => bcrypt('password'),
            'childName' => 'テスト児童',
            'age' => 5,
            'gender' => '男',
            'address' => '東京都',
            'coursePlan' => 1
        ]);
        
        $this->actingAs($user, 'api');

        $service = $this->getUserService();
        $result = $service->getLoginUser();

        $this->assertNotNull($result);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result->id);
        $this->assertEquals('テストユーザー', $result->parentName);
    }

    public function test_get_login_user_returns_null_when_not_authenticated()
    {
        $service = $this->getUserService();
        $result = $service->getLoginUser();

        $this->assertNull($result);
    }

    public function test_get_use_time_by_fee_returns_normal_use_time_for_other_fees()
    {
        $service = $this->getUserService();
        $this->assertEquals(ConstUser::NORMAL_USE_TIME, $service->getUseTimeByFee('other_fee'));
    }

    public function test_calculate_age_and_months()
    {
        $service = $this->getUserService();
        $birthDate = now()->subYears(3)->subMonths(5)->format('Y-m-d');
        $result = $service->calculateAgeAndMonths($birthDate);
        $this->assertStringContainsString('3歳', $result);
        $this->assertStringContainsString('5ヶ月', $result);
    }

    public function test_create_user_calls_repository()
    {
        $userParams = ['parentName' => 'Test User', 'email' => 'test@example.com'];
        $mockUser = new User($userParams);
        $mockRepo = Mockery::mock(UserRepository::class);
        $mockRepo->shouldReceive('create')->with($userParams)->andReturn($mockUser);

        $service = $this->getUserService(['UserRepository' => $mockRepo]);
        $result = $service->createUser($userParams);
        $this->assertEquals($mockUser->parentName, $result->parentName);
    }

    public function test_get_children_by_user_id_calls_repository()
    {
        $userId = 1;
        $mockChildren = new Collection([new Child(['name' => 'Child1'])]);
        $mockRepo = Mockery::mock(ChildRepository::class);
        $mockRepo->shouldReceive('getChildrenByUserId')->with($userId)->andReturn($mockChildren);

        $service = $this->getUserService(['ChildRepository' => $mockRepo]);
        $result = $service->getChildrenByUserId($userId);
        $this->assertCount(1, $result);
    }

    protected function getUserService($mocks = [])
    {
        $defaults = [
            'GoogleCalendarService' => $this->createMock(\App\Services\GoogleCalendarService::class),
            'MailService' => $this->createMock(\App\Services\MailService::class),
            'LineMessengerServices' => $this->createMock(\App\Services\LineMessengerServices::class),
            'AvailableReservationDatetimeService' => $this->createMock(\App\Services\AvailableReservationDatetimeService::class),
            'AvailableReservationDatetimeRepository' => $this->createMock(\App\Repositories\AvailableReservationDatetimeRepository::class),
            'UserRepository' => null,
            'ChildRepository' => null,
        ];
        $deps = array_merge($defaults, $mocks);
        return new UserService(
            $deps['GoogleCalendarService'],
            $deps['MailService'],
            $deps['LineMessengerServices'],
            $deps['AvailableReservationDatetimeService'],
            $deps['AvailableReservationDatetimeRepository'],
            $deps['UserRepository'],
            $deps['ChildRepository'],
        );
    }
} 