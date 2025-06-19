@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="text-center">Forgot Password</h3>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="w-50 mx-auto">
        @csrf
        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
    </form>
</div>
@endsection