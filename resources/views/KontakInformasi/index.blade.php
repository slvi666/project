@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Kontak Informasi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Kontak</li>
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
              <h3 class="card-title">Daftar Kontak Informasi</h3>
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
                <input type="text" id="searchInput" placeholder="🔍 Cari Kontak..." class="form-control w-50 shadow-sm rounded-pill px-3">
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('kontak-informasi.create') }}')" 
                  class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Kontak
                </a>
              </div>

              <div class="table-responsive">
                <table id="kontakTable" class="table table-bordered table-striped">
                  <thead class="bg-primary text-white">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>No Telpon</th>
                      <th>No WA</th>
                      <th>Instagram</th>
                      <th>FB</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($kontaks as $kontak)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kontak->nama_identitas }}</td>
                        <td>{{ $kontak->email }}</td>
                        <td>{{ $kontak->no_telpon }}</td>
                        <td>{{ $kontak->no_wa }}</td>
                        <td>{{ $kontak->instagram }}</td>
                        <td>{{ $kontak->fb }}</td>
                        <td>{{ $kontak->alamat }}</td>
                        <td class="text-center">
                          <a href="javascript:void(0)" onclick="confirmDetail('{{ route('kontak-informasi.show', $kontak->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm me-1">
                            <i class="fas fa-eye"></i>
                          </a>                      
                          <button class="btn btn-warning btn-sm rounded-pill shadow-sm me-1" onclick="confirmEdit('{{ route('kontak-informasi.edit', $kontak->id) }}')">
                            <i class="fas fa-edit"></i>
                          </button>
                          <form action="{{ route('kontak-informasi.destroy', $kontak->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="9" class="text-center">Belum ada kontak</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div id="paginationContainer" class="mt-3 text-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  
  function confirmAdd(url) {
    Swal.fire({
      title: 'Tambah Kontak Baru?',
      text: "Anda akan diarahkan ke halaman tambah kontak.",
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

  function confirmDetail(url) {
    Swal.fire({
      title: 'Lihat Detail Kontak?',
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
      text: "Kontak ini akan dihapus!",
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
    let table = document.getElementById("kontakTable");
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
