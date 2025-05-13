<!-- resources/views/chats/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Edit Pesan</h1>

    <form action="{{ route('messages.update', $message->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <textarea name="message" required>{{ $message->message }}</textarea><br>
        <button type="submit">Perbarui Pesan</button>
    </form>
@endsection
