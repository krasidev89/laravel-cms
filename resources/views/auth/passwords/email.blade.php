@extends('layouts.auth')

@section('title', __('Reset Password'))

@section('content')
<form action="{{ route('password.email') }}" method="POST">
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

    <button type="submit" class="btn btn-outline-primary btn-block">
        {{ __('Send Password Reset Link') }}
    </button>
</form>
@endsection

@if (session('status'))
@section('scripts')
<script>
    Swal.fire({
        icon: 'success',
        text: '{{ session('status') }}',
        confirmButtonText: '{{ __('Close') }}',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'swal2-styled btn btn-primary m-1'
        }
    });
</script>
@endsection
@endif
