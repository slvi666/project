@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Soal untuk Ujian: {{ $exam->exam_title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('exams.index') }}">Ujian</a></li>
                        <li class="breadcrumb-item active">Tambah Soal</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Form Tambah Soal Manual -->
            <div class="card shadow-lg rounded mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title m-0">Form Tambah Soal Manual</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.store', $exam->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="question_text">Soal</label>
                            <textarea name="question_text" id="question_text" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="type">Jenis Soal</label>
                            <input type="text" name="type" id="type" class="form-control" value="{{ $exam->question_type }}" readonly>
                        </div>

                        <div class="form-group" id="choices" style="display:none;">
                            <label for="choices_input">Pilihan Jawaban <small class="text-muted">(format JSON)</small></label>
                                <pre class="bg-light text-muted rounded p-2 mt-1" style="font-size: 0.9rem; white-space: pre-wrap;">
                                Contoh: ["A. Pilihan 1", "B. Pilihan 2", "C. Pilihan 3", "D. Pilihan 4"]
                                </pre>
                            <textarea name="choices" id="choices_input" class="form-control" rows="3" placeholder='Contoh: ["A. Pilihan 1", "B. Pilihan 2", "C. Pilihan 3", "D. Pilihan 4"]'></textarea>
                        </div>

                       {{-- Tambahkan ini tepat sebelum bagian input jawaban benar --}}
                        @if ($exam->question_type !== 'esai')
                        <div class="form-group">
                            <label for="correct_answer">Jawaban Benar</label>
                            <input type="text" name="correct_answer" id="correct_answer" class="form-control" placeholder="Contoh: A" required>
                        </div>
                        @endif

                       <div class="mt-3">
                        <button type="submit" class="btn btn-primary shadow-sm rounded-pill px-4">
                            <i class="fas fa-save mr-1"></i> Simpan Soal
                        </button>
                        <a href="{{ route('questions.index', $exam->id) }}" class="btn btn-secondary shadow-sm rounded-pill px-4 ml-2">
                            <i class="fas fa-times mr-1"></i> Batal
                        </a>
                    </div>

                    </form>
                </div>
            </div>

            <!-- Import Excel -->
            <div class="card shadow-lg rounded">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title m-0">Import Soal dari File Excel</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.importExcel', $exam->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="excel_file">Pilih File Excel <small class="text-muted">(.xlsx atau .xls)</small></label>
                            <input type="file" name="excel_file" id="excel_file" class="form-control-file" accept=".xlsx,.xls" required>
                        </div>

                        <button type="submit" class="btn btn-success shadow-sm rounded-pill px-4 mt-2">
                            <i class="fas fa-file-import mr-1"></i> Import Excel
                        </button>
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const typeInput = document.getElementById('type');
        const choicesSection = document.getElementById('choices');
        const choicesInput = document.getElementById('choices_input');
        const correctAnswerInput = document.getElementById('correct_answer');

        function toggleRequiredFields() {
            if (typeInput.value === 'pilihan_ganda') {
                choicesSection.style.display = 'block';
                choicesInput.setAttribute('required', 'required');
                correctAnswerInput.setAttribute('required', 'required');
            } else {
                choicesSection.style.display = 'none';
                choicesInput.removeAttribute('required');
                // Kalau jenis soal bukan pilihan ganda, tetap wajib isi jawaban benar
                correctAnswerInput.setAttribute('required', 'required');
            }
        }

        toggleRequiredFields();
    });

</script>
@endsection
