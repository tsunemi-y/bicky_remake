<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Services\MailService;
use App\Services\ReservationService;
use App\Services\GoogleCalendarService;
use App\Services\LineMessengerServices;
use App\Services\UserService;
use App\Services\CourseService;
use App\Http\Requests\ReservationFormRequest;
use App\Http\Requests\ReservationCalenderFormRequest;
use Illuminate\Http\Request;
class ReservationController extends Controller
{
    public function __construct(
        private ReservationService $reservationService, 
        private GoogleCalendarService $googleCalendarService,
        private MailService $mailService, 
        private LineMessengerServices $lineMessengerServices,
        private UserService $userService,
        private CourseService $courseService,
    )
    {
    }

    public function index()
    {
        $user = $this->userService->getLoginUser();

        $availableDatesAndTimes = $this->reservationService->getMappingAvailableDatesAndTimes($user->use_time);

        return response()->json([
            'success' => true,
            'data' => $availableDatesAndTimes,
        ]);
    }

    public function store(ReservationFormRequest $request, Reservation $reservation)
    {
        DB::beginTransaction();
        
        try {
            $childIds = $request->children;
            $courseId = $request->course;
            $fee = $request->fee;
            $useTime = $request->useTime;
            $time = $request->time;
            $date = $request->date;

            // 指定した日時がすでに埋まっている場合、予約トップにリダイレクト
            $isReserved = $this->reservationService->existsDuplicateReservation($date, $time);
            if ($isReserved) {
                return response()->json([
                    'success' => false,
                    'message' => '選択された日時はすでにご予約がございます。</br>違う日時でご予約ください。',
                ], 422);
            } 

            $userId = Auth::id();

            $endTime = $this->reservationService->calculateReservationEndTime($time, $useTime);

            $reservationData = [
                'user_id' => $userId,
                'reservation_date' => $date,
                'reservation_time' => $time,
                'end_time' => $endTime,
            ];
            $reservedInfo = $this->reservationService->createReservation($reservationData);

            // 予約と子供の関連付け
            $this->reservationService->attachChildrenToReservation($reservedInfo, $childIds);

            // リクエスト中の利用児idから利用児データ取得
            $selectedChildren = $this->userService->getChildrenByChildIds($childIds);

            $userInfo = $this->userService->getLoginUser();
            
            $messageData = [
                'date' => formatDate($date),
                'time' => formatTime($time),
                'email' => $userInfo->email,
                'reservationId' => $reservedInfo->id,
                // 'usageFee' => $usageFee,
            ];

            // 管理者へ予約通知のLINEメッセージ送信
            $this->lineMessengerServices->sendReservationMessage($messageData['date'], $messageData['time'], $selectedChildren);

            $this->lineMessengerServices->sendMonthlyFeeMessage();

            $viewFile = 'emails.reservations.user';
            $subject = '予約を受け付けました';
            $this->mailService->sendMailToUser($messageData, $viewFile, $subject);

            $this->googleCalendarService->store($userInfo->parentName, $date. $time, $date. $endTime, $reservedInfo->id);

            DB::commit();

            $response = [
                'success' => true,
                'data' => [
                    'message' => "予約が完了しました。<br>予約内容をメールで送信しました。",
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Reservation $reservation)
    {
        // TODO: エラーハンドリング最適解調査
        return response()->json($reservation);
    }

    public function destroy(Reservation $reservation)
    {
        DB::beginTransaction();

        try {
            $messageData = [
                'reservationDate' => formatDate($reservation->reservation_date),
                'reservationTime' => formatTime($reservation->reservation_time),
                'email'           => $reservation->user->email,
            ];

            // 予約IDから利用児データ取得
            $selectedChildren = $this->reservationService->getChildrenReservationByReservationId($reservation->id);

            $this->reservationService->deleteReservation($reservation->id);

            // 管理者へ予約キャンセルのLINEメッセージ送信
            $this->lineMessengerServices->sendCancelReservationMessage($messageData['reservationDate'], $messageData['reservationTime'], $selectedChildren);

            $this->lineMessengerServices->sendMonthlyFeeMessage();

            $viewFile = 'emails.reservations.cancel';
            $subject = '予約をキャンセルしました';
            $this->mailService->sendMailToUser($messageData, $viewFile, $subject);

            $this->googleCalendarService->delete($reservation->id);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'message' => '予約をキャンセルしました。'
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUserReservations()
    {
        $user = $this->userService->getLoginUser();
        $reservations = $this->reservationService->getUserReservations($user->id);

        return response()->json([
            'success' => true,
            'data' => $reservations,
        ]);
    }
}
