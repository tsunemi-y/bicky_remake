<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AvailableReservationDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvailableReservationTime extends Model
{
    use HasFactory;

    public function availableReservationDate()
    {
        return $this->belongsTo(AvailableReservationDate::class);
    }
}
