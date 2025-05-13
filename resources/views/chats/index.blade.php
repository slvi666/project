@extends('layouts.app')

@section('content')
    <h1>Daftar Pesan</h1>

    <!-- Tombol Pesan Baru -->
    <a href="{{ route('messages.create') }}" class="btn btn-success mb-3">Pesan Baru</a>

    <!-- Daftar percakapan pengirim dan penerima -->
    <div class="messages-list">
        @forelse ($sentMessages as $message)
            @php
                // Ambil penerima berdasarkan ID
                $receiver = $message->receiver_id == auth()->user()->id ? $message->sender : $message->receiver;
            @endphp
            <div class="message-item">
                <h4>Dengan: {{ $receiver->name }}</h4>
                <p>{{ $message->message }}</p>
                <a href="{{ route('messages.show', ['receiver_id' => $receiver->id]) }}" class="btn btn-primary">Lihat Percakapan</a>
            </div>
        @empty
            <p>Belum ada pesan yang dikirim.</p>
        @endforelse

        @forelse ($receivedMessages as $message)
            @php
                // Ambil pengirim berdasarkan ID
                $sender = $message->sender_id == auth()->user()->id ? $message->receiver : $message->sender;
            @endphp
            <div class="message-item">
                <h4>Dengan: {{ $sender->name }}</h4>
                <p>{{ $message->message }}</p>
                <a href="{{ route('messages.show', ['receiver_id' => $sender->id]) }}" class="btn btn-primary">Lihat Percakapan</a>
            </div>
        @empty
            <p>Belum ada pesan yang diterima.</p>
        @endforelse
    </div>
@endsection
