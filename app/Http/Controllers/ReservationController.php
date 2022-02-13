<?php

namespace App\Http\Controllers;

use \Yasumi\Yasumi;
use App\Models\User;
use App\Models\Reservation;
use App\Http\Services\MailService;
use App\Http\Traits\Reservationable;

use App\Http\Requests\ReservationCalenderFormRequest;
use App\Http\Requests\ReservationFormRequest;

class ReservationController extends Controller
{
    use Reservationable;
    /**
     * 予約画面表示.
     *
     * @return \Illuminate\Http\Response
     */
    public function dispReservationTop(ReservationCalenderFormRequest $request)
    {
        $calenderInfo = $this->createCalender($request);
        return view('pages.reservations.reservation', compact('calenderInfo'));
    }

    /**
     * カレンダー作成
     */
    public function createCalender($request)
    {

        // 予約可能日時取得
        $tmpAvaDatetimes = $this->getTmpAvailableReservationDatetimes();

        // 予約されている日時取得
        $reserveDateTimes = $this->getReservationDatetimes();

        $avaDatetimes = $this->getAvailableReservationDatetimes($tmpAvaDatetimes, $reserveDateTimes);
        $avaDates = $avaDatetimes['avaDates'];
        $avaTimes = $avaDatetimes['avaDatetimes'];

        // カレンダーに必要な情報取得
        if (!empty($request->ym)) {
            $targetYearMonth = $request->ym;
        } else {
            $targetYearMonth = date('Y-m');
        }

        // カレンダーに必要な情報取得
        $timestamp = strtotime($targetYearMonth . '-01');
        $today = date('Y-m-j');
        $calenderTitle = date('Y年n月', $timestamp);
        $dayCount = date('t', $timestamp);
        $week = date('w', $timestamp);
        $saturdayNum = 6;
        $sundayNum = 0;
        $nowDate = date('Y-m-d');
        $prevMonth = date('Y-m', strtotime('-1 month', $timestamp));
        $nextMonth = date('Y-m', strtotime('+1 month', $timestamp));

        // 祝日取得
        $holidays = Yasumi::create('Japan', '2021', 'ja_JP');

        // カレンダーの中身を格納する変数
        $calenders = [];
        $calender = '';

        $timeList = [];
        $time = '';

        // 初日と曜日の位置調整
        $calender .= str_repeat('<td></td>', $week);

        for ($day = 1; $day <= $dayCount; $day++, $week++) {
            /*============================
                    日付処理　ここから
            ============================*/
            $day = str_pad($day, 2, '0', STR_PAD_LEFT); //　一桁の日の場合、０詰め
            $displayedDate = $targetYearMonth . '-' . $day;

            $isAvailableDate = false;
            if (in_array($displayedDate, $avaDates, true)) $isAvailableDate = true;

            // 条件に応じてクラス付与
            $calender .= '<td ';
            if ($today == $displayedDate) $calender .= 'class="today" ';
            if ($holidays->isHoliday(new \DateTime($displayedDate)) || $week == 0) $calender .= 'class="holiday" ';
            if ($week == $saturdayNum) $calender .= 'class="saturday" ';
            $calender .= '>' . $day;
            if (strtotime($displayedDate) <= strtotime($nowDate) || strtotime($displayedDate) > strtotime("$nowDate +1 months")) {
                $calender .= "<p class='hyphen'>-</p>";
            } else if ($isAvailableDate) {
                $calender .= "<p class='circle day-ok' data-date='$displayedDate'>○</p>";
            } else {
                $calender .= "<p class='cross'>×</p>";
            }

            $calender .= '</td>';
            //月の最終日の後に空セルを追加
            if ($day == $dayCount) $calender .= str_repeat('<td></td>', $saturdayNum - $week);

            //週・月終わりの場合、改行
            if ($week == $saturdayNum || $day == $dayCount) {
                $calenders[] = '<tr>' . $calender . '</tr>';
                $calender = '';
            }
            /*============================
                    日付処理　ここまで
            ============================*/

            if ($week == $saturdayNum) $week = -1; // 土曜日の次は改行
        }
        return compact('calenders', 'calenderTitle', 'prevMonth', 'nextMonth', 'avaTimes');
    }

    public function existsDuplicateReservation($request)
    {
        $reservationModel = new Reservation;

        // 同じ日時に予約があるときはエラー
        $reservedDateTime = $reservationModel
            ->where('reservation_date', $request->avaDate)
            ->where('reservation_time', $request->avaTime)
            ->first();

        return !empty($reservedDateTime);
    }

    /**
     * 予約情報登録
     * @param App\Http\Requests\ReservationFormRequest
     * @return void
     */
    public function createReservation(ReservationFormRequest $request)
    {
        $reservationModel = new Reservation;

        $isReserved = $this->existsDuplicateReservation($request);
        // 指定した日時がすでに埋まっている場合は予約トップにリダイレクト
        if ($isReserved) return redirect(route('reservationTop'))->with('failedReservation', '選択された日時はすでにご予約がございます。</br>違う日時でご予約ください。');

        $userId = \Auth::id();
        $reservedInfo = $reservationModel->create([
            'user_id' => $userId,
            'reservation_date' => $request->avaDate,
            'reservation_time' => $request->avaTime,
        ]);

        $userInfo = User::find($userId);
        $mailData = [
            'childName' => $userInfo->childName,
            'reservationDate' => $request->avaDate,
            'reservationTime' => $request->avaTime,
            'email' => $userInfo->email,
            'reservationId' => $reservedInfo->id,
        ];

        $this->sendReservationMessage($mailData);
        return redirect(route('reservationTop'))
            ->with('successReservation', '予約を受け付けました。</br>予約内容確認のメールをお送りしました。');
    }

    /**
     * 予約メッセージ送信
     * @param $param
     * @return void
     */
    public function sendReservationMessage($params)
    {
        // 日時のフォーマット変更
        $params['reservationTime'] = formatTime($params['reservationTime']);
        $params['reservationDate'] = formatDate($params['reservationDate']);

        // 管理者へLINEメッセージ送信
        $lineMessenger = new LineMessengerController();
        $lineMessenger->sendReservationMessage($params['childName'], $params['reservationDate'], $params['reservationTime']);

        // 利用者へのメールに必要なデータ設定
        $mailService = new MailService();
        $viewFile = 'emails.reservations.user';
        $subject = '予約を受け付けました';
        $mailService->sendMailToUser($params, $viewFile, $subject);
    }

    /**
     * 予約キャンセル画面表示
     * @return void
     */
    public function dispReservationCancel(Reservation $reservation)
    {
        return view('pages.reservations.reservationCancel', compact('reservation'));
    }

    /**
     * 予約キャンセル
     * @param App\Models\Reservation
     * @return void
     */
    public function cancelReservation(Reservation $reservation)
    {
        $reservation->delete();
        return redirect(route('reservationTop'))->with('reservationCancel', '予約をキャンセルしました');
    }
}
