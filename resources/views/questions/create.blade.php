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
                            <textarea name="choices" id="choices_input" class="form-control" rows="3" placeholder='Contoh: ["A. Pilihan 1", "B. Pilihan 2", "C. Pilihan 3", "D. Pilihan 4"]'></textarea>
                        </div>

                        <div class="form-group">
                            <label for="correct_answer">Jawaban Benar</label>
                            <input type="text" name="correct_answer" id="correct_answer" class="form-control" placeholder="Contoh: A">
                        </div>

                        <button type="submit" class="btn btn-primary shadow-sm rounded-pill px-4 mt-3">
                            <i class="fas fa-save mr-1"></i> Simpan Soal
                        </button>
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
                        <p class="text-muted mt-2">* Format file Excel: Soal, Pilihan (pisah dengan titik koma), Jawaban Benar</p>
                        <a href="{{ asset('format_soal.xlsx') }}" class="btn btn-link px-0">
                            <i class="fas fa-download"></i> Download Format Excel
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeValue = document.getElementById('type').value;
        const choicesSection = document.getElementById('choices');
        if (typeValue === 'pilihan_ganda') {
            choicesSection.style.display = 'block';
        } else {
            choicesSection.style.display = 'none';
        }
    });
</script>
@endsection
