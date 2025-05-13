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
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Halaman Calon Siswa</a></li>
            <li class="breadcrumb-item active">Halaman Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Card Selamat Datang -->
      <div class="card shadow-lg rounded bg-white mb-4">
        <div class="card-body d-flex align-items-center">
          <i class="fas fa-smile-beam fa-3x text-success mr-4 animate__animated animate__pulse animate__infinite"></i>
          <div>
            <h4 class="mb-1">Halo, <strong>{{ auth()->user()->name }}</strong></h4>
            <p class="mb-0 text-muted">
              Anda login sebagai 
              <span class="badge badge-info">{{ auth()->user()->role_name }}</span>
            </p>
          </div>
        </div>
      </div>

      <!-- Data Pendaftaran Siswa -->
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
                <div class="card shadow-sm border-0 rounded-lg h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <div class="avatar bg-light rounded-circle p-3 mr-3">
                        <i class="fas fa-user text-primary fa-2x"></i>
                      </div>
                      <div>
                        <h5 class="mb-0 font-weight-bold text-dark">{{ $formulir->user->name ?? '-' }}</h5>
                        <small class="text-muted">{{ $formulir->user->email ?? '-' }}</small>
                      </div>
                    </div>
                    <hr class="my-2">
                    <p class="mb-2 text-muted">
                      <i class="fas fa-calendar-alt mr-2 text-info"></i>
                      <strong>{{ \Carbon\Carbon::parse($formulir->created_at)->translatedFormat('d F Y') }}</strong>
                    </p>
                    <div class="d-flex align-items-center">
                      <i class="fas fa-info-circle text-secondary mr-2"></i>
                      <span class="badge 
  @if($formulir->status === 'Lulus') badge-success
  @elseif($formulir->status === 'Pending') badge-primary
  @elseif($formulir->status === 'Tidak Lulus') badge-danger
  @else badge-secondary @endif">
  @if($formulir->status === 'Lulus')
    <i class="fas fa-check-circle mr-1"></i>
  @elseif($formulir->status === 'Pending')
    <i class="fas fa-hourglass-half mr-1"></i>
  @elseif($formulir->status === 'Tidak Lulus')
    <i class="fas fa-times-circle mr-1"></i>
  @endif
  {{ $formulir->status }}
</span>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="alert alert-info text-center">
                  <i class="fas fa-info-circle mr-2"></i>Belum ada data pendaftaran.
                </div>
              </div>
            @endforelse
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

@endsection
