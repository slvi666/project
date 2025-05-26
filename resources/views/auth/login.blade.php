@extends('adminlte.layouts.auth')

@section('content')
<body class="hold-transition login-page" id="body-theme" style="font-family: 'Poppins', sans-serif; min-height: 100vh; background: linear-gradient(to right, #74ebd5, #ACB6E5); transition: background 0.4s;">
  <div class="login-box">
    <div class="login-logo mb-4 text-center">
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

    <div class="card login-card animate__animated animate__fadeInUp">
      <div class="card-body px-4 py-4">
        {{-- Feedback session --}}
        @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <h4 class="text-center text-primary fw-bold mb-3">Selamat Datang 👋</h4>
        <p class="login-box-msg text-muted text-center mb-4">Silakan masuk ke akun Anda</p>

        <form action="{{ route('login') }}" method="post">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <input type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" id="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
              <span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
            </div>
            @error('email')
              <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
              <input type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" id="password-input" placeholder="Password" required>
              <span class="input-group-text"><i class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></i></span>
            </div>
            <small id="password-tips" class="form-text text-muted d-none mt-1">Gunakan kombinasi huruf, angka, dan simbol.</small>
            @error('password')
              <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
            @enderror
          </div>

          <div class="row mb-3 align-items-center">
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-muted" for="remember">Ingat Saya</label>
              </div>
            </div>
            <div class="col-6 text-end">
              <button type="submit" class="btn btn-primary w-100 shadow-sm" disabled>
                <i class="fas fa-sign-in-alt me-1"></i> Login
              </button>
            </div>
          </div>
        </form>

        @if (Route::has('register'))
          <p class="text-center mt-3 small">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary fw-bold">Daftar Sekarang</a>
          </p>
        @endif
      </div>
    </div>

    <footer class="text-white text-center mt-4 small">
      &copy; 2025 MTSS Al-Munawaroh. All rights reserved.
    </footer>
  </div>

  <!-- Fonts & Animate.css -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Styling tambahan -->
  <style>
    .logo-wrapper {
      background-color: white;
      border-radius: 50%;
      padding: 12px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }
    .login-card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      background-color: #fff;
      transition: background-color 0.4s, color 0.4s;
    }
    body.dark-mode {
      background: #1e1e2f !important;
    }
    body.dark-mode .login-card {
      background-color: #2d2d3a;
      color: #fff;
    }
    body.dark-mode .text-muted, body.dark-mode .form-text {
      color: #ccc !important;
    }
    body.dark-mode .form-control, body.dark-mode .form-control::placeholder {
      background-color: #333 !important;
      color: #fff !important;
    }
    .btn-primary:hover {
      background-color: #4d9fcf;
      border-color: #4d9fcf;
    }
  </style>

  <!-- Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password-input');
      const loginButton = document.querySelector('button[type="submit"]');
      const togglePassword = document.getElementById('toggle-password');
      const passwordTips = document.getElementById('password-tips');
      const toggleTheme = document.getElementById('toggle-theme');

      const isSuspicious = (value) => {
        const patterns = [
          /<script.*?>/i, /<\/script>/i, /<\?php/i,
          /{.*}/, /function\s*\(/i, /<.*?>/
        ];
        return patterns.some(pattern => pattern.test(value));
      };

      function validateInputs() {
        const emailVal = emailInput.value.trim();
        const passwordVal = passwordInput.value.trim();
        const hasSuspicious = isSuspicious(emailVal) || isSuspicious(passwordVal);

        loginButton.disabled = !(emailVal && passwordVal && !hasSuspicious);
      }

      emailInput.addEventListener('input', validateInputs);
      passwordInput.addEventListener('input', () => {
        validateInputs();
        passwordTips.classList.remove('d-none');
      });

      // Show/Hide password
      togglePassword.addEventListener('click', () => {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        togglePassword.classList.toggle('fa-eye-slash');
      });

      // Dark mode toggle
      toggleTheme.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const icon = toggleTheme.querySelector('i');
        icon.classList.toggle('fa-moon');
        icon.classList.toggle('fa-sun');
        toggleTheme.classList.toggle('btn-light');
        toggleTheme.classList.toggle('btn-dark');
        toggleTheme.innerHTML = icon.classList.contains('fa-sun') ? '<i class="fas fa-sun"></i> Mode Terang' : '<i class="fas fa-moon"></i> Mode Gelap';
      });

      validateInputs();
    });
  </script>
@endsection
