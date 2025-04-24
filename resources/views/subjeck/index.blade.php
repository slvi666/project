@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Kelas & Pelajaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Daftar Kelas & Pelajaran</li>
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
              <h3 class="card-title m-0">Daftar Kelas & Pelajaran</h3>
              <div class="card-tools">
              </div>
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
                <input type="text" id="search" placeholder="🔍 Cari Mata Pelajaran..." class="form-control w-50 shadow-sm rounded-pill px-3">
                <a href="javascript:void(0);" class="btn btn-primary fw-bold shadow-sm rounded-pill px-4" onclick="confirmAdd()">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Kelas & Pelajaran
                </a>
              </div>

              <div class="table-responsive">
                <table id="subjectsTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th>Kelas</th>
                      <th>Mata Pelajaran</th>
                      <th style="width: 20%;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($subjects as $index => $subject)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $subject->class_name }}</td>
                        <td>{{ $subject->subject_name }}</td>
                        <td class="text-center">
                          <!-- Ikon Lihat -->
                          <a href="javascript:void(0);" onclick="confirmShow('{{ route('subjects.show', $subject->id) }}')" class="btn btn-info btn-sm rounded-pill me-1 shadow-sm" title="Lihat">
                            <i class="fas fa-eye"></i>
                          </a>

                          <!-- Ikon Edit -->
                          <a href="javascript:void(0);" onclick="confirmEdit('{{ route('subjects.edit', $subject->id) }}')" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>

                          <!-- Ikon Hapus -->
                          <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)" title="Hapus">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("subjectsTable");
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

  function confirmEdit(url) {
    Swal.fire({
      title: 'Edit Kelas & Pelajaran?',
      text: "Anda akan diarahkan ke halaman edit kelas & pelajaran.",
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

  function confirmShow(url) {
    Swal.fire({
      title: 'Lihat Detail Kelas & Pelajaran?',
      text: "Anda akan diarahkan ke halaman detail kelas & pelajaran.",
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

  // Fungsi SweetAlert untuk konfirmasi Tambah Kelas & Pelajaran
  function confirmAdd() {
    Swal.fire({
      title: 'Tambah Kelas & Pelajaran?',
      text: "Apakah Anda ingin menambahkan kelas & pelajaran baru?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, tambah!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{ route('subjects.create') }}";
      }
    });
  }
</script>
@endsection
