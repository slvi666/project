@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Materi Pembelajaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('materi.index') }}">Daftar Materi</a></li>
            <li class="breadcrumb-item active">Edit Materi</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-warning">
          <h3 class="card-title">Form Edit Materi</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="guru_id">Guru</label>
              <select name="guru_id" class="form-control" required>
                @foreach($guru as $g)
                  <option value="{{ $g->id }}" {{ $materi->guru_id == $g->id ? 'selected' : '' }}>
                    {{ $g->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="subject_id">Mata Pelajaran</label>
              <select name="subject_id" class="form-control" required>
                @foreach($subject as $s)
                  <option value="{{ $s->id }}" {{ $materi->subject_id == $s->id ? 'selected' : '' }}>
                    {{ $s->subject_name }} - {{ $s->class_name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="file">File PDF (kosongkan jika tidak diubah)</label>
              <input type="file" name="file" class="form-control" accept="application/pdf">
            </div>

            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="4">{{ $materi->deskripsi }}</textarea>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Update</button>
              <a href="{{ route('materi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
