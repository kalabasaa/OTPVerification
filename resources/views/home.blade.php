@extends('layouts.app')
@section('title', 'Home')

@section('content')
  
    <h1>Home</h1>
    <p class="sub">You're verified. This is the protected page.</p>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('logout') }}" data-loading="Logging out...">
        @csrf
        <button type="submit" class="btn"><span class="spinner"></span><span class="label">Log out</span></button>
    </form>
@endsection