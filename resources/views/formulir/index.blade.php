@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Formulir Pendaftaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Formulir Pendaftaran</li>
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
              <h3 class="card-title m-0">Data Pendaftar</h3>
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
                <input type="text" id="search" placeholder="🔍 Cari Nama/NIK..." class="form-control w-50 shadow-sm rounded-pill px-3">
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('formulir.create') }}')" 
                  class="btn btn-primary fw-bold shadow-sm rounded-pill px-4 ms-3">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Pendaftaran
                </a>
              </div>

              <div class="table-responsive">
                <table id="formulirTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>NIK</th>
                      <th>TTL</th>
                      <th>Jenis Kelamin</th>
                      <th>No HP</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($formulirs as $index => $formulir)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $formulir->user->name }}</td>
                        <td>{{ $formulir->user->email }}</td>
                        <td>{{ $formulir->nik }}</td>
                        <td>{{ $formulir->tempat_lahir }}, {{ $formulir->tanggal_lahir }}</td>
                        <td>{{ $formulir->jenis_kelamin }}</td>
                        <td>{{ $formulir->no_hp }}</td>
                        <td class="text-center">
                          <span class="badge 
    {{ 
      $formulir->status === 'Lulus' ? 'bg-success' : 
      ($formulir->status === 'Tidak Lulus' ? 'bg-danger' : 'bg-primary') 
    }}">
    {{ $formulir->status }}
  </span>
                        </td>
                        <td class="text-center">
                          <a href="javascript:void(0);" 
                            onclick="confirmShow('{{ route('formulir.show', $formulir->id) }}')" 
                            class="btn btn-info btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="javascript:void(0);" onclick="confirmEdit('{{ route('formulir.edit', $formulir->id) }}')" 
                            class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-edit"></i>
                          </a>
                          <form action="{{ route('formulir.destroy', $formulir->id) }}" method="POST" class="d-inline">
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
              </div>

              <div id="pagination" class="mt-3 text-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("formulirTable");
    const searchInput = document.getElementById("search");
    const rows = table.getElementsByTagName("tr");
    const pagination = document.getElementById("pagination");
    let currentPage = 1;
    const rowsPerPage = 5;

    function showPage(page) {
      const start = (page - 1) * rowsPerPage + 1;
      const end = start + rowsPerPage;
      for (let i = 1; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? "" : "none";
      }
    }

    function setupPagination() {
      pagination.innerHTML = "";
      const pageCount = Math.ceil((rows.length - 1) / rowsPerPage);
      for (let i = 1; i <= pageCount; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = "btn btn-sm btn-secondary mx-1";
        btn.onclick = () => {
          currentPage = i;
          showPage(i);
        };
        pagination.appendChild(btn);
      }
    }

    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();
      for (let i = 1; i < rows.length; i++) {
        const text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(filter) ? "" : "none";
      }
    });

    showPage(currentPage);
    setupPagination();
  });

  function confirmAdd(url) {
    Swal.fire({
      title: 'Tambah Pendaftar Baru?',
      text: "Anda akan diarahkan ke halaman tambah pendaftaran.",
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
      title: 'Edit Data?',
      text: "Anda akan diarahkan ke halaman edit.",
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

  function confirmDelete(form) {
    Swal.fire({
      title: 'Yakin ingin hapus?',
      text: "Data akan dihapus secara permanen.",
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

  function confirmShow(url) {
    Swal.fire({
      title: 'Lihat Detail?',
      text: "Anda akan diarahkan ke halaman detail pendaftaran.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Lihat',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }
</script>
@endsection
