<?php

namespace App\Jobs;

use App\Models\GoogleAnalyticsOperatingSystem;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class ProcessGoogleAnalyticsOperatingSystem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $period;

    /**
     * Create a new job instance.
     */
    public function __construct($days)
    {
        $this->period = Period::days($days);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $offset = 0;

        do {
            $data = Analytics::get(
                $this->period,
                metrics: [
                    'activeUsers',
                    'screenPageViews'
                ],
                dimensions: [
                    'date',
                    'operatingSystem',
                    'operatingSystemVersion'
                ],
                offset: $offset
            )->map(function ($row) {
                GoogleAnalyticsOperatingSystem::updateOrCreate([
                    'date' => Carbon::parse($row['date'])->format('Y-m-d'),
                    'name' => $row['operatingSystem'],
                    'version' => $row['operatingSystemVersion']
                ], [
                    'visitors' => $row['activeUsers'],
                    'pageviews' => $row['screenPageViews']
                ]);
            });

            $offset += 10;
        } while ($data->isNotEmpty());
    }
}
