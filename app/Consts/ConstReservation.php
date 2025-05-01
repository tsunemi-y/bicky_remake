<?php

namespace App\Consts;

class ConstReservation
{

    // 予約可能時間リスト
    public const AVAILABLE_TIME_LIST = [
        '10:00',
        '11:00',
        '13:00',
        '14:00',
    ];

    // 利用料
    public const RESERVATION_FEE_ONE_CHILD = 8800;
    public const RESERVATION_FEE_TWO_CHILD = 13200;
    public const RESERVATION_FEE_THREE_CHILD = 19800;
    public const RESERVATION_NO_FEE = 0;
}
