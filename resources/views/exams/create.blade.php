@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Tambah Ujian Baru</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('exams.index') }}">Daftar Ujian</a></li>
            <li class="breadcrumb-item active">Tambah Ujian</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      @if ($errors->any())
        <script>
          Swal.fire({
            title: 'Kesalahan!',
            html: `<ul>{!! implode('', $errors->all('<li>:message</li>')) !!}</ul>`,
            icon: 'error',
            confirmButtonText: 'OK'
          });
        </script>
      @endif

      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Tambah Ujian</h5>
        </div>

        <div class="card-body">
          <form action="{{ route('exams.store') }}" method="POST">
            @csrf

<div class="mb-3">
  <label for="subject_id" class="form-label">Mata Pelajaran</label>
  <select name="subject_id" id="subject_id" class="form-control rounded-pill px-3 py-2" required>
    <option value="" disabled selected>Pilih Mata Pelajaran</option>
    @foreach($subjects as $subject)
      <option value="{{ $subject->id }}">{{ $subject->subject_name }} ({{ $subject->class_name }})</option>
    @endforeach
  </select>
</div>


            <div class="mb-3">
              <label for="exam_title" class="form-label">Judul Ujian</label>
              <input type="text" name="exam_title" id="exam_title" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-3">
              <label for="question_type" class="form-label">Jenis Soal</label>
              <select name="question_type" id="question_type" class="form-control rounded-pill px-3 py-2" required>
                <option value="pilihan_ganda">Pilihan Ganda</option>
                <option value="esai">Esai</option>
                <option value="campuran">Campuran</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="duration" class="form-label">Durasi (Menit)</label>
              <input type="number" name="duration" id="duration" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-3">
              <label for="start_time" class="form-label">Waktu Mulai</label>
              <input type="datetime-local" name="start_time" id="start_time" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="mb-3">
              <label for="end_time" class="form-label">Waktu Selesai</label>
              <input type="datetime-local" name="end_time" id="end_time" class="form-control rounded-pill px-3 py-2">
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('exams.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="fas fa-save me-1"></i> Simpan
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
