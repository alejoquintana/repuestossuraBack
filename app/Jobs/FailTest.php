<?php

namespace App\Jobs;

use App\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\TelegramNotificationLog;
use Throwable;

class FailTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Config::find(999)->delete(); // FAIL
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
    */
    public function failed(Throwable $exception){
        $notification = 'Failed Job - FailTest';
        TelegramNotificationLog::telegramNotifySupers($notification);
    }
}
