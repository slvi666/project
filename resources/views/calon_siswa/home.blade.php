@extends('adminlte.layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary font-weight-bold">
            <i class="fas fa-user-graduate mr-2"></i>Selamat datang, {{ auth()->user()->name }}
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-secondary">Halaman Calon Siswa</a></li>
            <li class="breadcrumb-item active text-primary font-weight-bold">Halaman Calon Siswa</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Welcome Card -->
      <div class="card shadow-lg rounded bg-white mb-5">
        <div class="card-body d-flex align-items-center">
          <i class="fas fa-smile-beam fa-3x text-success mr-4 animate__animated animate__pulse animate__infinite"></i>
          <div>
            <h4 class="mb-1">Halo, <strong>{{ auth()->user()->name }}</strong></h4>
            <p class="mb-0 text-muted">
              Anda login sebagai 
              <span class="badge badge-info px-3 py-2 rounded-pill font-weight-bold text-uppercase">{{ auth()->user()->role_name }}</span>
            </p>
          </div>
        </div>
      </div>

      <!-- Pendaftaran Card -->
      <div class="card shadow rounded">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title mb-0">
            <i class="fas fa-id-card-alt mr-2"></i>Status Pendaftaran Siswa
          </h5>
        </div>
        <div class="card-body">
          <div class="row">
            @forelse($pendaftarans as $formulir)
              <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 rounded-lg h-100 card-hover">
                  <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                      <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-light rounded-circle p-3 mr-3 d-flex justify-content-center align-items-center" style="width:60px; height:60px;">
                          <i class="fas fa-user text-primary fa-2x"></i>
                        </div>
                        <div>
                          <h5 class="mb-0 font-weight-bold text-dark">{{ $formulir->user->name ?? '-' }}</h5>
                          <small class="text-muted">{{ $formulir->user->email ?? '-' }}</small>
                        </div>
                      </div>
                      <hr class="my-3">
                      <p class="mb-3 text-muted d-flex align-items-center">
                        <i class="fas fa-calendar-alt mr-2 text-info"></i>
                        <strong>{{ \Carbon\Carbon::parse($formulir->created_at)->translatedFormat('d F Y') }}</strong>
                      </p>
                    </div>
                    <div class="d-flex align-items-center mt-auto">
                      <i class="fas fa-info-circle text-secondary mr-2"></i>
                      <span class="badge badge-status 
                        @if($formulir->status === 'Lulus') badge-success
                        @elseif($formulir->status === 'Pending') badge-primary
                        @elseif($formulir->status === 'Tidak Lulus') badge-danger
                        @else badge-secondary @endif
                        px-3 py-2 rounded-pill font-weight-bold text-uppercase d-flex align-items-center"
                      >
                        @if($formulir->status === 'Lulus')
                          <i class="fas fa-check-circle mr-1"></i>
                        @elseif($formulir->status === 'Pending')
                          <i class="fas fa-hourglass-half mr-1"></i>
                        @elseif($formulir->status === 'Tidak Lulus')
                          <i class="fas fa-times-circle mr-1"></i>
                        @endif
                        {{ $formulir->status === 'Pending' ? 'Menunggu Verifikasi' : $formulir->status }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="alert alert-info text-center d-flex justify-content-center align-items-center py-4">
                  <i class="fas fa-info-circle mr-2 fa-lg"></i> Belum ada data pendaftaran.
                </div>
              </div>
            @endforelse
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<style>
  /* Card hover effect */
  .card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 1rem;
  }
  .card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 1rem 2rem rgba(0,0,0,0.15);
  }

  /* Badge styling */
  .badge-status {
    font-size: 0.875rem;
    letter-spacing: 0.05em;
    animation: pulseBadge 2s infinite;
  }
  @keyframes pulseBadge {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.85; }
  }

  /* Breadcrumb style */
  .breadcrumb .breadcrumb-item a:hover {
    color: #0056b3;
    text-decoration: underline;
  }

  /* Responsive tweaks */
  @media (max-width: 576px) {
    .card-body .avatar {
      width: 50px !important;
      height: 50px !important;
      padding: 1rem !important;
    }
    .card-body h5 {
      font-size: 1rem !important;
    }
  }
</style>

@endsection
