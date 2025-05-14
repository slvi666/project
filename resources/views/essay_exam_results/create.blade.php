@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Jawaban Esai</h1>

        <form action="{{ route('essay_exam_results.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="exam_id">Ujian</label>
                <select name="exam_id" id="exam_id" class="form-control" required>
                    <option value="">Pilih Ujian</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}">{{ $exam->exam_title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="question_option">Pilih Soal Esai:</label>
                <select name="question_option" id="question_option" class="form-control" required>
                    <option value="manual">Soal Manual</option>
                    <option value="upload">Upload PDF</option>
                </select>
            </div>

            <div class="form-group" id="manual_question">
                <label for="question_text">Soal Esai</label>
                <textarea name="question_text" id="question_text" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group" id="pdf_question" style="display: none;">
                <label for="question_pdf">Upload Soal Esai PDF</label>
                <input type="file" name="question_pdf" id="question_pdf" class="form-control" accept=".pdf">
            </div>
        @if (in_array(auth()->user()->role_name, ['siswa']))
            <div class="form-group">
                <label for="answer_option">Pilih Jawaban:</label>
                <select name="answer_option" id="answer_option" class="form-control" required>
                    <option value="manual">Jawaban Manual</option>
                    <option value="upload">Upload PDF</option>
                </select>
            </div>

            <div class="form-group" id="manual_answer">
                <label for="answer_text">Jawaban Siswa</label>
                <textarea name="answer_text" id="answer_text" class="form-control" rows="6" required></textarea>
            </div>

            <div class="form-group" id="pdf_answer" style="display: none;">
                <label for="answer_pdf">Upload Jawaban PDF</label>
                <input type="file" name="answer_pdf" id="answer_pdf" class="form-control" accept=".pdf">
            </div>
@endif
            <div class="form-group">
                <label for="score">Nilai</label>
                <input type="number" name="score" id="score" class="form-control" placeholder="Nilai" min="0" max="100">
            </div>

            <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea name="feedback" id="feedback" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script>
        // Soal Esai
        document.getElementById('question_option').addEventListener('change', function () {
            const manualQuestion = document.getElementById('manual_question');
            const pdfQuestion = document.getElementById('pdf_question');
            const questionText = document.getElementById('question_text');
            const questionPdf = document.getElementById('question_pdf');

            if (this.value === 'upload') {
                manualQuestion.style.display = 'none';
                pdfQuestion.style.display = 'block';
                questionText.removeAttribute('required');
                questionPdf.setAttribute('required', 'required');
            } else {
                manualQuestion.style.display = 'block';
                pdfQuestion.style.display = 'none';
                questionPdf.removeAttribute('required');
                questionText.setAttribute('required', 'required');
            }
        });

        // Jawaban
        document.getElementById('answer_option').addEventListener('change', function () {
            const manualAnswer = document.getElementById('manual_answer');
            const pdfAnswer = document.getElementById('pdf_answer');
            const answerText = document.getElementById('answer_text');
            const answerPdf = document.getElementById('answer_pdf');

            if (this.value === 'upload') {
                manualAnswer.style.display = 'none';
                pdfAnswer.style.display = 'block';
                answerText.removeAttribute('required');
                answerPdf.setAttribute('required', 'required');
            } else {
                manualAnswer.style.display = 'block';
                pdfAnswer.style.display = 'none';
                answerPdf.removeAttribute('required');
                answerText.setAttribute('required', 'required');
            }
        });

        // Trigger default on load (optional)
        document.getElementById('question_option').dispatchEvent(new Event('change'));
        document.getElementById('answer_option').dispatchEvent(new Event('change'));
    </script>
@endsection
