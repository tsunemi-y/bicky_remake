<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\LineMessengerController;

class SendReservationListToLine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'line:rsv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '当日の予約者リストをラインに送信';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lineMessenger = new LineMessengerController();
        $lineMessenger->sendReservationListMessage();
    }
}
