<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? "MTSS Al-Munawaroh" }} | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
  
  <style>
/* Warna latar belakang utama */
body {
    background-color: #F5F5F5 !important;
    color: black !important;
}

/* Sidebar */
.main-sidebar {
    background-color: #F5F5F5 !important;
}

/* Warna teks sidebar */
.nav-sidebar .nav-link {
    color: black !important;
    border-radius: 5px;
}

/* Warna hover */
.nav-sidebar .nav-link:hover {
    background-color: #DD88CF !important;
    color: black !important;
}

/* Warna item aktif & menu terbuka */
.nav-sidebar .nav-item.menu-open > .nav-link,
.nav-sidebar .nav-link.active {
    background-color: #F5F5F5 !important;
    color: black !important;
    
}

/* Logo & teks brand */
.brand-link, .brand-text {
    color: black !important;
    
}

/* Warna teks di panel user */
.user-panel .info a {
    color: black !important;
    f
}

/* Navbar */
.navbar {
    background-color: #F5F5F5 !important;
    border-bottom: 2px solid #DD88CF;
}

/* Navbar links */
.navbar .nav-link {
    color: black !important;
  
}

/* Hover efek di navbar */
.navbar .nav-link:hover {
    background-color: #DD88CF !important;
    color: black !important;
    border-radius: 5px;
}

  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('main/assets/img/logo-mts.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ $title ?? "MTSS Al-Munawaroh" }}</span>
    </a>
  
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>
  
<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    @if (auth()->user()->role_name === 'Admin')
    <li class="nav-header mt-2 py-2">- Assets</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>Menejemen Pengguna<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('registrasi.index') }}" class="nav-link">
            <i class="fas fa-user-circle nav-icon"></i>
            <p>Data Pengguna</p>
          </a>
        </li>
      </ul>
    </li>
    @endif

    <li class="nav-header mt-2 py-2">- Pengelolaan Data</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-database"></i>
        <p>Data<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        @if (in_array(auth()->user()->role_name, ['siswa', 'calon_siswa']))
        <li class="nav-item">
          <a href="{{ route('formulir.index') }}" class="nav-link">
            <i class="fas fa-calendar nav-icon"></i>
            <p>Formulir Pendaftaran</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('seleksi-berkas.index') }}" class="nav-link">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>Berkas Pendaftaran</p>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a href="{{ route('laporan.index') }}" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>Laporan Pendaftaran</p>
          </a>
        </li> --}}
        @endif

        @if (in_array(auth()->user()->role_name, ['guru', 'Admin']))
        <li class="nav-item">
          <a href="{{ route('guru.index') }}" class="nav-link">
            <i class="fas fa-chalkboard-teacher nav-icon"></i>
            <p>Data Guru</p>
          </a>
        </li>
        @endif

        @if (in_array(auth()->user()->role_name, ['guru', 'siswa', 'Admin']))
        <li class="nav-item">
          <a href="{{ route('profil_siswa.index') }}" class="nav-link">
            <i class="fas fa-user-graduate nav-icon"></i>
            <p>Data Siswa</p>
          </a>
        </li>
        @endif

        @if (auth()->user()->role_name === 'Admin')
        <li class="nav-item">
          <a href="{{ route('pengumuman.index') }}" class="nav-link">
            <i class="fas fa-bullhorn nav-icon"></i>
            <p>Data Pengumuman</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('faq.index') }}" class="nav-link">
            <i class="fas fa-question-circle nav-icon"></i>
            <p>Data FAQ</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('kontak-informasi.index') }}" class="nav-link">
            <i class="fas fa-phone-alt nav-icon"></i>
            <p>Kontak Informasi</p>
          </a>
        </li>
        @endif
      </ul>
    </li>

    @if (in_array(auth()->user()->role_name, ['guru', 'siswa', 'Admin']))
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-calendar-check"></i>
        <p>Laporan Absensi<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('absensi.laporan') }}" class="nav-link {{ request()->routeIs('absensi.laporan') ? 'active' : '' }}">
            <i class="fas fa-list nav-icon"></i>
            <p>Laporan Absensi</p>
          </a>
        </li>
      </ul>
    </li>
    @endif

    @if (in_array(auth()->user()->role_name, ['siswa', 'guru', 'Admin']))
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-calendar-alt"></i>
        <p>Kalender Akademik<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('fullcalender') }}" class="nav-link">
            <i class="fas fa-calendar nav-icon"></i>
            <p>Kalender</p>
          </a>
        </li>
      </ul>
    </li>
    @endif

    @if (in_array(auth()->user()->role_name, ['guru', 'siswa', 'Admin']))
    <li class="nav-header mt-2 py-2">Pembelajaran Sekolah</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book-open"></i>
        <p>Media Pembelajaran<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('materi.index') }}" class="nav-link">
            <i class="fas fa-book nav-icon"></i>
            <p>Materi</p>
          </a>
        </li>

        @if (in_array(auth()->user()->role_name, ['guru', 'siswa']))
        <li class="nav-item">
          <a href="{{ route('tugas.index') }}" class="nav-link">
            <i class="fas fa-tasks nav-icon"></i>
            <p>Tugas</p>
          </a>
        </li>
        @endif

        @if (auth()->user()->role_name === 'Admin')
        <li class="nav-item">
          <a href="{{ route('subjects.index') }}" class="nav-link">
            <i class="fas fa-book-reader nav-icon"></i>
            <p>Kelas & Pelajaran</p>
          </a>
        </li>
        @endif

        @if (in_array(auth()->user()->role_name, ['guru', 'siswa', 'Admin', 'Orang Tua']))
        <li class="nav-item">
          <a href="{{ route('mata-pelajaran.index') }}" class="nav-link">
            <i class="fas fa-clock nav-icon"></i>
            <p>Jadwal Pelajaran</p>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif
    @if (in_array(auth()->user()->role_name, ['siswa', 'guru', 'Admin']))
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        <p>Perpustakaan<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        @if (auth()->user()->role_name === 'Admin')
        <li class="nav-item">
          <a href="{{ route('buku.index') }}" class="nav-link">
            <i class="fas fa-bookmark nav-icon"></i>
            <p>Data Buku Admin</p>
          </a>
        </li>
        @endif
    
        @if (in_array(auth()->user()->role_name, ['siswa', 'guru']))
        <li class="nav-item">
          <a href="{{ route('bookssiswa.index') }}" class="nav-link">
            <i class="fas fa-bookmark nav-icon"></i>
            <p>Data Buku Siswa/Guru</p>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif
    
  

    @if (in_array(auth()->user()->role_name, [ 'Admin']))
    <li class="nav-header mt-2 py-2">- PPDB</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user-check"></i>
        <p>PPDB<i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('formulir.index') }}" class="nav-link">
            <i class="fas fa-edit nav-icon"></i>
            <p>Pendaftaran</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('seleksi-berkas.index') }}" class="nav-link">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>Berkas Pendaftaran</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('laporan.index') }}" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>Laporan</p>
          </a>
        </li>
      </ul>
    </li>
    @endif
    @if (in_array(auth()->user()->role_name, [ 'Admin']))
    <li class="nav-header mt-2 py-2">- FAQ </li>
    <li class="nav-item">
      <a href="{{ route('faq.index') }}" class="nav-link">
        <i class="fas fa-file nav-icon"></i>
        <p>FAQ</p>
      </a>
    </li>
    @endif
    <li class="nav-header mt-2 py-2">- Logout</li>
    <li class="nav-item">
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">

        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Keluar</p>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </li>



  </ul>
</nav>
<!-- /.sidebar-menu -->


    </div>
    <!-- /.sidebar -->
  </aside>
  
  @yield('content')
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

<!-- Di bagian bawah sebelum penutupan </body> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
</body>
</html>
