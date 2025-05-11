@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Dokumen</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dok_kegiatan.index') }}">Dokumen Kegiatan</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Form Edit Dokumen</h3>
              </div>
              <div class="card-body">
                <form action="{{ route('dok_kegiatan.update', $dokKegiatan->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label>Nama Dokumen</label>
                    <input type="text" name="nama_dokumen" class="form-control" value="{{ $dokKegiatan->nama_dokumen }}" required>
                  </div>
                  <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ $dokKegiatan->deskripsi }}</textarea>
                  </div>
                  <div class="form-group">
                    <label>Gambar Lama:</label><br>
                    <img src="{{ asset($dokKegiatan->path_file) }}" width="200" class="img-thumbnail" alt="Gambar">
                  </div>
                  <div class="form-group">
                    <label>Gambar Baru (Opsional)</label>
                    <input type="file" name="path_file" class="form-control" accept="image/*">
                  </div>
                  <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('dok_kegiatan.index') }}" class="btn btn-secondary">Batal</a>
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
