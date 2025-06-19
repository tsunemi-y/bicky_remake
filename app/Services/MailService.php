<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailService
{
    /**
     * 従業員へのメール
     * @param $param
     */
    public function sendMailToVendor($params)
    {
        // メールデータ作成
        $mailData = [];
        foreach ($params as $key => $value) {
            $mailData[$key] = $value;
        };

        Mail::send(
            ['text' => 'emails.reservations.vendor'],
            $mailData,
            function ($message) {
                $message
                    ->to('tatataabcd@gmail.com')
                    ->subject("予約を受け付けました");
            }
        );
    }

    /**
     * 利用者へのメール
     * @param $params
     */
    public function sendMailToUser($params, $viewFile, $subject, $attachFile = null)
    {
        // メールデータ作成
        $mailData = [];
        foreach ($params as $key => $value) {
            $mailData[$key] = $value;
        }

        // $params['email']が存在しない、またはnullの場合にエラーになる可能性があります
        if (empty($params['email'])) {
            // エラー内容をログに記録するか、例外を投げる
            Log::error('メール送信先(email)が指定されていません。', ['params' => $params]);
            throw new \InvalidArgumentException('メール送信先(email)が指定されていません。');
        }

        Mail::send(
            ['text' => $viewFile],
            $mailData,
            function ($message) use ($params, $subject, $attachFile) {
                $message->to($params['email'])->subject($subject);
                if (!empty($attachFile)) {
                    // ファイルパスが正しいかどうかも要注意
                    $filePath = storage_path($attachFile);
                    if (file_exists($filePath)) {
                        $message->attach($filePath);
                    } else {
                        // 添付ファイルが存在しない場合はログに記録
                        Log::warning('添付ファイルが存在しません: ' . $filePath);
                    }
                }
            }
        );
    }
}
