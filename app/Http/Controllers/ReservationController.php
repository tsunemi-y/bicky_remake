<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationFormRequest;
use App\Http\Requests\CancelCodeAuthFormRequest;
use App\Http\Services\MailService;
use App\Models\Reservation;
use App\Models\ReservationTime;
use Illuminate\Http\Request;
use \Yasumi\Yasumi;
use Illuminate\Support\Facades\Cookie;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dispReservationTop(Request $request)
    {
        $calenderInfo = $this->createCalender($request);
        return view('pages.reservations.reservation', compact('calenderInfo'));
    }

    /**
     * カレンダー作成
     */
    public function createCalender($request)
    {

        // 予約テーブル情報取得
        $reservationModel = new Reservation;
        $reservations = $reservationModel->getReservations();
        $reservationDateList = array_column($reservations, 'reservation_date');

        // 予約時間情報取得
        $reservationTimes = ReservationTime::all()->toArray();
        $reservationTimesCount = count($reservationTimes);

        // カレンダーに必要な情報取得
        if (!empty($request->ym)) {
            $targetYearMonth = $request->ym;
        } else {
            $targetYearMonth = date('Y-m');
        }
        $timestamp = strtotime($targetYearMonth . '-01');
        $today = date('Y-m-j');
        $calenderTitle = date('Y年n月', $timestamp);
        $dayCount = date('t', $timestamp);
        $week = date('w', $timestamp);
        $saturdayNum = 6;
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
            $date = $targetYearMonth . '-' . $day;

            // 同日の予約可能時間が埋まっている場合、予約済みフラグ設定
            $targetDateReservationCount = count($reservationModel->where('reservation_date', '=', $date)->get());
            $reservedFlag = false;
            if ($targetDateReservationCount == $reservationTimesCount) $reservedFlag == true;

            // 条件に応じてクラス付与
            $calender .= '<td ';
            if ($today == $date) $calender .= 'class="today" ';
            if ($holidays->isHoliday(new \DateTime($date)) || $week == 0) $calender .= 'class="holiday" ';
            if ($week == $saturdayNum) $calender .= 'class="saturday" ';
            if ($reservedFlag) $calender .= 'class="reserved" ';
            $calender .= '>' . $day;
            if ($reservedFlag) {
                $calender .= "<p class='cross'>×</p>";
            } else if (strtotime($date) <= strtotime($nowDate) || strtotime($date) > strtotime("$nowDate +1 months")) {
                $calender .= "<p class='hyphen'>-</p>";
            } else {
                $calender .= "<p class='circle day-ok' data-day='day-$day'>○</p>";
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

            /*============================
                    時間処理　ここから
            ============================*/
            $reservatedTimeList = array_column($reservations, 'reservation_datetime');
            $time .= "<table class='reserv-table day-$day time-hide time-status'>";
            $time .= "<caption>時間選択<span style='padding-left: 1rem'>$day<span>日<span></span></caption> ";
            $time .= "<thead> ";
            $time .= "<tr> ";
            foreach ($reservationTimes as $reservationTime) {
                $reservationTimeFrom = $reservationTime['reservation_time_from'];
                $reservationTimeTo = $reservationTime['reservation_time_to'];

                $time .= "<th> ";
                $time .= "<span class='table-time reserve-time' data-reserveTime='$reservationTimeFrom'>$reservationTimeFrom</span> ";
                $time .= "<span class='table-time'>~</span> ";
                $time .= "<span class='table-time'>$reservationTimeTo</span> ";
                $time .= "</th> ";
            }
            $time .= "</tr> ";
            $time .= "</thead> ";
            $time .= "<tbody> ";
            $time .= "<tr> ";

            $dateTime = '';
            foreach ($reservationTimes as $reservationTime) {
                $reservationTimeFrom = $reservationTime['reservation_time_from'];
                $dateTime = $date . ' ' . $reservationTimeFrom;
                $reservationCompleteFlag = in_array($dateTime, $reservatedTimeList, true); // 予約済みフラグ

                if ($reservationCompleteFlag) {
                    $time .= "<td ";
                    $time .= "class='cross'>×";
                } else {
                    $time .= "<td ";
                    $time .= "class='circle time-ok' data-target_date='$date' data-target_time='$reservationTimeFrom'>○";
                }
                $time .= "</td>";
            }
            $time .= "</tr> ";
            $time .= "</tbody> ";
            $time .= "</thead> ";
            $time .= "</table> ";

            $timeList[] = $time;
            $time = '';
            /*============================
                    時間処理　ここまで
            ============================*/
            if ($week == $saturdayNum) $week = -1; // 土曜日の次は改行
        }

        return compact('calenders', 'calenderTitle', 'timeList', 'reservationTimes', 'prevMonth', 'nextMonth');
    }

    /**
     * 予約情報登録
     * @param App\Http\Requests\ReservationFormRequest
     * @return void
     */
    public function createReservation(ReservationFormRequest $request)
    {
        $reservationModel = new Reservation;

        $validated = $request->validated();
        $validated['cancel_code'] = base_convert(mt_rand(pow(36, 5 - 1), pow(36, 5) - 1), 10, 36);
        $created = $reservationModel->create($validated)->toArray();

        $this->sendMail($created);
        return redirect(route('top'))->with('successReservation', '予約を受け付けました。</br>予約内容確認のメールをお送りしました。');
    }

    /**
     * メール送信
     * @param App\Http\Requests\ReservationFormRequest
     * @return \Illuminate\Http\Response
     */
    public function sendMail($params)
    {
        $mailService = new MailService();
        $mailService->sendMailVendor($params);

        // 利用者へのメールに必要なデータ設定
        $viewFile = 'emails.reservations.user';
        $subject = '予約を受け付けました';
        $mailService->sendMailToUser($params, $viewFile, $subject);
    }

    /**
     * 予約フォーム表示
     * @param App\Http\Requests\ReservationFormRequest
     * @return \Illuminate\Http\Response
     */
    public function dispReservationForm(Request $request)
    {
        if ($request->modalBtn == 'yes') {
            return view('pages.reservations.reservationForm');
        } else {
            return view('pages.reservations.reservationFormUsed');
        }
    }

    /**
     * キャンセルコード確認画面
     * @param App\Http\Requests\ReservationFormRequest
     * @return \Illuminate\Http\Response
     */
    public function dispCancelCodeVerify()
    {
        return view('pages.reservations.cancelCodeVerify');
    }

    /**
     * キャンセルコード認証
     * @param App\Http\Requests\ReservationFormRequest
     * @return \Illuminate\Http\Response
     */
    public function VerifyCancelCode(CancelCodeAuthFormRequest $request)
    {
        $reservation = Reservation::find($request->id);

        if (empty($reservation->cancel_code)) return redirect(route('dispCancelCodeVerify'))->with('cancelError', 'idが間違っています');

        if ($request->cancel_code != $reservation->cancel_code) return redirect(route('dispCancelCodeVerify'))->with('cancelError', 'キャンセルコードが間違っています');

        Cookie::queue('cancelCodedispFlag', $reservation->cancel_code);
        return redirect(route('dispReservationCancel', ['reservation' => $request->id]));

        // if (!empty($reservation->cancel_code)) {
        //     if ($request->cancel_code == $reservation->cancel_code) {
        //         Cookie::queue('cancelCodedispFlag', $reservation->cancel_code);
        //         return redirect(route('dispReservationCancel', ['reservation' => $request->id]));
        //     } else {
        //         return redirect(route('dispCancelCodeVerify'))->with('cancelError', 'キャンセルコードが間違っています');
        //     }
        // } else {
        //     return redirect(route('dispCancelCodeVerify'))->with('cancelError', 'idが間違っています');
        // }
    }

    /**
     * 予約キャンセル画面表示
     * @param App\Http\Requests\ReservationFormRequest
     * @return \Illuminate\Http\Response
     */
    public function dispReservationCancel(Reservation $reservation)
    {
        $cookie = Cookie::get('cancelCodedispFlag');
        if ($reservation->cancel_code == $cookie) {
            return view('pages.reservations.reservationCancel', compact('reservation'));
        } else {
            return redirect(route('dispCancelCodeVerify'));
        }
    }

    /**
     * 予約キャンセル
     * @param App\Http\Requests\ReservationFormRequest
     * @return \Illuminate\Http\Response
     */
    public function cancelReservation(Reservation $reservation)
    {
        $reservation->delete();
        return redirect(route('top'))->with('successCancel', '予約をキャンセルしました');
    }
}
