<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateHeroku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heroku:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '30分周期のスリープを回避するため、定期的にPGを動かす';

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
    }
}
