@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>From Jawaban Siswa</h1>

        <form action="{{ route('essay_exam_results.update', $essayExamResult->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="exam_id">Nama Ujian</label>
                <select name="exam_id" id="exam_id" class="form-control" required>
                    <option value="{{ $essayExamResult->exam_id }}">{{ $essayExamResult->exam->exam_title }}</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}">{{ $exam->exam_title }}</option>
                    @endforeach
                </select>
            </div>

                <div class="form-group">
                    <label for="siswa_id">Siswa</label>
                    <select name="siswa_id" id="siswa_id" class="form-control" required>
                        <!-- Pengecekan untuk menghindari error jika siswa tidak ada -->
                        @if($essayExamResult->siswa)
                            <option value="{{ $essayExamResult->siswa_id }}" selected>{{ $essayExamResult->siswa->nisn }} - {{ $essayExamResult->siswa->user->name }}</option>
                        @else
                            <option value="" disabled>Data siswa tidak tersedia</option>
                        @endif
                        
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->nisn }} - {{ $siswa->user->name }}</option>
                        @endforeach
                    </select>
                </div>
@if (in_array(auth()->user()->role_name, ['guru']))
            <!-- Soal Esai Option -->
            <div class="form-group">
                <label for="question_option">Pilih Soal Esai:</label>
                <select name="question_option" id="question_option" class="form-control" required>
                    <option value="manual" {{ $essayExamResult->question_text ? 'selected' : '' }}>Soal Manual</option>
                    <option value="upload" {{ $essayExamResult->question_pdf ? 'selected' : '' }}>Upload PDF</option>
                </select>
            </div>
@endif
            <!-- Manual Soal Esai -->
            <div class="form-group" id="manual_question" style="{{ $essayExamResult->question_text ? 'display:block' : 'display:none' }}">
                <label for="question_text">Soal Esai</label>
                <textarea name="question_text" id="question_text" class="form-control" rows="4" {{ $essayExamResult->question_pdf ? 'readonly' : '' }}>{{ $essayExamResult->question_text }}</textarea>
            </div>

            <!-- PDF Soal Esai -->
            <div class="form-group" id="pdf_question" style="{{ $essayExamResult->question_pdf ? 'display:block' : 'display:none' }}">
                <label for="question_pdf">Soal Esai PDF</label>
                <!-- Menampilkan PDF menggunakan PDF.js -->
                <div id="pdf-viewer" style="width:100%; height:500px; overflow: auto;"></div>
            </div>

            <div class="form-group">
                <label for="answer_text">Jawaban Siswa</label>
                <textarea name="answer_text" id="answer_text" class="form-control" rows="6">{{ $essayExamResult->answer_text }}</textarea>
            </div>
@if (in_array(auth()->user()->role_name, ['guru']))
            <div class="form-group">
                <label for="score">Nilai</label>
                <input type="number" name="score" id="score" class="form-control" value="{{ $essayExamResult->score ?? '' }}" min="0" max="100">
            </div>

            <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea name="feedback" id="feedback" class="form-control" rows="4">{{ $essayExamResult->feedback ?? '' }}</textarea>
            </div>
@endif
            <button type="submit" class="btn btn-warning">Perbarui</button>
        </form>
    </div>
<!-- Masukkan link CDN untuk PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            const questionOption = document.getElementById('question_option');
            const manualQuestion = document.getElementById('manual_question');
            const pdfQuestion = document.getElementById('pdf_question');
            const questionText = document.getElementById('question_text');
            const questionPdf = document.getElementById('question_pdf');
            const pdfViewer = document.getElementById('pdf-viewer');

            // Trigger initial state based on current data
            questionOption.dispatchEvent(new Event('change'));

            questionOption.addEventListener('change', function () {
                if (this.value === 'upload') {
                    manualQuestion.style.display = 'none';
                    pdfQuestion.style.display = 'block';
                    questionText.setAttribute('readonly', 'readonly');
                    questionPdf.removeAttribute('readonly');
                    
                    // Load and render the PDF
                    const pdfUrl = '{{ asset('storage/' . $essayExamResult->question_pdf) }}';
                    if (pdfUrl) {
                        pdfjsLib.getDocument(pdfUrl).promise.then(function (pdf) {
                            pdf.getPage(1).then(function (page) {
                                const scale = 1.5; // Zoom level
                                const viewport = page.getViewport({ scale: scale });

                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                canvas.width = viewport.width;
                                canvas.height = viewport.height;

                                page.render({
                                    canvasContext: context,
                                    viewport: viewport
                                }).promise.then(function () {
                                    pdfViewer.innerHTML = '';  // Clear any existing content
                                    pdfViewer.appendChild(canvas);  // Add the rendered canvas to the viewer
                                });
                            });
                        });
                    }
                } else {
                    manualQuestion.style.display = 'block';
                    pdfQuestion.style.display = 'none';
                    questionText.removeAttribute('readonly');
                    questionPdf.setAttribute('readonly', 'readonly');
                }
            });
        });
    </script>
@endsection
