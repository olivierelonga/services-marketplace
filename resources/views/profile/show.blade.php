@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="min-vh-100">
    <div class="container py-5">
        <div class="row">
            <!-- Profile Header Card -->
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-user text-white" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h2 class="mb-2 fw-bold text-primary">{{ $user->first_name }}'s Profile</h2>
                                <p class="text-muted mb-3 lead">Service Provider</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-primary rounded-pill px-3 py-2">
                                        <i class="fas fa-star me-1"></i>{{ $user->years_of_experience }} Years Experience
                                    </span>
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <i class="fas fa-dollar-sign me-1"></i>R{{ $user->hourly_rate }}/hour
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-success rounded-circle p-2 me-3">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <h5 class="mb-0 text-success fw-bold">Contact Information</h5>
                        </div>

                        <div class="space-y-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded-4 mb-3">
                                <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                                    <i class="fas fa-envelope text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email Address</small>
                                    <span class="fw-semibold">{{ $user->email }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                                    <i class="fas fa-map-marker-alt text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Location</small>
                                    <span class="fw-semibold">{{ $user->postal_code ?? 'Not specified' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Details Card -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-warning rounded-circle p-2 me-3">
                                <i class="fas fa-briefcase text-white"></i>
                            </div>
                            <h5 class="mb-0 text-warning fw-bold">Professional Details</h5>
                        </div>

                        <div class="space-y-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded-4 mb-3">
                                <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                                    <i class="fas fa-money-bill text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Hourly Rate</small>
                                    <span class="fw-semibold fs-5 text-success">R{{ $user->hourly_rate }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                                    <i class="fas fa-clock text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Experience</small>
                                    <span class="fw-semibold">{{ $user->years_of_experience }} years</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Card -->
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-info rounded-circle p-2 me-3">
                                <i class="fas fa-tools text-white"></i>
                            </div>
                            <h5 class="mb-0 text-info fw-bold">Services Offered</h5>
                        </div>

                        @if($user->services->count() > 0)
                            <div class="row g-3">
                                @foreach($user->services as $service)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="d-flex align-items-center p-3 bg-light rounded-4 h-100">
                                            <div class="bg-white rounded-circle p-2 me-3 shadow-sm">
                                                <i class="fas fa-check text-success"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">{{ $service->name }}</div>
                                                {{-- <small class="text-muted">{{ $service->category }}</small> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-tools text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">No services listed yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-5">
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <button class="btn btn-primary btn-lg px-4 py-3 rounded-4 fw-semibold">
                    <i class="fas fa-message me-2"></i>Contact Provider
                </button>

                <button class="btn btn-outline-light btn-lg px-4 py-3 rounded-4 fw-semibold share-prof">
                    <i class="fas fa-share me-2"></i>Share Profile
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .btn:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .share-prof{
        background-color: white;
        color: black;
    }

    .card {
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        
        .d-flex.flex-column.flex-sm-row {
            flex-direction: column;
        }
    }
</style>

@endsection