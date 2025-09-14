@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/profile-vue-inspired.css') }}">

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

<div class="container py-5">
    <div class="profile-layout">
        <div class="profile-main-vue">
            <div class="profile-card-vue text-center">
                <h1 class="display-5 fw-bold">Find the best professionals in South Africa</h1>
                <p class="lead text-muted">Get free quotes within minutes</p>

                <div class="row justify-content-center mt-4">
                    <div class="col-md-10">
                        <form method="GET" action="{{ route('search') }}" class="search-form bg-white shadow rounded-pill p-2">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="What service are you looking for?" required>
                                <input type="text" name="postal_code" class="form-control" placeholder="Postal code">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                            <div id="advanced-search" class="mt-3" style="display: none;">
                                <div class="input-group">
                                    <input type="number" name="hourly_rate" class="form-control" placeholder="Max hourly rate">
                                    <input type="number" name="experience" class="form-control" placeholder="Min years of experience">
                                </div>
                            </div>
                        </form>
                        <button id="advanced-search-btn" class="btn btn-link text-muted mt-2">Advanced Search</button>
                        <small class="text-muted d-block mt-2">
                            Popular: House Cleaning, Web Design, Personal Trainers
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('advanced-search-btn').addEventListener('click', function() {
        var advancedSearch = document.getElementById('advanced-search');
        if (advancedSearch.style.display === 'none') {
            advancedSearch.style.display = 'block';
            this.textContent = 'Hide Advanced Search';
        } else {
            advancedSearch.style.display = 'none';
            this.textContent = 'Advanced Search';
        }
    });
});
</script>
@endpush