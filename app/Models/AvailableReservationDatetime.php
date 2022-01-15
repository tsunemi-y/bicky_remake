<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableReservationDatetime extends Model
{
    protected $fillable = [
        'available_time',
        'available_date',
    ];
}
