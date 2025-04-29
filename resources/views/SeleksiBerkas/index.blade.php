@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Seleksi Berkas</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Seleksi Berkas</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
              <h3 class="card-title m-0">Daftar Seleksi Berkas</h3>
            </div>

            <div class="card-body">
              <div class="mb-3 d-flex justify-content-between align-items-center">
                <!-- Search Input on Left -->
                <input type="text" id="searchBerkas" class="form-control w-50 shadow-sm rounded-pill px-3" placeholder="🔍 Cari...">
                @if (auth()->user()->role_name === 'calon_siswa')
                <!-- Add Data Button on Right -->
                <a href="{{ route('seleksi-berkas.create') }}" class="btn btn-primary shadow-sm rounded-pill ms-3">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Data
                </a>
                @endif
              </div>

              <div class="table-responsive">
                <table id="berkasTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th>No</th>
                      <th>Nama User</th>
                      <th>Formulir Pendaftaran ID</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $index => $item)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->formulir_pendaftaran_id }}</td>
                        <td class="text-center">
                          <a href="{{ route('seleksi-berkas.show', $item->id) }}" class="btn btn-info btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-eye"></i> Lihat
                          </a>
                          @if (auth()->user()->role_name === 'calon_siswa')
                          <a href="{{ route('seleksi-berkas.edit', $item->id) }}" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                          @endif
                        </td>
                        
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div class="mt-3">
                {{ $data->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    setupTable("berkasTable", "searchBerkas");
  });

  function setupTable(tableId, searchId) {
    let table = document.getElementById(tableId);
    if (!table) return;

    let rows = Array.from(table.getElementsByTagName("tbody")[0].rows);
    let searchInput = document.getElementById(searchId);

    searchInput.addEventListener("input", function() {
      let filter = searchInput.value.toLowerCase();
      rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
      });
    });
  }

    // Tambahkan event listener untuk Tambah Data
    const tambahBtn = document.querySelector('a[href="{{ route('seleksi-berkas.create') }}"]');
    if (tambahBtn) {
      tambahBtn.addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Tambah Data Baru?',
          text: "Anda akan diarahkan ke halaman tambah data.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Ya, lanjutkan!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = this.href;
          }
        });
      });
    }

    // Tambahkan event listener untuk semua tombol Lihat
    document.querySelectorAll('.btn-info').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Lihat Detail?',
          text: "Anda akan diarahkan ke halaman detail.",
          icon: 'info',
          showCancelButton: true,
          confirmButtonText: 'Ya, lihat!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = this.href;
          }
        });
      });
    });

    // Tambahkan event listener untuk semua tombol Edit
    document.querySelectorAll('.btn-warning').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Edit Data?',
          text: "Anda akan diarahkan ke halaman edit data.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, edit!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = this.href;
          }
        });
      });
    });
</script>
@endsection
