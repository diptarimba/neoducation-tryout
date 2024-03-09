<?php

namespace App\Console\Commands;

use App\Http\Controllers\SchedulerController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testswitch:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $scheduler = new SchedulerController();
        Log::info($scheduler->start_test());
        Log::info($scheduler->end_test());
    }
}
