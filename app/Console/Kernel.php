<?php

namespace App\Console;

use App\Models\NotificationSetting;
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

        $upcomming = NotificationSetting::where('notification', "upcoming_due_mail")->first();
        $overdues_mail = NotificationSetting::where('notification', "overdues_mail")->first();
        if ($time) {
            if ($upcomming->status == true) {

                $schedule->command('app:send-upcomming-dues-mail')
                    ->dailyAt($time)
                    ->withoutOverlapping();
            }

            if ($overdues_mail->status == true) {

                $schedule->command('app:send-over-dues-mail')
                    ->dailyAt($time)
                    ->withoutOverlapping();
            }
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
