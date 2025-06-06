@extends('adminlte.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary font-weight-bold">Selamat datang di Halaman {{ auth()->user()->role_name }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Halaman Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Total Kegiatan Card -->
        <div class="col-lg-6 mb-4">
          <div class="card shadow-lg rounded-4 border-0 bg-gradient-primary text-white hover-effect">
            <div class="card-body text-center py-5">
              <div class="icon-container mb-4">
                <i class="fas fa-calendar-check fa-4x animate__animated animate__pulse animate__infinite"></i>
              </div>
              <h3 class="display-4 font-weight-bold">{{ $totalKegiatan }}</h3>
              <p class="h5">Total Kegiatan</p>
              <hr class="divider">
            </div>
          </div>
        </div>

        <!-- Card Example -->
        <div class="col-lg-6 mb-4">
          <div class="card card-outline card-primary h-100 hover-effect rounded-4 shadow-lg">
            <div class="card-body">
              <h5 class="card-title font-weight-bold">Total Data Pelajaran</h5>
              <p class="card-text">
                Jumlah total data pelajaran yang tersedia dalam sistem.
              </p>
              <h3 class="display-4 text-primary">{{ \App\Models\NamaPelajaran::count() }}</h3>
              <hr class="divider">
            </div>
          </div>
        </div>

        <!-- Featured Cards -->
        <div class="col-lg-6 mb-4">
          <div class="card border-0 shadow-lg rounded-4 hover-effect">
            <div class="card-header bg-gradient-primary text-white">
              <h5 class="m-0 font-weight-bold">Total Data Siswa</h5>
            </div>
            <div class="card-body">
              <h6 class="card-title font-weight-bold">Jumlah Siswa Terdaftar</h6>
              <p class="card-text">Jumlah total siswa yang terdaftar dalam sistem.</p>
              <h3 class="display-4 text-primary">{{ \App\Models\Siswa::count() }}</h3>
              <hr class="divider">
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-4">
          <div class="card card-outline card-primary h-100 hover-effect rounded-4 shadow-lg">
            <div class="card-header">
              <h5 class="m-0 font-weight-bold">Total Data Tugas</h5>
            </div>
            <div class="card-body">
              <h6 class="card-title font-weight-bold">Jumlah Tugas Tersedia</h6>
              <p class="card-text">Jumlah total tugas yang telah dibuat oleh guru dalam sistem.</p>
              <h3 class="display-4 text-primary">{{ \App\Models\Tugas::count() }}</h3>
              <hr class="divider">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('css')
<style>
  /* Efek Hover pada Kartu */
  .hover-effect:hover {
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    transform: translateY(-8px);
    transition: all 0.3s ease-in-out;
  }

  /* Gradien Kartu */
  .bg-gradient-primary {
    background: linear-gradient(145deg, #6a11cb 0%, #2575fc 100%);
  }

  /* Animasi pada ikon */
  .icon-container i {
    color: white;
    transition: color 0.3s ease;
  }

  .icon-container:hover i {
    color: #ffcc00;
  }

  /* Styling angka */
  .display-4 {
    font-size: 3.5rem;
    font-weight: bold;
    transition: transform 0.3s ease-in-out;
  }

  .display-4:hover {
    transform: scale(1.1);
    color: #f8f9fa;
  }

  /* Menambah padding pada konten kartu */
  .card-body {
    padding: 2rem;
  }

  /* Header pada kartu */
  .card-header {
    background-color: #6a11cb;
    color: white;
  }

  /* Styling Sudut dan Bayangan pada Kartu */
  .card {
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  /* Divider Antara Bagian Teks */
  .divider {
    border: 1px solid rgba(255, 255, 255, 0.3);
    margin-top: 20px;
    margin-bottom: 20px;
  }

  /* Animasi untuk ikon */
  .animate__pulse {
    animation: pulse 1s infinite;
  }

  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }
</style>
@endpush
