<?php

namespace App\Console;

use App\Models\OrganizationSetting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('app:send-upcomming-dues-mail')->dailyAt('15:04');

        // $schedule->command('app:send-upcomming-dues-mail')->everyMinute();


        $time = OrganizationSetting::where('key', 'auto_notify')
            ->value('value'); // e.g. "15:01"

        if ($time) {
            $schedule->command('app:send-upcomming-dues-mail')
                ->dailyAt($time)
                ->withoutOverlapping();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
