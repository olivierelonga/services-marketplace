@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f2f2f2;
    }
    .forgot-card {
        max-width: 400px;
        margin: 60px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
    }
    .forgot-card .form-control {
        height: 45px;
        font-size: 15px;
    }
    .forgot-card .btn-primary {
        height: 45px;
        font-size: 16px;
        font-weight: 600;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="container">
    <div class="forgot-card">
        <h3 class="text-center mb-4">Forgot Password</h3>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
    </div>
</div>

@endsection
