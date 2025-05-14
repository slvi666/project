@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Jawaban</h2>

    <form action="{{ route('answers.store') }}" method="POST">
        @csrf

        <select name="student_exam_id" class="form-control" required>
    @foreach($studentExams as $exam)
        <option value="{{ $exam->id }}">
    {{ $exam->siswa->user->name ?? 'Siswa?' }} - {{ $exam->exam->exam_title ?? 'Ujian?' }}
</option>

    @endforeach
</select>
<div class="mb-3">
    <label for="question_id" class="form-label">Soal</label>
    <select name="question_id" class="form-control" required>
        @foreach($questions as $question)
            <option value="{{ $question->id }}">
                {{ Str::limit($question->question_text, 60) }}
            </option>
        @endforeach
    </select>
</div>
        <div class="mb-3">
            <label for="answer_text" class="form-label">Jawaban</label>
            <textarea name="answer_text" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="score" class="form-label">Skor (hanya untuk esai)</label>
            <input type="number" name="score" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('answers.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
