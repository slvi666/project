@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Edit Dokumentasi Kegiatan</h1>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dok_kegiatan.index') }}">Dokumentasi Kegiatan</a></li>
            <li class="breadcrumb-item active">Edit</li>
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
          <h5 class="mb-0">Form Edit Dokumentasi</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('dok_kegiatan.update', $dokKegiatan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">Nama Dokumentasi</label>
              <input type="text" name="nama_dokumen" value="{{ $dokKegiatan->nama_dokumen }}" class="form-control rounded-pill px-3 py-2" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" class="form-control rounded-4 px-3 py-2" rows="4">{{ $dokKegiatan->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Gambar Lama</label><br>
              <img src="{{ asset($dokKegiatan->path_file) }}" width="250" class="img-thumbnail border border-primary shadow-sm" alt="Gambar">
            </div>

            <div class="mb-4">
              <label class="form-label">Gambar Baru (Opsional)</label>
              <input type="file" name="path_file" class="form-control rounded-pill px-3 py-2" accept="image/*">
              <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            </div>

            <div class="d-flex justify-content-start gap-2">
              <a href="{{ route('dok_kegiatan.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
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
