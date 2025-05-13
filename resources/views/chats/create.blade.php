@extends('layouts.app')

@section('content')
    <h1>Kirimi Pesan</h1>

    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        
        <!-- Penerima Pesan: Dropdown untuk memilih penerima -->
        <label for="receiver_id">Pilih Penerima</label>
        <select name="receiver_id" id="receiver_id" required>
            <option value="">-- Pilih Penerima --</option>
            @foreach ($users as $user)
                @if ($user->id != auth()->user()->id)  <!-- Pastikan pengirim tidak memilih dirinya sendiri -->
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endif
            @endforeach
        </select><br>

        <!-- Pesan: Textarea untuk menulis pesan -->
        <label for="message">Pesan</label>
        <textarea name="message" id="message" required placeholder="Tulis pesan di sini..."></textarea><br>

        <!-- Tombol Kirim -->
        <button type="submit">Kirim Pesan</button>
    </form>
@endsection
