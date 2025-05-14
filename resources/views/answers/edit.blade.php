@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Jawaban</h2>

    <form action="{{ route('answers.update', $answer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="answer_text" class="form-label">Jawaban</label>
            <textarea name="answer_text" class="form-control" required>{{ $answer->answer_text }}</textarea>
        </div>

        <div class="mb-3">
            <label for="score" class="form-label">Skor (jika esai)</label>
            <input type="number" name="score" class="form-control" value="{{ $answer->score }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('answers.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
