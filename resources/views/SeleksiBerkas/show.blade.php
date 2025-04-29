@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-file-alt"></i> Detail Seleksi Berkas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('seleksi-berkas.index') }}">Seleksi Berkas</a></li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title m-0"><i class="fas fa-user"></i> Informasi Pendaftar</h3>
            </div>

            <div class="card-body">
              <!-- Grid Layout for User Information -->
              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Nama User</div>
                <div class="col-sm-9">{{ $seleksiBerkas->user->name }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3 font-weight-bold">Formulir Pendaftaran ID</div>
                <div class="col-sm-9">{{ $seleksiBerkas->formulir_pendaftaran_id }}</div>
              </div>
            </div>
          </div>

          <!-- Card for Document Files -->
          <div class="card shadow-lg rounded mt-4">
            <div class="card-header bg-gradient-info text-white">
              <h3 class="card-title m-0"><i class="fas fa-file"></i> Dokumen Pendaftar</h3>
            </div>

            <div class="card-body">
              <!-- Grid Layout for Document Files -->
              <div class="row mb-3">
                @php
                  $documents = [
                      'Foto KTP Orang Tua' => $seleksiBerkas->poto_ktp_orang_tua,
                      'Kartu Keluarga' => $seleksiBerkas->kartu_keluarga,
                      'Akte Kelahiran' => $seleksiBerkas->akte_kelahiran,
                      'Surat Kelulusan' => $seleksiBerkas->surat_kelulusan,
                      'Raport' => $seleksiBerkas->raport,
                      'KIS/KIP' => $seleksiBerkas->kis_kip,
                      'Ijazah' => $seleksiBerkas->ijazah,
                  ];
                @endphp

                @foreach ($documents as $label => $file)
                  <div class="col-md-6 mb-3">
                    <div class="card shadow-sm rounded-lg">
                      <div class="card-header bg-light text-dark">
                        <h6 class="mb-0"><i class="fas fa-paperclip"></i> {{ $label }}</h6>
                      </div>
                      <div class="card-body text-center">
                        @if ($file)
                          <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-success btn-sm rounded-pill">
                            <i class="fas fa-eye"></i> Lihat File
                          </a>
                        @else
                          <span class="badge bg-secondary">Tidak Ada</span>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>

              <!-- Action Buttons Inside the Document Card -->
              <div class="row mt-4">
                <div class="col text-right">
                  <a href="{{ route('seleksi-berkas.index') }}" class="btn btn-danger btn-lg rounded-pill">
                    <i class="fas fa-arrow-left"></i> Kembali
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('styles')
<style>
  .card-header {
    border-radius: 10px 10px 0 0;
  }
  .card-body {
    background-color: #f9f9f9;
    padding: 25px;
    border-radius: 10px;
  }
  .card-footer {
    background-color: #f1f1f1;
    border-radius: 0 0 10px 10px;
  }
  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  .badge-secondary {
    background-color: #6c757d !important;
  }
  .btn-rounded {
    border-radius: 50px !important;
  }
  .btn-success {
    background-color: #28a745;
    border-color: #28a745;
  }
  .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
  }
  .mx-2 {
    margin-left: 0.5rem;
    margin-right: 0.5rem;
  }
</style>
@endpush
