@extends('layouts.backend')

@section('content')
<div id="accordionProfile" class="accordion">
    @php
        $collapseUpdatePassword = $errors->has('current_password') || $errors->has('password');
        $collapseUpdateExpanded = !$collapseUpdatePassword;
    @endphp
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center bg-transparent" data-toggle="collapse" data-target="#collapseUpdate" aria-expanded="{{ $collapseUpdateExpanded ? 'true' : 'false' }}" aria-controls="collapseUpdate">
            {{ __('Profile') }}
            <i class="plus-minus-rotate flex-shrink-0 ml-auto collapsed"></i>
        </div>

        <div id="collapseUpdate" @class(["collapse", "show" => $collapseUpdateExpanded]) data-parent="#accordionProfile">
            <div class="card-body">
                <form action="{{ route('backend.profile.update') }}" method="post" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}: <span class="text-danger">*</span></label>

                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" id="name" class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="email">{{ __('Email Address') }}: <span class="text-danger">*</span></label>

                                <input type="text" name="email" value="{{ old('email', auth()->user()->email) }}" id="email" class="form-control @error('email') is-invalid @enderror">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom mb-3"></div>

                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center bg-transparent" data-toggle="collapse" data-target="#collapseUpdatePassword" aria-expanded="{{ $collapseUpdatePassword ? 'true' : 'false' }}" aria-controls="collapseUpdatePassword">
            {{ __('Update Password') }}
            <i class="plus-minus-rotate flex-shrink-0 ml-auto collapsed"></i>
        </div>

        <div id="collapseUpdatePassword" @class(["collapse", "show" => $collapseUpdatePassword]) data-parent="#accordionProfile">
            <div class="card-body">
                <form action="{{ route('backend.profile.update') }}" method="post" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="update-password">

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="current_password">{{ __('Current Password') }}: <span class="text-danger">*</span></label>

                                <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror">

                                @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}: <span class="text-danger">*</span></label>

                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="password-confirm">{{ __('Confirm Password') }}: <span class="text-danger">*</span></label>

                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom mb-3"></div>

                    <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                </form>
            </div>
        </div>
    </div>

    @if (Route::has('backend.profile.destroy'))
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center bg-transparent text-danger" data-toggle="collapse" data-target="#collapseDeleteAccount" aria-expanded="false" aria-controls="collapseDeleteAccount">
            {{ __('Delete Account') }}
            <i class="plus-minus-rotate flex-shrink-0 ml-auto collapsed"></i>
        </div>

        <div id="collapseDeleteAccount" class="collapse" data-parent="#accordionProfile">
            <div class="card-body">
                <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>

                <form action="{{ route('backend.profile.destroy') }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" id="btn-destroy" class="btn btn-danger">{{ __('Delete Account') }}</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $('#role').select2({
        allowClear: true
    });

    $('#btn-destroy').on('click', function(e) {
        var form = $(this).closest('form');

        Swal.fire({
            icon: 'question',
            text: '{{ __('Do you want to delete your account?') }}',
            confirmButtonText : '{{ __('Delete Account') }}',
            cancelButtonText: '{{ __('Cancel') }}',
            showCancelButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'swal2-styled btn btn-danger m-1',
                cancelButton: 'swal2-styled btn btn-primary m-1'
            }
        }).then(function(result) {
            if (result.value) {
                form.submit();
            }
        });

        e.preventDefault();
    });
</script>
@endsection
