@php
    $title = 'Register';
@endphp

@extends('adminlte.layouts.auth')

@section('content')
<body class="hold-transition register-page" style="background: linear-gradient(to right, #a1c4fd, #c2e9fb); font-family: 'Poppins', sans-serif; min-height: 100vh;">
  <div class="register-box">
    <div class="register-logo mb-4 text-center">
      <div class="d-flex justify-content-center">
        <div style="background-color: white; border-radius: 50%; padding: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
          <img src="{{ asset('main/assets/img/logo-mts.png') }}" alt="Logo Sekolah" width="65">
        </div>
      </div>
      <h4 class="text-dark font-weight-bold mt-3">MTSS Al-Munawaroh</h4>
    </div>

    <div class="card shadow-lg rounded-lg border-0 animate__animated animate__fadeInDown">
      <div class="card-body register-card-body">
        <h5 class="text-center text-primary font-weight-bold mb-2">Silahkan Daftar Akun</h5>
        <p class="text-center text-muted mb-4">Lengkapi data dengan benar untuk melanjutkan</p>

        <form action="{{ route('register') }}" method="post">
          @csrf

          <div class="input-group mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror"
              name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
            <div class="input-group-append">
              <div class="input-group-text bg-white">
                <i class="fas fa-user-graduate text-primary"></i>
              </div>
            </div>
            @error('name')
              <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror"
              name="email" placeholder="Email" value="{{ old('email') }}" required>
            <div class="input-group-append">
              <div class="input-group-text bg-white">
                <i class="fas fa-envelope-open-text text-primary"></i>
              </div>
            </div>
            @error('email')
              <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror"
              name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text bg-white">
                <i class="fas fa-lock text-primary"></i>
              </div>
            </div>
            @error('password')
              <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password_confirmation"
              placeholder="Konfirmasi Password" required>
            <div class="input-group-append">
              <div class="input-group-text bg-white">
                <i class="fas fa-lock text-primary"></i>
              </div>
            </div>
          </div>

          <div class="form-group form-check mb-3">
            <input type="checkbox" class="form-check-input" id="terms" required>
            <label class="form-check-label text-muted" for="terms">
              Saya menyetujui <a href="#" class="text-primary font-weight-bold">syarat & ketentuan</a>
            </label>
          </div>

          <div class="row mb-2">
            <div class="col-12">
              <button type="submit" class="btn btn-success btn-block">
                <i class="fas fa-user-plus mr-1"></i> Daftar Akun
              </button>
            </div>
          </div>
        </form>

        @if (Route::has('login'))
        <p class="mb-0 text-center mt-2">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="text-primary font-weight-bold">Login di sini</a>
        </p>
        @endif
      </div>
    </div>

    <p class="text-dark text-center mt-4" style="font-size: 13px;">
      © 2025 MTSS Al-Munawaroh
    </p>
  </div>

  <!-- Font & Animasi -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
