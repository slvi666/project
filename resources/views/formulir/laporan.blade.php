@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan Pendaftaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Laporan</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h3 class="card-title">Data Pendaftaran</h3>
        </div>
        <div class="card-body">
          @if(session('success'))
            <script>
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
              });
            </script>
          @endif

          <div class="mb-3 d-flex align-items-center flex-wrap gap-2">
            <input type="text" id="search" placeholder="🔍 Cari Nama/NIK..." class="form-control flex-grow-1 rounded-pill shadow-sm" style="max-width: 400px;">
          
            <div class="d-flex gap-2">
              <button class="btn btn-success btn-sm rounded-pill" onclick="exportTableToExcel('laporan_pendaftaran.xlsx')">
                <i class="fas fa-file-excel me-1"></i> Export Excel
              </button>
              <button class="btn btn-danger btn-sm rounded-pill" onclick="printTable()">
                <i class="fas fa-print me-1"></i> Print
              </button>
            </div>
          </div>

          <div class="table-responsive">
            <table id="laporanTable" class="table table-bordered table-striped">
              <thead class="bg-primary text-white text-center">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NIK</th>
                  <th>TTL</th>
                  <th>Asal Sekolah</th>
                  <th>Status</th>
                  <th>Seleksi Berkas</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($laporan as $index => $data)
                  <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $data->user->name }}</td>
                    <td>{{ $data->nik }}</td>
                    <td>{{ $data->tempat_lahir }}, {{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td>{{ $data->asal_sekolah }}</td>
                    <td class="text-center">
                      <span class="badge {{ $data->status == 'Diterima' ? 'bg-success' : 'bg-danger' }}">
                        {{ $data->status }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="badge {{ $data->seleksiBerkas ? 'bg-primary' : 'bg-warning' }}">
                        {{ $data->seleksiBerkas ? 'Berkas Lengkap' : 'Belum Lengkap' }}
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<!-- XLSX for export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
  function exportTableToExcel(filename) {
    const table = document.getElementById("laporanTable");
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(table);
    XLSX.utils.book_append_sheet(wb, ws, "Laporan");
    XLSX.writeFile(wb, filename);
  }

  function printTable() {
    const contentWrapper = document.querySelector(".table-responsive");
    const originalContent = document.body.innerHTML;

    // Tambahkan judul "Laporan Pendaftaran" sebelum tabel
    const printContent = `
        <div style="text-align: center; margin-bottom: 20px;">
        <h2>Laporan Pendaftaran</h2>
        <p>${new Date().toLocaleString()}</p> <!-- Tanggal dan waktu cetak -->
        </div>
        ${contentWrapper.innerHTML}
    `;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
 }
 
  document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("search");
    const rows = document.querySelectorAll("#laporanTable tbody tr");
    input.addEventListener("keyup", function () {
      const filter = input.value.toLowerCase();
      rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filter) ? "" : "none";
      });
    });
  });
</script>
@endsection
