@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Edit Hasil Ujian</h1>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow">
        <div class="card-header bg-warning text-white">
          <h3 class="card-title">Detail Ujian</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('siswa.exam.update', $studentExam->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">Judul Ujian</label>
              <input type="text" class="form-control" value="{{ $studentExam->exam->exam_title }}" disabled>
            </div>

            <div class="mb-3">
              <label class="form-label">Skor</label>
              <input type="number" class="form-control" name="score" value="{{ $studentExam->score }}" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="{{ route('siswa.exam.index') }}" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
