<?php

namespace App\Http\Traits;

use App\Models\AvailableReservationDatetime;
use App\Models\Reservation;

trait Reservationable
{
    /**
     * 予約可能日時テーブルから予約可能日時取得
     *
     * @return Array
     */
    public function getTmpAvailableReservationDatetimes()
    {
        $avaReserveDatetimes = AvailableReservationDatetime::get(['id', 'available_date', 'available_time']);
        $avaTimes = [];
        foreach ($avaReserveDatetimes as $avaReserveDateTime) {
            $avaTimes[$avaReserveDateTime->available_date][] = $avaReserveDateTime->available_time;
        }
        return $avaTimes;
    }

    /**
     * 予約テーブルから予約日時取得
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getReservationDatetimes()
    {
        $reservations = Reservation::all();
        $reserveDateTimes = [];
        foreach ($reservations as $reservation) {
            $reserveDateTimes[$reservation->reservation_date][] = $reservation->reservation_time;
        }
        return $reserveDateTimes;
    }

    /**
     * 1. 予約可能日時をループで回す
     * 2. 予約されている日時をループで回す
     * 3. 予約可能日時 - 予約されている日時で予約可能な日時を設定
     *
     * @return Array
     */
    public function getAvailableReservationDatetimes($tmpAvaDatetimes, $reserveDateTimes)
    {
        // 利用可能日時と予約されている時間日時を比較し、被っているものがあれば配列から削除
        $avaDatetimes = [];

        // 予約可能日を配列に格納
        // 下記配列から予約が埋まっている日を削除し画面に表示する
        $avaDates = array_keys($tmpAvaDatetimes);

        foreach ($tmpAvaDatetimes as $avaDate => $avaTimes) {

            // 日付に対応する時間を格納
            $avaDatetimes[$avaDate] = $avaTimes;

            // ビューに表示する日付を設定
            foreach ($reserveDateTimes as $reserveDate => $reserveTimes) {
                if ($avaDate !== $reserveDate) continue;

                // その日の利用可能時間が全て予約で埋まっている場合、対応する日を☓に設定
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
            // 日付に対応する時間配列を再作成（unsetで添字がずれたため）
            // 添字がずれている場合、ビューに渡した配列がオブジェクト形式になってしまう
            $avaDatetimes[$avaDate] = array_values($avaDatetimes[$avaDate]);

            // 時間形式をhh時ss秒に変更
            foreach ($avaDatetimes[$avaDate] as $key => $time) {
                $formattedTime = formatTime($time);
                $avaDatetimes[$avaDate][$key] = $formattedTime; // フォーマット前時間をフォーマット後時間で上書き
            }
        }

        return compact('avaDatetimes', 'avaDates');
    }
}
