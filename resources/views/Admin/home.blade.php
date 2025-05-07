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
      <!-- Cards with Progress Bars -->
      {{-- total guru --}}
      <div class="row mb-4">
        @php
        use App\Models\User;
        $totalGuru = User::where('role_name', 'guru')->count();
        @endphp
        
        <div class="col-md-3">
          <div class="card p-3">
            <h6>Total Pengguna (Guru)</h6>
            <h4>{{ $totalGuru }}
              <span class="text-success small">▲ 100%%</span>
            </h4>
            <div class="progress">
              <div class="progress-bar bg-success" style="width: 70.5%" role="progressbar" aria-valuenow="70.5" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
       {{-- Totoal pengguna  --}}
        <div class="col-md-3">
          <div class="card p-3">
              <h6>Total Pengguna</h6>
              <h4>{{ \App\Models\User::count() }} <span class="text-success small">▲ 100%%</span></h4>
              <div class="progress">
                  <div class="progress-bar bg-success" style="width: 70.5%" role="progressbar" aria-valuenow="70.5" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
          </div>
      </div>
      
        <div class="col-md-3">
          @php
        // use App\Models\User;
          $totalSiswa = User::where('role_name', 'siswa')->count();
          @endphp
          
          <div class="card p-3">
            <h6>Total Siswa</h6>
            <h4>{{ number_format($totalSiswa) }} <span class="text-warning small">▼ 27.4%</span></h4>
            <div class="progress">
              <div class="progress-bar bg-warning" style="width: 27.4%" role="progressbar" aria-valuenow="27.4" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          
        </div>

        {{-- total calon siswa --}}
        <div class="col-md-3">
          @php
          $totalCalonSiswa = User::where('role_name', 'calon_siswa')->count();
          @endphp
          
          <div class="card p-3">
            <h6>Calon Siswa</h6>
            <h4>{{ number_format($totalCalonSiswa) }} <span class="text-danger small">▼ 27.4%</span></h4>
            <div class="progress">
              <div class="progress-bar bg-danger" style="width: 27.4%" role="progressbar" aria-valuenow="27.4" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          
        </div>
      </div>

      <!-- Unique Visitor and Income Overview -->
      <div class="row mb-4">
        <div class="col-md-12">
          <div class="card p-3">
            <h6>Data Pendaftaran Calon Siswa</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
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
                  @foreach(\App\Models\FormulirPendaftaran::latest()->take(5)->get() as $formulir)
                    <tr>
                      <td>{{ $formulir->user->name ?? '-' }}</td>
                      <td>{{ $formulir->nik }}</td>
                      <td>{{ $formulir->jenis_kelamin }}</td>
                      <td>{{ $formulir->tempat_lahir }}, {{ \Carbon\Carbon::parse($formulir->tanggal_lahir)->format('d-m-Y') }}</td>
                      <td>{{ $formulir->asal_sekolah }}</td>
                      <td>{{ $formulir->tahun_lulus }}</td>
                      <td>{{ ucfirst($formulir->status) }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Recent Orders and Analytics -->
      <div class="row mb-4">
        <div class="col-md-8">
          <div class="card p-3">
            <h6>Jadwal Mata Pelajaran</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr>
                    <th>Nama Pelajaran</th>
                    <th>Jumlah Siswa</th>
                    <th>Hari</th>
                    <th>Durasi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach(\App\Models\MataPelajaran::with('subject')->get() as $mapel)
                    <tr>
                      <td>{{ $mapel->subject->subject_name ?? '-' }}</td>
                      <td>{{ is_array($mapel->siswa_ids) ? count($mapel->siswa_ids) : 0 }}</td>
                      <td>{{ $mapel->hari }}</td>
                      <td>
                        @php
                          $start = \Carbon\Carbon::parse($mapel->waktu_mulai);
                          $end = \Carbon\Carbon::parse($mapel->waktu_berakhir);
                        @endphp
                        {{ $start->diff($end)->format('%Hj %Im') }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      
        <div class="col-md-4">
          <div class="card p-3">
            <h6>Analytics Report</h6>
            <ul class="list-group mb-3">
              <li class="list-group-item d-flex justify-content-between">
                <span>Total Mata Pelajaran</span>
                <strong>{{ \App\Models\MataPelajaran::count() }}</strong>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Guru Terlibat</span>
                <strong>{{ \App\Models\MataPelajaran::distinct('guru_id')->count('guru_id') }}</strong>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Hari Aktif</span>
                <strong>{{ \App\Models\MataPelajaran::distinct('hari')->count('hari') }}</strong>
              </li>
            </ul>
            <canvas id="riskChart" height="150"></canvas>
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
