@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/messages.css') }}">

<div class="container-fluid vh-100 d-flex flex-column p-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">yelp</a>
            <div class="ms-auto d-flex align-items-center">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2">Dashboard</a>
                <span class="navbar-text me-2">{{ auth()->user()->first_name }}</span>
                <img src="{{ auth()->user()->profile_picture_url ?? 'https://i.pravatar.cc/40?u=' . auth()->id() }}" alt="My Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            </div>
        </div>
    </nav>

    <div class="flex-grow-1 d-flex overflow-hidden">
        <!-- Conversations Pane -->
        <div class="col-md-4 col-lg-3 border-end overflow-auto" id="conversations-list">
            <div class="p-3 border-bottom">
                <h4 class="mb-0">Inbox</h4>
            </div>
            @forelse ($messages as $message)
                <a href="#" class="list-group-item list-group-item-action border-0 p-3 conversation-item" data-conversation-id="{{ $message->id }}">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{ $message->sender_name }}</h6>
                        <small>{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1 text-muted text-truncate">{{ $message->body }}</p>
                </a>
            @empty
                <div class="p-3 text-center">
                    <p class="text-muted">No conversations yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Message Viewer Pane -->
        <div class="col-md-8 col-lg-9 d-flex flex-column" id="message-viewer">
            <div class="flex-grow-1 p-4 overflow-auto" id="message-history">
                <div class="text-center text-muted" id="select-conversation-prompt">
                    <i class="bi bi-chat-dots-fill fs-1"></i>
                    <p class="mt-2">Select a conversation to start messaging.</p>
                </div>
            </div>
            <div class="p-3 bg-light border-top" id="message-input-form" style="display: none;">
                <form action="#" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Type your message...">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-send-fill"></i></button>
                        <button class="btn btn-outline-secondary" type="button"><i class="bi bi-paperclip"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conversationItems = document.querySelectorAll('.conversation-item');
        const messageViewer = document.getElementById('message-viewer');
        //const messageViewerHeader = document.getElementById('message-viewer-header');
        const messageHistory = document.getElementById('message-history');
        const messageInputForm = document.getElementById('message-input-form');
        const selectConversationPrompt = document.getElementById('select-conversation-prompt');

        conversationItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active state from all items
                conversationItems.forEach(i => i.classList.remove('active'));
                // Add active state to the clicked item
                this.classList.add('active');

                // Show the message viewer
                selectConversationPrompt.style.display = 'none';
                //messageViewerHeader.style.display = 'flex';
                messageInputForm.style.display = 'block';

                // Update header
                const senderName = this.querySelector('h6').textContent;
                const avatarUrl = `https://i.pravatar.cc/50?u=${this.dataset.conversationId}`;
                //messageViewerHeader.querySelector('img').src = avatarUrl;
                //messageViewerHeader.querySelector('h5').textContent = senderName;

                // Clear previous messages
                messageHistory.innerHTML = '';

                // Fetch and display messages
                fetch(`/messages/${this.dataset.conversationId}`)
                    .then(response => response.json())
                    .then(messages => {
                        messageHistory.innerHTML = '';
                        messages.forEach(msg => {
                            const messageElement = document.createElement('div');
                            messageElement.classList.add('message', msg.sender_id === {{ auth()->id() }} ? 'sent' : 'received');
                            
                            let messageContent = `<div class="message-bubble">${msg.body}</div>`;

                            if (msg.voice_memo_path) {
                                messageContent += `
                                    <div class="message-bubble mt-2">
                                        <audio controls src="/storage/${msg.voice_memo_path}"></audio>
                                        <div class="transcript mt-2">${msg.transcript}</div>
                                    </div>
                                `;
                            }

                            messageElement.innerHTML = `
                                ${messageContent}
                                <div class="message-time">${new Date(msg.created_at).toLocaleTimeString()}</div>
                            `;
                            messageHistory.appendChild(messageElement);
                        });
                        // Scroll to the bottom
                        messageHistory.scrollTop = messageHistory.scrollHeight;
                    });
            });
        });
    });
</script>
@endpush
