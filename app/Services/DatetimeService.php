<?php

namespace App\Services;

class DatetimeService
{
    public function checkLastDayOfMonth()
    {
        $today = date("Y-m-d");
        $lastDayOfMonth = date("Y-m-t");

        if ($today !== $lastDayOfMonth) {
            return false;
        }

        return true;
    }
}
