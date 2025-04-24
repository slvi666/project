@extends('adminlte.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Pengumuman</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Pengumuman</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Pengumuman</h3>
          <div class="card-tools">
            <a href="javascript:void(0)" onclick="confirmAdd('{{ route('pengumuman.create') }}')" class="btn btn-success shadow-sm">
              <i class="fas fa-plus-circle"></i> Tambah Pengumuman
            </a>
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

              <div class="mb-3">
                <input type="text" id="searchInput" placeholder="🔍 Cari pengumuman..." class="form-control w-50 shadow-sm">
              </div>

              <table id="announcementTable" class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berakhir</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pengumuman as $index => $item)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $item->judul_pengumuman }}</td>
                      <td>
                        <span class="badge {{ $item->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                          {{ ucfirst($item->status) }}
                        </span>
                      </td>
                      <td>{{ $item->tanggal_mulai }}</td>
                      <td>{{ $item->tanggal_berakhir }}</td>
                      <td>
                        <a href="javascript:void(0)" onclick="confirmView('{{ route('pengumuman.show', $item->id) }}')" class="btn btn-info btn-sm rounded-pill shadow-sm me-1">
                          <i class="fas fa-eye"></i> Detail
                        </a>
                        <button class="btn btn-warning btn-sm rounded-pill shadow-sm me-1"
                                onclick="confirmEdit('{{ route('pengumuman.edit', $item->id) }}')">
                          <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm"
                                  onclick="confirmDelete(this.form)">
                            <i class="fas fa-trash"></i> Hapus
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
      title: 'Tambah Pengumuman Baru?',
      text: "Anda akan diarahkan ke halaman tambah pengumuman.",
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
      title: 'Lihat Detail Pengumuman?',
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
      text: "Pengumuman ini akan dihapus!",
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

  document.addEventListener("DOMContentLoaded", function() {
    let table = document.getElementById("announcementTable");
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
        btn.onclick = function() { currentPage = i; showPage(i); };
        pagination.appendChild(btn);
      }
    }

    searchInput.addEventListener("keyup", function() {
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
