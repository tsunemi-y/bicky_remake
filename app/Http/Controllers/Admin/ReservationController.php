<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\MailService;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReservations(Request $request)
    {
        $reservationModel = new Reservation;
        $reservations = $reservationModel
            ->equalDate($request->reservationDate)
            ->fuzzyName($request->reservationName)
            ->equalId($request->id)
            ->get();
        return $reservations;
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
