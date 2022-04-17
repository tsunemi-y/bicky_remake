<?php

namespace App\Http\Controllers\Admin;

use \Yasumi\Yasumi;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Consts\ConstReservation;
use App\Http\Services\MailService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Traits\Reservationable;
use App\Models\AvailableReservationDatetime;
use App\Http\Requests\CreateAvailableFormRequest;

class ReservationController extends Controller
{
    use Reservationable;

    /**
     * 予約画面表示
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getReservations()
    {
        $reservationModel = new Reservation;

        // 予約可能日時取得
        $avaTimes = $this->getTmpAvailableReservationDatetimes();

        //======予約情報取得　ここから======
        $tmpReservations = $reservationModel
            ->join('users', 'reservations.user_id', 'users.id')
            ->orderBy('reservation_date', 'asc')
            ->orderBy('reservation_time', 'asc')
            ->get(['parentName', 'reservation_date', 'reservation_time']);

        $reservations = [];
        foreach ($tmpReservations as $tr) {
            $reservations[$tr->reservation_date][] = [
                'reservationName' => $tr->parentName,
                'reservationTime' => $tr->reservation_time
            ];
        }
        //======予約情報取得　ここまで======

        // 祝日取得
        $holidays = Yasumi::create('Japan', date('Y'), 'ja_JP');
        $holidays = array_values($holidays->getHolidayDates());

        return compact('avaTimes', 'reservations', 'holidays');
    }

    /**
     * 利用可能日時登録
     *
     * @param \Illuminate\Http\Request
     * @return void
     */
    public function saveDatetime(CreateAvailableFormRequest $request)
    {
        $datetime = $request['datetime'];
        $date = substr($datetime, 0, 10);
        $time = substr($datetime, 11, 15);

        $avaRsvDatetimeModel = new AvailableReservationDatetime();

        // 一括ボタン押下時、一括登録
        if ($request['isBulkMonth']) {
            // 祝日取得
            $holidays = Yasumi::create('Japan', date('Y'), 'ja_JP');
            $monthCount = date('t', strtotime($date));
            $dateNotDay = substr($date, 0, 8); // 例）2022/05/
            $insertDatetimeList = [];

            for ($i = 1; $i <= $monthCount; $i++) {
                if ($holidays->isHoliday(new \DateTime($dateNotDay . $i))) continue;
                foreach (ConstReservation::AVAILABLE_TIME_LIST as $time) {
                    $insertDatetimeList[] = [
                        'available_date' => $dateNotDay . $i,
                        'available_time' => $time,
                    ];
                }
            }
            DB::table('available_reservation_datetimes')->insert($insertDatetimeList);
        } elseif ($request['isBulkDay']) {
            $insertDatetimeList = [];
            foreach (ConstReservation::AVAILABLE_TIME_LIST as $time) {
                $insertDatetimeList[] = [
                    'available_date' => $date,
                    'available_time' => $time,
                ];
            }
            DB::table('available_reservation_datetimes')->insert($insertDatetimeList);
        } else {
            $avaRsvDatetimeModel->create([
                'available_date' => $date,
                'available_time' => $time,
            ]);
        }
    }

    /**
     * 利用可能日時削除　todo: バリデ
     * @param \Illuminate\Http\Request
     * @return void
     */
    public function deleteDatetime(Request $request)
    {
        $time = date('H:i:s', strtotime(str_replace(['時', '分'], [':', ''], $request['time']))); // フロントから送られる形式は〇〇時〇〇分なので変換

        $avaDateId = AvailableReservationDatetime::where('available_date', $request['date'])
            ->where('available_time', $time)
            ->get('id')
            ->toArray()[0]['id'];

        AvailableReservationDatetime::where('id', $avaDateId)->delete();
    }

    // /**
    //  * 領収書送信するためのユーザ情報取得
    //  */
    // public function getUserInfoSendReciept(Request $request)
    // {
    //     $reservationModel = new Reservation;
    //     $reservations = $reservationModel
    //         ->joinUsers()
    //         ->equalDate($request->reservationDate)
    //         ->fuzzyName($request->reservationName)
    //         ->equalId($request->id)
    //         ->get(['reservations.id as id', 'parentName', 'reservation_date', 'reservation_time', 'email', 'fee']);
    //     return $reservations;
    // }

    // /**
    //  * 領収書送信 todo：　共通化　評価表も送るため pdfじゃないと送れないようにバリで
    //  * @param Illuminate\Http\Request
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function sendReceipt(Request $request)
    // {
    //     // パラメータ設定
    //     $args = [
    //         "name"              => $request->name,
    //         "email"             => $request->email,
    //         "fee"               => $request->fee,
    //     ];

    //     // メールデータ作成
    //     $date = str_replace('-', '', $args['reservation_date']);
    //     $viewFile = 'admin.emails.receipt';
    //     $subject = '領収書のご送付';
    //     $attachFile = "app/領収書_{$date}.pdf";

    //     // 領収書を出力し、ストレージに配置
    //     $pdf = \PDF::loadView('admin/emails/receiptPdf', $args);
    //     $downloadedPdf = $pdf->output();
    //     file_put_contents(storage_path("app/領収書_{$date}.pdf"), $downloadedPdf);

    //     // 領収書送信
    //     $mailService = new MailService();
    //     $mailService->sendMailToUser($args, $viewFile, $subject, $attachFile);

    //     // 領収書削除
    //     unlink(storage_path("app/領収書_{$date}.pdf"));
    // }
}
