@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white">
            <h4>Register as a Service Provider</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('provider.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Years of Experience</label>
                        <input type="number" name="years_of_experience" class="form-control" min="0" max="100">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Services Offered</label>
                        <select name="services[]" class="form-control" multiple required>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Short Bio</label>
                        <textarea name="bio" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <button class="btn btn-success w-100" type="submit">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection
