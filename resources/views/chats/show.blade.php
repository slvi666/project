@extends('adminlte.layouts.app')

@section('content')
<style>
    body {
        background-color: #f1f2f6;
    }

    .chat-container {
        max-width: 900px;
        margin: auto;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    .chat-header {
        background: #3059b1;
        color: #ffffff;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header h4 {
        margin: 0;
    }

    .chat-header .status {
        font-size: 0.85rem;
        color: #70d26f;
        display: flex;
        align-items: center;
    }

    .chat-header .status i {
        font-size: 0.6rem;
        margin-right: 6px;
    }

    .chat-body {
        padding: 20px;
        height: 500px;
        overflow-y: auto;
        background: #e8e8e8;
        display: flex;
        flex-direction: column;
    }

    .message-wrapper {
        display: flex;
        margin-bottom: 15px;
    }

    .message-wrapper.sent {
        justify-content: flex-end;
    }

    .message-bubble {
        max-width: 70%;
        padding: 12px 18px;
        border-radius: 20px;
        position: relative;
        background: #f1f1f1;
        font-size: 0.95rem;
        transition: background 0.3s ease;
    }

    .sent .message-bubble {
        background: #4cd137;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .received .message-bubble {
        background: white;
        color: black;
        border-bottom-left-radius: 4px;
    }

    .message-bubble:hover {
        background-color: #dcdde1;
    }

    .message-meta {
        font-size: 0.75rem;
        margin-top: 6px;
        opacity: 0.7;
    }

    .chat-footer {
        padding: 10px 20px;
        border-top: 1px solid #ddd;
        background: white;
        display: flex;
        align-items: center;
        gap: 10px;
        position: sticky;
        bottom: 0;
    }

    .chat-footer textarea {
        flex: 1;
        resize: none;
        border-radius: 20px;
        padding: 10px 15px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .chat-footer textarea:focus {
        outline: none;
        border-color: #4cd137;
        box-shadow: 0 0 0 2px rgba(76, 209, 55, 0.2);
    }

    .btn-send {
        border-radius: 50%;
        width: 42px;
        height: 42px;
        border: none;
        background-color: #4cd137;
        color: white;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }

    .btn-send:hover {
        background-color: #44bd32;
    }

    @media (max-width: 768px) {
        .chat-body {
            height: 400px;
        }

        .chat-header, .chat-footer {
            padding: 15px;
        }

        .message-bubble {
            font-size: 0.9rem;
        }
    }
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="chat-container my-4">
            <!-- Header -->
            <div class="chat-header">
                <div>
                    <h4>Percakapan dengan {{ $receiver->name }}</h4>
                    <span class="status"><i class="fas fa-circle"></i> Online</span>
                </div>
                <a href="{{ route('messages.index') }}" class="btn btn-sm btn-light text-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>

            <!-- Body -->
            <div class="chat-body" id="messages">
                @foreach ($messages as $message)
                    <div class="message-wrapper {{ $message->sender_id == auth()->user()->id ? 'sent' : 'received' }}">
                        <div class="message-bubble">
                            <strong>{{ $message->sender_id == auth()->user()->id ? 'Anda' : $message->sender->name }}</strong>
                            <div>{{ $message->message }}</div>
                            <div class="message-meta" title="{{ \Carbon\Carbon::parse($message->sent_at)->toDayDateTimeString() }}">
                                {{ \Carbon\Carbon::parse($message->sent_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer -->
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                <div class="chat-footer">
                    <textarea name="message" placeholder="Ketik pesan..." required></textarea>
                    <button type="submit" class="btn-send">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- External Assets -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('messages');
        container.scrollTop = container.scrollHeight;
    });
</script>
@endsection
