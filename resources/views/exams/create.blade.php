@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Ujian Baru</h1>
        </div>
        <div class="col-sm-6">
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
      <div class="card shadow-lg rounded">
        <div class="card-header bg-success text-white">
          <h3 class="card-title m-0">Form Tambah Ujian</h3>
        </div>

        <div class="card-body">
          <form action="{{ route('exams.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="subject_id" class="form-label">Mata Pelajaran</label>
              <select name="subject_id" id="subject_id" class="form-control" required>
                <option value="" disabled selected>Pilih Mata Pelajaran</option>
                @foreach($subjects as $subject)
                  <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="exam_title" class="form-label">Judul Ujian</label>
              <input type="text" name="exam_title" id="exam_title" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="question_type" class="form-label">Jenis Soal</label>
              <select name="question_type" id="question_type" class="form-control" required>
                <option value="pilihan_ganda">Pilihan Ganda</option>
                <option value="esai">Esai</option>
                <option value="campuran">Campuran</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="duration" class="form-label">Durasi (Menit)</label>
              <input type="number" name="duration" id="duration" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="start_time" class="form-label">Waktu Mulai</label>
              <input type="datetime-local" name="start_time" id="start_time" class="form-control">
            </div>

            <div class="mb-3">
              <label for="end_time" class="form-label">Waktu Selesai</label>
              <input type="datetime-local" name="end_time" id="end_time" class="form-control">
            </div>

            <div class="d-flex justify-content-end">
              <a href="{{ route('exams.index') }}" class="btn btn-secondary me-2">Batal</a>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
