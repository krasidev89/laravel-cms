<?php

namespace Database\Seeders;

use App\Models\GoogleAnalyticsBrowser;
use App\Models\GoogleAnalyticsDeviceCategory;
use App\Models\GoogleAnalyticsLanguage;
use App\Models\GoogleAnalyticsLocation;
use App\Models\GoogleAnalyticsOperatingSystem;
use App\Models\GoogleAnalyticsOverview;
use App\Models\GoogleAnalyticsUrl;
use App\Models\Project;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoogleAnalyticsSeeder extends Seeder
{
    const SUB_DAYS = 10;

    const LOCATIONS = [
        [
            'continent' => 'Europe',
            'country' => 'Bulgaria',
            'city' => '(not set)'
        ], [
            'continent' => 'Europe',
            'country' => 'Bulgaria',
            'city' => 'Sofia'
        ], [
            'continent' => 'Europe',
            'country' => 'Ireland',
            'city' => 'Dublin'
        ]
    ];

    const LANGUAGES = [
        [
            'name' => 'Bulgarian',
            'code' => 'bg'
        ], [
            'name' => 'Bulgarian',
            'code' => 'bg-bg'
        ], [
            'name' => 'English',
            'code' => 'en-us'
        ]
    ];

    const BROWSERS = [
        [
            'name' => 'Firefox'
        ], [
            'name' => 'Chrome'
        ], [
            'name' => 'Internet Explorer'
        ], [
            'name' => 'Edge'
        ]
    ];

    const OPERATING_SYSTEMS = [
        [
            'name' => 'Windows',
            'version' => '10'
        ], [
            'name' => 'Windows',
            'version' => '7'
        ], [
            'name' => 'Linux',
            'version' => 'x86_64'
        ], [
            'name' => 'Android',
            'version' => '7.1.1'
        ]
    ];

    const DEVICE_CATEGORIES = [
        [
            'name' => 'desktop'
        ], [
            'name' => 'mobile'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();

        if ($projects->isNotEmpty()) {
            $startDate = Carbon::now()->subDays(self::SUB_DAYS)->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
            $period = CarbonPeriod::create($startDate, $endDate);
            $countLocations = count(self::LOCATIONS) - 1;
            $countLanguages = count(self::LANGUAGES) - 1;
            $countBrowsers = count(self::BROWSERS) - 1;
            $countOperatingSystems = count(self::OPERATING_SYSTEMS) - 1;
            $countDeviceCategories = count(self::DEVICE_CATEGORIES) - 1;

            foreach ($period as $date) {
                $sumVisitors = 0;
                $sumPageViews = 0;
                $date = $date->format('Y-m-d');
                $location = self::LOCATIONS[rand(0, $countLocations)];
                $language = self::LANGUAGES[rand(0, $countLanguages)];
                $browser = self::BROWSERS[rand(0, $countBrowsers)];
                $operatingSystem = self::OPERATING_SYSTEMS[rand(0, $countOperatingSystems)];
                $deviceCategory = self::DEVICE_CATEGORIES[rand(0, $countDeviceCategories)];

                foreach ($projects as $project) {
                    $visitors = rand(1, 5);
                    $pageViews = rand(10, 20);
                    $sumVisitors += $visitors;
                    $sumPageViews += $pageViews;

                    GoogleAnalyticsUrl::updateOrCreate([
                        'date' => $date,
                        'path' => route('frontend.projects.show', ['project' => $project->slug], false),
                        'title' => $project->name
                    ], [
                        'visitors' => $visitors,
                        'pageviews' => $pageViews
                    ]);
                }

                GoogleAnalyticsOverview::updateOrCreate([
                    'date' => $date,
                    'device_category' => $deviceCategory['name'],
                    'operating_system' => $operatingSystem['name'],
                    'browser' => $browser['name'],
                    'continent' => $location['continent'],
                    'country' => $location['country'],
                    'city' => $location['city']
                ], [
                    'visitors' => $sumVisitors,
                    'pageviews' => $sumPageViews
                ]);

                GoogleAnalyticsLocation::updateOrCreate([
                    'date' => $date,
                    'continent' => $location['continent'],
                    'country' => $location['country'],
                    'city' => $location['city']
                ], [
                    'visitors' => $sumVisitors,
                    'pageviews' => $sumPageViews
                ]);

                GoogleAnalyticsLanguage::updateOrCreate([
                    'date' => $date,
                    'name' => $language['name'],
                    'code' => $language['code']
                ], [
                    'visitors' => $sumVisitors,
                    'pageviews' => $sumPageViews
                ]);

                GoogleAnalyticsBrowser::updateOrCreate([
                    'date' => $date,
                    'name' => $browser['name']
                ], [
                    'visitors' => $sumVisitors,
                    'pageviews' => $sumPageViews
                ]);

                GoogleAnalyticsOperatingSystem::updateOrCreate([
                    'date' => $date,
                    'name' => $operatingSystem['name'],
                    'version' => $operatingSystem['version']
                ], [
                    'visitors' => $sumVisitors,
                    'pageviews' => $sumPageViews
                ]);

                GoogleAnalyticsDeviceCategory::updateOrCreate([
                    'date' => $date,
                    'name' => $deviceCategory['name'],
                ], [
                    'visitors' => $sumVisitors,
                    'pageviews' => $sumPageViews
                ]);
            }
        }
    }
}
