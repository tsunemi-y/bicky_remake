<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Mail;


class MailService
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail($request)
    {
        Mail::send(
            ['text' => 'emails.reservation'],
            [
                "name"         => $request->name,
                "age"          => $request->age,
                "gender"       => $request->gender,
                "diagnosis"    => $request->diagnosis,
                "address"      => $request->address,
                "Introduction" => $request->Introduction,
                "email"        => $request->email,
                "date"         => $request->date,
                "time"         => $request->time,
                "note"         => $request->note,
            ],
            function ($message) {
                $message
                    ->to('tatataabcd@gmail.com')
                    ->subject("予約を受け付けました");
            }
        );
    }
}
