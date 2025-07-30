@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="min-vh-100">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Form Card -->
                <div class="card border-0 shadow-lg" style="border-radius: 20px; backdrop-filter: blur(10px);">
                    <div class="card-body p-5">
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #ff6b6b, #ee5a24);">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Please fix the following errors:</strong>
                                </div>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('provider.store') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Personal Information Section -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-primary rounded-circle p-2 me-3">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <h5 class="mb-0 text-primary fw-bold">Personal Information</h5>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="first_name" class="form-control border-2 rounded-4" 
                                                   id="first_name" placeholder="First Name" required value="{{ old('first_name') }}" 
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="first_name" class="text-muted">
                                                <i class="fas fa-user me-2"></i>First Name
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="last_name" class="form-control border-2 rounded-4" 
                                                   id="last_name" placeholder="Last Name" required value="{{ old('last_name') }}"
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="last_name" class="text-muted">
                                                <i class="fas fa-user me-2"></i>Last Name
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" name="date_of_birth" class="form-control border-2 rounded-4" 
                                                   id="date_of_birth" required value="{{ old('date_of_birth') }}"
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="date_of_birth" class="text-muted">
                                                <i class="fas fa-calendar me-2"></i>Date of Birth
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="gender" class="form-select border-2 rounded-4" id="gender"
                                                    style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                                <option value="">Choose...</option>
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            <label for="gender" class="text-muted">
                                                <i class="fas fa-venus-mars me-2"></i>Gender
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-success rounded-circle p-2 me-3">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <h5 class="mb-0 text-success fw-bold">Contact Information</h5>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control border-2 rounded-4" 
                                                   id="email" placeholder="Email" required value="{{ old('email') }}"
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="email" class="text-muted">
                                                <i class="fas fa-envelope me-2"></i>Email Address
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="phone" class="form-control border-2 rounded-4" 
                                                   id="phone" placeholder="Phone" required value="{{ old('phone') }}"
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="phone" class="text-muted">
                                                <i class="fas fa-phone me-2"></i>Phone Number
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" name="location" class="form-control border-2 rounded-4" 
                                                   id="location" placeholder="Location" value="{{ old('location') }}"
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="location" class="text-muted">
                                                <i class="fas fa-map-marker-alt me-2"></i>Location / City
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Information Section -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-warning rounded-circle p-2 me-3">
                                        <i class="fas fa-briefcase text-white"></i>
                                    </div>
                                    <h5 class="mb-0 text-warning fw-bold">Professional Details</h5>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" name="hourly_rate" class="form-control border-2 rounded-4" 
                                                   id="hourly_rate" placeholder="Hourly Rate" value="{{ old('hourly_rate') }}"
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="hourly_rate" class="text-muted">
                                                <i class="fas fa-dollar-sign me-2"></i>Hourly Rate (R)
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" name="years_of_experience" class="form-control border-2 rounded-4" 
                                                   id="years_of_experience" placeholder="Years of Experience" min="0" max="100" 
                                                   value="{{ old('years_of_experience') }}"
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="years_of_experience" class="text-muted">
                                                <i class="fas fa-clock me-2"></i>Years of Experience
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="services" class="form-label text-muted fw-semibold mb-3">
                                            <i class="fas fa-tools me-2"></i>Services Offered
                                        </label>
                                        <div class="border border-2 rounded-4 p-3" style="max-height: 200px; overflow-y: auto; background-color: #f8f9fa;">
                                            @foreach ($services as $service)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                                           value="{{ $service->id }}" id="service_{{ $service->id }}"
                                                           {{ collect(old('services'))->contains($service->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-medium" for="service_{{ $service->id }}">
                                                        {{ $service->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea name="bio" class="form-control border-2 rounded-4" id="bio" 
                                                      placeholder="Tell us about yourself..." style="height: 120px;">{{ old('bio') }}</textarea>
                                            <label for="bio" class="text-muted">
                                                <i class="fas fa-pen me-2"></i>Short Bio
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Section -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-danger rounded-circle p-2 me-3">
                                        <i class="fas fa-lock text-white"></i>
                                    </div>
                                    <h5 class="mb-0 text-danger fw-bold">Account Security</h5>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" name="password" class="form-control border-2 rounded-4" 
                                                   id="password" placeholder="Password" required
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="password" class="text-muted">
                                                <i class="fas fa-lock me-2"></i>Password
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" name="password_confirmation" class="form-control border-2 rounded-4" 
                                                   id="password_confirmation" placeholder="Confirm Password" required
                                                   style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="password_confirmation" class="text-muted">
                                                <i class="fas fa-lock me-2"></i>Confirm Password
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button class="btn btn-lg py-3 rounded-4 fw-bold text-white position-relative overflow-hidden" 
                                        type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; transition: all 0.3s ease;">
                                    <span class="position-relative z-index-1">
                                        <i class="fas fa-rocket me-2"></i>Create My Profile
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer Text -->
                <div class="text-center mt-4">
                    <p class="text-white-50 mb-0">Already have an account? <a href="#" class="text-white fw-semibold">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .card {
        transition: transform 0.3s ease;
    }
    
    .form-floating > label {
        padding-left: 1rem;
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
    }
</style>

@endsection