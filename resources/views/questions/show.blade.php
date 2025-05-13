@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Soal</h1>

    <div class="card">
        <div class="card-header">
            <strong>{{ $question->question_text }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Jenis Soal:</strong> {{ $question->type }}</p>
            @if($question->type == 'pilihan_ganda')
                <p><strong>Opsi Jawaban:</strong> {{ json_decode($question->choices) }}</p>
                <p><strong>Jawaban Benar:</strong> {{ $question->correct_answer }}</p>
            @endif
        </div>
    </div>

    <a href="{{ route('questions.index', $exam->id) }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
