<?php

namespace App\Http\Controllers;

use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use App\Models\Reservation;

class LineMessengerController extends Controller
{
    // メッセージ送信用
    public function sendMessage($userId, $message)
    {

        // LINEBOTSDKの設定
        $httpClient = new CurlHTTPClient(config('services.line.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messenger_secret')]);

        // メッセージ送信
        $textMessageBuilder = new TextMessageBuilder($message);
        $bot->pushMessage($userId, $textMessageBuilder);
    }

    // 予約一覧リストのメッセージ作成
    public function sendReservationListMessage()
    {
        $userId = config('services.line.admin_id');
        $today = date("Y-m-d H:i:s");
        $reservationModel = new Reservation;
        $todayReservationList = $reservationModel->where('reservation_date', '=', $today)->get();
        if (count($todayReservationList) == 0) {
            $message = '本日の予約者はいません。';
        } else {
            // 本日の予約者がいる場合、名前と時間をスタッフに送信
            $todayReservationListCount = count($todayReservationList);
            $message = '本日の予約者は下記の通りです。' . "\n" . "\n";
            foreach ($todayReservationList as $key => $rsv) {
                $message .= $rsv->name . ': ' . $rsv->reservation_time;

                if ($todayReservationListCount != $key + 1) {
                    $message .= "\n" . "\n";
                }
            }
        }

        $this->sendMessage($userId, $message);
    }

    // 予約があった場合にメッセージ送信
    public function sendReservationMessage($name, $reservationDate, $reservationTime)
    {
        $userId = config('services.line.admin_id');

        $message = 'ご予約を受け付けました。' . "\n" . "\n";
        $message .= "利用児氏名：　{$name}" . "\n";
        $message .= "予約日時：　{$reservationDate}" . "\n";
        $message .= "予約時間：　{$reservationTime}";

        $this->sendMessage($userId, $message);
    }

    // 新規登録者のメッセージ作成
    public function sendRegistrationMessage()
    {
        $userId = config('services.line.admin_id');
        $today = date("Y-m-d H:i:s");
        $reservationModel = new Reservation;
        $todayReservationList = $reservationModel->where('reservation_date', '=', $today)->get();
        if (count($todayReservationList) == 0) {
            $message = '本日の予約者はいません。';
        } else {
            // 本日の予約者がいる場合、名前と時間をスタッフに送信
            $todayReservationListCount = count($todayReservationList);
            $message = '本日の予約者は下記の通りです。' . "\n" . "\n";
            foreach ($todayReservationList as $key => $rsv) {
                $message .= $rsv->name . ': ' . $rsv->reservation_time;

                if ($todayReservationListCount != $key + 1) {
                    $message .= "\n" . "\n";
                }
            }
        }

        $this->sendMessage($userId, $message);
    }
}
