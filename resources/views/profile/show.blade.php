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
                <button class="btn btn-primary btn-lg px-4 py-3 rounded-4 fw-semibold" 
                        data-bs-toggle="modal" data-bs-target="#contactProviderModal">
                    <i class="fas fa-message me-2"></i>Contact Provider
                </button>

                <div class="dropdown">
                    <button class="btn btn-outline-light btn-lg px-4 py-3 rounded-4 fw-semibold share-prof dropdown-toggle" 
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-share me-2"></i>Share Profile
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius: 15px; min-width: 200px;">
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="copyProfileLink()">
                                <i class="fas fa-link text-primary me-3"></i>
                                <div>
                                    <div class="fw-semibold">Copy Link</div>
                                    <small class="text-muted">Copy profile URL</small>
                                </div>
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="shareToWhatsApp()">
                                <i class="fab fa-whatsapp text-success me-3"></i>
                                <div>
                                    <div class="fw-semibold">WhatsApp</div>
                                    <small class="text-muted">Share via WhatsApp</small>
                                </div>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="shareToTwitter()">
                                <i class="fab fa-twitter text-info me-3"></i>
                                <div>
                                    <div class="fw-semibold">Twitter</div>
                                    <small class="text-muted">Share on Twitter</small>
                                </div>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="shareToLinkedIn()">
                                <i class="fab fa-linkedin text-primary me-3"></i>
                                <div>
                                    <div class="fw-semibold">LinkedIn</div>
                                    <small class="text-muted">Share on LinkedIn</small>
                                </div>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="shareToFacebook()">
                                <i class="fab fa-facebook text-primary me-3"></i>
                                <div>
                                    <div class="fw-semibold">Facebook</div>
                                    <small class="text-muted">Share on Facebook</small>
                                </div>
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="shareViaEmail()">
                                <i class="fas fa-envelope text-warning me-3"></i>
                                <div>
                                    <div class="fw-semibold">Email</div>
                                    <small class="text-muted">Share via email</small>
                                </div>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="shareViaSMS()">
                                <i class="fas fa-sms text-success me-3"></i>
                                <div>
                                    <div class="fw-semibold">SMS</div>
                                    <small class="text-muted">Share via text message</small>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
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

<!-- Contact Provider Modal -->
<div class="modal fade" id="contactProviderModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary rounded-circle p-2 me-3">
                        <i class="fas fa-message text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Contact {{ $user->first_name }}</h5>
                        <small class="text-muted">Send a message to this service provider</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            @auth
                <form action="{{ route('contacts.store', $user) }}" method="POST" id="contactForm">
                    @csrf
                    <input class="form-check-input" type="hidden" name="receiver_id" value="{{$user->id}}" checked>
                    <div class="modal-body px-4">
                        <!-- Contact Method Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">How would you like to be contacted back?</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="contact_method" id="contact_email" value="email" checked>
                                        <label class="form-check-label d-flex align-items-center" for="contact_email">
                                            <i class="fas fa-envelope text-primary me-2"></i>
                                            <div>
                                                <div class="fw-semibold">Email</div>
                                                <small class="text-muted">{{ auth()->user()->email }}</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="contact_method" id="contact_phone" value="phone">
                                        <label class="form-check-label d-flex align-items-center" for="contact_phone">
                                            <i class="fas fa-phone text-success me-2"></i>
                                            <div>
                                                <div class="fw-semibold">Phone</div>
                                                <small class="text-muted">Enter phone number below</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone Number Field (shown when phone is selected) -->
                        <div class="mb-4" id="phoneField" style="display: none;">
                            <label for="phone_number" class="form-label fw-semibold">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0" style="border-radius: 15px 0 0 15px;">
                                    <i class="fas fa-phone text-success"></i>
                                </span>
                                <input type="tel" name="phone_number" id="phone_number" class="form-control border-0 bg-light" placeholder="{{ auth()->check() ? auth()->user()->phone : '' }}" value="{{ auth()->check() ? auth()->user()->phone : '' }}" style="border-radius: 0 15px 15px 0;">
                            </div>
                        </div>

                        <!-- Service Interest -->
                        <div class="mb-4">
                            <label for="service_interest" class="form-label fw-semibold">Service of Interest</label>
                            <select name="service_interest" id="service_interest" class="form-select border-0 bg-light" style="border-radius: 15px;">
                                <option value="">Select a service (optional)</option>
                                @foreach($user->services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                                <option value="other">Other / General Inquiry</option>
                            </select>
                        </div>

                        <!-- Project Timeline -->
                        <div class="mb-4">
                            <label for="timeline" class="form-label fw-semibold">Project Timeline</label>
                            <select name="timeline" id="timeline" class="form-select border-0 bg-light" style="border-radius: 15px;" required>
                                <option value="">When do you need this done?</option>
                                <option value="asap">ASAP (Within a week)</option>
                                <option value="within_month">Within a month</option>
                                <option value="1_3_months">1-3 months</option>
                                <option value="3_6_months">3-6 months</option>
                                <option value="just_browsing">Just browsing/getting quotes</option>
                            </select>
                            <div class="form-text mt-2">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-phone text-success me-2 mt-1" style="font-size: 0.8rem;"></i>
                                    <small class="text-muted">
                                        <strong>Need immediate assistance?</strong> 
                                        @auth
                                            <a href="tel:{{ $user->phone_number ?? $user->email }}" class="text-decoration-none text-success fw-semibold">
                                                Call {{ $user->first_name }} directly
                                            </a>
                                            @if($user->phone_number)
                                                at <span class="fw-semibold">{{ $user->phone_number }}</span>
                                            @else
                                                or <a href="mailto:{{ $user->email }}" class="text-decoration-none text-success">email immediately</a>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-link p-0 text-success fw-semibold text-decoration-none" 
                                                    onclick="showLoginPrompt()" style="vertical-align: baseline; font-size: inherit;">
                                                Call {{ $user->first_name }} directly
                                            </button> 
                                            <span class="text-muted">(login required to view contact info)</span>
                                        @endauth
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Budget Range -->
                        <div class="mb-4">
                            <label for="budget_range" class="form-label fw-semibold">Budget Range (Optional)</label>
                            <select name="budget_range" id="budget_range" class="form-select border-0 bg-light" style="border-radius: 15px;">
                                <option value="">Select budget range</option>
                                <option value="under_500">Under R500</option>
                                <option value="500_1000">R500 - R1,000</option>
                                <option value="1000_2500">R1,000 - R2,500</option>
                                <option value="2500_5000">R2,500 - R5,000</option>
                                <option value="5000_10000">R5,000 - R10,000</option>
                                <option value="over_10000">Over R10,000</option>
                            </select>
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">Message</label>
                            <textarea name="message" id="message" class="form-control border-0 bg-light" 
                                      rows="4" placeholder="Describe your project or ask any questions..." 
                                      style="border-radius: 15px;" required></textarea>
                            <div class="form-text">
                                <small class="text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Tip: Be specific about your requirements to get a better response
                                </small>
                            </div>
                        </div>

                        <!-- Provider Info Summary -->
                        <div class="bg-light rounded-4 p-3 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $user->first_name }}</h6>
                                    <div class="d-flex align-items-center gap-3 text-muted">
                                        <small><i class="fas fa-star text-warning me-1"></i>{{ $user->years_of_experience }} years exp.</small>
                                        <small><i class="fas fa-money-bill text-success me-1"></i>R{{ $user->hourly_rate }}/hour</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-paper-plane me-1"></i>Send Message
                        </button>
                    </div>
                </form>
            @else
                <!-- Not Authenticated View -->
                <div class="modal-body px-4 text-center py-5">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-lock text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Login Required</h5>
                        <p class="text-muted mb-4">You need to be logged in to contact service providers.</p>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                        <a href="{{ route('user.form') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-user-plus me-1"></i>Sign Up
                        </a>
                    </div>
                    
                    <!-- Alternative Contact Methods -->
                    <div class="mt-4 pt-4 border-top">
                        <p class="text-muted mb-3"><small>Or contact directly:</small></p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="mailto:{{ $user->email }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                                <i class="fas fa-envelope me-1"></i>Email
                            </a>
                            @if($user->phone_number)
                                <a href="tel:{{ $user->phone_number }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                                    <i class="fas fa-phone me-1"></i>Call
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endauth
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
    
    /* Share toast animations */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    /* Share dropdown styling */
    .dropdown-menu {
        padding: 0.5rem 0;
    }
    
    .dropdown-item {
        border-radius: 8px;
        margin: 0 0.5rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }
    
    /* Phone field animation */
    #phoneField {
        transition: all 0.3s ease;
    }
    
    /* Contact method radio styling */
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .form-check-label {
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0.5rem;
        border-radius: 8px;
    }
    
    .form-check-label:hover {
        background-color: #f8f9fa;
    }
    
    .form-check-input:checked + .form-check-label {
        background-color: #e7f3ff;
        border: 1px solid #0d6efd;
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
    
    // Profile sharing functionality
    const profileUrl = window.location.href;
    const profileTitle = `{{ $user->first_name }}'s Profile - Professional Service Provider`;
    const profileDescription = `Check out {{ $user->first_name }}'s profile on Yelp. ${'{'}{{ $user->years_of_experience }}{'}'}+ years of experience, R{{'{'}}{{ $user->hourly_rate }}{'}'}}/hour. View services and testimonials.`;

    // copy clipboard
    window.copyProfileLink = function() {
        navigator.clipboard.writeText(profileUrl).then(function() {
            showShareToast('Profile link copied to clipboard!', 'success');
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = profileUrl;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showShareToast('Profile link copied to clipboard!', 'success');
        });
    };

    // whatsApp
    window.shareToWhatsApp = function() {
        const text = encodeURIComponent(`${profileDescription}\n\n${profileUrl}`);
        window.open(`https://wa.me/?text=${text}`, '_blank');
    };

    //twitter
    window.shareToTwitter = function() {
        const text = encodeURIComponent(profileDescription);
        const url = encodeURIComponent(profileUrl);
        window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
    };

    // linkedIn
    window.shareToLinkedIn = function() {
        const url = encodeURIComponent(profileUrl);
        const title = encodeURIComponent(profileTitle);
        const summary = encodeURIComponent(profileDescription);
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}&title=${title}&summary=${summary}`, '_blank');
    };

    //FB
    window.shareToFacebook = function() {
        const url = encodeURIComponent(profileUrl);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
    };

    // email
    window.shareViaEmail = function() {
        const subject = encodeURIComponent(profileTitle);
        const body = encodeURIComponent(`Hi!\n\nI wanted to share this service provider's profile with you:\n\n${profileDescription}\n\n${profileUrl}\n\nBest regards`);
        window.location.href = `mailto:?subject=${subject}&body=${body}`;
    };

    //sms
    window.shareViaSMS = function() {
        const text = encodeURIComponent(`Check out ${profileTitle}: ${profileUrl}`);
        if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
            window.location.href = `sms:?body=${text}`;
        } else {
            // For desktop, copy to clipboard as fallback
            navigator.clipboard.writeText(`Check out ${profileTitle}: ${profileUrl}`).then(function() {
                showShareToast('Message copied to clipboard! You can paste it in your messaging app.', 'info');
            });
        }
    };

    // Native Web Share API (for mobile devices that support it)
    window.shareNative = function() {
        if (navigator.share) {
            navigator.share({
                title: profileTitle,
                text: profileDescription,
                url: profileUrl
            }).then(() => {
                showShareToast('Profile shared successfully!', 'success');
            }).catch(() => {
                // Fallback to copy link
                copyProfileLink();
            });
        } else {
            copyProfileLink();
        }
    };

    // Toast notification function
    function showShareToast(message, type = 'success') {
        // Remove existing toast if any
        const existingToast = document.querySelector('.share-toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `share-toast alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} shadow-lg`;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 15px;
            border: none;
            animation: slideInRight 0.3s ease-out;
        `;
        
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                ${message}
            </div>
        `;

        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 3000);
    }
});

// Simple function to toggle phone field visibility
function togglePhoneField() {
    const phoneRadio = document.getElementById('contact_phone');
    const emailRadio = document.getElementById('contact_email');
    const phoneField = document.getElementById('phoneField');
    const phoneInput = document.getElementById('phone_number');
    
    // Check if phone radio is selected
    if (phoneRadio && phoneRadio.checked) {
        phoneField.style.display = 'block';
        phoneInput.required = true;
    } else {
        phoneField.style.display = 'none';
        phoneInput.required = false;
        phoneInput.value = ''; // Clear the input
    }
}

// Add event listeners to both radio buttons
document.addEventListener('DOMContentLoaded', function() {
    const phoneRadio = document.getElementById('contact_phone');
    const emailRadio = document.getElementById('contact_email');
    
    if (phoneRadio) {
        phoneRadio.addEventListener('change', togglePhoneField);
    }
    
    if (emailRadio) {
        emailRadio.addEventListener('change', togglePhoneField);
    }
    
    // Initialize on page load
    togglePhoneField();
});

// Alternative: Even simpler inline approach
function showPhoneField() {
    document.getElementById('phoneField').style.display = 'block';
    document.getElementById('phone_number').required = true;
}

function hidePhoneField() {
    document.getElementById('phoneField').style.display = 'none';
    document.getElementById('phone_number').required = false;
    document.getElementById('phone_number').value = '';
}

// You can also add this directly to the radio buttons in HTML:
// <input type="radio" name="contact_method" id="contact_phone" value="phone" onchange="showPhoneField()">
// <input type="radio" name="contact_method" id="contact_email" value="email" onchange="hidePhoneField()">

</script>

@endsection