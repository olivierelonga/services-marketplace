@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="text-center mb-4">Login</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="w-50 mx-auto">
        @csrf

        <div class="mb-3">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required autofocus value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        {{-- Forgot Password Link --}}
        <div class="mt-3 text-center">
            <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot your password?</a>
        </div>
    </form>
</div>
@endsection
