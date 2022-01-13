<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\sendQuotes::class,
        \App\Console\Commands\sendFixtures::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send-quotes')
        ->dailyAt('05:00')
        ->timezone('Asia/Bangkok');
        $schedule->command('send-fixtures')
        ->dailyAt('19:00')
        ->timezone('Asia/Bangkok');
    }
}
