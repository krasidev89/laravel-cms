@extends('layouts.auth')

@section('title', __('Register'))

@section('content')
<form action="{{ route('register') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="name">{{ __('Name') }}: <span class="text-danger">*</span></label>

        <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control @error('name') is-invalid @enderror" autocomplete="name" autofocus>

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">{{ __('Email Address') }}: <span class="text-danger">*</span></label>

        <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="email">

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
        {{ __('Register') }}
    </button>
</form>
@endsection
