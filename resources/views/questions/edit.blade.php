@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Soal untuk Ujian: {{ $exam->exam_title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('exams.index') }}">Ujian</a></li>
                        <li class="breadcrumb-item active">Edit Soal</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-lg rounded mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title m-0">Form Edit Soal</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.update', [$exam->id, $question->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="question_text">Soal</label>
                            <textarea name="question_text" id="question_text" class="form-control" rows="4" required>{{ old('question_text', $question->question_text) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="type">Jenis Soal</label>
                            <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $question->type)) }}" disabled>
                            <input type="hidden" name="type" value="{{ $question->type }}">
                        </div>

                        <div class="form-group" id="choices" style="{{ $question->type === 'pilihan_ganda' ? 'display:block;' : 'display:none;' }}">
                            <label for="choices_input">Pilihan Jawaban <small class="text-muted">(format JSON)</small></label>
                            <textarea name="choices" id="choices_input" class="form-control" rows="3">{{ old('choices', json_encode(json_decode($question->choices), JSON_PRETTY_PRINT)) }}</textarea>
                        </div>

                        <div class="form-group" id="correct_answer_group" style="{{ $question->type === 'pilihan_ganda' ? 'display:block;' : 'display:none;' }}">
                            <label for="correct_answer">Jawaban Benar</label>
                            <input type="text" name="correct_answer" id="correct_answer" class="form-control" value="{{ old('correct_answer', $question->correct_answer) }}">
                        </div>


                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary shadow-sm rounded-pill px-4">
                                <i class="fas fa-save mr-1"></i> Perbarui Soal
                            </button>
                            <a href="{{ route('questions.index', $exam->id) }}" class="btn btn-secondary shadow-sm rounded-pill px-4 ml-2">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const choicesDiv = document.getElementById('choices');
        const correctAnswerDiv = document.getElementById('correct_answer_group');

        function toggleFields() {
            const isMultipleChoice = typeSelect.value === 'pilihan_ganda';
            choicesDiv.style.display = isMultipleChoice ? 'block' : 'none';
            correctAnswerDiv.style.display = isMultipleChoice ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleFields);

        // Inisialisasi saat pertama kali dimuat
        toggleFields();
    });
</script>
@endsection
