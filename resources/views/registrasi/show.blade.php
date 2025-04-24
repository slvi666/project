@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-md-6">
          <h1 class="m-0 text-primary"><i class="fas fa-user-circle"></i> Detail Pengguna</h1>
        </div>
        <div class="col-md-6 text-md-right">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('registrasi.index') }}">Daftar Pengguna</a></li>
            <li class="breadcrumb-item active">Detail Pengguna</li>
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
          <h3 class="card-title"><i class="fas fa-id-card-alt"></i> Informasi Pengguna</h3>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-3 font-weight-bold text-muted">Nama</div>
            <div class="col-md-9">{{ $registrasi->name }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-md-3 font-weight-bold text-muted">Email</div>
            <div class="col-md-9">
              <i class="fas fa-envelope text-primary mr-1"></i> {{ $registrasi->email }}
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-3 font-weight-bold text-muted">Role</div>
            <div class="col-md-9">
              @php
                $roleColor = [
                  'Admin' => 'danger',   // Red for Admin
                  'guru' => 'warning',   // Yellow for Guru
                  'siswa' => 'primary',  // Blue for Siswa
                  'calon_siswa' => 'success' // Green for Calon Siswa
                ];
                $roleClass = $roleColor[$registrasi->role_name] ?? 'secondary'; // Default to 'secondary' if no match
              @endphp
              <span class="badge badge-pill badge-{{ $roleClass }}">
                {{ $registrasi->role_name }}
              </span>
            </div>
          </div>

          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('registrasi.index') }}" class="btn btn-outline-danger btn-lg rounded-pill shadow-sm">
              Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
