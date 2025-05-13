@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Dokumen Kegiatan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dokumen Kegiatan</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Daftar Dokumen Kegiatan</h3>
            </div>

            <div class="card-body">
              @if(session('success'))
                <script>
                  Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                  }).then(() => {
                    window.location.reload();
                  });
                </script>
              @endif

              <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="searchInput" placeholder="🔍 Cari pengumuman..." class="form-control w-50 shadow-sm rounded-pill px-3">
              @if (auth()->user()->role_name === 'Admin')
              <a href="javascript:void(0)" onclick="confirmAdd('{{ route('dok_kegiatan.create') }}')" 
                class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                <i class="fas fa-plus-circle me-1"></i> Tambah Dokumentasi
              </a>
              @endif
              </div>

              <table id="dokumenTable" class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($dokKegiatan as $index => $dok)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $dok->nama_dokumen }}</td>
                      <td>{{ $dok->deskripsi }}</td>
                      <td>
                        <img src="{{ asset($dok->path_file) }}" width="100" alt="Gambar" class="img-thumbnail">
                      </td>
                     <td class="text-center">
                      <a href="javascript:void(0)" onclick="confirmView('{{ route('dok_kegiatan.show', $dok->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm me-1">
                        <i class="fas fa-eye"></i>
                      </a>
                      <button class="btn btn-warning btn-sm rounded-pill shadow-sm me-1" onclick="confirmEdit('{{ route('dok_kegiatan.edit', $dok->id) }}')">
                        <i class="fas fa-edit"></i>
                      </button>
                      <form action="{{ route('dok_kegiatan.destroy', $dok->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <div id="paginationContainer" class="mt-3 text-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmAdd(url) {
    Swal.fire({
      title: 'Tambah Dokumen Baru?',
      text: "Anda akan diarahkan ke halaman tambah dokumen.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Lanjutkan',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmEdit(url) {
    Swal.fire({
      title: 'Anda yakin ingin mengedit?',
      text: "Anda akan diarahkan ke halaman edit.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Ya, lanjutkan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmView(url) {
    Swal.fire({
      title: 'Lihat Detail Dokumen?',
      text: "Anda akan diarahkan ke halaman detail.",
      icon: 'info',
      confirmButtonText: 'Lanjutkan'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }

  function confirmDelete(form) {
    Swal.fire({
      title: 'Anda yakin?',
      text: "Dokumen ini akan dihapus!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    let table = document.getElementById("dokumenTable");
    let searchInput = document.getElementById("searchInput");
    let rows = table.getElementsByTagName("tr");
    let currentPage = 1;
    let rowsPerPage = 5;
    let pagination = document.getElementById("paginationContainer");

    function showPage(page) {
      let start = (page - 1) * rowsPerPage + 1;
      let end = start + rowsPerPage;

      for (let i = 1; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? "table-row" : "none";
      }
    }

    function setupPagination() {
      pagination.innerHTML = "";
      let pageCount = Math.ceil((rows.length - 1) / rowsPerPage);
      for (let i = 1; i <= pageCount; i++) {
        let btn = document.createElement("button");
        btn.innerText = i;
        btn.className = "btn btn-sm btn-secondary mx-1";
        btn.onclick = function () {
          currentPage = i;
          showPage(i);
        };
        pagination.appendChild(btn);
      }
    }

    searchInput.addEventListener("keyup", function () {
      let filter = searchInput.value.toLowerCase();
      for (let i = 1; i < rows.length; i++) {
        let text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(filter) ? "table-row" : "none";
      }
    });

    showPage(1);
    setupPagination();
  });
</script>
@endsection
