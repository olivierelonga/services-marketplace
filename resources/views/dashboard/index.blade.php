@extends('layouts.app')

@section('content')

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>

        <div class="ms-auto d-flex align-items-center gap-2">
            {{-- Messages Button --}}
            <a href="{{ route('messages.index') }}" class="position-relative">
                <i class="bi bi-envelope-fill me-1" aria-hidden="true"></i>

                @if($unreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-3">
            <div class="card shadow-sm rounded-4">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $user->first_name }} {{ $user->last_name }}</h5>
                    <p class="text-muted">{{ ucfirst($user->role) }}</p>
                    <p><i class="bi bi-geo-alt"></i> {{ $user->location ?? 'No location' }}</p>

                    @if ($user->role === 'provider')
                        <hr>
                        <h6>Services</h6>
                        <ul class="list-unstyled small">
                            @foreach ($user->services as $service)
                                <li>• {{ $service->name }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <hr>
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        {{-- Main content --}}
        <div class="col-md-9">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Welcome, {{ $user->first_name }} 👋</h5>
                </div>

                <div class="card-body">
                    <p>This is your dashboard. Here you can manage your profile, services, requests, and more.</p>

                    <div class="row">
                        @if ($user->role === 'provider')
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <strong>Years of Experience:</strong> {{ $user->years_of_experience ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-secondary">
                                    <strong>Bio:</strong><br>
                                    {{ $user->bio ?? 'No bio yet.' }}
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <strong>You are a regular user.</strong> You can submit service requests or search for professionals.
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Future sections: messages, requests, bookings --}}
                    <div class="text-end mt-4">
                        @if(auth()->user()->is_provider)
                            <a href="{{ route('provider.dashboard') }}" class="btn btn-primary btn-sm">Provider Dashboard</a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
