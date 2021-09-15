<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Mail;


class MailService
{
    /**
     * 従業員へのメール
     * @param $param
     */
    public function sendMailVendor($params)
    {
        Mail::send(
            ['text' => 'emails.reservations.vendor'],
            [
                "name"              => $params['name'],
                "age"               => $params['age'],
                "gender"            => $params['gender'],
                "diagnosis"         => $params['diagnosis'],
                "address"           => $params['address'],
                "Introduction"      => $params['Introduction'],
                "email"             => $params['email'],
                "reservation_date"  => $params['reservation_date'],
                "reservation_time"  => $params['reservation_time'],
                "note"              => $params['note'],
            ],
            function ($message) {
                $message
                    ->to('tatataabcd@gmail.com')
                    ->subject("予約を受け付けました");
            }
        );
    }

    /**
     * 利用者へのメール
     * @param $param
     */
    public function sendMailUser($params)
    {
        Mail::send(
            ['text' => 'emails.reservations.user'],
            [
                "name"              => $params['name'],
                "age"               => $params['age'],
                "gender"            => $params['gender'],
                "diagnosis"         => $params['diagnosis'],
                "address"           => $params['address'],
                "Introduction"      => $params['Introduction'],
                "email"             => $params['email'],
                "reservation_date"  => $params['reservation_date'],
                "reservation_time"  => $params['reservation_time'],
                "note"              => $params['note'],
                "id"                => $params['id'],
                "cancel_code"       => $params['cancel_code'],

            ],
            function ($message) use ($params) {
                $message
                    ->to($params['email'])
                    ->subject("予約を受け付けました");
            }
        );
    }
}
