@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
    </div>
</nav>
<div class="container" style="padding-top: 25px">
    <a href="{{ url()->previous() }}" class="btn btn-light mb-3">← Back</a>

    <div class="card">
        <div class="card-header">
            Replying to: {{ $message->sender->first_name }} {{ $message->sender->last_name }}
        </div>
        <div class="card-body">
            <p><strong> Message:</strong><br>{{ $message->body }}</p>

            <form method="POST" action="{{ route('messages.sendReply', $message->id) }}">
                @csrf
                <div class="form-group mt-3">
                    <label for="reply_body">Your Reply</label>
                    <textarea name="reply_body" class="form-control" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Send Reply</button>
            </form>
        </div>
    </div>
</div>
@endsection
