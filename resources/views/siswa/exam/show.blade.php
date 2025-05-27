@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detail Hasil Ujian</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('student-exams.index') }}">Hasil Ujian</a></li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      {{-- Info Ujian --}}
      <div class="card shadow rounded mb-4">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title m-0">Informasi Ujian</h3>
        </div>
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-3">Judul Ujian</dt>
            <dd class="col-sm-9">{{ $studentExam->exam->exam_title }}</dd>

            <dt class="col-sm-3">Siswa</dt>
           <dd class="col-sm-9">{{ $studentExam->siswa->user->name ?? 'Nama tidak tersedia' }}</dd>

            <dt class="col-sm-3">Waktu Mulai</dt>
            <dd class="col-sm-9">{{ $studentExam->started_at ? \Carbon\Carbon::parse($studentExam->started_at)->translatedFormat('d F Y H:i') : '-' }}</dd>

            <dt class="col-sm-3">Waktu Selesai</dt>
            <dd class="col-sm-9">{{ $studentExam->finished_at ? \Carbon\Carbon::parse($studentExam->finished_at)->translatedFormat('d F Y H:i') : '-' }}</dd>

            <dt class="col-sm-3">Skor Akhir</dt>
            <dd class="col-sm-9">
              @if($studentExam->score !== null)
                <span class="badge bg-success fs-6">{{ $studentExam->score }}</span>
              @else
                <span class="text-muted">Belum dinilai</span>
              @endif
            </dd>
          </dl>
        </div>
      </div>

      {{-- List Soal --}}
      @foreach ($questions as $index => $question)
        <div class="card mb-3 shadow-sm border">
          <div class="card-header bg-light">
            <strong>Soal {{ $index + 1 }}</strong>
          </div>
          <div class="card-body">
            <p><strong>Pertanyaan:</strong><br> {!! nl2br(e($question->question_text)) !!}</p>

             @foreach ($question->choices as $key => $choice)
            <li class="list-group-item d-flex justify-content-between align-items-center
              @if(isset($answers[$question->id]) && $answers[$question->id]->answer == $key) list-group-item-info @endif">
              <span>
                {{ $choice }}
                @if ($question->correct_answer === $key)
                  <span class="badge bg-success ms-2">Kunci</span>
                @endif
                @if(isset($answers[$question->id]) && $answers[$question->id]->answer === $key)
                  <span class="badge bg-primary ms-2">Jawaban Siswa</span>
                @endif
              </span>
            </li>
          @endforeach


            <p><strong>Jawaban Siswa:</strong>
              @if(isset($answers[$question->id]))
                <span>{{ $answers[$question->id]->answer }}</span>
              @else
                <span class="text-muted">Belum dijawab</span>
              @endif
            </p>

            <p><strong>Skor:</strong>
              @if(isset($answers[$question->id]) && $answers[$question->id]->score !== null)
                <span class="badge bg-info">{{ $answers[$question->id]->score }}</span>
              @else
                <span class="text-muted">Belum dinilai</span>
              @endif
            </p>
          </div>
        </div>
      @endforeach

      <a href="{{ route('student-exams.index') }}" class="btn btn-secondary mt-4">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
      </a>

    </div>
  </section>
</div>
@endsection
