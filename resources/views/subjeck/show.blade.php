@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
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
      <div class="card shadow-sm rounded-lg">
        <div class="card-header bg-gradient-info text-white">
          <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Mata Pelajaran</h3>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-3 font-weight-bold text-muted">Kelas</div>
            <div class="col-md-9">{{ $subject->class_name }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-md-3 font-weight-bold text-muted">Mata Pelajaran</div>
            <div class="col-md-9">{{ $subject->subject_name }}</div>
          </div>

          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
