@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-user-tie me-2 text-primary"></i>Detail Guru</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right bg-transparent">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Daftar Guru</a></li>
            <li class="breadcrumb-item active">Detail Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp w-100">
            <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top-4">
              <h3 class="card-title text-dark mb-0">
                <i class="fas fa-id-card-alt me-2 text-info"></i>Informasi Guru
              </h3>
              <a href="{{ route('guru.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>

            <div class="card-body">
              <div class="row g-4">
                <div class="col-md-4 text-center">
                  <img src="{{ asset('storage/'.$guru->foto) }}"
                       alt="Foto Guru"
                       class="img-fluid rounded-circle shadow"
                       style="width: 200px; height: 200px; object-fit: cover;">
                  <div class="text-muted mt-2"><i class="fas fa-camera-retro"></i> Foto Guru</div>
                </div>

                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="text-muted small"><i class="fas fa-id-badge me-1"></i> NIP</label>
                      <div class="fw-semibold text-dark">{{ $guru->nip }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="text-muted small"><i class="fas fa-user me-1"></i> Nama</label>
                      <div class="fw-semibold text-dark">{{ $guru->nama_guru }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> Alamat</label>
                      <div class="fw-semibold text-dark">{{ $guru->alamat }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="text-muted small"><i class="fas fa-venus-mars me-1"></i> Jenis Kelamin</label>
                      <div class="fw-semibold">
                        @if($guru->jenis_kelamin == 'Laki-laki')
                          <span class="badge bg-primary rounded-pill"><i class="fas fa-mars me-1"></i> Laki-laki</span>
                        @else
                          <span class="badge bg-danger rounded-pill"><i class="fas fa-venus me-1"></i> Perempuan</span>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="text-muted small"><i class="fas fa-phone me-1"></i> Telepon</label>
                      <div class="fw-semibold text-dark">{{ $guru->telepon }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer bg-white text-muted text-end small rounded-bottom-4">
              <i class="fas fa-clock me-1"></i> Terakhir diperbarui: {{ $guru->updated_at->format('d M Y, H:i') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Load FontAwesome & Animate.css -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
