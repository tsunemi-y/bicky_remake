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
        $i = 0;
        foreach ($reservations as $reservation) {
            $reserveDateTimes[$reservation->reservation_date][$i]['start_time'] = $reservation->reservation_time;
            $reserveDateTimes[$reservation->reservation_date][$i]['end_time'] = $reservation->end_time;
            $i++;
        }
        return $reserveDateTimes;
    }

    /**
     * 利用可能時間と予約時間から画面に表示される利用可能時間を取得
     * 1. 予約可能日時をループで回す
     * 2. 予約されている日時をループで回す
     * 3. 予約可能日時 - 予約されている日時で予約可能な日時を設定
     *
     * @return Array
     */
    public function getAvailableReservationDatetimes($tmpAvaDatetimes, $reserveDateTimes)
    {
        $avaDates = array_keys($tmpAvaDatetimes);
        $avaDatetimes = [];

        foreach ($tmpAvaDatetimes as  $avaDate => $avaTimes) {
            if (!isset($reserveDateTimes[$avaDate])) continue; // 予約配列に利用可能配列の日付がない場合、スキップ
            foreach ($reserveDateTimes[$avaDate] as $rsvTime) {
                foreach ($avaTimes as $avaTime) {
                    if ($rsvTime['start_time'] <= $avaTime && $avaTime < $rsvTime['end_time']) {
                        $deleteTimeKey = array_search($avaTime, $tmpAvaDatetimes[$avaDate]);
                        unset($tmpAvaDatetimes[$avaDate][$deleteTimeKey]);
                    }
                }
            }

            $avaDatetimes[$avaDate] = $tmpAvaDatetimes[$avaDate];
            $avaDatetimes[$avaDate] = array_values($avaDatetimes[$avaDate]); // 配列順序並び替え

            // 時間形式をhh時ss秒に変更
            foreach ($avaDatetimes[$avaDate] as $key => $time) {
                $formattedTime = formatTime($time);
                $avaDatetimes[$avaDate][$key] = $formattedTime; // フォーマット前時間をフォーマット後時間で上書き
            }

            // 時間を持っていない日付を削除
            if (empty($tmpAvaDatetimes[$avaDate])) {
                $deleteDateKey = array_search($avaDate, $avaDates);
                unset($avaDates[$deleteDateKey]);
            }
        }

        return compact('avaDatetimes', 'avaDates');
    }
}
