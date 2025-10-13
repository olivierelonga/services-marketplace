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
</style>

<div class="sidebar">
    <h4 class="text-center">Provider Dashboard</h4>
    <hr style="background-color: #fff;">
    <a href="{{ route('provider.dashboard') }}"><i class="fas fa-tachometer-alt card-title-icon"></i>Dashboard</a>
    <a href="{{ route('work-tasks.create') }}"><i class="fas fa-plus card-title-icon"></i>Create Job</a>
    <a href="{{ route('provider.dashboard') }}"><i class="fas fa-tasks card-title-icon"></i>My Jobs</a>
    <a href="{{ route('dashboard') }}"><i class="fas fa-user card-title-icon"></i>Profile</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt card-title-icon"></i>Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create New Work Task</h1>
            <a href="{{ route('provider.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back to Dashboard</a>
        </div>

        <form action="{{ route('work-tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle card-title-icon"></i>Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-friends card-title-icon"></i>Client & Location</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3"><label for="client_name">Client Name</label><input type="text" class="form-control" id="client_name" name="client_name"></div>
                                <div class="col-md-6 mb-3"><label for="client_contact">Client Contact</label><input type="text" class="form-control" id="client_contact" name="client_contact"></div>
                                <div class="col-md-6 mb-3"><label for="client_email">Client Email</label><input type="email" class="form-control" id="client_email" name="client_email"></div>
                                <div class="col-md-6 mb-3"><label for="address">Address</label><input type="text" class="form-control" id="address" name="address"></div>
                            </div>
                            <div class="mb-3"><label for="access_instructions">Access Instructions</label><textarea class="form-control" id="access_instructions" name="access_instructions" rows="2"></textarea></div>
                        </div>
                    </div>
                    {{-- <button type="submit" class="btn btn-primary btn-lg">Create Work Task</button> --}}
                </div>

                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks card-title-icon"></i>Status & Info</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-camera card-title-icon"></i>Photos</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="photos" class="form-label">Upload Photos</label>
                                <input class="form-control" type="file" id="photos" name="photos[]" multiple>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-save card-title-icon"></i>Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Create Work Task</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
