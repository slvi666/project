@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary">Detail Materi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('materi.index') }}">Materi</a></li>
            <li class="breadcrumb-item active">Detail Materi</li>
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
              <h3 class="card-title m-0">Informasi Materi Pembelajaran</h3>
            </div>

            <div class="card-body p-5">
              <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-user me-2 text-primary"></i> Guru:
                    </h5>
                    <p class="fs-5 text-dark">{{ $materi->guru->name }}</p>
                  </div>

                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-book me-2 text-success"></i> Mata Pelajaran:
                    </h5>
                    <p class="fs-5 text-dark">{{ $materi->subject->subject_name }}</p>
                  </div>

                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-users me-2 text-warning"></i> Kelas:
                    </h5>
                    <p class="fs-5 text-dark">{{ $materi->subject->class_name }}</p>
                  </div>
                  <div class="mb-4">
  <h5 class="fw-bold text-dark">
    <i class="fas fa-eye me-2 text-primary"></i> Status Dilihat:
  </h5>
  <p class="fs-5 text-dark">{{ $materi->views }} kali</p>
</div>


                  @if(isset($materi->status))
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-info-circle me-2 text-secondary"></i> Status:
                    </h5>
                    <span class="badge {{ $materi->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                      {{ ucfirst($materi->status) }}
                    </span>
                  </div>
                  @endif
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-calendar-alt me-2 text-info"></i> Tanggal Update:
                    </h5>
                    <p class="fs-5 text-dark">{{ $materi->created_at->format('d M Y') }}</p>
                  </div>

                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-align-left me-2 text-danger"></i> Deskripsi:
                    </h5>
                    <p class="fs-5 text-muted">{{ $materi->deskripsi }}</p>
                  </div>

                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-file-pdf me-2 text-danger"></i> File Materi:
                    </h5>
                    <a href="{{ asset('storage/' . $materi->file) }}" target="_blank" class="btn btn-outline-danger shadow-sm rounded-pill">
                      <i class="fas fa-eye me-1"></i> Lihat Materi
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center rounded-bottom">
              <a href="{{ route('materi.index') }}" class="btn btn-secondary btn-sm px-4 py-2 shadow-lg rounded-pill">
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
