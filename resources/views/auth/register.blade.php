@php
  $title = 'Register';
@endphp

@extends('adminlte.layouts.auth')

@section('content')
<body class="hold-transition register-page" style="font-family: 'Poppins', sans-serif; min-height: 100vh; background: linear-gradient(to right, #74ebd5, #ACB6E5); transition: background 0.4s;">
  <div class="register-box">
    <div class="register-logo mb-4 text-center">
      <div class="d-flex justify-content-center">
        <div class="logo-wrapper">
          <img src="{{ asset('main/assets/img/logo-mts.png') }}" alt="Logo Sekolah" width="70">
        </div>
      </div>
      <h4 class="text-white fw-bold mt-3">MTSS Al-Munawaroh</h4>
      <button id="toggle-theme" class="btn btn-sm btn-light mt-2">
        <i class="fas fa-moon"></i> Mode Gelap
      </button>
    </div>

    <div class="card register-card animate__animated animate__fadeInUp mx-auto" style="max-width: 500px;">
      <div class="card-body px-4 py-4">
        <h4 class="text-center text-primary fw-bold mb-3">Buat Akun Baru</h4>
        <p class="text-muted text-center mb-4">Lengkapi formulir untuk mendaftar akun baru</p>

        <form action="{{ route('register') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <div class="input-group">
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                placeholder="Nama lengkap" value="{{ old('name') }}" required>
              <span class="input-group-text"><i class="fas fa-user-graduate text-primary"></i></span>
            </div>
            @error('name')
              <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                placeholder="Email aktif" value="{{ old('email') }}" required>
              <span class="input-group-text"><i class="fas fa-envelope-open-text text-primary"></i></span>
            </div>
            @error('email')
              <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" id="password" placeholder="Password" required>
              <span class="input-group-text"><i class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></i></span>
            </div>
            <small class="form-text text-muted">Gunakan kombinasi huruf, angka, dan simbol.</small>
            @error('password')
              <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="password_confirmation"
                placeholder="Ulangi password" required>
              <span class="input-group-text"><i class="fas fa-lock text-primary"></i></span>
            </div>
          </div>

          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="terms" required>
            <label class="form-check-label text-muted" for="terms">
              Saya menyetujui <a href="#" class="text-primary fw-bold">syarat & ketentuan</a>
            </label>
          </div>

          <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100 shadow-sm" id="register-btn" disabled>
              <i class="fas fa-user-plus me-1"></i> Daftar Akun
            </button>
          </div>
        </form>

        <p class="text-center mt-2 small">
          Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold">Masuk di sini</a>
        </p>
        
      </div>
    </div>

    <footer class="text-white text-center mt-4 small">
      &copy; 2025 MTSS Al-Munawaroh. All rights reserved.
    </footer>
  </div>

  {{-- Fonts & CSS --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  {{-- Style tambahan --}}
  <style>
    .logo-wrapper {
      background-color: white;
      border-radius: 50%;
      padding: 12px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }
    .register-card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      background-color: #fff;
      transition: background-color 0.4s, color 0.4s;
    }
    body.dark-mode {
      background: #1e1e2f !important;
    }
    body.dark-mode .register-card {
      background-color: #2d2d3a;
      color: #fff;
    }
    body.dark-mode .form-control, body.dark-mode .form-control::placeholder {
      background-color: #333 !important;
      color: #fff !important;
    }
    body.dark-mode .text-muted, body.dark-mode .form-text {
      color: #ccc !important;
    }
    .btn-primary:hover {
      background-color: #4d9fcf;
      border-color: #4d9fcf;
    }
  </style>

  {{-- Script --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const email = document.getElementById('email');
      const name = document.getElementById('name');
      const password = document.getElementById('password');
      const terms = document.getElementById('terms');
      const registerBtn = document.getElementById('register-btn');
      const togglePassword = document.getElementById('toggle-password');
      const toggleTheme = document.getElementById('toggle-theme');

      function isValid() {
        return email.value.trim() && name.value.trim() && password.value.length >= 6 && terms.checked;
      }

      function toggleSubmit() {
        registerBtn.disabled = !isValid();
      }

      [email, name, password, terms].forEach(el => el.addEventListener('input', toggleSubmit));

      togglePassword.addEventListener('click', () => {
        const type = password.type === 'password' ? 'text' : 'password';
        password.type = type;
        togglePassword.classList.toggle('fa-eye-slash');
      });

      toggleTheme.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const icon = toggleTheme.querySelector('i');
        icon.classList.toggle('fa-moon');
        icon.classList.toggle('fa-sun');
        toggleTheme.classList.toggle('btn-light');
        toggleTheme.classList.toggle('btn-dark');
        toggleTheme.innerHTML = icon.classList.contains('fa-sun') ? '<i class="fas fa-sun"></i> Mode Terang' : '<i class="fas fa-moon"></i> Mode Gelap';
      });

      toggleSubmit();
    });
  </script>
@endsection
