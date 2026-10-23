@extends('layouts.app')
@section('title', 'OTP Verification')

@section('content')
    <div class="icon">
        <svg viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
    </div>
    <h1>OTP Verification</h1>
    <p class="sub">Enter the six-digit code sent to your email or phone.</p>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}" data-loading="Verifying...">
        @csrf
        <input type="text" name="otp" class="otp" maxlength="6" inputmode="numeric"
               autocomplete="one-time-code" placeholder="······" data-digits autofocus>
        @error('otp') <p class="field-error">{{ $message }}</p> @enderror
        <button type="submit" class="btn"><span class="spinner"></span><span class="label">Verify OTP</span></button>
    </form>

    <a class="link" href="{{ route('otp.request') }}">Request a new OTP</a>
@endsection