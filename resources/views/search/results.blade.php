@extends('layouts.app')

@section('content')

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="container py-4">
    <h3>Search Results</h3>

    @forelse($providers as $provider)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5>{{ $provider->first_name }}</h5>
                <p>
                    Location: {{ $provider->postal_code ?? '—' }} <br>
                    Hourly Rate: R{{ $provider->hourly_rate ?? '—' }} <br>
                    Experience: {{ $provider->years_of_experience ?? '—' }} years <br>
                    Services: {{ $provider->services ?? 'N/A' }}
                </p>
                <a href="{{ route('profile.view', $provider->id) }}" class="btn btn-sm btn-outline-primary">View Profile</a>
            </div>
        </div>
    @empty
        <p>No matching service providers found.</p>
    @endforelse
</div>
@endsection