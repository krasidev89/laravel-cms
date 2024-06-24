<?php

namespace App\Jobs;

use App\Models\GoogleAnalyticsLanguage;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class ProcessGoogleAnalyticsLanguage implements ShouldQueue
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
                    'language',
                    'languageCode'
                ],
                offset: $offset
            )->map(function ($row) {
                GoogleAnalyticsLanguage::updateOrCreate([
                    'date' => Carbon::parse($row['date'])->format('Y-m-d'),
                    'name' => $row['language'],
                    'code' => $row['languageCode']
                ], [
                    'visitors' => $row['activeUsers'],
                    'pageviews' => $row['screenPageViews']
                ]);
            });

            $offset += 10;
        } while ($data->isNotEmpty());
    }
}
