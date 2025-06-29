@extends('layouts.app')

@section('content')

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>

<div class="container py-4">

    {{-- Back Button --}}
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Page Heading --}}
    <div class="p-3 mb-4 bg-light rounded border">
        <h3 class="mb-0">Freelance Inbox</h3>
    </div>

    {{-- Message List --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Client Leads</h5>

            @forelse ($messages as $message)
                <div class="d-flex flex-column flex-md-row mb-4 pb-3 border-bottom">
                    
                    {{-- Avatar --}}
                    <div class="me-md-3 mb-2 mb-md-0 text-center">
                        <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center mx-auto" style="width: 48px; height: 48px;">
                            <span class="fw-bold">{{ strtoupper(substr($message->sender_name, 0, 1)) }}</span>
                        </div>
                    </div>

                    {{-- Message Content --}}
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="mb-2">
                                <strong>{{ $message->sender_name }}</strong><br>
                                <span class="text-muted">
                                    Re:
                                    <a href="mailto:{{ $message->email }}"
                                    style="{{ auth()->user()->is_premium ? '' : 'filter: blur(4px); pointer-events: none; user-select: none;' }}">
                                    {{ $message->email }}
                                    </a>
                                </span>
                            </div>
                            <small class="text-muted text-end">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('d M Y') }}<br>
                                {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                            </small>
                        </div>

                        <p class="mt-2 mb-2">{{ $message->body }}</p>

                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-secondary btn-sm" disabled>Block</button>
                                <a href="tel:{{ $message->phone }}"
                                class="btn btn-outline-success btn-sm"
                                style="{{ auth()->user()->is_premium ? '' : 'pointer-events: none;' }}">
                                    Call
                                    <span style="{{ auth()->user()->is_premium ? '' : 'filter: blur(4px); user-select: none;' }}">
                                        {{ $message->phone }}
                                    </span>
                                </a>                            
                                <a href="{{ route('messages.reply', $message->id) }}" class="btn btn-outline-primary btn-sm">Reply</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No messages found.</p>
            @endforelse

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $messages->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

</div>
@endsection
