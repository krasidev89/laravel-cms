@extends('layouts.backend')

@section('title', __('Google Analytics') . ' - ' . __('Operating Systems'))

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-header d-flex align-items-center bg-transparent">
        {{ __('Operating Systems') }}
        @can('sync')
        <a href="{{ route('backend.google-analytics.sync.operating-systems') }}" class="btn d-flex flex-shrink-0 ml-auto p-0" data-toggle="tooltip" data-placement="left" title="{{ __('Google Analytics - Sync') }}">
            <i class="fas fa-sync text-primary"></i>
        </a>
        @endcan
    </div>

    <div class="card-body">
        <div class="row mb-n3">
            <div class="col-12 col-sm-4">
                <div class="form-group">
                    <select name="name" class="form-control google-analytics-select2 google-analytics-table-filters">
                        <option value="0">{{ __('All Operating Systems') }}</option>
                        @foreach ($operatingSystems as $operatingSystem)
                        <option value="{{ $operatingSystem->name }}">{{ $operatingSystem->name }}</option>
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
        <table id="operating-systems-table" class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>{{ __('Operating System') }}</th>
                    <th>{{ __('Version') }}</th>
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
            url: '{!! route('backend.google-analytics.operating-systems', ['highcharts']) !!}',
            data: data,
            success: function(data) {
                createChart(data);
            }
        });
    };

    var operatingSystemsTable = $('#operating-systems-table').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        ajax: {
            url: '{!! route('backend.google-analytics.operating-systems') !!}',
            data: function(data) {
                googleAnalyticsTableFilters.each(function(index, element) {
                    data[element.name] = element.value;
                });
            }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'version', name: 'version' },
            { data: 'visitors', name: 'visitors' },
            { data: 'pageviews', name: 'pageviews' }
        ]
    });

    googleAnalyticsTableFilters.on('change', function() {
        chart();
        operatingSystemsTable.draw();
    });

    chart();
</script>
@endsection
