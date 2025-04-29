@extends('adminlte.layouts.auth')

@section('content')
<body class="hold-transition login-page" style="background: linear-gradient(to right, #74ebd5, #ACB6E5); font-family: 'Poppins', sans-serif; min-height: 100vh;">
  <div class="login-box">
    <div class="login-logo mb-4 text-center">
      <div class="d-flex justify-content-center">
        <div style="background-color: white; border-radius: 50%; padding: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
          <img src="{{ asset('main/assets/img/logo-mts.png') }}" alt="Logo Sekolah" width="70">
        </div>
      </div>
      <h4 class="text-white font-weight-bold mt-3">MTSS Al-Munawaroh</h4>
    </div>

    <div class="card shadow-lg border-0 rounded-3 animate__animated animate__fadeIn">
      <div class="card-body login-card-body">
        <h4 class="text-center text-primary font-weight-bold mb-3">Selamat Datang 👋</h4>
        <p class="login-box-msg text-muted">Silahkan Masuk ke Akun Anda</p>

        <form action="{{ route('login') }}" method="post">
          @csrf

          <div class="input-group mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror"
              name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text bg-white">
                <span class="fas fa-envelope text-primary"></span>
              </div>
            </div>
            @error('email')
              <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror"
              name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text bg-white">
                <span class="fas fa-lock text-primary"></span>
              </div>
            </div>
            @error('password')
              <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="row mb-3">
            <div class="col-8 d-flex align-items-center">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="text-muted">
                  Ingat Saya
                </label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-success btn-block">
                <i class="fas fa-sign-in-alt mr-1"></i> Login
              </button>
            </div>
          </div>
        </form>

        @if (Route::has('password.request'))
          <p class="mb-2 text-center">
            {{-- <a href="{{ route('password.request') }}" class="text-secondary">
              <i class="fas fa-key mr-1"></i> Lupa Password?
            </a> --}}
          </p>
        @endif

        @if (Route::has('register'))
          <p class="mb-0 text-center">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary font-weight-bold">
              Daftar Sekarang
            </a>
          </p>
        @endif
      </div>
    </div>

    <p class="text-white text-center mt-4" style="font-size: 13px;">
      © 2025 MTSS Al-Munawaroh 
    </p>
  </div>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <!-- Animate.css for simple animation -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
