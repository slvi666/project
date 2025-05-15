@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Soal untuk Ujian: {{ $exam->exam_title }}</h1>

    {{-- Form Tambah Soal Manual --}}
    <form action="{{ route('questions.store', $exam->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="question_text">Soal</label>
            <textarea name="question_text" id="question_text" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="type">Jenis Soal</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ $exam->question_type }}" readonly>
        </div>

        <div class="form-group" id="choices" style="display:none;">
            <label for="choices">Pilihan Jawaban (format JSON)</label>
            <textarea name="choices" id="choices_input" class="form-control" placeholder='Contoh: ["A", "B", "C", "D"]'></textarea>
        </div>

        <div class="form-group">
            <label for="correct_answer">Jawaban Benar</label>
            <input type="text" name="correct_answer" id="correct_answer" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Soal</button>
    </form>

    <hr class="my-5">

    {{-- Form Import Excel --}}
    <h3>Import Soal dari File Excel</h3>
    <form action="{{ route('questions.importExcel', $exam->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="excel_file">Pilih File Excel (.xlsx atau .xls)</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx,.xls" required>
        </div>

        <button type="submit" class="btn btn-success mt-2">Import Excel</button>
        <p class="text-muted mt-2">* Format file Excel: Soal, Pilihan (pisah dengan titik koma), Jawaban Benar</p>
        <a href="{{ asset('format_soal.xlsx') }}" class="btn btn-link">Download Format Excel</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var typeValue = document.getElementById('type').value;
        if (typeValue === 'pilihan_ganda') {
            document.getElementById('choices').style.display = 'block';
        } else {
            document.getElementById('choices').style.display = 'none';
        }
    });
</script>
@endsection
