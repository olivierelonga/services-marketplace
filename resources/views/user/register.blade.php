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

                        <form method="POST" action="{{ route('user.store') }}" class="needs-validation" novalidate>
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
                                                   id="first_name" placeholder="First Name" required value="{{ old('first_name') }}" style="padding-top: 1.625rem; padding-bottom: .625rem;">
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
                                            <select name="gender" class="form-select border-2 rounded-4" id="gender" style="padding-top: 1.625rem; padding-bottom: .625rem;" required>
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
                                            <div style="padding-left: 90px; padding-top: 10px">
                                                 <input class="form-check-input" type="checkbox" name="same_whatsapp_number" 
                                                        id="same_whatsapp_number" checked {{ old('same_whatsapp_number', true) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-medium" for="same_whatsapp_number">
                                                    <i class="fab fa-whatsapp text-success me-2"></i>Use the same number for WhatsApp
                                                </label> 
                                            </div>
                                      

                                    </div>
                                    
                                    <div class="col-md-6" id="whatsapp_field" style="display: none;">
                                        <div class="form-floating">
                                            <input type="text" name="whatsapp_number" class="form-control border-2 rounded-4" id="whatsapp_number" placeholder="WhatsApp Number (Optional)" value="{{ old('whatsapp_number') }}" style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="whatsapp_number" class="text-muted">
                                                <i class="fab fa-whatsapp me-2"></i>WhatsApp Number (Optional)
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" name="location" id="autocomplete" class="form-control border-2 rounded-4" 
                                                placeholder="Start typing your address..." value="{{ old('location') }}"
                                                style="padding-top: 1.625rem; padding-bottom: .625rem;">
                                            <label for="autocomplete" class="text-muted">
                                                <i class="fas fa-map-marker-alt me-2"></i>Location / Address
                                            </label>
                                        </div>

                                        {{-- Hidden fields to capture city, province, postal code --}}
                                        <input type="hidden" name="city" id="city" value="{{ old('city') }}">
                                        <input type="hidden" name="province" id="province" value="{{ old('province') }}">
                                        <input type="hidden" name="postal_code" id="postal_code" value="{{ old('postal_code') }}">
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
                                            <input type="password" name="password" class="form-control border-2 rounded-4" required
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

                        <!-- Footer Text -->
                        <div class="text-center mt-4">
                            <p class="text-muted mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Sign in here</a></p>
                        </div>

                    </div>
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

    .form-control.is-valid {
        border-color: #28a745;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.98-.68c.23-.16.42-.42.42-.42l2.05-2.05c.38-.38.38-1.02 0-1.4-.38-.38-1.02-.38-1.4 0L3.28 3.65c-.08.08-.2.08-.28 0L1.7 2.35c-.38-.38-1.02-.38-1.4 0-.38.38-.38 1.02 0 1.4l1.4 1.4c.4.4 1.02.4 1.4 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(.375em + .1875rem) center;
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3e%3cpath fill='%23dc3545' d='M9.5 3.2l-.8-.8L6 5.1 3.3 2.4l-.8.8L5.1 6 2.4 8.7l.8.8L6 6.9l2.7 2.7.8-.8L6.9 6 9.5 3.2z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(.375em + .1875rem) center;
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }

    .form-select.is-valid {
        border-color: #28a745;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 6 6 6-6'/%3e%3c/svg%3e"), url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.98-.68c.23-.16.42-.42.42-.42l2.05-2.05c.38-.38.38-1.02 0-1.4-.38-.38-1.02-.38-1.4 0L3.28 3.65c-.08.08-.2.08-.28 0L1.7 2.35c-.38-.38-1.02-.38-1.4 0-.38.38-.38 1.02 0 1.4l1.4 1.4c.4.4 1.02.4 1.4 0z'/%3e%3c/svg%3e");
        background-position: right .75rem center, center right 2.25rem;
        background-size: 16px 12px, calc(.75em + .375rem) calc(.75em + .375rem);
    }

    .form-select.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 6 6 6-6'/%3e%3c/svg%3e"), url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3e%3cpath fill='%23dc3545' d='M9.5 3.2l-.8-.8L6 5.1 3.3 2.4l-.8.8L5.1 6 2.4 8.7l.8.8L6 6.9l2.7 2.7.8-.8L6.9 6 9.5 3.2z'/%3e%3c/svg%3e");
        background-position: right .75rem center, center right 2.25rem;
        background-size: 16px 12px, calc(.75em + .375rem) calc(.75em + .375rem);
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

    /* Services container validation styling */
    .border-danger {
        border-color: #dc3545 !important;
        animation: shake 0.5s ease-in-out;
    }

    .border-success {
        border-color: #28a745 !important;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Invalid feedback styling */
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .valid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #28a745;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
    }
</style>


<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY&libraries=places"></script>
<script>
    // Add this to your existing script section or create a new one

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap form validation
    const form = document.querySelector('.needs-validation');
    const sameWhatsAppCheckbox = document.getElementById('same_whatsapp_number');
    const whatsappField = document.getElementById('whatsapp_field');
    const whatsappInput = document.getElementById('whatsapp_number');
    
    // WhatsApp field toggle functionality (FIXED)
    function toggleWhatsAppField() {
        if (sameWhatsAppCheckbox.checked) {
            // Hide field and remove required when using same number
            whatsappField.style.display = 'none';
            whatsappInput.removeAttribute('required');
            whatsappInput.value = '';
        } else {
            // Show field and make it optional (remove required)
            whatsappField.style.display = 'block';
            // Don't make it required - it's marked as optional in your label
            // whatsappInput.setAttribute('required', 'required');
        }
    }
    
    // Initialize WhatsApp field state
    toggleWhatsAppField();
    
    // Add event listener for WhatsApp checkbox changes
    if (sameWhatsAppCheckbox) {
        sameWhatsAppCheckbox.addEventListener('change', toggleWhatsAppField);
    }
    
    // Bootstrap form validation
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Scroll to first invalid field
                const firstInvalidField = form.querySelector(':invalid');
                if (firstInvalidField) {
                    firstInvalidField.focus();
                    firstInvalidField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
            
            form.classList.add('was-validated');
        }, false);
    }
    
    // Custom validation for specific fields
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (field.checkValidity()) {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            } else {
                field.classList.remove('is-valid');
                field.classList.add('is-invalid');
            }
        });
        
        field.addEventListener('input', function() {
            if (field.classList.contains('was-validated')) {
                if (field.checkValidity()) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                } else {
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                }
            }
        });
    });
    
    // Services validation (at least one service must be selected)
    const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
    const servicesContainer = document.querySelector('.border.border-2.rounded-4.p-3');
    
    function validateServices() {
        const checkedServices = document.querySelectorAll('input[name="services[]"]:checked');
        if (checkedServices.length === 0) {
            servicesContainer.classList.add('border-danger');
            return false;
        } else {
            servicesContainer.classList.remove('border-danger');
            servicesContainer.classList.add('border-success');
            return true;
        }
    }
    
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', validateServices);
    });
    
    // Add services validation to form submission
    const originalSubmitHandler = form.onsubmit;
    form.addEventListener('submit', function(event) {
        if (!validateServices()) {
            event.preventDefault();
            event.stopPropagation();
            
            // Show error message for services
            let servicesError = document.getElementById('services-error');
            if (!servicesError) {
                servicesError = document.createElement('div');
                servicesError.id = 'services-error';
                servicesError.className = 'text-danger mt-2';
                servicesError.innerHTML = '<small><i class="fas fa-exclamation-triangle me-1"></i>Please select at least one service.</small>';
                servicesContainer.parentNode.appendChild(servicesError);
            }
            
            servicesContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        } else {
            const servicesError = document.getElementById('services-error');
            if (servicesError) {
                servicesError.remove();
            }
        }
    });
});

// Google Maps Autocomplete (your existing code with slight improvements)
function initAutocomplete() {
    const autocompleteInput = document.getElementById('autocomplete');
    
    if (!autocompleteInput) return; // Guard clause
    
    const autocomplete = new google.maps.places.Autocomplete(autocompleteInput, {
        types: ['geocode'],
        componentRestrictions: { country: 'za' }
    });

    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        let city = '', province = '', postalCode = '';

        if (!place.address_components) return;

        for (const component of place.address_components) {
            const types = component.types;
            if (types.includes('locality') || types.includes('sublocality')) {
                city = component.long_name;
            }
            if (types.includes('administrative_area_level_1')) {
                province = component.long_name;
            }
            if (types.includes('postal_code')) {
                postalCode = component.long_name;
            }
        }

        document.getElementById('city').value = city;
        document.getElementById('province').value = province;
        document.getElementById('postal_code').value = postalCode;
        
        // Mark autocomplete field as valid when place is selected
        autocompleteInput.classList.add('is-valid');
        autocompleteInput.classList.remove('is-invalid');
    });
}

// Initialize Google Maps when available
if (typeof google !== 'undefined') {
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
} else {
    // Fallback if Google Maps fails to load
    console.warn('Google Maps API not loaded');
}
</script>


@endsection