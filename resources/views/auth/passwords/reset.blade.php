@extends('layouts.auth')

@section('title', __('Reset Password'))

@section('content')
<form action="{{ route('password.update') }}" method="POST">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="email">{{ __('Email Address') }}: <span class="text-danger">*</span></label>

        <input type="email" name="email" value="{{ $email ?? old('email') }}" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="email" autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">{{ __('Password') }}: <span class="text-danger">*</span></label>

        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password-confirm">{{ __('Confirm Password') }}: <span class="text-danger">*</span></label>

        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" autocomplete="new-password">
    </div>

    <button type="submit" class="btn btn-outline-primary btn-block">
        {{ __('Reset Password') }}
    </button>
</form>
@endsection
