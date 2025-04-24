@extends('adminlte.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Pengguna</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('registrasi.index') }}">Daftar Pengguna</a></li>
              <li class="breadcrumb-item active">Edit Pengguna</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Card for edit user form -->
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Informasi Pengguna</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ route('registrasi.update', $registrasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label for="name">Nama:</label>
                  <input type="text" id="name" name="name" class="form-control" value="{{ $registrasi->name }}" required readonly>
                </div>

                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" class="form-control" value="{{ $registrasi->email }}" required readonly>
                </div>
                <div class="form-group">
                  <label for="password">Kata Sandi:</label>
                  <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-primary" id="togglePassword" style="border-radius: 0 5px 5px 0;">
                        <i class="fas fa-eye"></i> Show
                      </button>
                    </div>
                  </div>
                  <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah kata sandi.</small>
                </div>

                <div class="form-group">
                  <label for="password_confirmation">Konfirmasi Kata Sandi:</label>
                  <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>

                <div class="form-group">
                  <label for="role_name">Role:</label>
                  <select id="role_name" name="role_name" class="form-control" required>
                      <option value="siswa" {{ $registrasi->role_name === 'siswa' ? 'selected' : '' }}>Siswa</option>
                      <option value="guru" {{ $registrasi->role_name === 'guru' ? 'selected' : '' }}>Guru</option>
                      <option value="Admin" {{ $registrasi->role_name === 'Admin' ? 'selected' : '' }}>Admin</option>
                      <option value="Orang Tua" {{ $registrasi->role_name === 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                      <option value="Perpustakaan" {{ $registrasi->role_name === 'Perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                  </select>
                </div>

                <div class="form-group text-left">
                  <button type="submit" class="btn btn-primary">Perbarui Pengguna</button>
                  <a href="{{ route('registrasi.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
      var passwordField = document.getElementById('password');
      var toggleIcon = this.querySelector('i');
      
      // Toggle the type of the password field
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
        this.innerHTML = '<i class="fas fa-eye-slash"></i> Hide';
        this.classList.remove('btn-primary');
        this.classList.add('btn-warning');
      } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
        this.innerHTML = '<i class="fas fa-eye"></i> Show';
        this.classList.remove('btn-warning');
        this.classList.add('btn-primary');
      }
    });
  </script>
@endsection
