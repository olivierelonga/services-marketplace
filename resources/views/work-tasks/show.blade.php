@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
    }
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        background-color: #343a40;
        color: #fff;
        padding-top: 20px;
    }
    .sidebar a {
        color: #fff;
        text-decoration: none;
        display: block;
        padding: 10px 15px;
    }
    .sidebar a:hover {
        background-color: #495057;
    }
    .main-content {
        margin-left: 250px;
        padding: 30px;
    }
    .card-title-icon {
        margin-right: 10px;
    }
    #imageModal .modal-content {
        background-color: transparent;
        border: none;
    }
    #imageModal .modal-body {
        position: relative;
    }
    #imageModal .carousel-control-prev, #imageModal .carousel-control-next {
        opacity: 0;
        transition: opacity 0.3s ease;
        width: 5%;
    }
    #imageModal .modal-body:hover .carousel-control-prev, #imageModal .modal-body:hover .carousel-control-next {
        opacity: 0.8;
    }
</style>

<div class="sidebar">
    <h4 class="text-center">Provider Dashboard</h4>
    <hr style="background-color: #fff;">
    <a href="{{ route('provider.dashboard') }}"><i class="fas fa-tachometer-alt card-title-icon"></i>Dashboard</a>
    <a href="{{ route('work-tasks.create') }}"><i class="fas fa-plus card-title-icon"></i>Create Job</a>
    <a href="{{ route('provider.dashboard') }}"><i class="fas fa-tasks card-title-icon"></i>My Jobs</a>
    <a href="#"><i class="fas fa-user card-title-icon"></i>Profile</a>
    <a href="#"><i class="fas fa-sign-out-alt card-title-icon"></i>Logout</a>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $workTask->title }}</h1>
            <div>
                <a href="{{ route('work-tasks.edit', $workTask) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash me-1"></i>Delete</button>
                <a href="{{ route('provider.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Description Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle card-title-icon"></i>Description</h6>
                    </div>
                    <div class="card-body">
                        <p>{{ $workTask->description ?? 'No description provided.' }}</p>
                    </div>
                </div>

                <!-- Client & Location Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-friends card-title-icon"></i>Client & Location</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"><i class="fas fa-user me-2"></i><strong>Client:</strong> {{ $workTask->client_name ?? 'N/A' }}</div>
                            <div class="col-md-6"><i class="fas fa-phone me-2"></i><strong>Contact:</strong> {{ $workTask->client_contact ?? 'N/A' }}</div>
                            <div class="col-md-6"><i class="fas fa-envelope me-2"></i><strong>Email:</strong> {{ $workTask->client_email ?? 'N/A' }}</div>
                            <div class="col-md-6"><i class="fas fa-map-marker-alt me-2"></i><strong>Address:</strong> {{ $workTask->address ?? 'N/A' }}</div>
                        </div>
                        <hr>
                        <p><strong><i class="fas fa-key me-2"></i>Access Instructions:</strong> {{ $workTask->access_instructions ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Task Specifics Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tools card-title-icon"></i>Task Specifics</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Materials Needed:</strong> {{ $workTask->materials_needed ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Tools Required:</strong> {{ $workTask->tools_required ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Measurements:</strong> {{ $workTask->measurements ?? 'N/A' }}</li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <!-- Task Status Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks card-title-icon"></i>Status & Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Status:</span>
                            <span class="badge bg-info text-dark">{{ ucfirst(str_replace('_', ' ', $workTask->status)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Priority:</span>
                            <span class="badge bg-warning text-dark">{{ ucfirst($workTask->priority) ?? 'N/A' }}</span>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h6 class="text-muted">Estimated Cost</h6>
                            <h4>R{{ number_format($workTask->estimated_cost, 2) ?? 'N/A' }}</h4>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h6 class="text-muted">Estimated Hours</h6>
                            <h4>{{ $workTask->estimated_hours ?? 'N/A' }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Photos Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-camera card-title-icon"></i>Photos</h6>
                    </div>
                    <div class="card-body">
                        @if($workTask->photos && count(json_decode($workTask->photos)) > 0)
                            @foreach(json_decode($workTask->photos) as $photo)
                                <a href="#" class="expand-image" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{ asset('storage/' . $photo) }}">
                                    <img src="{{ asset('storage/' . $photo) }}" class="img-fluid rounded mb-2" alt="Task Photo">
                                </a>
                            @endforeach
                        @else
                            <p class="text-center text-muted">No photos uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center position-relative">
        <img src="" id="modalImage" class="img-fluid">
        <a class="carousel-control-prev" href="#" role="button" id="modalPrev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#" role="button" id="modalNext">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this work task? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form action="{{ route('work-tasks.destroy', $workTask) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalImage = document.getElementById('modalImage');
    const expandImageLinks = document.querySelectorAll('.expand-image');
    const modalPrev = document.getElementById('modalPrev');
    const modalNext = document.getElementById('modalNext');

    let images = [];
    let currentIndex = 0;

    expandImageLinks.forEach((link, index) => {
        images.push(link.getAttribute('data-src'));
        link.addEventListener('click', function (event) {
            event.preventDefault();
            currentIndex = index;
            updateModalImage();
        });
    });

    function updateModalImage() {
        modalImage.setAttribute('src', images[currentIndex]);
    }

    modalPrev.addEventListener('click', function(e) {
        e.preventDefault();
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
        updateModalImage();
    });

    modalNext.addEventListener('click', function(e) {
        e.preventDefault();
        currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
        updateModalImage();
    });

    document.addEventListener('keydown', function (e) {
        if (document.getElementById('imageModal').classList.contains('show')) {
            if (e.key === 'ArrowLeft') {
                modalPrev.click();
            } else if (e.key === 'ArrowRight') {
                modalNext.click();
            }
        }
    });
});
</script>
@endpush
