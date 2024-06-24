<?php

namespace App\Jobs;

use App\Models\GoogleAnalyticsOverview;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class ProcessGoogleAnalyticsOverview implements ShouldQueue
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
                    'deviceCategory',
                    'operatingSystem',
                    'browser',
                    'continent',
                    'country',
                    'city'
                ],
                offset: $offset
            )->map(function ($row) {
                GoogleAnalyticsOverview::updateOrCreate([
                    'date' => Carbon::parse($row['date'])->format('Y-m-d'),
                    'device_category' => $row['deviceCategory'],
                    'operating_system' => $row['operatingSystem'],
                    'browser' => $row['browser'],
                    'continent' => $row['continent'],
                    'country' => $row['country'],
                    'city' => $row['city']
                ], [
                    'visitors' => $row['activeUsers'],
                    'pageviews' => $row['screenPageViews']
                ]);
            });

            $offset += 10;
        } while ($data->isNotEmpty());
    }
}
