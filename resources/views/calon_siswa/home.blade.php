@extends('adminlte.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary font-weight-bold">
            Selamat datang, {{ auth()->user()->name }} ({{ auth()->user()->role_name }})
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Halaman Calon Siswa</a></li>
            <li class="breadcrumb-item active">Halaman Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Card Selamat Datang -->
      <div class="card bg-light p-4 mb-4">
        <div class="d-flex align-items-center">
          <i class="fas fa-smile fa-3x text-success mr-3 animate__animated animate__pulse animate__infinite"></i>
          <div>
            <h4 class="mb-0">Halo {{ auth()->user()->name }}, selamat datang di sistem!</h4>
            <p class="mb-0 text-muted">Anda login sebagai {{ auth()->user()->role_name }}</p>
          </div>
        </div>
      </div>

      <!-- Tabel Pendaftaran (Statis) -->
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title mb-0">Data Pendaftaran Siswa</h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Email</th>
                <th>Status</th>
                <th>Tanggal Daftar</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pendaftarans as $index => $formulir)
                  <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $formulir->user->name ?? '-' }}</td>
                      <td>{{ $formulir->user->email ?? '-' }}</td>
                      <td>
                          <span class="badge 
                              @if($formulir->status === 'Diterima') bg-success 
                              @elseif($formulir->status === 'Diproses') bg-warning 
                              @else bg-danger @endif">
                              {{ $formulir->status }}
                          </span>
                      </td>
                      <td>{{ \Carbon\Carbon::parse($formulir->created_at)->translatedFormat('d F Y') }}</td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="5" class="text-center text-muted">Belum ada data pendaftaran.</td>
                  </tr>
              @endforelse
          </tbody>
          
          </table>
        </div>
      </div>

    </div>
  </section>

</div>
<!-- /.content-wrapper -->

@endsection
