@extends('adminlte.layouts.app')

@section('content')
<style>
    .messages {
        max-height: 500px;
        overflow-y: auto;
        padding: 15px;
        background-color: #e5ddd5;
        border-radius: 10px;
    }

    .message {
        max-width: 70%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 10px;
        position: relative;
        clear: both;
    }

    .sent {
        background-color: #dcf8c6;
        margin-left: auto;
        text-align: right;
        border-bottom-right-radius: 0;
    }

    .received {
        background-color: #fff;
        margin-right: auto;
        text-align: left;
        border-bottom-left-radius: 0;
    }

    .message small {
        display: block;
        font-size: 0.75rem;
        color: #666;
        margin-top: 5px;
    }

    .card-body {
        background-color: #e5ddd5;
        padding: 0;
    }

    .card-footer textarea {
        resize: none;
    }
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-comment-alt me-2 text-primary"></i>Percakapan dengan {{ $receiver->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('messages.index') }}"">Daftar Percakapan</a></li>
                        <li class="breadcrumb-item active">Percakapan dengan {{ $receiver->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp w-100">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top-4">
                            <h3 class="card-title text-dark mb-0">
                                <i class="fas fa-comment-dots me-2 text-info"></i>Pesan
                            </h3>
                            <a href="{{ route('messages.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="messages">
                                @foreach ($messages as $message)
                                    <div class="message {{ $message->sender_id == auth()->user()->id ? 'sent' : 'received' }}">
                                        <strong>{{ $message->sender_id == auth()->user()->id ? 'You' : $message->sender->name }}:</strong>
                                        <p>{{ $message->message }}</p>
                                        <small>{{ \Carbon\Carbon::parse($message->sent_at)->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer bg-white text-muted text-end small rounded-bottom-4">
                            <form action="{{ route('messages.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                                <textarea name="message" required placeholder="Tulis balasan di sini..." class="form-control"></textarea><br>
                                <button type="submit" class="btn btn-primary btn-sm">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Load FontAwesome & Animate.css -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const messagesContainer = document.querySelector('.messages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });
</script>

