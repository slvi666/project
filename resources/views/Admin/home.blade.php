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
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="card p-3">
            <h6>Total Page Views</h6>
            <h4>442,236 <span class="text-primary small">▲ 59.3%</span></h4>
            <div class="progress">
              <div class="progress-bar bg-primary" style="width: 59.3%" role="progressbar" aria-valuenow="59.3" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3">
              <h6>Total Users</h6>
              <h4>{{ \App\Models\User::count() }} <span class="text-success small">▲ 100%%</span></h4>
              <div class="progress">
                  <div class="progress-bar bg-success" style="width: 70.5%" role="progressbar" aria-valuenow="70.5" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
          </div>
      </div>
      
        <div class="col-md-3">
          <div class="card p-3">
            <h6>Total Orders</h6>
            <h4>18,800 <span class="text-warning small">▼ 27.4%</span></h4>
            <div class="progress">
              <div class="progress-bar bg-warning" style="width: 27.4%" role="progressbar" aria-valuenow="27.4" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3">
            <h6>Total Sales</h6>
            <h4>$35,078 <span class="text-danger small">▼ 27.4%</span></h4>
            <div class="progress">
              <div class="progress-bar bg-danger" style="width: 27.4%" role="progressbar" aria-valuenow="27.4" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Unique Visitor and Income Overview -->
      <div class="row mb-4">
        <div class="col-md-8">
          <div class="card p-3">
            <h6>Unique Visitor (Per Hari)</h6>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr>
                    <th>Hari</th>
                    <th>Page Views</th>
                    <th>Sessions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    $pageViews = [30, 45, 35, 55, 50, 120, 110];
                    $sessions = [15, 35, 50, 30, 40, 55, 40];
                  @endphp
                  @foreach($days as $i => $day)
                  <tr>
                    <td>{{ $day }}</td>
                    <td>{{ $pageViews[$i] }}</td>
                    <td>{{ $sessions[$i] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      
        <div class="col-md-4">
          <div class="card p-3">
            <h6>Income Overview (This Week)</h6>
            <p>Total Income: <strong>$7,650</strong></p>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr>
                    <th>Hari</th>
                    <th>Income ($)</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $income = [1000, 1300, 950, 600, 850, 780, 1170];
                  @endphp
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

      <!-- Recent Orders and Analytics -->
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
