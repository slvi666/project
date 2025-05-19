@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Ujian</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('exams.index') }}">Daftar Jadwal Ujian</a></li>
            <li class="breadcrumb-item active">Edit Ujian</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow-lg rounded">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title m-0">Form Edit Ujian</h3>
            </div>

            <div class="card-body">
              @if ($errors->any())
                <div class="alert alert-danger">
                  <strong>Ups!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form action="{{ route('exams.update', $exam->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                  <label for="subject_id" class="form-label">Mata Pelajaran</label>
                  <select name="subject_id" id="subject_id" class="form-control">
                    @foreach ($subjects as $subject)
                      <option value="{{ $subject->id }}" {{ $exam->subject_id == $subject->id ? 'selected' : '' }}>
                        {{ $subject->subject_name }} ({{ $subject->class_name }})
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label for="exam_title" class="form-label">Judul Ujian</label>
                  <input type="text" name="exam_title" class="form-control" value="{{ old('exam_title', $exam->exam_title) }}" required>
                </div>

                <div class="mb-3">
                  <label for="question_type" class="form-label">Tipe Soal</label>
                  <select name="question_type" class="form-control" required>
                    <option value="pilihan_ganda" {{ $exam->question_type == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                    <option value="esai" {{ $exam->question_type == 'esai' ? 'selected' : '' }}>Esai</option>
                    <option value="campuran" {{ $exam->question_type == 'campuran' ? 'selected' : '' }}>Campuran</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="duration" class="form-label">Durasi (menit)</label>
                  <input type="number" name="duration" class="form-control" value="{{ old('duration', $exam->duration) }}" required>
                </div>

                <div class="mb-3">
                  <label for="start_time" class="form-label">Waktu Mulai</label>
                  <input type="datetime-local" name="start_time" class="form-control"
                    value="{{ old('start_time', $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d\TH:i') : '') }}">
                </div>

                <div class="mb-3">
                  <label for="end_time" class="form-label">Waktu Selesai</label>
                  <input type="datetime-local" name="end_time" class="form-control"
                    value="{{ old('end_time', $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d\TH:i') : '') }}">
                </div>

                <div class="d-flex justify-content-between">
                  <a href="{{ route('exams.index') }}" class="btn btn-secondary">Kembali</a>
                  <button type="submit" class="btn btn-primary">Perbarui Ujian</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
