@extends('layouts.backend')

@section('title', __('Users') . ' - ' . __('Edit User'))

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-transparent">{{ __('Edit User') }}</div>

    <div class="card-body">
        <form action="{{ route('backend.users.update', ['user' => $user->id]) }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}: <span class="text-danger">*</span></label>

                        <input type="text" name="name" value="{{ old('name', $user->name) }}" id="name" class="form-control @error('name') is-invalid @enderror">

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

                        <input type="text" name="email" value="{{ old('email', $user->email) }}" id="email" class="form-control @error('email') is-invalid @enderror">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}:</label>

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
                        <label for="password-confirm">{{ __('Confirm Password') }}:</label>

                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control">
                    </div>
                </div>
            </div>

            <div class="border-bottom mb-3"></div>

            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        </form>
    </div>
</div>
@endsection
