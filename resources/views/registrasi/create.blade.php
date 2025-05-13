@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-sm-6">
          <h1 class="m-0">Buat Pengguna Baru</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('registrasi.index') }}">Daftar Pengguna</a></li>
            <li class="breadcrumb-item active">Buat Pengguna Baru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Form Registrasi Pengguna Manual</h5>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <strong>Terjadi kesalahan:</strong>
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Form Buat Manual -->
          <form action="{{ route('registrasi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" id="name" name="name" class="form-control rounded-pill" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" name="email" class="form-control rounded-pill" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Kata Sandi</label>
              <input type="password" id="password" name="password" class="form-control rounded-pill" required>
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control rounded-pill" required>
            </div>

            <div class="mb-4">
              <label for="role_name" class="form-label">Peran</label>
              <select id="role_name" name="role_name" class="form-control rounded-pill" required>
                <option value="">-- Pilih Role --</option>
                <option value="siswa">Siswa</option>
                <option value="guru">Guru</option>
                <option value="Admin">Admin</option>
                <option value="Orang Tua">Orang Tua</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
              <i class="fas fa-user-plus me-1"></i> Buat Pengguna
            </button>
          </form>

          <hr class="my-5">

          <!-- Import Excel -->
          <h5 class="mb-3">Atau Import dari File Excel</h5>
          <form action="{{ route('registrasi.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="file" class="form-label">Pilih File (.xlsx, .xls, .csv)</label>
              <input type="file" id="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="fas fa-file-import me-1"></i> Import Excel
              </button>
              <a href="{{ route('registrasi.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection
