@extends('adminlte.layouts.app')

@section('content')
<style>
  
</style>
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
            <li class="breadcrumb-item active">Halaman Guru</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="col-md-6 offset-md-3">
      <div class="card p-4 shadow-lg" style="border-radius: 10px;">
        <div class="card-body text-center ">
          <h4 class="card-title display-4 fw-bold text-primary text-center py-2 px-2">Selamat Datang!</h4>
          <p class="card-text text-muted fs-5">Halo, <strong>{{ auth()->user()->name }}</strong>! Semoga hari Anda menyenankan. Selamat bekerja dan sukses selalu! Terus semangat belajar, karena setiap langkah kecil akan membawa Anda lebih dekat ke tujuan besar. Jangan pernah ragu untuk terus berusaha dan berkembang. Setiap usaha pasti membuahkan hasil yang luar biasa!</p>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Tambahkan CSS Kustom untuk Bayangan dan Hover -->
 <style>
  body {
    background-color: #f4f6f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .card {
    border-radius: 12px;
    transition: all 0.3s ease;
    background-color: #ffffff;
    border: none;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
  }

  .card-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #1e88e5;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
  }

  .card-text {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
  }

  .badge {
    padding: 6px 12px;
    font-size: 0.85rem;
    border-radius: 20px;
  }

  table.table {
    font-size: 0.95rem;
  }

  .table th {
    background-color: #e3f2fd;
    color: #0d47a1;
  }

  .breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
  }

  h1.text-primary {
    font-size: 1.8rem;
  }

  .shadow-lg {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.07) !important;
  }

  .text-muted {
    color: #6c757d !important;
  }

  .display-4 {
    font-size: 2.5rem;
  }

  .fw-bold {
    font-weight: 700 !important;
  }

  .table-sm th,
  .table-sm td {
    padding: 0.5rem;
  }
</style>

  
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Unique Visitor and Income Overview -->
      <div class="row mb-4">
        <div class="col-md-8">
          <div class="card p-4 shadow-sm">
              <h5 class="card-title text-primary">Pengumuman Aktif</h5>
      
              <!-- Menampilkan Pengumuman dengan Status Aktif -->
              @php
                  // Mengambil semua pengumuman yang statusnya 'Aktif'
                  $pengumumans = \App\Models\Pengumuman::where('status', 'Aktif')->get();
              @endphp
      
              @if($pengumumans->count() > 0)
                  @foreach($pengumumans as $pengumuman)
                      <!-- Judul Pengumuman -->
                      <h6 class="card-subtitle mb-3 text-secondary">{{ $pengumuman->judul_pengumuman }}</h6>
      
                      <!-- Deskripsi Pengumuman -->
                      <p class="card-text">{{ $pengumuman->deskripsi_pengumuman }}</p>
      
                      <!-- Status Pengumuman -->
                      <div class="mb-3">
                          <strong>Status:</strong>
                          <span class="badge bg-success">{{ $pengumuman->status }}</span>
                      </div>
      
                      <!-- Tanggal Mulai dan Berakhir -->
                      <div class="row">
                          <div class="col-6">
                              <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($pengumuman->tanggal_mulai)->format('d M Y') }}</p>
                          </div>
                          <div class="col-6">
                              <p><strong>Tanggal Berakhir:</strong> {{ \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->format('d M Y') }}</p>
                          </div>
                      </div>
      
                      <hr>
                  @endforeach
              @else
                  <p>Tidak ada pengumuman aktif saat ini.</p>
              @endif
          </div>
      </div>
      
    
      
        <div class="col-md-4">
          <div class="card p-3">
            @php
                // Mengambil pengumuman terbaru langsung dari model
                $pengumuman = \App\Models\Pengumuman::latest()->first(); // Ambil pengumuman terbaru
        
                // Data Income per hari
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $income = [1000, 1300, 950, 600, 850, 780, 1170];
            @endphp
        
            <h6>{{ $pengumuman->judul_pengumuman }}</h6>
            <p>{{ $pengumuman->deskripsi_pengumuman }}</p>
            <p><strong>Untuk Bagian Ujian:</strong> $7,650</p>
            
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Hari</th>
                            <th>Income ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($days as $i => $day)
                        <tr>
                            <td>{{ $day }}</td>
                            <td>${{ number_format($income[$i], 0) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        </div>
      </div>

      {{-- <!-- Recent Orders and Analytics -->
      <div class="row mb-4">
        <div class="col-md-8">
          <div class="card p-3">
            <h6>Recent Orders</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr>
                    <th>Tracking No.</th>
                    <th>Product Name</th>
                    <th>Total Order</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                  </tr>
                </thead>
                <tbody>
                  @for ($i = 0; $i < 10; $i++)
                  <tr>
                    <td>84564564</td>
                    <td>{{ ['Camera Lens', 'Laptop', 'Mobile'][$i % 3] }}</td>
                    <td>{{ rand(30, 400) }}</td>
                    <td class="{{ ['text-danger','text-warning','text-success'][$i % 3] }}">
                      {{ ['Rejected', 'Pending', 'Approved'][$i % 3] }}
                    </td>
                    <td>${{ rand(10000, 200000) }}</td>
                  </tr>
                  @endfor
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
                <span>Company Finance Growth</span>
                <strong class="text-success">+45.14%</strong>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Company Expenses Ratio</span>
                <strong>0.58%</strong>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Business Risk Cases</span>
                <strong class="text-muted">Low</strong>
              </li>
            </ul>
            <canvas id="riskChart" height="150"></canvas>
          </div>
        </div>
      </div> --}}
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
