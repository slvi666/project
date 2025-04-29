@extends('adminlte.layouts.app')

@section('content')
  <div class="content-wrapper">
    {{-- Header --}}
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Absensi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Laporan Absensi</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    {{-- Konten --}}
    <section class="content">
      <div class="container-fluid">
        <div class="card shadow-sm border-0">
          {{-- Filter --}}
          <div class="card-header bg-info text-white">
            <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan</h3>
          </div>
          <div class="card-body">
            <form method="GET" action="{{ route('absensi.laporan') }}" class="mb-4">
              <div class="row">
                <div class="col-md-3">
                  <label><i class="fas fa-calendar-alt"></i> Tanggal</label>
                  <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                </div>
                <div class="col-md-3">
                  <label><i class="fas fa-check-circle"></i> Status</label>
                  <select name="status" class="form-control">
                    <option value="">-- Semua --</option>
                    <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin"  {{ request('status') == 'izin'  ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                  </select>
                </div>
                <div class="col-md-3">
                    <label><i class="fas fa-book"></i> Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" class="form-control">
                      <option value="">-- Semua --</option>
                      @foreach($mataPelajaran as $mp)
                        <option value="{{ $mp->id }}" {{ request('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                          {{ optional($mp->subject)->subject_name ?? '-' }} - 
                          {{ optional(optional($mp->guru)->user)->name ?? '-' }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                
                <div class="col-md-3 d-flex align-items-end">
                  <button type="submit" class="btn btn-primary w-100">Filter</button>
                  <!-- Reset Button -->
                  <a href="{{ route('absensi.laporan') }}" class="btn btn-secondary w-100 ml-2">Reset</a>
                    {{-- Cek apakah user memiliki role admin --}}
                    @if (auth()->user()->role_name === 'Admin')
                    <div class="col-sm-6 text-left">
                      <button onclick="printReport()" class="btn btn-danger"><i class="fas fa-print"></i> Cetak</button>
                    </div>
                  @endif
                </div>
              </div>
            </form>

            {{-- Pencarian client-side --}}
            <input type="text" id="search" placeholder="Cari Laporan Absensi" class="form-control mb-3">

            
            {{-- Tabel --}}
            <div class="table-responsive">
              <table id="absensiTable" class="table table-bordered table-striped table-hover">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($absensi as $index => $item)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y H:i') }}</td>
                      <td>{{ optional(optional($item->siswa)->user)->name ?? '-' }}</td>
                      <td>
                        {{ 
                          optional(
                            optional($item->mataPelajaran)->subject
                          )->subject_name 
                          ?? '-' 
                        }}
                      </td>
                      <td>
                        @php
                          $badgeClass = [
                            'hadir' => 'success',
                            'izin'  => 'info',
                            'sakit' => 'warning',
                            'alpha' => 'danger',
                          ][$item->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $badgeClass }}">{{ ucfirst($item->status) }}</span>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            {{-- Pagination client-side --}}
            <div id="pagination" class="mt-3 text-center"></div>

            {{-- Jumlah data --}}
            <p class="mt-2"><strong>{{ $absensi->count() }}</strong> data ditemukan.</p>
          </div>
        </div>
      </div>
    </section>
  </div>

  {{-- Script pencarian + pagination --}}
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const table = document.getElementById("absensiTable");
      const searchInput = document.getElementById("search");
      const pagination = document.getElementById("pagination");
      const rowsPerPage = 5;
      let currentPage = 1;

      function getVisibleRows() {
        const allRows = Array.from(table.querySelectorAll("tbody tr"));
        return allRows.filter(row => row.style.display !== "none");
      }

      function showPage(page) {
        const allRows = Array.from(table.querySelectorAll("tbody tr"));
        const filteredRows = getVisibleRows();

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        allRows.forEach(row => row.style.display = "none");

        filteredRows.slice(start, end).forEach(row => {
          row.style.display = "";
        });
      }

      function setupPagination() {
        const filteredRows = getVisibleRows();
        const pageCount = Math.ceil(filteredRows.length / rowsPerPage);
        pagination.innerHTML = "";

        for (let i = 1; i <= pageCount; i++) {
          const btn = document.createElement("button");
          btn.innerText = i;
          btn.className = "btn btn-sm btn-outline-primary mx-1";
          if (i === currentPage) {
            btn.classList.add("active");
          }
          btn.addEventListener("click", () => {
            currentPage = i;
            showPage(i);
            highlightActiveButton();
          });
          pagination.appendChild(btn);
        }

        highlightActiveButton();
      }

      function highlightActiveButton() {
        const buttons = pagination.querySelectorAll("button");
        buttons.forEach(btn => btn.classList.remove("active"));
        if (buttons[currentPage - 1]) {
          buttons[currentPage - 1].classList.add("active");
        }
      }

      function filterTable() {
        const keyword = searchInput.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(keyword) ? "" : "none";
        });

        currentPage = 1;
        setupPagination();
        showPage(currentPage);
      }

      searchInput.addEventListener("keyup", filterTable);

      setupPagination();
      showPage(currentPage);
    });

    
  function printReport() {
    // Menampilkan indikator loading sebelum pencetakan dimulai
    var loading = document.createElement("div");
    loading.className = "loading-indicator";
    loading.innerHTML = "Sedang menyiapkan laporan untuk dicetak...";
    document.body.appendChild(loading);

    // Menyimpan konten yang ingin dicetak
    var content = document.getElementById("absensiTable").outerHTML;

    // Membuka window baru untuk mencetak
    var printWindow = window.open('', '', 'height=600,width=800');

    // Menambahkan CSS agar tabel terlihat rapi saat dicetak
    printWindow.document.write('<html><head><title>Laporan Absensi</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('table, th, td { border: 1px solid black; }');
    printWindow.document.write('th, td { padding: 8px; text-align: left; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // Menambahkan header laporan
    printWindow.document.write('<h2>Laporan Absensi Siswa per Tanggal ' + document.querySelector('input[name="tanggal"]').value + '</h2>');
    
    // Menambahkan tabel
    printWindow.document.write(content);
    
    // Menambahkan footer
    printWindow.document.write('<footer><p>Dicetak pada: ' + new Date().toLocaleString() + '</p></footer>');
    
    printWindow.document.write('</body></html>');
    
    printWindow.document.close();
    
    // Sembunyikan indikator loading setelah pencetakan dimulai
    loading.remove();
    
    // Menyelesaikan proses print
    printWindow.print();
  }

  </script>
@endsection
