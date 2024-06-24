@extends('layouts.backend')

@section('title', __('Google Analytics') . ' - ' . __('URLs'))

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header d-flex align-items-center bg-transparent">
        {{ __('URLs') }}
        @can('sync')
        <a href="{{ route('backend.google-analytics.sync.urls') }}" class="btn d-flex flex-shrink-0 ml-auto p-0" data-toggle="tooltip" data-placement="left" title="{{ __('Google Analytics - Sync') }}">
            <i class="fas fa-sync text-primary"></i>
        </a>
        @endcan
    </div>

    <div class="card-body">
        <div class="row mb-n3">
            <div class="col-12 col-sm-4">
                <div class="form-group">
                    <select name="path" class="form-control google-analytics-select2 google-analytics-table-filters">
                        <option value="0">{{ __('All URLs') }}</option>
                        @foreach ($urls as $url)
                        <option value="{{ $url->path }}">{{ $url->path }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @include('backend.google-analytics.filters.datepickers')
        </div>
    </div>
</div>

@include('backend.google-analytics.highchart.area-visitors-and-pageviews')

<div class="card shadow-sm mt-3">
    <div class="card-header bg-transparent">{{ __('Total data') }}</div>

    <div class="card-body">
        <table id="urls-table" class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>{{ __('Path') }}</th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Visitors') }}</th>
                    <th>{{ __('Page Views') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@include('scripts.bootstrap-datepicker-range')
@include('backend.google-analytics.scripts.tooltip')
@include('backend.google-analytics.scripts.select2')
@include('backend.google-analytics.scripts.highcharts')
@include('scripts.datatables')
<script>
    var googleAnalyticsTableFilters = $('.google-analytics-table-filters');

    var chart = function() {
        var data = {};

        googleAnalyticsTableFilters.each(function(index, element) {
            data[element.name] = element.value;
        });

        $.ajax({
            url: '{!! route('backend.google-analytics.urls', ['highcharts']) !!}',
            data: data,
            success: function(data) {
                createChart(data);
            }
        });
    };

    var urlsTable = $('#urls-table').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        ajax: {
            url: '{!! route('backend.google-analytics.urls') !!}',
            data: function(data) {
                googleAnalyticsTableFilters.each(function(index, element) {
                    data[element.name] = element.value;
                });
            }
        },
        columns: [
            { data: 'path', name: 'path' },
            { data: 'title', name: 'title' },
            { data: 'visitors', name: 'visitors' },
            { data: 'pageviews', name: 'pageviews' }
        ]
    });

    googleAnalyticsTableFilters.on('change', function() {
        chart();
        urlsTable.draw();
    });

    chart();
</script>
@endsection
