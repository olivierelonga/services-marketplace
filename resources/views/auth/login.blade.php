@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f2f2f2;
    }
    .login-card {
        max-width: 400px;
        margin: 60px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
    }
    .login-card .form-control {
        height: 45px;
        font-size: 15px;
    }
    .login-card .btn-primary {
        height: 45px;
        font-size: 16px;
        font-weight: 600;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
        
        <div class="ms-auto d-flex align-items-center gap-2">
            @auth
                <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-envelope-fill me-1"></i> Messages
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-person-circle me-1"></i> Profile
                </a>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                <a href="{{ route('provider.form') }}" class="btn btn-primary">Join as a Professional</a>
            @endguest
        </div>
    </div>
</nav>

<div class="container">
    <div class="login-card">
        <h3 class="text-center mb-4">Login</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
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

            <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot your password?</a>
            </div>
        </form>
    </div>
</div>

@endsection