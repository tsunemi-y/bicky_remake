<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AvailableReservationDatetime;
use App\Models\Reservation;

class deleteDataYesterday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rsv:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '前日以降の予約と利用可能日時のレコードを削除';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 前日以前の予約・利用可能日時データを削除
     * ※レコード数削減のため、不必要なレコード削除
     *
     * @return int
     */
    public function handle()
    {
        $reservationModel = new Reservation();
        $availableReservationDatetime = new AvailableReservationDatetime();
        $today = date("Y/m/d H:i:s");

        $reservationModel->where('reservation_date', '<', $today)->delete();
        $availableReservationDatetime->where('available_date', '<', $today)->delete();
    }
}
