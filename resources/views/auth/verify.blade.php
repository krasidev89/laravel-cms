@extends('layouts.auth')

@section('title', __('Verify Your Email Address'))

@section('content')
{{ __('Before proceeding, please check your email for a verification link.') }}
{{ __('If you did not receive the email') }},
<form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
</form>
@endsection

@if (session('resent'))
@section('scripts')
<script>
    Swal.fire({
        icon: 'success',
        text: '{{ __('A fresh verification link has been sent to your email address.') }}',
        confirmButtonText: '{{ __('Close') }}',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'swal2-styled btn btn-primary m-1'
        }
    });
</script>
@endsection
@endif
