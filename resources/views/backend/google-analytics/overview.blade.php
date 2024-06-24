@extends('layouts.backend')

@section('title', __('Google Analytics') . ' - ' . __('Overview'))

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header d-flex align-items-center bg-transparent">
        {{ __('Overview') }}
        @can('sync')
        <a href="{{ route('backend.google-analytics.sync.overview') }}" class="btn d-flex flex-shrink-0 ml-auto p-0" data-toggle="tooltip" data-placement="left" title="{{ __('Google Analytics - Sync') }}">
            <i class="fas fa-sync text-primary"></i>
        </a>
        @endcan
    </div>

    <div class="card-body">
        <div class="row mb-n3">
            @include('backend.google-analytics.filters.datepickers')
        </div>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header bg-transparent">{{ __('Summary by dimension') }}</div>

    <div class="card-body">
        <div class="row mb-n3">
            <div class="col-12 col-lg-6 pb-3">
                <div class="w-100 position-relative" style="padding-top: 100%">
                    <div class="position-absolute inset-0">
                        <svg id="chart-sunburst-visitors"></svg>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 pb-3">
                <div class="w-100 position-relative" style="padding-top: 100%">
                    <div class="position-absolute inset-0">
                        <svg id="chart-sunburst-pageviews"></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('backend.google-analytics.highchart.area-visitors-and-pageviews')
@endsection

@section('scripts')
@include('scripts.bootstrap-datepicker-range')
@include('backend.google-analytics.scripts.tooltip')
@include('backend.google-analytics.scripts.sunburstchart')
@include('backend.google-analytics.scripts.highcharts')
<script>
    var googleAnalyticsTableFilters = $('.google-analytics-table-filters');

    googleAnalyticsTableFilters.on('change', function() {
        var data = {};

        googleAnalyticsTableFilters.each(function(index, element) {
            data[element.name] = element.value;
        });

        $.ajax({
            url: '{!! route('backend.google-analytics.overview') !!}',
            data: data,
            success: function(data) {
                sunburstChart('#chart-sunburst-visitors', JSON.parse(data.visitors));
                sunburstChart('#chart-sunburst-pageviews', JSON.parse(data.pageviews));
            }
        });

        $.ajax({
            url: '{!! route('backend.google-analytics.overview', ['highcharts']) !!}',
            data: data,
            success: function(data) {
                createChart(data);
            }
        });
    });

    $(googleAnalyticsTableFilters[0]).change();
</script>
@endsection
