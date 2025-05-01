<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;

use App\Services\MailService;
use App\Services\ReservationService;
use App\Services\GoogleCalendarService;
use App\Services\LineMessengerServices;
use App\Services\UserService;
use App\Http\Requests\ReservationFormRequest;
use App\Http\Requests\ReservationCalenderFormRequest;

class ReservationController extends Controller
{
    public function __construct(
        private ReservationService $reservationService, 
        private GoogleCalendarService $googleCalendarService,
        private MailService $mailService, 
        private LineMessengerServices $lineMessengerServices,
        private UserService $userService,
    )
    {
    }

    public function index()
    {
        $user = $this->userService->getLoginUser();

        $availableDatesAndTimes = $this->reservationService->getMappingAvailableDatesAndTimes($user->use_time);

        $children = $this->userService->getChildren($user->id);

        return response()->json(compact('availableDatesAndTimes', 'children'));
    }

    public function store(ReservationFormRequest $request, Reservation $reservation)
    {
        // 指定した日時がすでに埋まっている場合、予約トップにリダイレクト
        $isReserved = $this->reservationService->existsDuplicateReservation($request);
        if ($isReserved) {
            return response()->json([
                'success' => false,
                'message' => '選択された日時はすでにご予約がございます。</br>違う日時でご予約ください。'
            ], 422);
        } 

        $userId = \Auth::id();

        $childIds = $request->childIds;

        $endTime = $this->reservationService->calculateReservationEndTime($request, $userId);

        $reservedInfo = $this->reservationService->createReservation($reservation, $request, $userId, $endTime);

        // 予約と子供の関連付け
        $this->reservationService->attachChildrenToReservation($reservedInfo, $childIds);

        // リクエスト中の利用児idから利用児データ取得
        $selectedChildren = $this->userService->getChildrenByChildIds($childIds);

        // 利用料計算
        $usageFee = $this->reservationService->calculateUsageFee($childIds);

        if ($usageFee === ConstReservation::RESERVATION_NO_FEE) {
            return response()->json([
                'success' => false,
                'message' => '利用児が選択されていません。</br>利用児を選択してください。'
            ], 422);
        }

        $userInfo = User::find($userId);
        
        $messageData = [
            'reservationDate' => formatDate($request->avaDate),
            'reservationTime' => formatTime($request->avaTime),
            'email' => $userInfo->email,
            'reservationId' => $reservedInfo->id,
            // 'usageFee' => $usageFee,
        ];

        // 管理者へ予約通知のLINEメッセージ送信
        $this->lineMessengerServices->sendReservationMessage($messageData['reservationDate'], $messageData['reservationTime'], $selectedChildren, $usageFee);

        $this->lineMessengerServices->sendMonthlyFeeMessage();

        $viewFile = 'emails.reservations.user';
        $subject = '予約を受け付けました';
        $this->mailService->sendMailToUser($messageData, $viewFile, $subject);

        $this->googleCalendarService->store($userInfo->parentName, $request->avaDate. $request->avaTime, $request->avaDate. $endTime, $reservedInfo->id);

        return response()->json([
            'success' => true,
            'message' => '予約を受け付けました。</br>予約内容確認のメールをお送りしました。'
        ]);
    }

    public function show(Reservation $reservation)
    {
        // TODO: エラーハンドリング最適解調査
        return response()->json($reservation);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        $messageData = [
            'reservationDate' => formatDate($reservation->reservation_date),
            'reservationTime' => formatTime($reservation->reservation_time),
            'email'           => $reservation->user->email,
        ];

        // 予約IDから利用児データ取得
        $selectedChildren = $this->reservationService->getChildrenByReservationId($reservation->id);

        // 管理者へ予約キャンセルのLINEメッセージ送信
        $this->lineMessengerServices->sendCancelReservationMessage($messageData['childName'], $messageData['childName2'], $messageData['reservationDate'], $messageData['reservationTime'], $selectedChildren);

        $this->lineMessengerServices->sendMonthlyFeeMessage();

        $viewFile = 'emails.reservations.cancel';
        $subject = '予約をキャンセルしました';
        $this->mailService->sendMailToUser($messageData, $viewFile, $subject);

        $this->googleCalendarService->delete($reservation->id);

        return response()->json([
            'success' => true,
            'message' => '予約をキャンセルしました。'
        ]);
    }
}
