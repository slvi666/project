@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-6">
          <h1 class="m-0 text-primary"><i class="fas fa-book"></i> Detail Mata Pelajaran</h1>
        </div>
        <div class="col-md-6 text-md-right">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Daftar Mata Pelajaran</a></li>
            <li class="breadcrumb-item active">Detail Mata Pelajaran</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded-4 w-100">
            <!-- Card Header -->
            <div class="card-header bg-gradient-info text-white text-center py-4 rounded-top">
              <h3 class="card-title m-0"><i class="fas fa-info-circle"></i> Informasi Mata Pelajaran</h3>
            </div>

            <!-- Card Body -->
            <div class="card-body p-5">
              <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-chalkboard-teacher me-2 text-success"></i> Kelas:
                    </h5>
                    <p class="fs-5 text-dark">{{ $subject->class_name }}</p>
                  </div>

                  <div class="mb-4">
                    <h5 class="fw-bold text-dark">
                      <i class="fas fa-book me-2 text-warning"></i> Mata Pelajaran:
                    </h5>
                    <p class="fs-5 text-dark">{{ $subject->subject_name }}</p>
                  </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                  <!-- Only keep the button at the bottom -->
                </div>
              </div>
            </div>

            <!-- Card Footer with the "Back" Button -->
            <div class="card-footer d-flex justify-content-between align-items-center rounded-bottom">
              <a href="{{ route('subjects.index') }}" class="btn btn-secondary btn-sm px-4 py-2 shadow-lg rounded-pill">
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
