<?php

namespace App\Services;

use LINE\LINEBot;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineMessengerServices
{
    private $userId;

    public function __construct(private ReservationRepository $reservationRepository,)
    {
        $this->userId = config('services.line.admin_id');
    }

    // メッセージ送信用
    public function sendMessage($message)
    {
        // LINEBOTSDKの設定
        $httpClient = new CurlHTTPClient(config('services.line.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messenger_secret')]);

        // メッセージ送信
        $textMessageBuilder = new TextMessageBuilder($message);
        $bot->pushMessage($this->userId, $textMessageBuilder);
    }

    // 予約一覧リストのメッセージ作成
    public function sendReservationListMessage()
    {
        $today = date("Y-m-d H:i:s");
        $reservationModel = new Reservation;
        $todayReservationList = $reservationModel->with('user')->where('reservation_date', '=', $today)->oldest('reservation_time')->get();
        if (count($todayReservationList) == 0) {
            $message = '本日の予約者はいません。';
        } else {
            // 本日の予約者がいる場合、名前と時間をスタッフに送信
            $todayReservationListCount = count($todayReservationList);
            $message = '本日の予約者は下記の通りです。' . "\n" . "\n";
            foreach ($todayReservationList as $key => $rsv) {
                $message .= $rsv->user->childName . ': ' . $rsv->reservation_time;
                if (!is_null($rsv->user->childName2)) {
                    $message .= "\n" . $rsv->user->childName2 . ': ' . $rsv->reservation_time;
                }

                if ($todayReservationListCount != $key + 1) {
                    $message .= "\n";
                }
            }
        }

        $this->sendMessage($message);
    }

    // 予約があった場合にメッセージ送信
    public function sendReservationMessage($name, $name2, $reservationDate, $reservationTime, $dateOfBirth)
    {
        $message = 'ご予約を受け付けました。' . "\n" . "\n";

        // TODO：利用時毎回変動あるのでそれを対応できるように
        $message .= "利用児氏名：　{$name}" . 　{$dateOfBirth} "\n";
        if (!empty($name2)) {
            $message .= "利用児2氏名：　{$name2}" . "\n";
        }

        $message .= "予約日時：　{$reservationDate}" . "\n";
        $message .= "予約時間：　{$reservationTime}";

        $this->sendMessage($message);
    }

    // 予約キャンセルがあった場合にメッセージ送信
    public function sendCancelReservationMessage($name, $name2, $reservationDate, $reservationTime)
    {
        $message = 'ご予約がキャンセルされました。' . "\n" . "\n";
        $message .= "利用児氏名：　{$name}" . "\n";
        if (!empty($name2)) $message .= "利用児2氏名：　{$name2}" . "\n";
        $message .= "予約日時：　{$reservationDate}" . "\n";
        $message .= "予約時間：　{$reservationTime}";

        $this->sendMessage($message);
    }

    // 新規登録者のメッセージ作成
    public function sendRegistrationMessage($user)
    {
        $message = '新規登録を受付ました。' . "\n" . "\n";
        $message .= "保護者氏名：　$user->parentName" . "\n";
        $message .= "保護者氏名（フリガナ）：　$user->parent_name_kana" . "\n";
        $message .= "メールアドレス：　$user->email" . "\n";
        $message .= "電話番号：　$user->tel" . "\n";
        $message .= "利用児氏名：　$user->childName" . "\n";
        $message .= "利用児氏名（フリガナ）：　$user->child_name_kana" . "\n";
        $message .= "年齢：　$user->age" . "\n";
        $message .= "性別：　$user->gender" . "\n";
        $message .= "LINE相談：　" . ($user->line_consultation_flag ? 'あり' : 'なし') . "\n";
        if (!empty($user->diagnosis)) $message .= "診断名：　$user->diagnosis" . "\n";
        if (!empty($user->childName2)) $message .= "利用児氏名2：　$user->childName2" . "\n";
        if (!empty($user->child_name2_kana)) $message .= "利用児氏名2（フリガナ）：　$user->child_name2_kana" . "\n";
        if (!empty($user->age2)) $message .= "年齢2：　$user->age2" . "\n";
        if (!empty($user->gender2)) $message .= "性別2：　$user->gender2" . "\n";
        if (!empty($user->diagnosis2)) $message .= "診断名2：　$user->diagnosis2" . "\n";
        if (!empty($user->introduction)) $message .= "紹介先：　$user->introduction" . "\n";
        if (!empty($user->consaltation)) $message .= "相談内容：　$user->consaltation" . "\n";
        $message .= "住所：　$user->address";
        
        $this->sendMessage($message);
    }

    // 月の利用料集計
    public function sendMonthlyFeeMessage()
    {
        $monthlityFeeCount = $this->reservationRepository->getMonthlyFee();
        $fee = number_format($monthlityFeeCount);

        $message = "今月の売り上げは、{$fee}円です。";

        $this->sendMessage($message);
    }
}
