<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AvailableReservationTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvailableReservationDate extends Model
{
    use HasFactory;

    public function availableReservationTimes()
    {
        return $this->hasMany(AvailableReservationTime::class);
    }
}
