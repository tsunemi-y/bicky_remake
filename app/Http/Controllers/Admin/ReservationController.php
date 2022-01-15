<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Services\MailService;
use App\Http\Controllers\Controller;
use App\Http\Traits\Reservationable;
use App\Models\AvailableReservationDate;
use App\Models\AvailableReservationDatetime;

use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    use Reservationable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReservations(Request $request)
    {
        $reservationModel = new Reservation;

        //======予約可能日時取得　ここから======

        // 予約可能日時取得
        $tmpAvaDatetimes = $this->getTmpAvailableReservationDatetimes();
        // 予約されている日時取得
        $reserveDateTimes = $this->getReservationDatetimes();
        $avaDatetimes = $this->getAvailableReservationDatetimes($tmpAvaDatetimes, $reserveDateTimes);

        $avaTimes = $avaDatetimes['avaDatetimes'];

        //======予約可能日時取得　ここまで======

        //======予約情報取得　ここから======
        $tmpReservations = $reservationModel
            ->join('users', 'reservations.user_id', 'users.id')
            ->get(['childName', 'reservation_date', 'reservation_time']);
        $reservations = [];
        foreach ($tmpReservations as $tr) {
            $reservations[$tr->reservation_date] = [
                'reservationName' => $tr->childName,
                'reservationTime' => $tr->reservation_time
            ];
        }
        //======予約情報取得　ここまで======

        return compact('avaTimes', 'reservations');
    }

    /**
     * 利用可能日時登録
     *
     * @param \Illuminate\Http\Request
     */
    public function saveDatetime(Request $request)
    {
        $datetime = $request['datetime'];
        $date = substr($datetime, 0, 10);
        $time = substr($datetime, 11, 15);

        $avaRsvDatetimeModel = new AvailableReservationDatetime();

        $avaRsvDatetimeModel->create([
            'available_date' => $date,
            'available_time' => $time,
        ]);
    }

    /**
     * 利用可能日時削除
     *
     * @param \Illuminate\Http\Request
     */
    public function deleteDatetime(Request $request)
    {
        $avaDateId = AvailableReservationDatetime::where('available_date', $request['date'])
            ->where('available_time', $request['time'])
            ->get('id')
            ->toArray()[0]['id'];

        AvailableReservationDatetime::where('id', $avaDateId)->delete();
    }

    /**
     * 料金更新
     *
     * @return \Illuminate\Http\Response
     */
    public function updateReservation(Request $request, Reservation $reservation)
    {
        $reservation->update([
            'fee' => $request->fee,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReservations(Request $request)
    {
        $reservationModel = new Reservation;

        //======予約可能日時取得　ここから======

        // 予約可能日時取得
        $tmpAvaDatetimes = $this->getTmpAvailableReservationDatetimes();
        // 予約されている日時取得
        $reserveDateTimes = $this->getReservationDatetimes();
        $avaDatetimes = $this->getAvailableReservationDatetimes($tmpAvaDatetimes, $reserveDateTimes);

        $avaTimes = $avaDatetimes['avaDatetimes'];

        //======予約可能日時取得　ここまで======

        //======予約情報取得　ここから======
        $tmpReservations = $reservationModel
            ->join('users', 'reservations.user_id', 'users.id')
            ->get(['childName', 'reservation_date', 'reservation_time']);
        $reservations = [];
        foreach ($tmpReservations as $tr) {
            $reservations[$tr->reservation_date] = [
                'reservationName' => $tr->childName,
                'reservationTime' => $tr->reservation_time
            ];
        }
        //======予約情報取得　ここまで======

        return compact('avaTimes', 'reservations');
    }

    /**
     * 領収書送信
     *
     * @return \Illuminate\Http\Response
     */
    public function sendReceipt(Request $request)
    {
        // パラメータ設定
        $args = [
            "name"              => $request->name,
            "reservation_date"  => $request->date,
            "reservation_time"  => $request->time,
            "email"             => $request->email,
            "fee"               => $request->fee,
        ];

        // メールデータ作成
        $date = str_replace('-', '', $args['reservation_date']);
        $viewFile = 'admin.emails.receipt';
        $subject = '領収書のご送付';
        $attachFile = "pdfs/領収書_{$date}.pdf";

        // 領収書を出力し、ストレージに配置
        $pdf = \PDF::loadView('admin/emails/receiptPdf', $args);
        $downloadedPdf = $pdf->output();
        file_put_contents(storage_path("pdfs/領収書_{$date}.pdf"), $downloadedPdf);

        // 領収書送信
        $mailService = new MailService();
        $mailService->sendMailToUser($args, $viewFile, $subject, $attachFile);

        // 領収書削除
        unlink(storage_path("pdfs/領収書_{$date}.pdf"));
    }
}
