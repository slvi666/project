@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Soal untuk Ujian: {{ $exam->exam_title }}</h1>

    <form action="{{ route('questions.store', $exam->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="question_text">Soal</label>
            <textarea name="question_text" id="question_text" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="type">Jenis Soal</label>
            <select name="type" id="type" class="form-control" required>
                <option value="pilihan_ganda">Pilihan Ganda</option>
                <option value="esai">Esai</option>
            </select>
        </div>

        <div class="form-group" id="choices" style="display:none;">
            <label for="choices">Pilihan Jawaban (JSON format)</label>
            <textarea name="choices" id="choices" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="correct_answer">Jawaban Benar</label>
            <input type="text" name="correct_answer" id="correct_answer" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Soal</button>
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
