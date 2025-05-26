@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Edit Ujian</h1>
        </div>
        <div class="col-md-6">
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
      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Edit Ujian</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('exams.update', $exam->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="subject_id" class="form-label">Mata Pelajaran</label>
              <select name="subject_id" id="subject_id" class="form-control rounded-pill px-3 py-2" required>
                @foreach ($subjects as $subject)
                  <option value="{{ $subject->id }}" {{ $exam->subject_id == $subject->id ? 'selected' : '' }}>
                    {{ $subject->subject_name }} ({{ $subject->class_name }})
                  </option>
                @endforeach
              </select>
            </div>


            {{-- <div class="mb-3">
              <label for="guru_id" class="form-label">Guru Pengampu</label>
              <select name="guru_id" id="guru_id" class="form-control select2 rounded-pill px-3 py-2" required>
                <option value="" disabled {{ !$exam->guru_id ? 'selected' : '' }}>Pilih Guru</option>
                @foreach ($gurus as $guru)
                  <option value="{{ $guru->id }}" {{ $exam->guru_id == $guru->id ? 'selected' : '' }}>
                    {{ $guru->name }}
                  </option>
                @endforeach
              </select>
            </div> --}}


          <div class="mb-3">
            <label for="guru_id" class="form-label">Guru Pengampu</label>
            <select name="guru_id_disabled" id="guru_id" class="form-control select2 rounded-pill px-3 py-2" disabled>
              @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}" {{ $exam->guru_id == $guru->id ? 'selected' : '' }}>
                  {{ $guru->name }}
                </option>
              @endforeach
            </select>
            <!-- Hidden input tetap kirimkan nilai guru_id -->
            <input type="hidden" name="guru_id" value="{{ $exam->guru_id }}">
          </div>



            <div class="mb-3">
              <label for="exam_title" class="form-label">Judul Ujian</label>
              <input type="text" name="exam_title" class="form-control rounded-pill px-3 py-2" value="{{ old('exam_title', $exam->exam_title) }}" required>
            </div>

            <div class="mb-3">
              <label for="question_type" class="form-label">Tipe Soal</label>
              <select name="question_type" class="form-control rounded-pill px-3 py-2" required>
                <option value="pilihan_ganda" {{ $exam->question_type == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                <option value="esai" {{ $exam->question_type == 'esai' ? 'selected' : '' }}>Esai</option>
                <option value="campuran" {{ $exam->question_type == 'campuran' ? 'selected' : '' }}>Campuran</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="duration" class="form-label">Durasi (menit)</label>
              <input type="number" name="duration" class="form-control rounded-pill px-3 py-2" value="{{ old('duration', $exam->duration) }}" required>
            </div>

            <div class="mb-3">
              <label for="start_time" class="form-label">Waktu Mulai</label>
              <input type="datetime-local" name="start_time" class="form-control rounded-pill px-3 py-2"
                value="{{ old('start_time', $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="mb-3">
              <label for="end_time" class="form-label">Waktu Selesai</label>
              <input type="datetime-local" name="end_time" class="form-control rounded-pill px-3 py-2"
                value="{{ old('end_time', $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('exams.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
              </a>
              <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-save me-1"></i> Perbarui
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Load SweetAlert2 script BEFORE kamu pakai Swal -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Cek error dan tampilkan SweetAlert -->
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

@endsection
