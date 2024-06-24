@extends('layouts.backend')

@section('title', __('Projects') . ' - ' . __('List Projects'))

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center bg-transparent">
        {{ __('List Projects') }}
        <div class="btn-group btn-group-sm flex-shrink-0 ml-auto" role="group">
            <button type="button" class="btn pl-2 pr-0 py-0" data-dt-toggle="tooltip" data-placement="left" title="{{ __('Filters') }}" data-toggle="collapse" data-target="#projectsTableFilters" aria-expanded="false" aria-controls="projectsTableFilters">
                <i class="fas fa-filter text-primary"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div id="projectsTableFilters" class="collapse">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <select name="trashed" id="trashed" class="form-control projects-table-filters">
                            <option value="0">{{ __('All Projects') }}</option>
                            <option value="1">{{ __('Deleted Projects') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <div id="container_start_date" class="input-group has-clear">
                            <input type="text" name="start_date" id="start_date" class="form-control projects-table-filters bg-white" placeholder="{{ __('Start date') }}" readonly>

                            <div class="input-group-append">
                                <button type="button" class="btn btn-clear">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <div id="container_end_date" class="input-group has-clear">
                            <input type="text" name="end_date" id="end_date" class="form-control projects-table-filters bg-white" placeholder="{{ __('End date') }}" readonly>

                            <div class="input-group-append">
                                <button type="button" class="btn btn-clear">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table id="projects-table" class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Order') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Slug') }}</th>
                    <th>{{ __('Created') }}</th>
                    <th>{{ __('Updated') }}</th>
                    <th>{{ __('Deleted') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@include('scripts.bootstrap-datepicker-range')
@include('scripts.datatables')
<script>
    var inputTrashed = $('#trashed');
    var projectsTableFilters = $('.projects-table-filters');
    var projectsTable = $('#projects-table').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        ordering: false,
        ajax: {
            url: '{!! route('backend.projects.index') !!}',
            data: function(data) {
                projectsTableFilters.each(function(index, element) {
                    data[element.name] = element.value;
                });

                $('[data-dt-toggle="tooltip"]').tooltip('dispose');
            },
            complete: function(data) {
                var trashed = parseInt(inputTrashed.val());

                projectsTable.column(5).visible(!trashed);
                projectsTable.column(6).visible(trashed);

                $('[data-dt-toggle="tooltip"]').tooltip();
            }
        },
        columns: [
            { data: 'id', name: 'id', searchable: false },
            { data: 'order', name: 'order', searchable: false, className: 'reorder py-2' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'deleted_at', name: 'deleted_at', visible: false },
            { data: 'actions', name: 'actions', searchable: false, orderable: false, className: 'py-2' }
        ],
        rowReorder: {
            dataSrc: 'id',
            selector: '.reorder'
        }
    });

    projectsTable.on('row-reorder', function(e, diff, edit) {
        var data = {};

        for (var i = 0, len = diff.length; i < len; i++) {
            data[diff[i].newData] = diff[i].oldData;
        }

        if (len) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{!! route('backend.projects.reorder') !!}',
                type: 'POST',
                data: data,
                dataType: 'json'
            });
        }
    });

    projectsTableFilters.on('change', function() {
        projectsTable.draw();
    });

    inputTrashed.select2();
</script>
@endsection
