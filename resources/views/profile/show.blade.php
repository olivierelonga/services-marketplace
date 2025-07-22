@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>{{ $user->first_name }}'s Profile</h2>

    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Hourly Rate:</strong> R{{ $user->hourly_rate }}</p>
    <p><strong>Experience:</strong> {{ $user->years_of_experience }} years</p>
    <p><strong>Postal Code:</strong> {{ $user->postal_code }}</p>

    <h5 class="mt-4">Services Offered:</h5>
    <ul>
        @foreach($user->services as $service)
            <li>{{ $service->name }} ({{ $service->category }})</li>
        @endforeach
    </ul>
</div>
@endsection
