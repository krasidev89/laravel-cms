<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessGoogleAnalyticsBrowser;
use App\Jobs\ProcessGoogleAnalyticsDeviceCategory;
use App\Jobs\ProcessGoogleAnalyticsLanguage;
use App\Jobs\ProcessGoogleAnalyticsLocation;
use App\Jobs\ProcessGoogleAnalyticsOperatingSystem;
use App\Jobs\ProcessGoogleAnalyticsOverview;
use App\Jobs\ProcessGoogleAnalyticsUrl;
use App\Models\GoogleAnalyticsBrowser;
use App\Models\GoogleAnalyticsDeviceCategory;
use App\Models\GoogleAnalyticsLanguage;
use App\Models\GoogleAnalyticsLocation;
use App\Models\GoogleAnalyticsOperatingSystem;
use App\Models\GoogleAnalyticsOverview;
use App\Models\GoogleAnalyticsUrl;
use Illuminate\Http\Request;

class GoogleAnalyticsController extends Controller
{
    protected $days;

    public function __construct()
    {
        $this->days = 2;
    }

    public function overview(Request $request)
    {
        if ($request->ajax()) {
            $overview = GoogleAnalyticsOverview::query();

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $overview->whereBetween('date', [$startDate, $endDate]);
            }

            if ($request->has('highcharts')) {
                $overview->SummaryByDate();

                return [
                    'categories' => $overview->pluck('categories')->toJson(),
                    'visitors' => $overview->pluck('visitors')->toJson(JSON_NUMERIC_CHECK),
                    'pageviews' => $overview->pluck('pageviews')->toJson(JSON_NUMERIC_CHECK)
                ];
            }

            $data = [];
            $overview = $overview->SummaryByDimension()->get();

            foreach ([
                'visitors' => 'Visitors',
                'pageviews' => 'Page Views'
            ] as $metric => $name) {
                $children = [];

                if ($sum = $overview->sum($metric)) {
                    $a = 1 / $sum;

                    $children = $overview->groupBy('device_category')->map(function ($data, $key) use ($metric, $a) {
                        return [
                            'name' => $key . ':',
                            'color' => 'rgba(0, 105, 217, ' . ($a * $data->sum($metric)) . ')',
                            'children' => $data->groupBy('operating_system')->map(function ($data, $key) use ($metric, $a) {
                                return [
                                    'name' => $key . ':',
                                    'color' => 'rgba(0, 105, 217, ' . ($a * $data->sum($metric)) . ')',
                                    'children' => $data->groupBy('browser')->map(function ($data, $key) use ($metric, $a) {
                                        return [
                                            'name' => $key . ':',
                                            'color' => 'rgba(0, 105, 217, ' . ($a * $data->sum($metric)) . ')',
                                            'children' => $data->groupBy('continent')->map(function ($data, $key) use ($metric, $a) {
                                                return [
                                                    'name' => $key . ':',
                                                    'color' => 'rgba(0, 105, 217, ' . ($a * $data->sum($metric)) . ')',
                                                    'children' => $data->groupBy('country')->map(function ($data, $key) use ($metric, $a) {
                                                        return [
                                                            'name' => $key . ':',
                                                            'color' => 'rgba(0, 105, 217, ' . ($a * $data->sum($metric)) . ')',
                                                            'children' => $data->groupBy('city')->map(function ($data, $key) use ($metric, $a) {
                                                                return [
                                                                    'name' => $key . ':',
                                                                    'color' => 'rgba(0, 105, 217, ' . ($a * $data->sum($metric)) . ')',
                                                                    'size' => $data->sum($metric)
                                                                ];
                                                            })->values()
                                                        ];
                                                    })->values()
                                                ];
                                            })->values()
                                        ];
                                    })->values()
                                ];
                            })->values()
                        ];
                    })->values();
                }

                $data[$metric] = collect([
                    'name' => __($name) . ':',
                    'color' => 'rgb(0, 105, 217)',
                    'children' => $children
                ])->toJson();
            }

            return $data;
        }

        return view('backend.google-analytics.overview');
    }

    public function urls(Request $request)
    {
        if ($request->ajax()) {
            $urls = GoogleAnalyticsUrl::query();

            if ($request->get('path')) {
                $urls->where('path', $request->get('path'));
            }

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $urls->whereBetween('date', [$startDate, $endDate]);
            }

            if ($request->has('highcharts')) {
                $urls->SummaryByDate();

                return [
                    'categories' => $urls->pluck('categories')->toJson(),
                    'visitors' => $urls->pluck('visitors')->toJson(JSON_NUMERIC_CHECK),
                    'pageviews' => $urls->pluck('pageviews')->toJson(JSON_NUMERIC_CHECK)
                ];
            }

            $urls->totalData();

            $datatable = datatables()->eloquent($urls);

            return $datatable->make(true);
        }

        $urls = GoogleAnalyticsUrl::distinct('path')->select('path')->get();

        return view('backend.google-analytics.urls', compact('urls'));
    }

    public function locations(Request $request)
    {
        if ($request->ajax()) {
            $locations = GoogleAnalyticsLocation::query();

            if ($request->get('continent')) {
                $locations->where('continent', $request->get('continent'));
            }

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $locations->whereBetween('date', [$startDate, $endDate]);
            }

            if ($request->has('highcharts')) {
                $locations->SummaryByDate();

                return [
                    'categories' => $locations->pluck('categories')->toJson(),
                    'visitors' => $locations->pluck('visitors')->toJson(JSON_NUMERIC_CHECK),
                    'pageviews' => $locations->pluck('pageviews')->toJson(JSON_NUMERIC_CHECK)
                ];
            }

            $locations->totalData();

            $datatable = datatables()->eloquent($locations);

            return $datatable->make(true);
        }

        $locationContinents = GoogleAnalyticsLocation::distinct('continent')->select('continent')->get();

        return view('backend.google-analytics.locations', compact('locationContinents'));
    }

    public function languages(Request $request)
    {
        if ($request->ajax()) {
            $languages = GoogleAnalyticsLanguage::query();

            if ($request->get('name')) {
                $languages->where('name', $request->get('name'));
            }

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $languages->whereBetween('date', [$startDate, $endDate]);
            }

            if ($request->has('highcharts')) {
                $languages->SummaryByDate();

                return [
                    'categories' => $languages->pluck('categories')->toJson(),
                    'visitors' => $languages->pluck('visitors')->toJson(JSON_NUMERIC_CHECK),
                    'pageviews' => $languages->pluck('pageviews')->toJson(JSON_NUMERIC_CHECK)
                ];
            }

            $languages->totalData();

            $datatable = datatables()->eloquent($languages);

            return $datatable->make(true);
        }

        $languages = GoogleAnalyticsLanguage::distinct('name')->select('name')->get();

        return view('backend.google-analytics.languages', compact('languages'));
    }

    public function browsers(Request $request)
    {
        if ($request->ajax()) {
            $browsers = GoogleAnalyticsBrowser::query();

            if ($request->get('name')) {
                $browsers->where('name', $request->get('name'));
            }

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $browsers->whereBetween('date', [$startDate, $endDate]);
            }

            if ($request->has('highcharts')) {
                $browsers->SummaryByDate();

                return [
                    'categories' => $browsers->pluck('categories')->toJson(),
                    'visitors' => $browsers->pluck('visitors')->toJson(JSON_NUMERIC_CHECK),
                    'pageviews' => $browsers->pluck('pageviews')->toJson(JSON_NUMERIC_CHECK)
                ];
            }

            $browsers->totalData();

            $datatable = datatables()->eloquent($browsers);

            return $datatable->make(true);
        }

        $browsers = GoogleAnalyticsBrowser::distinct('name')->select('name')->get();

        return view('backend.google-analytics.browsers', compact('browsers'));
    }

    public function operatingSystems(Request $request)
    {
        if ($request->ajax()) {
            $operatingSystems = GoogleAnalyticsOperatingSystem::query();

            if ($request->get('name')) {
                $operatingSystems->where('name', $request->get('name'));
            }

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $operatingSystems->whereBetween('date', [$startDate, $endDate]);
            }

            if ($request->has('highcharts')) {
                $operatingSystems->SummaryByDate();

                return [
                    'categories' => $operatingSystems->pluck('categories')->toJson(),
                    'visitors' => $operatingSystems->pluck('visitors')->toJson(JSON_NUMERIC_CHECK),
                    'pageviews' => $operatingSystems->pluck('pageviews')->toJson(JSON_NUMERIC_CHECK)
                ];
            }

            $operatingSystems->totalData();

            $datatable = datatables()->eloquent($operatingSystems);

            return $datatable->make(true);
        }

        $operatingSystems = GoogleAnalyticsOperatingSystem::distinct('name')->select('name')->get();

        return view('backend.google-analytics.operating-systems', compact('operatingSystems'));
    }

    public function deviceCategories(Request $request)
    {
        if ($request->ajax()) {
            $deviceCategories = GoogleAnalyticsDeviceCategory::query();

            if ($request->get('name')) {
                $deviceCategories->where('name', $request->get('name'));
            }

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $deviceCategories->whereBetween('date', [$startDate, $endDate]);
            }

            if ($request->has('highcharts')) {
                $deviceCategories->SummaryByDate();

                return [
                    'categories' => $deviceCategories->pluck('categories')->toJson(),
                    'visitors' => $deviceCategories->pluck('visitors')->toJson(JSON_NUMERIC_CHECK),
                    'pageviews' => $deviceCategories->pluck('pageviews')->toJson(JSON_NUMERIC_CHECK)
                ];
            }

            $deviceCategories->totalData();

            $datatable = datatables()->eloquent($deviceCategories);

            return $datatable->make(true);
        }

        $deviceCategories = GoogleAnalyticsDeviceCategory::distinct('name')->select('name')->get();

        return view('backend.google-analytics.device-categories', compact('deviceCategories'));
    }

    public function syncOverview()
    {
        dispatch(new ProcessGoogleAnalyticsOverview($this->days));

        return redirect()->route('backend.google-analytics.overview')
            ->withSuccess(__('Synchronization successfully!'));
    }

    public function syncUrls()
    {
        dispatch(new ProcessGoogleAnalyticsUrl($this->days));

        return redirect()->route('backend.google-analytics.urls')
            ->withSuccess(__('Synchronization successfully!'));
    }

    public function syncLocations()
    {
        dispatch(new ProcessGoogleAnalyticsLocation($this->days));

        return redirect()->route('backend.google-analytics.locations')
            ->withSuccess(__('Synchronization successfully!'));
    }

    public function syncLanguages()
    {
        dispatch(new ProcessGoogleAnalyticsLanguage($this->days));

        return redirect()->route('backend.google-analytics.languages')
            ->withSuccess(__('Synchronization successfully!'));
    }

    public function syncBrowsers()
    {
        dispatch(new ProcessGoogleAnalyticsBrowser($this->days));

        return redirect()->route('backend.google-analytics.browsers')
            ->withSuccess(__('Synchronization successfully!'));
    }

    public function syncOperatingSystems()
    {
        dispatch(new ProcessGoogleAnalyticsOperatingSystem($this->days));

        return redirect()->route('backend.google-analytics.operating-systems')
            ->withSuccess(__('Synchronization successfully!'));
    }

    public function syncDeviceCategories()
    {
        dispatch(new ProcessGoogleAnalyticsDeviceCategory($this->days));

        return redirect()->route('backend.google-analytics.device-categories')
            ->withSuccess(__('Synchronization successfully!'));
    }
}
