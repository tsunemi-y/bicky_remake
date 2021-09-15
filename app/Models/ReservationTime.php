<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_time_from',
        'reservation_time_to',
    ];

    /**
     * 予約時間FROMの取得
     *
     * @param  string  $value
     * @return string
     */
    public function getReservationTimeFromAttribute($value)
    {
        return substr($value, 0, -3);
    }

    /**
     * 予約時間TOの取得
     *
     * @param  string  $value
     * @return string
     */
    public function getReservationTimeToAttribute($value)
    {
        return substr($value, 0, -3);
    }
}
