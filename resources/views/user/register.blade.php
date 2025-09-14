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
    <div class="profile-layout justify-content-center">
        <div class="profile-main-vue col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg p-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Create Your Account</h2>
                    <p class="text-muted">Join our community and start connecting with service providers.</p>
                </div>

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

                <form method="POST" action="{{ route('user.store') }}" class="needs-validation" novalidate>
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="mb-5">
                        <h4 class="mb-3 text-primary fw-bold">Personal Information</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="first_name" class="form-control form-control-lg" style="border-radius: 10px;" id="first_name" placeholder="First Name" required value="{{ old('first_name') }}">
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="last_name" class="form-control form-control-lg" style="border-radius: 10px;" id="last_name" placeholder="Last Name" required value="{{ old('last_name') }}">
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="date_of_birth" class="form-control form-control-lg datepicker" style="border-radius: 10px;" id="date_of_birth" required value="{{ old('date_of_birth') }}" placeholder="Date of Birth">
                            </div>

                            <div class="col-md-6">
                                <select name="gender" class="form-select form-select-lg" style="border-radius: 10px;" id="gender" required>
                                    <option value="">Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="mb-5">
                        <h4 class="mb-3 text-primary fw-bold">Contact Information</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control form-control-lg" style="border-radius: 10px;" id="email" placeholder="Email Address" required value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="phone" class="form-control form-control-lg" style="border-radius: 10px;" id="phone" placeholder="Phone Number" required value="{{ old('phone') }}">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="same_whatsapp_number" 
                                           id="same_whatsapp_number" {{ old('same_whatsapp_number', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium" for="same_whatsapp_number">
                                        Use the same number for WhatsApp
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6" id="whatsapp_field" style="display: none;">
                                <input type="text" name="whatsapp_number" class="form-control form-control-lg" style="border-radius: 10px;" id="whatsapp_number" placeholder="WhatsApp Number (Optional)" value="{{ old('whatsapp_number') }}">
                            </div>

                            <div class="col-12">
                                <input type="text" name="location" id="autocomplete" class="form-control form-control-lg" style="border-radius: 10px;" 
                                    placeholder="Location / Address" value="{{ old('location') }}">
                                <input type="hidden" name="city" id="city" value="{{ old('city') }}">
                                <input type="hidden" name="province" id="province" value="{{ old('province') }}">
                                <input type="hidden" name="postal_code" id="postal_code" value="{{ old('postal_code') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="mb-5">
                        <h4 class="mb-3 text-primary fw-bold">Account Security</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="password" name="password" class="form-control form-control-lg" style="border-radius: 10px;" id="password" placeholder="Password" required>
                            </div>

                            <div class="col-md-6">
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" style="border-radius: 10px;" id="password_confirmation" placeholder="Confirm Password" required>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg w-100" type="submit" style="border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">Create My Account</button>
                    </div>
                </form>

                <!-- Footer Text -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/register-scripts.js') }}"></script>
<script>
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
    });
</script>
@endpush