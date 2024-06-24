@extends('layouts.backend')

@section('title', __('Users') . ' - ' . __('List Users'))

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center bg-transparent">
        {{ __('List Users') }}
        <div class="btn-group btn-group-sm flex-shrink-0 ml-auto" role="group">
            <button type="button" class="btn pl-2 pr-0 py-0" data-dt-toggle="tooltip" data-placement="left" title="{{ __('Filters') }}" data-toggle="collapse" data-target="#usersTableFilters" aria-expanded="false" aria-controls="usersTableFilters">
                <i class="fas fa-filter text-primary"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div id="usersTableFilters" class="collapse">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <select name="trashed" id="trashed" class="form-control users-table-filters">
                            <option value="0">{{ __('All Users') }}</option>
                            <option value="1">{{ __('Deleted Users') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <div id="container_start_date" class="input-group has-clear">
                            <input type="text" name="start_date" id="start_date" class="form-control users-table-filters bg-white" placeholder="{{ __('Start date') }}" readonly>

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
                            <input type="text" name="end_date" id="end_date" class="form-control users-table-filters bg-white" placeholder="{{ __('End date') }}" readonly>

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

        <table id="users-table" class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email Address') }}</th>
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
    var usersTableFilters = $('.users-table-filters');
    var usersTable = $('#users-table').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: '{!! route('backend.users.index') !!}',
            data: function(data) {
                usersTableFilters.each(function(index, element) {
                    data[element.name] = element.value;
                });

                $('[data-dt-toggle="tooltip"]').tooltip('dispose');
            },
            complete: function(data) {
                var trashed = parseInt(inputTrashed.val());

                usersTable.column(4).visible(!trashed);
                usersTable.column(5).visible(trashed);

                $('[data-dt-toggle="tooltip"]').tooltip();
            }
        },
        columns: [
            { data: 'id', name: 'id', searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'deleted_at', name: 'deleted_at', visible: false },
            { data: 'actions', name: 'actions', searchable: false, orderable: false, className: 'py-2' }
        ]
    });

    usersTableFilters.on('change', function() {
        usersTable.draw();
    });

    inputTrashed.select2();
</script>
@endsection
