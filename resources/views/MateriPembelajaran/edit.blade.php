@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Edit Materi Pembelajaran</h1>
        </div>
        <div class="col-md-6">
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
          <h5 class="mb-0">Form Edit Materi</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="guru_id" class="form-label">Guru</label>
              <select name="guru_id" class="form-control rounded-pill px-3 py-2" required>
                @foreach($guru as $g)
                  <option value="{{ $g->id }}" {{ $materi->guru_id == $g->id ? 'selected' : '' }}>
                    {{ $g->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="subject_id" class="form-label">Mata Pelajaran</label>
              <select name="subject_id" class="form-control rounded-pill px-3 py-2" required>
                @foreach($subject as $s)
                  <option value="{{ $s->id }}" {{ $materi->subject_id == $s->id ? 'selected' : '' }}>
                    {{ $s->subject_name }} - {{ $s->class_name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="file" class="form-label">File PDF (kosongkan jika tidak diubah)</label>
              <input type="file" name="file" class="form-control rounded-pill px-3 py-2" accept="application/pdf">
            </div>

            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea name="deskripsi" class="form-control rounded-4 px-3 py-2" rows="4">{{ $materi->deskripsi }}</textarea>
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('materi.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
              </a>
              <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-save me-1"></i> Update
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
