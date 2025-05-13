@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Soal untuk Ujian: {{ $exam->exam_title }}</h1>

    <form action="{{ route('questions.update', [$exam->id, $question->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="question_text">Soal</label>
            <textarea name="question_text" id="question_text" class="form-control" required>{{ old('question_text', $question->question_text) }}</textarea>
        </div>

        <div class="form-group">
            <label for="type">Jenis Soal</label>
            <select name="type" id="type" class="form-control" required>
                <option value="pilihan_ganda" {{ $question->type === 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                <option value="esai" {{ $question->type === 'esai' ? 'selected' : '' }}>Esai</option>
            </select>
        </div>

        <div class="form-group" id="choices" style="{{ $question->type === 'pilihan_ganda' ? 'display:block;' : 'display:none;' }}">
            <label for="choices">Pilihan Jawaban (JSON format)</label>
            <textarea name="choices" id="choices" class="form-control">{{ old('choices', json_decode($question->choices, true)) }}</textarea>
        </div>

        <div class="form-group">
            <label for="correct_answer">Jawaban Benar</label>
            <input type="text" name="correct_answer" id="correct_answer" class="form-control" value="{{ old('correct_answer', $question->correct_answer) }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Perbarui Soal</button>
    </form>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        if (this.value === 'pilihan_ganda') {
            document.getElementById('choices').style.display = 'block';
        } else {
            document.getElementById('choices').style.display = 'none';
        }
    });
</script>
@endsection
