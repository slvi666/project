@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detail Dokumen</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dok_kegiatan.index') }}">Dokumen Kegiatan</a></li>
              <li class="breadcrumb-item active">Detail</li>
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
                <h3 class="card-title">Informasi Dokumen</h3>
              </div>
              <div class="card-body">
                <p><strong>Nama Dokumen:</strong> {{ $dokKegiatan->nama_dokumen }}</p>
                <p><strong>Deskripsi:</strong> {{ $dokKegiatan->deskripsi }}</p>
                <p><strong>Gambar:</strong></p>
                <img src="{{ asset($dokKegiatan->path_file) }}" width="100%" style="max-width: 400px;" class="img-thumbnail" alt="Gambar">
              </div>
              <div class="card-footer">
                <a href="{{ route('dok_kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
