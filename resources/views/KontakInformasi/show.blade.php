@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary">Detail Kontak Informasi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('kontak-informasi.index') }}">Kontak</a></li>
            <li class="breadcrumb-item active">Detail Kontak</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded-4 w-100">
            <div class="card-header bg-gradient-primary text-white text-center py-4 rounded-top">
              <h3 class="card-title m-0">Informasi Kontak</h3>
            </div>

            <div class="card-body p-5">
              <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                  <!-- Nama -->
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark"><i class="fas fa-user me-2"></i> Nama:</h5>
                    <p class="fs-5 text-dark">{{ $kontak->nama_identitas }}</p>
                  </div>

                  <!-- Email -->
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark"><i class="fas fa-envelope me-2"></i> Email:</h5>
                    <p class="fs-5 text-dark">{{ $kontak->email }}</p>
                  </div>

                  <!-- Nomor Telepon -->
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark"><i class="fas fa-phone-alt me-2"></i> Nomor Telepon:</h5>
                    <p class="fs-5 text-dark">{{ $kontak->no_telpon }}</p>
                  </div>

                  <!-- Instagram -->
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark"><i class="fab fa-instagram me-2"></i> Instagram:</h5>
                    <p class="fs-5 text-dark">{{ $kontak->instagram }}</p>
                  </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                  <!-- Nomor WhatsApp -->
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark"><i class="fab fa-whatsapp me-2"></i> Nomor WhatsApp:</h5>
                    <p class="fs-5 text-dark">{{ $kontak->no_wa }}</p>
                  </div>

                  <!-- Facebook -->
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark"><i class="fab fa-facebook-square me-2"></i> Facebook:</h5>
                    <p class="fs-5 text-dark">{{ $kontak->fb }}</p>
                  </div>

                  <!-- Alamat -->
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark"><i class="fas fa-map-marker-alt me-2"></i> Alamat:</h5>
                    <p class="fs-5 text-dark">{{ $kontak->alamat }}</p>
                  </div>

                  <!-- Tanggal Dibuat -->
                  <div class="text-muted mt-4">
                    <small><i class="fas fa-calendar-alt me-2"></i> Dibuat pada: {{ $kontak->created_at->translatedFormat('d F Y, H:i') }}</small>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center rounded-bottom">
              <a href="{{ route('kontak-informasi.index') }}" class="btn btn-secondary btn-sm px-4 py-2 shadow-lg rounded-pill">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
