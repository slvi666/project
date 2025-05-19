@extends('adminlte.layouts.app')

@section('content')
@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark"><i class="fas fa-file-alt text-primary me-2"></i> Detail Ujian</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('exams.index') }}">Daftar Ujian</a></li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <!-- Ringkasan Info Cards -->
      <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
          <div class="small-box bg-gradient-primary shadow">
            <div class="inner">
              <h4>{{ $exam->exam_title }}</h4>
              <p>Judul</p>
            </div>
            <div class="icon"><i class="fas fa-file-signature"></i></div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
          <div class="small-box bg-gradient-success shadow">
            <div class="inner">
              <h4>{{ $exam->duration }} Menit</h4>
              <p>Durasi</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
          <div class="small-box bg-gradient-info shadow">
            <div class="inner">
              <h4>{{ ucfirst(str_replace('_', ' ', $exam->question_type)) }}</h4>
              <p>Jenis Soal</p>
            </div>
            <div class="icon"><i class="fas fa-question-circle"></i></div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
          <div class="small-box bg-gradient-warning shadow">
            <div class="inner">
              <h4>{{ $exam->subject->class_name }}</h4>
              <p>Kelas</p>
            </div>
            <div class="icon"><i class="fas fa-users-class"></i></div>
          </div>
        </div>
      </div>

      <!-- Informasi Detail -->
      <div class="card border-0 shadow rounded-lg">
        <div class="card-header bg-light">
          <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Informasi Lengkap</h5>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <strong><i class="fas fa-book-open me-1 text-muted"></i> Mata Pelajaran:</strong>
              <div>{{ $exam->subject->subject_name }} ({{ $exam->subject->class_name }})</div>
            </div>

            <div class="col-md-6 mb-3">
              <strong><i class="fas fa-hourglass-start me-1 text-muted"></i> Waktu Mulai:</strong>
              <div>
                {{ $exam->start_time ? Carbon::parse($exam->start_time)->translatedFormat('l, d F Y H:i') : '-' }}
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <strong><i class="fas fa-hourglass-end me-1 text-muted"></i> Waktu Selesai:</strong>
              <div>
                {{ $exam->end_time ? Carbon::parse($exam->end_time)->translatedFormat('l, d F Y H:i') : '-' }}
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <strong><i class="fas fa-toggle-on me-1 text-muted"></i> Status:</strong>
              <div>
                @php
                  $now = Carbon::now();
                  $status = '-';
                  $badge = 'secondary';

                  if ($exam->start_time && $exam->end_time) {
                      if ($now->lt($exam->start_time)) {
                          $status = 'Belum Dimulai';
                          $badge = 'secondary';
                      } elseif ($now->between($exam->start_time, $exam->end_time)) {
                          $status = 'Sedang Berlangsung';
                          $badge = 'success';
                      } else {
                          $status = 'Selesai';
                          $badge = 'danger';
                      }
                  }
                @endphp
                <span class="badge bg-{{ $badge }} px-3 py-1">{{ $status }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tombol Aksi -->
      <div class="d-flex justify-content-between flex-wrap mt-4">
        <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
          <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
      </div>

    </div>
  </section>
</div>
@endsection
