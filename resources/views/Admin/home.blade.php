@extends('adminlte.layouts.app')

@section('content')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary font-weight-bold">Selamat datang di Halaman {{ auth()->user()->role_name }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Halaman Super Admin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

<div class="row mb-4">
    @php
        use App\Models\User;
        $totalGuru = User::where('role_name', 'guru')->count();
        $totalSiswa = User::where('role_name', 'siswa')->count();
        $totalCalonSiswa = User::where('role_name', 'calon_siswa')->count();
        $totalUser = User::count();
    @endphp

    <!-- Kartu Total Guru -->
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm rounded-4 bg-gradient-primary text-white p-3">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-chalkboard-teacher fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Total Guru</h6>
                    <h4 class="mb-0">{{ $totalGuru }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Total Pengguna -->
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm rounded-4 bg-gradient-success text-white p-3">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Total Pengguna</h6>
                    <h4 class="mb-0">{{ $totalUser }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Total Siswa -->
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm rounded-4 bg-gradient-warning text-white p-3">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-user-graduate fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Total Siswa</h6>
                    <h4 class="mb-0">{{ number_format($totalSiswa) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Calon Siswa -->
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm rounded-4 bg-gradient-danger text-white p-3">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-user-plus fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Calon Siswa</h6>
                    <h4 class="mb-0">{{ number_format($totalCalonSiswa) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

      </div>

<div class="row mb-4">
  <div class="col-12">
    <div class="card shadow">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div>
          <i class="bi bi-person-plus-fill me-2"></i>
          <strong>Data Pendaftaran Calon Siswa</strong>
        </div>
        <small class="text-white-50">5 pendaftar terbaru</small>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped table-sm align-middle mb-0">
            <thead class="table-primary text-center">
              <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Asal Sekolah</th>
                <th>Tahun Lulus</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse(\App\Models\FormulirPendaftaran::latest()->take(5)->get() as $formulir)
                <tr>
                  <td>{{ $formulir->user->name ?? '-' }}</td>
                  <td>{{ $formulir->nik }}</td>
                  <td class="text-center">{{ $formulir->jenis_kelamin }}</td>
                  <td>{{ $formulir->tempat_lahir }}, {{ \Carbon\Carbon::parse($formulir->tanggal_lahir)->format('d-m-Y') }}</td>
                  <td>{{ $formulir->asal_sekolah }}</td>
                  <td class="text-center">{{ $formulir->tahun_lulus }}</td>
                  <td class="text-center">
                    @php
                      $badgeColor = match($formulir->status) {
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                        'menunggu' => 'warning',
                        default => 'secondary',
                      };
                    @endphp
                    <span class="badge bg-{{ $badgeColor }}">{{ ucfirst($formulir->status) }}</span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted">Belum ada pendaftar.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-3 text-end">
          <a href="{{ route('formulir.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-eye"></i> Lihat Semua
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

      <!-- Recent Orders and Analytics -->
      <div class="row mb-4">
<div class="col-md-8">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <div>
        <i class="bi bi-calendar-week-fill me-2"></i>
        <strong>Jadwal Mata Pelajaran</strong>
      </div>
      <span class="badge bg-light text-success">Aktif</span>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped table-sm align-middle mb-0">
          <thead class="table-success text-center">
            <tr>
              <th>Nama Pelajaran</th>
              <th>Guru</th>
              <th>Kelas</th>
              <th>Hari</th>
              <th>Durasi</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\MataPelajaran::with('subject', 'guru')->get() as $mapel)
              <tr>
                <td>
                  <i class="bi bi-book me-1 text-primary"></i>
                  {{ $mapel->subject->subject_name ?? '-' }}
                </td>
                <td>
                  <i class="bi bi-person-fill me-1 text-dark"></i>
                  {{ $mapel->guru->name ?? '-' }}
                </td>
                <td class="text-center">{{ $mapel->subject->class_name ?? '-' }}</td>
                <td class="text-center">
                  <span class="badge bg-info text-dark">{{ $mapel->hari }}</span>
                </td>
                <td class="text-center">
                  @php
                    $start = \Carbon\Carbon::parse($mapel->waktu_mulai);
                    $end = \Carbon\Carbon::parse($mapel->waktu_berakhir);
                  @endphp
                  <i class="bi bi-clock me-1 text-warning"></i>
                  {{ $start->diff($end)->format('%Hj %Im') }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">Tidak ada jadwal tersedia.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3 text-end">
        <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-outline-success btn-sm">
          <i class="bi bi-eye-fill me-1"></i> Lihat Semua Jadwal
        </a>
      </div>
    </div>
  </div>
</div>

      
<div class="col-md-4">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <div>
        <i class="bi bi-graph-up-arrow me-2"></i>
        <strong>Analytics Report</strong>
      </div>
      <span class="badge bg-light text-primary">Live</span>
    </div>

    <div class="card-body">
      <ul class="list-group list-group-flush mb-4">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <i class="bi bi-book-fill me-2 text-info"></i>Total Mata Pelajaran
          </div>
          <span class="badge bg-info text-white rounded-pill">
            {{ \App\Models\MataPelajaran::count() }}
          </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <i class="bi bi-person-badge-fill me-2 text-success"></i>Guru Terlibat
          </div>
          <span class="badge bg-success text-white rounded-pill">
            {{ \App\Models\MataPelajaran::distinct('guru_id')->count('guru_id') }}
          </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <i class="bi bi-calendar-event-fill me-2 text-warning"></i>Hari Aktif
          </div>
          <span class="badge bg-warning text-dark rounded-pill">
            {{ \App\Models\MataPelajaran::distinct('hari')->count('hari') }}
          </span>
        </li>
      </ul>

      <!-- Progress Overview -->
      <p class="mb-1">Tingkat Jadwal Terisi</p>
      <div class="progress mb-3" style="height: 8px;">
        <div class="progress-bar bg-primary" style="width: 75%;" role="progressbar"></div>
      </div>

      <!-- Optional: Chart -->
      <div>
        <canvas id="riskChart" height="150"></canvas>
      </div>
    </div>
  </div>
</div>

      </div>
      
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Analytics Chart
var ctx = document.getElementById('analyticsChart').getContext('2d');
var analyticsChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    datasets: [{
      label: 'Income ($)',
      data: [1000, 1300, 950, 600, 850, 780, 1170],
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 2,
      fill: false
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

// Risk Chart
var riskCtx = document.getElementById('riskChart').getContext('2d');
var riskChart = new Chart(riskCtx, {
  type: 'pie',
  data: {
    labels: ['Low Risk', 'Medium Risk', 'High Risk'],
    datasets: [{
      label: 'Risk Analysis',
      data: [65, 25, 10],
      backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)'],
      borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 99, 132, 1)'],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      }
    }
  }
});
</script>
@endpush
