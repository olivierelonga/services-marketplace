@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="min-vh-100">
    <div class="container py-5">
        <!-- Success/Error Messages -->
        @if(session('success') || session('error') || $errors->any())
            <div class="row mb-4">
                <div class="col-12">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 15px; border: none;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3 text-success" style="font-size: 1.2rem;"></i>
                                <div>
                                    <strong>Success!</strong> {{ session('success') }}
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 15px; border: none;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-3 text-danger" style="font-size: 1.2rem;"></i>
                                <div>
                                    <strong>Error!</strong> {{ session('error') }}
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 15px; border: none;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-info-circle me-3 text-warning mt-1" style="font-size: 1.2rem;"></i>
                                <div>
                                    <strong>Please check the following:</strong>
                                    <ul class="mb-0 mt-2 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
        @endif
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
                                        R{{ $user->hourly_rate }}/hour
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
            <div class="col-12 mb-4">
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

            <!-- Statements of Character (Testimonials) Card -->
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-purple rounded-circle p-2 me-3" style="background-color: #6f42c1;">
                                    <i class="fas fa-quote-right text-white"></i>
                                </div>
                                <h5 class="mb-0 fw-bold" style="color: #6f42c1;">Statements of Character</h5>
                            </div>
                            
                            @auth
                                @if(auth()->id() !== $user->id)
                                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
                                        <i class="fas fa-plus me-1"></i>Add Testimonial
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login to Add Testimonial
                                </a>
                            @endauth
                        </div>

                        @if($user->testimonials && $user->testimonials->count() > 0)
                            <div class="row g-4">
                                @foreach($user->testimonials as $testimonial)
                                    <div class="col-md-6">
                                        <div class="testimonial-card p-4 bg-light rounded-4 h-100">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 50px; height: 50px; flex-shrink: 0;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold">{{ $testimonial->author->first_name }} {{ $testimonial->author->last_name }}</h6>
                                                    <div class="d-flex align-items-center mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 0.8rem;"></i>
                                                        @endfor
                                                        <small class="text-muted ms-2">{{ $testimonial->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <blockquote class="mb-0">
                                                <p class="text-muted mb-0 fst-italic">"{{ $testimonial->content }}"</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-quote-right text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">No testimonials yet</p>
                                <small class="text-muted">Be the first to share your experience!</small>
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

<!-- Add Testimonial Modal -->
@auth
@if(auth()->id() !== $user->id)
<div class="modal fade" id="addTestimonialModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: #6f42c1;">
                    <i class="fas fa-quote-right me-2"></i>Add Testimonial
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('testimonials.store', $user) }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-4">
                        <label for="rating" class="form-label fw-semibold">Rating</label>
                        <div class="rating-input d-flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="d-none" required>
                                <label for="star{{ $i }}" class="star-label" style="cursor: pointer; font-size: 1.5rem; color: #ddd;">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label fw-semibold">Your Experience</label>
                        <textarea name="content" id="content" class="form-control border-0 bg-light" 
                                  rows="4" placeholder="Share your experience with {{ $user->first_name }}..." 
                                  style="border-radius: 15px;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-paper-plane me-1"></i>Submit Testimonial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

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
    
    .testimonial-card {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .testimonial-card:hover {
        border-color: #6f42c1;
        transform: translateY(-2px);
    }
    
    .star-label:hover,
    .star-label:hover ~ .star-label {
        color: #ffc107 !important;
    }
    
    .rating-input input:checked ~ label,
    .rating-input input:checked ~ label ~ label {
        color: #ffc107 !important;
    }
    
    /* Alert animations */
    .alert {
        animation: slideInDown 0.3s ease-out;
    }
    
    @keyframes slideInDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Auto-hide alerts after 5 seconds */
    .alert.auto-dismiss {
        animation: slideInDown 0.3s ease-out, fadeOut 0.5s ease-out 4.5s forwards;
    }
    
    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        
        .d-flex.flex-column.flex-sm-row {
            flex-direction: column;
        }
        
        .testimonial-card {
            margin-bottom: 1rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle star rating interaction
    const stars = document.querySelectorAll('.star-label');
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            ratingInputs[index].checked = true;
            updateStarDisplay(index + 1);
        });
        
        star.addEventListener('mouseenter', function() {
            updateStarDisplay(index + 1);
        });
    });
    
    document.querySelector('.rating-input')?.addEventListener('mouseleave', function() {
        const checkedInput = document.querySelector('input[name="rating"]:checked');
        const rating = checkedInput ? parseInt(checkedInput.value) : 0;
        updateStarDisplay(rating);
    });
    
    function updateStarDisplay(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ddd';
            }
        });
    }
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        // Add auto-dismiss class for animation
        alert.classList.add('auto-dismiss');
        
        // Auto-close success messages after 5 seconds
        if (alert.classList.contains('alert-success')) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }
        
        // Auto-close error messages after 8 seconds (give more time to read)
        if (alert.classList.contains('alert-danger')) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 8000);
        }
    });
});
</script>

@endsection