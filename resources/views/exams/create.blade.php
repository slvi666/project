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
              <select name="subject_id" id="subject_id" class="form-control select2 rounded-pill px-3 py-2" required>
                <option value="" disabled selected>Pilih Mata Pelajaran</option>
                @foreach($subjects as $subject)
                  <option value="{{ $subject->id }}">{{ $subject->subject_name }} ({{ $subject->class_name }})</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="guru_id" class="form-label">Guru Pengampu</label>
              <select name="guru_id" id="guru_id" class="form-control select2 rounded-pill px-3 py-2" required>
                <option value="" disabled selected>Pilih Guru</option>
                @foreach($gurus as $guru)
                  <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="exam_title" class="form-label">Judul Ujian</label>
              <input type="text" name="exam_title" id="exam_title" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-3">
              <label for="question_type" class="form-label fw-bold">Jenis Soal</label>
              <select name="question_type" id="question_type" class="form-control rounded-pill px-3 py-2" required>
                <option value="" disabled selected>Pilih jenis soal</option>
                <option value="pilihan_ganda">Pilihan Ganda</option>
                <option value="esai">Esai</option>
                {{-- <option value="campuran">Campuran</option> --}}
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

{{-- Load SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Load jQuery dan Select2 --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: 'Silahkan pilih',
      allowClear: true,
      width: '100%'
    });
  });
</script>

<style>
  .select2-container--default .select2-selection--single {
    height: 42px !important;
    padding: 8px 12px;
    border-radius: 25px;
    border: 1px solid #ced4da;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 24px;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px;
    right: 10px;
  }
</style>
@endsection
