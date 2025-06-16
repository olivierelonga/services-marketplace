@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Service Provider Registration</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('provider.register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Bio (optional)</label>
                    <textarea name="bio" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Services Offered</label>
                    <select name="services[]" multiple class="form-control">
                        <option value="1">Plumbing</option>
                        <option value="2">Painting</option>
                        <option value="3">Carpentry</option>
                        <option value="4">Electrical</option>
                        <!-- later replace with DB-driven list -->
                    </select>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection
