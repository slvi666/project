@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Materi Pembelajaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('materi.index') }}">Daftar Materi</a></li>
            <li class="breadcrumb-item active">Tambah Materi</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-primary">
          <h3 class="card-title text-white">Form Tambah Materi</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="guru_id" value="{{ auth()->user()->id }}">

              <!-- Kalau mau ditampilkan nama gurunya tapi tidak editable -->
              <div class="form-group">
                  <label>Guru</label>
                  <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
              </div>

            <div class="form-group">
              <label for="subject_id">Mata Pelajaran</label>
              <select name="subject_id" class="form-control" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($subject as $s)
                  <option value="{{ $s->id }}">{{ $s->subject_name }} - {{ $s->class_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="file">File PDF</label>
              <input type="file" name="file" class="form-control" required accept="application/pdf">
            </div>

            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-success">Simpan</button>
              <a href="{{ route('materi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
