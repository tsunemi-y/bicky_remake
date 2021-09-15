<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'email',
        'diagnosis',
        'address',
        'introduction',
        'reservation_date',
        'reservation_time',
        'cancel_code',
    ];

    public function getReservations()
    {
        // 予約情報取得
        $sql = <<<SQL
            SELECT 
                name,
                age,
                gender,
                email,
                diagnosis,
                address,
                introduction,
                reservation_date,
                CONCAT(reservation_date, ' ', to_char(reservation_time, 'hh24:mm')) as reservation_datetime
            FROM reservations
        SQL;

        $reservations = DB::select($sql);
        return $reservations;
    }

    /**
     * 予約時間の取得
     *
     * @param  string  $value
     * @return string
     */
    public function getReservationTimeAttribute($value)
    {
        return substr($value, 0, -3);
    }
}
