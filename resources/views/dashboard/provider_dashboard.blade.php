@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
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
        padding: 20px;
    }
    .card-header {
        background-color: #007bff;
        color: #fff;
    }
</style>

<div class="sidebar">
    <h4 class="text-center">Provider Dashboard</h4>
    <hr style="background-color: #fff;">
    <a href="#">Dashboard</a>
    <a href="#">Create Job</a>
    <a href="#">My Jobs</a>
    <a href="#">Profile</a>
    <a href="#">Logout</a>
</div>

<div class="main-content">
    <div id="notificationArea" class="notification-area"></div>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">My Jobs</h1>
            <a href="{{ route('work-tasks.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Create New Job</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Current Work Tasks</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($workTasks as $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task->title }}</td>
                                    <td><span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning text-dark' : 'danger') }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></td>
                                    <td>{{ ucfirst($task->priority) ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('work-tasks.show', $task) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('work-tasks.edit', $task) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No jobs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.notification-area {
    position: fixed;
    top: 80px;
    right: 20px;
    z-index: 1050;
    width: 350px;
}

.custom-alert {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border: none;
    color: #fff;
    margin-bottom: 1rem;
    opacity: 0.95;
    transform: translateX(100%);
    animation: slideIn 0.5s forwards;
}

.alert-content {
    display: flex;
    align-items: center;
}

.alert-icon {
    font-size: 1.5rem;
    margin-right: 1rem;
}

.alert-text {
    flex-grow: 1;
}

.alert-title {
    font-weight: bold;
}

.alert-message {
    font-size: 0.9rem;
}

.progress-bar-custom {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    width: 100%;
    background-color: rgba(0,0,0,0.2);
}

.progress-fill {
    height: 100%;
    background-color: #fff;
    width: 100%;
    animation: progress linear 5s forwards;
}

@keyframes slideIn {
    to {
        transform: translateX(0);
    }
}

.fade-out {
    animation: fadeOut 0.5s forwards;
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: scale(0.8);
    }
}

@keyframes progress {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        showNotification('success', 'Success', '{{ session('success') }}');
    @endif

    @if(session('error'))
        showNotification('danger', 'Error', '{{ session('error') }}');
    @endif

    @if($errors->any())
        let errorMessages = '<ul>';
        @foreach ($errors->all() as $error)
            errorMessages += '<li>{{ $error }}</li>';
        @endforeach
        errorMessages += '</ul>';
        showNotification('danger', 'Validation Error', errorMessages);
    @endif
});

function showNotification(type, title, message, duration = 5000) {
    const notificationArea = document.getElementById('notificationArea');
    
    const icons = {
        success: 'fas fa-check-circle',
        danger: 'fas fa-times-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };

    const notification = document.createElement('div');
    notification.className = `alert custom-alert alert-${type} alert-dismissible`;
    notification.innerHTML = `
        <div class="alert-content">
            <i class="${icons[type]} alert-icon"></i>
            <div class="alert-text">
                <div class="alert-title">${title}</div>
                <div class="alert-message">${message}</div>
            </div>
            <button type="button" class="btn-close" onclick="closeNotification(this)"></button>
        </div>
        <div class="progress-bar-custom">
            <div class="progress-fill" style="animation-duration: ${duration}ms"></div>
        </div>
    `;

    notificationArea.appendChild(notification);

    setTimeout(() => {
        if (notification.parentNode) {
            closeNotification(notification.querySelector('.btn-close'));
        }
    }, duration);
}

function closeNotification(button) {
    const notification = button.closest('.custom-alert');
    notification.classList.add('fade-out');
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 300);
}
</script>
@endpush
