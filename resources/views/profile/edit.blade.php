@extends('layouts.app')

@section('content')

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="container mt-4">
    <h3>Edit Your Profile</h3>

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Profile Picture -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Profile Picture</h5>
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                @if ($user->profile_picture_url)
                                    <img src="{{ $user->profile_picture_url }}" 
                                         alt="Profile Picture" 
                                         class="img-thumbnail rounded-circle" 
                                         width="150">
                                @else
                                    <i class="fas fa-user-circle fa-8x text-muted"></i>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <label for="profile_picture" class="form-label">Upload a new picture</label>
                                <input class="form-control" type="file" id="profile_picture" name="profile_picture">
                                <small class="text-muted">Max file size: 2MB. Allowed formats: JPG, PNG.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Personal Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" name="gender" class="form-select">
                                    <option value="" disabled selected>-- Select --</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Contact Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $user->whatsapp_number) }}">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="same_whatsapp_number" name="same_whatsapp_number" {{ old('same_whatsapp_number', $user->same_whatsapp_number) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="same_whatsapp_number">
                                        Use the same as phone number
                                    </label>
                                </div>
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $user->location) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            @if ($user->role === 'provider')
                <div class="col-md-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Professional Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="hourly_rate" class="form-label">Hourly Rate ($)</label>
                                    <input type="number" id="hourly_rate" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', $user->hourly_rate) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="years_of_experience" class="form-label">Years of Experience</label>
                                    <input type="number" id="years_of_experience" name="years_of_experience" class="form-control" value="{{ old('years_of_experience', $user->years_of_experience) }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea id="bio" name="bio" class="form-control" rows="5">{{ old('bio', $user->bio) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Security -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Security</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <small class="text-muted">Leave blank to keep your current password.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="col-12 text-end">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('phone');
        const whatsappInput = document.getElementById('whatsapp_number');
        const sameAsPhoneCheckbox = document.getElementById('same_whatsapp_number');

        function toggleWhatsAppInput() {
            if (sameAsPhoneCheckbox.checked) {
                whatsappInput.value = phoneInput.value;
                whatsappInput.setAttribute('readonly', true);
            } else {
                whatsappInput.removeAttribute('readonly');
            }
        }

        // Initial state
        toggleWhatsAppInput();

        // Event listeners
        sameAsPhoneCheckbox.addEventListener('change', toggleWhatsAppInput);
        phoneInput.addEventListener('input', function() {
            if (sameAsPhoneCheckbox.checked) {
                whatsappInput.value = phoneInput.value;
            }
        });
    });
</script>
@endpush


