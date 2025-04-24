@extends('adminlte.layouts.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Materi Pembelajaran</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Materi</li>
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
              <h3 class="card-title m-0">Daftar Materi Pembelajaran</h3>
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
                <input type="text" id="search" placeholder="🔍 Cari Materi..." class="form-control w-50 shadow-sm rounded-pill px-3">
                @if (auth()->user()->role_name === 'guru' || auth()->user()->role_name === 'Admin')
                <a href="javascript:void(0)" onclick="confirmAdd('{{ route('materi.create') }}')" 
                  class="btn btn-primary fw-bold shadow-sm rounded-pill px-4 ms-3">
                  <i class="fas fa-plus-circle me-1"></i> Tambah Materi
                </a>
                @endif
              </div>

              <div class="table-responsive">
                <table id="materiTable" class="table table-bordered table-striped align-middle">
                  <thead class="bg-primary text-white text-center">
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th>Guru</th>
                      <th>Mata Pelajaran</th>
                      <th>Kelas</th>
                      <th>Deskripsi</th>
                      <th>File</th>
                      <th style="width: 20%;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($materi as $index => $m)
                      <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $m->guru->name ?? '-' }}</td>
                        <td>{{ $m->subject->subject_name ?? '-' }}</td>
                        <td>{{ $m->subject->class_name ?? '-' }}</td>
                        <td class="text-truncate" style="max-width: 250px;">{{ Str::limit($m->deskripsi, 80, '...') }}</td>
                        <td class="text-center">
                          @if ($m->file)
                          <a href="{{ asset('storage/' . $m->file) }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill">
                            <i class="fas fa-file-pdf"></i> Lihat
                          </a>
                          @else
                          <span class="badge bg-secondary">Tidak Ada</span>
                          @endif
                        </td>
                        <td class="text-center">
                          <a href="javascript:void(0);" 
                            onclick="confirmShow('{{ route('materi.show', $m->id) }}')" 
                            class="btn btn-info btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-eye"></i>
                          </a>
                          @if (auth()->user()->role_name === 'guru' || auth()->user()->role_name === 'Admin')
                          <a href="javascript:void(0);" onclick="confirmEdit('{{ route('materi.edit', $m->id) }}')" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm">
                            <i class="fas fa-edit"></i>
                          </a>
                          <form action="{{ route('materi.destroy', $m->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" onclick="confirmDelete(this.form)">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                          @endif
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

<!-- Script & Pagination -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("materiTable");
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
      title: 'Tambah Materi Baru?',
      text: "Anda akan diarahkan ke halaman tambah materi.",
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
      title: 'Edit Materi?',
      text: "Anda akan diarahkan ke halaman edit materi.",
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
    title: 'Lihat Detail Materi?',
    text: "Anda akan diarahkan ke halaman detail materi.",
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
