@extends('layouts.auth')

@section('title', __('Login'))

@section('content')
<form action="{{ route('login') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="email">{{ __('Email Address') }}: <span class="text-danger">*</span></label>

        <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="email" autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">{{ __('Password') }}: <span class="text-danger">*</span></label>

        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>

            <label for="remember" class="form-check-label">
                {{ __('Remember Me') }}
            </label>
        </div>
    </div>

    <button type="submit" class="btn btn-outline-primary btn-block">
        {{ __('Login') }}
    </button>

    @if (Route::has('register'))
    <a href="{{ route('register') }}" class="btn btn-link btn-block">
        {{ __('Register') }}
    </a>
    @endif

    @if (Route::has('password.request'))
    <a href="{{ route('password.request') }}" class="btn btn-link btn-block">
        {{ __('Forgot Your Password?') }}
    </a>
    @endif
</form>
@endsection
