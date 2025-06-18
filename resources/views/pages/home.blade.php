@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">yelp</a>
        <div class="ms-auto">
            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
            <a href="{{ route('provider.form') }}" class="btn btn-primary">Join as a Professional</a>
        </div>
    </div>
</nav>

<section class="hero py-5 text-center bg-light">
    <div class="container">
        <h1 class="display-5 fw-bold">Find the best professionals in South Africa</h1>
        <p class="lead text-muted">Get free quotes within minutes</p>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <form class="d-flex shadow rounded-4 overflow-hidden bg-white p-2">
                    <input type="text" class="form-control me-2 border-0" placeholder="What service are you looking for?">
                    <input type="text" class="form-control me-2 border-0" placeholder="Postal code">
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
