@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/profile-vue-inspired.css') }}">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="container py-5">
    <div class="profile-layout">
        <div class="profile-main-vue">
            <div class="profile-card-vue">
                <div class="card-header-vue">
                    <i class="fas fa-search"></i>
                    <h3 class="card-title-vue">Search Results</h3>
                </div>
                @forelse($providers as $provider)
                    @php
                        $user = \App\Models\User::find($provider->id);
                    @endphp
                    <div class="testimonial-vue">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                @if ($user && $user->profile_picture_url)
                                    <img src="{{ $user->profile_picture_url }}" alt="Profile Picture" class="rounded-circle" width="50" height="50">
                                @else
                                    <div class="bg-primary d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                                <div class="ms-3">
                                    <h5>{{ $provider->first_name }}</h5>
                                    <p class="mb-1">
                                        Location: {{ $provider->location ?? '—' }} <br>
                                        Hourly Rate: R{{ $provider->hourly_rate ?? '—' }} <br>
                                        Experience: {{ $provider->years_of_experience ?? '—' }} years <br>
                                        Services: {{ $provider->services }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('profile.view', $provider->id) }}" class="btn btn-sm btn-outline-primary align-self-start">View Profile</a>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No matching service providers found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
