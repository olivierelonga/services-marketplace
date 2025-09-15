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
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Contact {{ $user->first_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center bg-light p-5">
                            <div class="text-center">
                                <img src="{{ $user->profile_picture_url ?? 'https://i.pravatar.cc/150?u=' . $user->id }}" alt="Profile Picture" class="img-fluid rounded-circle mb-4" style="width: 150px; height: 150px; object-fit: cover;">
                                <h2 class="fw-bold mb-3">{{ $user->first_name }} {{ $user->last_name }}</h2>
                                <p class="text-muted mb-4">{{ $user->email }}</p>
                                <div class="d-flex justify-content-center gap-4">
                                    <div class="text-center">
                                        <div class="fw-bold fs-4">{{ $user->years_of_experience }}</div>
                                        <div class="text-muted">Years</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-bold fs-4">R{{ $user->hourly_rate }}</div>
                                        <div class="text-muted">Hourly Rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 p-5">
                            <h2 class="fw-bold mb-4">Send a Message</h2>
                            <form action="{{ route('contacts.store', $user) }}" method="POST" id="contactForm">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{$user->id}}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_method_email" class="form-label">Contact Method</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contact_method" id="contact_method_email" value="email" checked>
                                            <label class="form-check-label" for="contact_method_email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_method_phone" class="form-label">&nbsp;</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="contact_method" id="contact_method_phone" value="phone">
                                            <label class="form-check-label" for="contact_method_phone">Phone</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3" id="phoneField" style="display: none;">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="tel" name="phone_number" id="phone_number" class="form-control form-control-lg" placeholder="Your Phone Number">
                                </div>
                                <div class="mb-3">
                                    <label for="service_interest" class="form-label">Service of Interest</label>
                                    <select name="service_interest" id="service_interest" class="form-select form-select-lg">
                                        <option value="">Select a service</option>
                                        @foreach($user->services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="timeline" class="form-label">Project Timeline <span class="text-danger">*</span></label>
                                        <select name="timeline" id="timeline" class="form-select form-select-lg" required>
                                            <option value="">Select a timeline</option>
                                            <option value="asap">ASAP</option>
                                            <option value="within_month">Within a month</option>
                                            <option value="1_3_months">1-3 months</option>
                                            <option value="3_6_months">3-6 months</option>
                                            <option value="just_browsing">Just browsing</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="budget_range" class="form-label">Budget Range</label>
                                        <select name="budget_range" id="budget_range" class="form-select form-select-lg">
                                            <option value="">Select a budget</option>
                                            <option value="under_500">Under R500</option>
                                            <option value="500_1000">R500 - R1,000</option>
                                            <option value="1000_2500">R1,000 - R2,500</option>
                                            <option value="2500_5000">R2,500 - R5,000</option>
                                            <option value="5000_10000">R5,000 - R10,000</option>
                                            <option value="over_10000">Over R10,000</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" class="form-control form-control-lg" rows="5" placeholder="Tell us about your project..." required></textarea>
                                    <div class="form-text">You can type your message here or record a voice memo below (or both).</div>
                                </div>
                                
                                <!-- Voice Memo Section using RecordRTC -->
                                <div class="mb-3">
                                    <label class="form-label">Voice Memo (Optional)</label>
                                    <div class="card" style="border: 2px dashed #dee2e6;">
                                        <div class="card-body">
                                            <!-- Recording Controls -->
                                            <div id="voice-recorder-container">
                                                <div id="start-section" class="text-center">
                                                    <button type="button" id="start-recording" class="btn btn-outline-primary">
                                                        <i class="bi bi-mic-fill me-2"></i>Start Voice Recording
                                                    </button>
                                                    <p class="text-muted small mt-2">Click to record a voice message</p>
                                                </div>
                                                
                                                <div id="recording-section" class="text-center" style="display: none;">
                                                    <div class="mb-3">
                                                        <div class="recording-pulse">
                                                            <div class="pulse-ring"></div>
                                                            <i class="bi bi-mic-fill text-danger fs-1"></i>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="badge bg-danger fs-6" id="recording-timer">00:00</span>
                                                    </div>
                                                    <button type="button" id="stop-recording" class="btn btn-danger">
                                                        <i class="bi bi-stop-fill me-2"></i>Stop Recording
                                                    </button>
                                                </div>
                                                
                                                <div id="playback-section" style="display: none;">
                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <div>
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                            <span class="text-success">Voice memo recorded!</span>
                                                        </div>
                                                        <span id="recording-duration" class="badge bg-info"></span>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <audio controls class="w-100" id="audio-playback">
                                                            Your browser does not support audio playback.
                                                        </audio>
                                                    </div>
                                                    
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button type="button" id="re-record" class="btn btn-outline-secondary btn-sm">
                                                            <i class="bi bi-arrow-clockwise me-1"></i>Re-record
                                                        </button>
                                                        <button type="button" id="delete-recording" class="btn btn-outline-danger btn-sm">
                                                            <i class="bi bi-trash me-1"></i>Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="has_voice_memo" id="has_voice_memo" value="0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
<!-- RecordRTC for reliable audio recording -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/RecordRTC/5.6.2/RecordRTC.min.js"></script>

<style>
.recording-pulse {
    position: relative;
    display: inline-block;
}

.pulse-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    border: 3px solid #dc3545;
    border-radius: 50%;
    animation: pulse 1.5s ease-out infinite;
}

@keyframes pulse {
    0% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(0.5);
    }
    100% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(1.5);
    }
}

.voice-recorder-card {
    transition: all 0.3s ease;
}

.voice-recorder-card:hover {
    border-color: #0d6efd !important;
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.1);
}
</style>

<script>
$(document).ready(function() {
    // Form elements
    const phoneField = $('#phoneField');
    const contactEmail = $('#contact_method_email');
    const contactPhone = $('#contact_method_phone');
    const hasVoiceMemoInput = $('#has_voice_memo');
    
    // Voice recording elements
    const startSection = $('#start-section');
    const recordingSection = $('#recording-section');
    const playbackSection = $('#playback-section');
    const startBtn = $('#start-recording');
    const stopBtn = $('#stop-recording');
    const reRecordBtn = $('#re-record');
    const deleteBtn = $('#delete-recording');
    const timerElement = $('#recording-timer');
    const durationElement = $('#recording-duration');
    const audioPlayback = $('#audio-playback')[0];
    
    // Recording variables
    let recorder = null;
    let recordingBlob = null;
    let timerInterval = null;
    let recordingStartTime = null;

    // Contact method toggle
    contactEmail.on('change', function() {
        if ($(this).is(':checked')) {
            phoneField.hide();
        }
    });

    contactPhone.on('change', function() {
        if ($(this).is(':checked')) {
            phoneField.show();
        }
    });

    // Start recording
    startBtn.on('click', async function() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                audio: {
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true
                }
            });

            // Initialize RecordRTC
            recorder = new RecordRTC(stream, {
                type: 'audio',
                mimeType: 'audio/webm',
                recorderType: RecordRTC.StereoAudioRecorder,
                numberOfAudioChannels: 1,
                desiredSampRate: 16000
            });

            // Start recording
            recorder.startRecording();
            recordingStartTime = Date.now();

            // Update UI
            startSection.hide();
            recordingSection.show();

            // Start timer
            let seconds = 0;
            timerInterval = setInterval(() => {
                seconds++;
                const mins = Math.floor(seconds / 60).toString().padStart(2, '0');
                const secs = (seconds % 60).toString().padStart(2, '0');
                timerElement.text(`${mins}:${secs}`);
            }, 1000);

        } catch (error) {
            console.error('Error accessing microphone:', error);
            alert('Could not access microphone. Please check your browser permissions.');
        }
    });


    // Stop recording - FIXED VERSION
    stopBtn.on('click', function() {
        if (recorder) {
            recorder.stopRecording(function() {
                // Get the recorded blob
                recordingBlob = recorder.getBlob();
                
                // Stop the stream - ADD NULL CHECK HERE
                try {
                    const internalRecorder = recorder.getInternalRecorder();
                    if (internalRecorder && internalRecorder.stream) {
                        internalRecorder.stream.getTracks().forEach(track => track.stop());
                    }
                } catch (error) {
                    console.warn('Error stopping stream tracks:', error);
                }
                
                // Clear timer
                clearInterval(timerInterval);
                
                // Calculate duration
                const duration = Math.floor((Date.now() - recordingStartTime) / 1000);
                const mins = Math.floor(duration / 60).toString().padStart(2, '0');
                const secs = (duration % 60).toString().padStart(2, '0');
                durationElement.text(`${mins}:${secs}`);
                
                // Create audio URL for playback
                const audioUrl = URL.createObjectURL(recordingBlob);
                audioPlayback.src = audioUrl;
                
                // Update UI
                recordingSection.hide();
                playbackSection.show();
                
                // Mark that we have a voice memo
                hasVoiceMemoInput.val('1');
                
                console.log('Recording completed:', recordingBlob);
            });
        }
    });

    // Re-record
    reRecordBtn.on('click', function() {
        resetRecording();
    });

    // Delete recording
    deleteBtn.on('click', function() {
        if (confirm('Are you sure you want to delete this voice memo?')) {
            resetRecording();
        }
    });

    // Enhanced resetRecording function with better cleanup
    function resetRecording() {
        // Clean up stream tracks first
        if (recorder) {
            try {
                const internalRecorder = recorder.getInternalRecorder();
                if (internalRecorder && internalRecorder.stream) {
                    internalRecorder.stream.getTracks().forEach(track => track.stop());
                }
            } catch (error) {
                console.warn('Error stopping tracks during reset:', error);
            }
        }
        
        // Clean up audio URL
        if (audioPlayback.src) {
            URL.revokeObjectURL(audioPlayback.src);
            audioPlayback.src = '';
        }
        
        recordingBlob = null;
        recorder = null;
        
        if (timerInterval) {
            clearInterval(timerInterval);
        }
        
        // Reset UI
        playbackSection.hide();
        recordingSection.hide();
        startSection.show();
        
        timerElement.text('00:00');
        hasVoiceMemoInput.val('0');
    }

    // Form submission
    // $('#contactForm').on('submit', function(e) {
    //     e.preventDefault();

    //     // Validation
    //     const timeline = $('#timeline').val();
    //     const message = $('#message').val().trim();
        
    //     let errors = [];
        
    //     if (!timeline) {
    //         errors.push('Please select a project timeline.');
    //     }
        
    //     if (!message) {
    //         errors.push('Please enter a message.');
    //     }
        
    //     if (errors.length > 0) {
    //         alert(errors.join('\n'));
    //         return;
    //     }

    //     // Prepare form data
    //     const formData = new FormData(this);
        
    //     // Add voice memo if exists
    //     if (recordingBlob) {
    //         formData.append('voice_memo', recordingBlob, 'voice_memo.webm');
    //     }

    //     // Show loading state
    //     const submitBtn = $(this).find('button[type="submit"]');
    //     const originalText = submitBtn.html();
    //     submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Sending...').prop('disabled', true);

    //     // Submit form
    //     $.ajax({
    //         url: this.action,
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         headers: {
    //             'X-Requested-With': 'XMLHttpRequest'
    //         },
    //         success: function(response) {
    //             alert('Message sent successfully! The service provider will get back to you soon.');
    //             $('#contactProviderModal').modal('hide');
    //             resetForm();
    //         },
    //         error: function(xhr) {
    //             console.error('Error:', xhr.responseJSON);
                
    //             let errorMessage = 'Error sending message. Please try again.';
                
    //             if (xhr.responseJSON && xhr.responseJSON.errors) {
    //                 const errors = xhr.responseJSON.errors;
    //                 const messages = [];
                    
    //                 Object.keys(errors).forEach(field => {
    //                     errors[field].forEach(msg => messages.push(`• ${msg}`));
    //                 });
                    
    //                 errorMessage = 'Please fix the following errors:\n\n' + messages.join('\n');
    //             } else if (xhr.responseJSON && xhr.responseJSON.message) {
    //                 errorMessage = xhr.responseJSON.message;
    //             }
                
    //             alert(errorMessage);
    //         },
    //         complete: function() {
    //             submitBtn.html(originalText).prop('disabled', false);
    //         }
    //     });
    // });

    // Reset entire form
    function resetForm() {
        $('#contactForm')[0].reset();
        phoneField.hide();
        contactEmail.prop('checked', true);
        resetRecording();
    }

    // Also fix the cleanup in modal close handler
    $('#contactProviderModal').on('hidden.bs.modal', function() {
        if (recorder && recorder.getState() === 'recording') {
            recorder.stopRecording(() => {
                try {
                    const internalRecorder = recorder.getInternalRecorder();
                    if (internalRecorder && internalRecorder.stream) {
                        internalRecorder.stream.getTracks().forEach(track => track.stop());
                    }
                } catch (error) {
                    console.warn('Error stopping stream tracks on modal close:', error);
                }
            });
        }
        resetForm();
    });
});

// Social sharing functions
function copyProfileLink() {
    const copyText = document.getElementById("profileUrl");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    
    navigator.clipboard.writeText(copyText.value).then(function() {
        alert("Profile link copied to clipboard!");
    }).catch(function() {
        document.execCommand("copy");
        alert("Profile link copied to clipboard!");
    });
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