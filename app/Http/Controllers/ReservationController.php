<?php

namespace App\Http\Controllers;

use \Yasumi\Yasumi;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationTime;
use App\Http\Services\MailService;
use Illuminate\Support\Facades\Cookie;
use App\Models\AvailableReservationTime;
use App\Http\Requests\ReservationFormRequest;
use App\Http\Requests\CancelCodeAuthFormRequest;
use Illuminate\Support\Facades\DB;

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
     * 予約可能日時テーブルから予約可能日時取得
     *
     * @return Array
     */
    private function getTmpAvailableReservationDatetimes()
    {
        $availableReservationDates = DB::table('available_reservation_dates as dates');
        $avaReserveDatetimes = $availableReservationDates
            ->join('available_reservation_times as times', 'dates.id', 'times.available_reservation_date_id')
            ->get(['dates.available_date', 'times.available_time']);
        $avaTimes = [];
        foreach ($avaReserveDatetimes as $avaReserveDateTime) {
            $avaTimes[$avaReserveDateTime->available_date][] = $avaReserveDateTime->available_time;
        }
        return $avaTimes;
    }

    /**
     * 重複しない日付をキー、日付に対応した値を配列である連想配列を取得
     *
     * @return Array
     */
    public function getAvailableReservationDatetimes($tmpAvaDatetimes, $reserveDateTimes)
    {
        // 利用可能日時と予約されている時間日時を比較し、被っているものがあれば配列から削除
        $avaDatetimes = [];
        $avaDates = array_keys($tmpAvaDatetimes);

        foreach ($tmpAvaDatetimes as $avaDate => $avaTimes) {
            $avaDatetimes[$avaDate] = $avaTimes;

            // ビューに表示する日付を設定
            foreach ($reserveDateTimes as $reserveDate => $reserveTimes) {
                if ($avaDate !== $reserveDate) continue;
                if (count($avaTimes) === count($reserveTimes)) {
                    $keysDeleteTargetDate = array_search($avaDate, $avaDates);
                    unset($avaDates[$keysDeleteTargetDate]);
                }

                // ビューに表示する日付に紐づく時間を設定
                foreach ($reserveTimes as $reserveTime) {
                    $keyDeleteTargetTime = array_search($reserveTime, $avaDatetimes[$avaDate]);
                    if ($keyDeleteTargetTime == '') continue;
                    unset($avaDatetimes[$avaDate][$keyDeleteTargetTime]);
                }
            }
        }

        return compact('avaDatetimes', 'avaDates');
    }

    /**
     * 予約テーブルから予約日時取得
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function getReservationDatetimes()
    {
        $reservations = Reservation::all();
        $reserveDateTimes = [];
        foreach ($reservations as $reservation) {
            $reserveDateTimes[$reservation->reservation_date][] = $reservation->reservation_time;
        }
        return $reserveDateTimes;
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
            if ($isAvailableDate) {
                $calender .= "<p class='circle day-ok' data-date='$displayedDate'>○</p>";
            } else if (strtotime($displayedDate) <= strtotime($nowDate) || strtotime($displayedDate) > strtotime("$nowDate +1 months")) {
                $calender .= "<p class='hyphen'>-</p>";
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

    /**
     * 予約情報登録
     * @param App\Http\Requests\ReservationFormRequest
     * @return void
     */
    public function createReservation(Request $request)
    {
        // todo
        // ログイン機能実装
        // ユーザID取得
        // 非ログイン者は処理終了
        // ユーザID・日・時間をインサート
        $reservationModel = new Reservation;

        // 同じ日時に予約があるときはエラー
        $reservedDate = $reservationModel
            ->where('reservation_date', $request->reservation_date)
            ->where('reservation_time', $request->reservation_time)
            ->first();

        if (!empty($reservedDate)) {
            return redirect(route('reservationTop'))
                ->with('differentReservation', '違う日時でご予約ください。');
        }

        $validated = $request->validated();
        $validated['cancel_code'] = base_convert(mt_rand(pow(36, 5 - 1), pow(36, 5) - 1), 10, 36);
        $created = $reservationModel->create($validated)->toArray();

        $this->sendMail($created);
        return redirect(route('top'))
            ->with('successReservation', '予約を受け付けました。</br>予約内容確認のメールをお送りしました。');
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
