@extends('layouts.app')

@section('content')

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="text-center">Reset Password</h3>
    
    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="w-50 mx-auto">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
        <div class="mb-3">
            <label>Email Address</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required>
        </div>
        
        <div class="mb-3">
            <label>New Password</label>
            <input class="form-control" type="password" name="password" required>
        </div>
        
        <div class="mb-3">
            <label>Confirm Password</label>
            <input class="form-control" type="password" name="password_confirmation" required>
        </div>
        
        <button type="submit" class="btn btn-success w-100">Reset Password</button>
    </form>
</div>
@endsection