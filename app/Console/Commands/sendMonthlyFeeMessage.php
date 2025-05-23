<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LineMessengerServices;
use App\Services\DatetimeService;

class sendMonthlyFeeMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'line:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '月の合計売上送信';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private LineMessengerServices $lineMessengerServices,
        private DatetimeService $datetimeServices
    )
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
        // 月末じゃなければ終了
        if (!$this->datetimeServices->checkLastDayOfMonth()) {
            return;
        }
        
        $this->lineMessengerServices->sendMonthlyFeeMessage();
    }
}
