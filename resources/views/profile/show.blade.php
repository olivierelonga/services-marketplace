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
    <div class="profile-layout">
        <div class="profile-sidebar-vue">
            <div class="text-center">
                @if ($user->profile_picture_url)
                    <img src="{{ $user->profile_picture_url }}" alt="Profile Picture" class="profile-picture-vue">
                @else
                    <div class="bg-primary d-flex align-items-center justify-content-center profile-picture-vue mx-auto">
                        <i class="fas fa-user text-white" style="font-size: 4rem;"></i>
                    </div>
                @endif
                <h2 class="profile-name-vue">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="profile-email-vue">{{ $user->email }}</p>
            </div>
            <div class="profile-stats-vue">
                <div class="stat-item-vue">
                    <div class="stat-value-vue">{{ $user->years_of_experience }}</div>
                    <div class="stat-label-vue">Years</div>
                </div>
                <div class="stat-item-vue">
                    <div class="stat-value-vue">R{{ $user->hourly_rate }}</div>
                    <div class="stat-label-vue">Hourly Rate</div>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactProviderModal">Contact Now</button>
                <button class="btn share-btn-vue" data-bs-toggle="modal" data-bs-target="#shareProfileModal">Share Profile</button>
            </div>
        </div>
        <div class="profile-main-vue">
            <div class="profile-card-vue">
                <div class="card-header-vue">
                    <i class="fas fa-user"></i>
                    <h3 class="card-title-vue">About Me</h3>
                </div>
                <p>{{ $user->bio ?? 'A results-oriented professional with a passion for creating value.' }}</p>
            </div>
            <div class="profile-card-vue">
                <div class="card-header-vue">
                    <i class="fas fa-concierge-bell"></i>
                    <h3 class="card-title-vue">Services</h3>
                </div>
                @if($user->services->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($user->services as $service)
                            <span class="service-tag-vue">{{ $service->name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No services listed at the moment.</p>
                @endif
            </div>
            <div class="profile-card-vue">
                <div class="card-header-vue">
                    <i class="fas fa-star"></i>
                    <h3 class="card-title-vue">Testimonials</h3>
                </div>
                @if($user->testimonials && $user->testimonials->count() > 0)
                    @foreach($user->testimonials as $testimonial)
                        <div class="testimonial-vue">
                            <div class="d-flex justify-content-between">
                                <p class="mb-1">"{{ $testimonial->content }}"</p>
                                <div class="rating-vue">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? '' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted">- {{ $testimonial->author->first_name }}</small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No testimonials to show yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Contact Provider Modal -->
<div class="modal fade" id="contactProviderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header">
                <h5 class="modal-title">Contact {{ $user->first_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            @auth
                <form action="{{ route('contacts.store', $user) }}" method="POST" id="contactForm">
                    @csrf
                    <input class="form-check-input" type="hidden" name="receiver_id" value="{{$user->id}}" checked>
                    <div class="modal-body">
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
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#signUpChoiceModal">
                            <i class="fas fa-user-plus me-1"></i>Sign Up
                        </button>
                    </div>
                    
                    <!-- Alternative Contact Methods -->
                    {{-- <div class="mt-4 pt-4 border-top">
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
                    </div> --}}
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- Sign Up Choice Modal -->
<div class="modal fade" id="signUpChoiceModal" tabindex="-1" aria-labelledby="signUpChoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="signUpChoiceModalLabel">Join as:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="d-grid gap-3">
                    <a href="{{ route('user.form') }}" class="btn btn-primary btn-lg rounded-pill">
                        <i class="fas fa-user me-1"></i> A Normal User
                    </a>
                    <a href="{{ route('provider.form') }}" class="btn btn-outline-primary btn-lg rounded-pill">
                        <i class="fas fa-briefcase me-1"></i> A Service Provider
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Share Profile Modal -->
<div class="modal fade" id="shareProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title">Share Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body share-modal-body">
                <div class="row gy-3">
                    <div class="col-4 text-center">
                        <a href="#" class="share-btn" onclick="shareToFacebook()"><i class="fab fa-facebook"></i><span>Facebook</span></a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#" class="share-btn" onclick="shareToX()"><i class="fab fa-xing"></i><span>X</span></a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#" class="share-btn" onclick="shareToLinkedIn()"><i class="fab fa-linkedin"></i><span>LinkedIn</span></a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#" class="share-btn" onclick="shareToWhatsApp()"><i class="fab fa-whatsapp"></i><span>WhatsApp</span></a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#" class="share-btn" onclick="shareViaEmail()"><i class="fas fa-envelope"></i><span>Email</span></a>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <input type="text" class="form-control" value="{{ url()->current() }}" id="profileUrl">
                    <button class="btn btn-outline-secondary" type="button" onclick="copyProfileLink()">Copy</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function copyProfileLink() {
        var copyText = document.getElementById("profileUrl");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
    }

    function shareToFacebook() {
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
    }

    function shareToX() {
        window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href), '_blank');
    }

    function shareToLinkedIn() {
        window.open('https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(window.location.href), '_blank');
    }

    function shareToWhatsApp() {
        window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(window.location.href), '_blank');
    }

    function shareViaEmail() {
        window.location.href = 'mailto:?subject=Check out this profile&body=' + encodeURIComponent(window.location.href);
    }
</script>
@endpush
