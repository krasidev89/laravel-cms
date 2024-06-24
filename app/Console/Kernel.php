<?php

namespace App\Console;

use App\Jobs\ProcessGoogleAnalyticsBrowser;
use App\Jobs\ProcessGoogleAnalyticsDeviceCategory;
use App\Jobs\ProcessGoogleAnalyticsLanguage;
use App\Jobs\ProcessGoogleAnalyticsLocation;
use App\Jobs\ProcessGoogleAnalyticsOperatingSystem;
use App\Jobs\ProcessGoogleAnalyticsOverview;
use App\Jobs\ProcessGoogleAnalyticsUrl;
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

        $schedule->job(new ProcessGoogleAnalyticsOverview(2))->daily();
        $schedule->job(new ProcessGoogleAnalyticsUrl(2))->daily();
        $schedule->job(new ProcessGoogleAnalyticsLocation(2))->daily();
        $schedule->job(new ProcessGoogleAnalyticsLanguage(2))->daily();
        $schedule->job(new ProcessGoogleAnalyticsBrowser(2))->daily();
        $schedule->job(new ProcessGoogleAnalyticsDeviceCategory(2))->daily();
        $schedule->job(new ProcessGoogleAnalyticsOperatingSystem(2))->daily();
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
