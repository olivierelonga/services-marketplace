@extends('layouts.app')

@section('content')
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

<section class="hero py-5 text-center bg-light">
    <div class="container">
        <h1 class="display-5 fw-bold">Find the best professionals in South Africa</h1>
        <p class="lead text-muted">Get free quotes within minutes</p>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <form method="GET" action="{{ route('search') }}" class="d-flex flex-wrap gap-2 bg-white shadow rounded-4 p-3">
                    <input type="text" name="q" class="form-control border-0" placeholder="What service are you looking for?" required>
                    <input type="text" name="postal_code" class="form-control border-0" placeholder="Postal code">
                    <input type="number" name="hourly_rate" class="form-control border-0" placeholder="Max hourly rate">
                    <input type="number" name="experience" class="form-control border-0" placeholder="Min years of experience">
                    <button class="btn btn-primary px-4">Search</button>
                </form>
                <small class="text-muted d-block mt-2">
                    Popular: House Cleaning, Web Design, Personal Trainers
                </small>
            </div>
        </div>
    </div>
</section>
@endsection
