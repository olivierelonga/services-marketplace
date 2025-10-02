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
                <form id="reply-form" action="" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="reply-message-body" name="reply_body" class="form-control form-control-lg" placeholder="Type your message...">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-send-fill"></i></button>
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
        const messageHistory = document.getElementById('message-history');
        const messageInputForm = document.getElementById('message-input-form');
        const selectConversationPrompt = document.getElementById('select-conversation-prompt');
        const replyForm = document.getElementById('reply-form');
        const replyMessageBody = document.getElementById('reply-message-body');
        let activeConversationId = null;

        conversationItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                activeConversationId = this.dataset.conversationId;
                replyForm.action = `{{ url('messages') }}/${activeConversationId}/reply`;

                // Remove active state from all items
                conversationItems.forEach(i => i.classList.remove('active'));
                // Add active state to the clicked item
                this.classList.add('active');

                // Show the message viewer
                selectConversationPrompt.style.display = 'none';
                messageInputForm.style.display = 'block';

                // Clear previous messages
                messageHistory.innerHTML = '';

                // Fetch and display messages
                $.ajax({
                    url: `/messages/${activeConversationId}`,
                    type: 'GET',
                    success: function(messages) {
                        renderMessages(messages);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching messages:', textStatus, errorThrown);
                        alert('An error occurred while fetching messages.');
                    }
                });
            });
        });

        replyForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!this.action) return;

            const formData = new FormData(this);

            $.ajax({
                url: this.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(newMessage) {
                    appendMessage(newMessage);
                    replyMessageBody.value = '';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error sending reply:', textStatus, errorThrown);
                    // Log the full error response to see if it's a validation error
                    console.error(jqXHR.responseJSON); 
                    alert('An error occurred while sending the reply. Check the console for details.');
                }
            });
        });

        function renderMessages(messages) {
            messageHistory.innerHTML = '';
            messages.forEach(appendMessage);
        }

        function appendMessage(msg) {
            const messageElement = document.createElement('div');
            messageElement.dataset.messageId = msg.id;
            messageElement.classList.add('message', msg.sender_id === {{ auth()->id() }} ? 'sent' : 'received');
            
            let messageContent = `<div class="message-bubble">
                                    <p>${msg.body}</p>
                                    <div class="translation-controls">
                                        <button class="btn btn-sm btn-outline-secondary translate-btn">Translate</button>
                                        <div class="language-dropdown" style="display: none;">
                                            <a href="#" data-lang="zu">Zulu</a>
                                            <a href="#" data-lang="xh">Xhosa</a>
                                            <a href="#" data-lang="fr">French</a>
                                        </div>
                                    </div>
                                    <div class="translated-message mt-2"></div>
                                </div>`;

            if (msg.voice_memo_path) {
                messageContent += `
                    <div class="message-bubble mt-2">
                        <audio controls src="/storage/${msg.voice_memo_path}"></audio>
                        <button class="btn btn-sm btn-outline-secondary transcribe-btn mt-2">Transcribe</button>
                        <div class="transcript mt-2">${msg.transcript || ''}</div>
                    </div>
                `;
            }

            messageElement.innerHTML = `${messageContent}<div class="message-time">${new Date(msg.created_at).toLocaleTimeString()}</div>`;
            messageHistory.appendChild(messageElement);
            messageHistory.scrollTop = messageHistory.scrollHeight;
        }

        messageHistory.addEventListener('click', function(e) {
            if (e.target.classList.contains('translate-btn')) {
                const dropdown = e.target.nextElementSibling;
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
            }

            if (e.target.matches('.language-dropdown a')) {
                e.preventDefault();
                const messageElement = e.target.closest('.message');
                const messageId = messageElement.dataset.messageId;
                const targetLanguage = e.target.dataset.lang;
                const translatedMessageContainer = messageElement.querySelector('.translated-message');

                $.ajax({
                    url: `/messages/${messageId}/translate`,
                    type: 'POST',
                    data: {
                        target_language: targetLanguage,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        translatedMessageContainer.textContent = response.translated_text;
                        e.target.closest('.language-dropdown').style.display = 'none';

                        if (response.translated_audio_path) {
                            const audioPlayer = document.createElement('audio');
                            audioPlayer.controls = true;
                            audioPlayer.src = response.translated_audio_path;
                            translatedMessageContainer.appendChild(audioPlayer);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(jqXHR.responseJSON); 
                        console.error('Error translating message:', textStatus, errorThrown);
                        alert('An error occurred while translating the message.');
                    }
                });
            }

            if (e.target.classList.contains('transcribe-btn')) {
                const messageElement = e.target.closest('.message');
                const messageId = messageElement.dataset.messageId;
                const transcriptContainer = messageElement.querySelector('.transcript');

                $.ajax({
                    url: `/messages/${messageId}/transcribe`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        transcriptContainer.textContent = response.transcript;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error transcribing message:', textStatus, errorThrown);
                        alert('An error occurred while transcribing the message.');
                    }
                });
            }
        });
    });
</script>
@endpush